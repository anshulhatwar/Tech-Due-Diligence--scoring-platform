<?php

namespace App\Controllers\Evaluation;

use App\Controllers\BaseController;
use App\Models\EvaluationModel;
use App\Models\EvaluationScoreModel;

class EvaluationController extends BaseController
{
    // Get evaluation parameters for an assigned application
    public function parameters($applicationId)
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => false,
                'message' => 'Please login first.'
            ]);
        }

        if ($session->get('role') !== 'Evaluator') {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => false,
                'message' => 'Evaluator access required.'
            ]);
        }

        $db = \Config\Database::connect();

        // Check evaluator assignment
        $assignment = $db->table('application_assignments')
            ->where('application_id', $applicationId)
            ->where('evaluator_id', $session->get('user_id'))
            ->get()
            ->getRowArray();

        if (!$assignment) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => false,
                'message' => 'This application is not assigned to you.'
            ]);
        }

        // Fetch active evaluation parameters
        $parameters = $db->table('evaluation_parameters')
            ->where('is_active', 1)
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'status' => true,
            'application_id' => (int) $applicationId,
            'parameters' => $parameters
        ]);
    }


    // Submit evaluation scores
    public function submit()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => false,
                'message' => 'Please login first.'
            ]);
        }

        if ($session->get('role') !== 'Evaluator') {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => false,
                'message' => 'Evaluator access required.'
            ]);
        }

        $input = $this->request->getJSON(true);

        $applicationId = (int) ($input['application_id'] ?? 0);
        $scores = $input['scores'] ?? [];
        $comments = trim($input['comments'] ?? '');

        if ($applicationId <= 0 || !is_array($scores) || empty($scores)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => false,
                'message' => 'Application ID and scores are required.'
            ]);
        }

        $db = \Config\Database::connect();

        // Verify evaluator assignment
        $assignment = $db->table('application_assignments')
            ->where('application_id', $applicationId)
            ->where('evaluator_id', $session->get('user_id'))
            ->get()
            ->getRowArray();

        if (!$assignment) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => false,
                'message' => 'This application is not assigned to you.'
            ]);
        }

        // Fetch active parameters
        $parameters = $db->table('evaluation_parameters')
            ->where('is_active', 1)
            ->get()
            ->getResultArray();

        if (count($scores) !== count($parameters)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => false,
                'message' => 'Please submit scores for all active parameters.'
            ]);
        }

        $parameterWeights = [];

        foreach ($parameters as $parameter) {
            $parameterWeights[$parameter['id']] = $parameter['weight'];
        }

        $totalScore = 0;
        $scoreData = [];
        $submittedIds = [];

        foreach ($scores as $item) {
            $parameterId = (int) ($item['parameter_id'] ?? 0);
            $score = $item['score'] ?? null;

            if (
                !isset($parameterWeights[$parameterId]) ||
                !is_numeric($score) ||
                $score < 0 ||
                $score > 10 ||
                in_array($parameterId, $submittedIds, true)
            ) {
                return $this->response->setStatusCode(422)->setJSON([
                    'status' => false,
                    'message' => 'Invalid or duplicate parameter score.'
                ]);
            }

            $weightedScore = (
                ((float) $score / 10) *
                (float) $parameterWeights[$parameterId]
            );

            $totalScore += $weightedScore;
            $submittedIds[] = $parameterId;

            $scoreData[] = [
                'parameter_id' => $parameterId,
                'score' => $score,
                'weighted_score' => round($weightedScore, 2)
            ];
        }

        if (count($submittedIds) !== count($parameters)) {
            return $this->response->setStatusCode(422)->setJSON([
                'status' => false,
                'message' => 'All active parameters must be scored.'
            ]);
        }

        // Prevent duplicate evaluation
        $evaluationModel = new EvaluationModel();

        $existing = $evaluationModel
            ->where('application_id', $applicationId)
            ->first();

        if ($existing) {
            return $this->response->setStatusCode(409)->setJSON([
                'status' => false,
                'message' => 'This application has already been evaluated.'
            ]);
        }

        // Save evaluation and individual scores
        $db->transBegin();

        $evaluationId = $evaluationModel->insert([
            'application_id' => $applicationId,
            'evaluator_id' => $session->get('user_id'),
            'total_score' => round($totalScore, 2),
            'comments' => $comments,
            'status' => 'Submitted'
        ]);

        if (!$evaluationId) {
            $db->transRollback();

            return $this->response->setStatusCode(500)->setJSON([
                'status' => false,
                'message' => 'Failed to save evaluation.'
            ]);
        }

        $evaluationScoreModel = new EvaluationScoreModel();

        foreach ($scoreData as $item) {
            $saved = $evaluationScoreModel->insert([
                'evaluation_id' => $evaluationId,
                'parameter_id' => $item['parameter_id'],
                'score' => $item['score'],
                'weighted_score' => $item['weighted_score']
            ]);

            if (!$saved) {
                $db->transRollback();

                return $this->response->setStatusCode(500)->setJSON([
                    'status' => false,
                    'message' => 'Failed to save parameter scores.'
                ]);
            }
        }

        if ($db->transStatus() === false) {
            $db->transRollback();

            return $this->response->setStatusCode(500)->setJSON([
                'status' => false,
                'message' => 'Evaluation transaction failed.'
            ]);
        }

        $db->transCommit();

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Evaluation submitted successfully.',
            'evaluation' => [
                'evaluation_id' => $evaluationId,
                'application_id' => $applicationId,
                'total_score' => round($totalScore, 2),
                'status' => 'Submitted'
            ]
        ]);
    }
}