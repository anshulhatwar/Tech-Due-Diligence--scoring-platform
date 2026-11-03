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


    // Admin: View submitted evaluation details
    public function review($applicationId)
    {
        $session = session();

        // Check login
        if (!$session->get('logged_in')) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => false,
                'message' => 'Please login first.'
            ]);
        }

        // Admin access only
        if ($session->get('role') !== 'Admin') {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => false,
                'message' => 'Admin access required.'
            ]);
        }

        $db = \Config\Database::connect();

        // Fetch evaluation with application, company and evaluator details
        $evaluation = $db->table('evaluations e')
            ->select('
                e.id AS evaluation_id,
                e.application_id,
                e.evaluator_id,
                e.total_score,
                e.comments,
                e.status AS evaluation_status,
                e.submitted_at,
                a.application_number,
                a.assessment_type,
                a.status AS application_status,
                c.name AS company_name,
                u.Name AS evaluator_name
            ')
            ->join('assessment_applications a', 'a.id = e.application_id')
            ->join('companies c', 'c.id = a.company_id')
            ->join('users u', 'u.ID = e.evaluator_id')
            ->where('e.application_id', $applicationId)
            ->get()
            ->getRowArray();

        if (!$evaluation) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Evaluation not found.'
            ]);
        }

        // Fetch individual parameter scores
        $scores = $db->table('evaluation_scores es')
            ->select('
                es.parameter_id,
                ep.parameter_name,
                ep.description,
                ep.weight,
                es.score,
                es.weighted_score
            ')
            ->join(
                'evaluation_parameters ep',
                'ep.id = es.parameter_id'
            )
            ->where('es.evaluation_id', $evaluation['evaluation_id'])
            ->orderBy('ep.id', 'ASC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Evaluation details fetched successfully.',
            'evaluation' => $evaluation,
            'scores' => $scores
        ]);
    }
    // Admin: Approve or Reject an evaluation
public function approveReject()
{
    $session = session();

    // Check login
    if (!$session->get('logged_in')) {
        return $this->response->setStatusCode(401)->setJSON([
            'status' => false,
            'message' => 'Please login first.'
        ]);
    }

    // Admin access only
    if ($session->get('role') !== 'Admin') {
        return $this->response->setStatusCode(403)->setJSON([
            'status' => false,
            'message' => 'Admin access required.'
        ]);
    }

    $input = $this->request->getJSON(true);

    $applicationId = (int) ($input['application_id'] ?? 0);
    $decision = trim($input['decision'] ?? '');
    $remarks = trim($input['admin_remarks'] ?? '');

    // Validate input
    if (
        $applicationId <= 0 ||
        !in_array($decision, ['Approved', 'Rejected'], true)
    ) {
        return $this->response->setStatusCode(422)->setJSON([
            'status' => false,
            'message' => 'Valid application ID and decision are required.'
        ]);
    }

    $db = \Config\Database::connect();

    // Find submitted evaluation
    $evaluation = $db->table('evaluations')
        ->where('application_id', $applicationId)
        ->get()
        ->getRowArray();

    if (!$evaluation) {
        return $this->response->setStatusCode(404)->setJSON([
            'status' => false,
            'message' => 'Evaluation not found.'
        ]);
    }

    // Prevent changing an already approved/rejected evaluation
    if (in_array($evaluation['status'], ['Approved', 'Rejected'], true)) {
        return $this->response->setStatusCode(409)->setJSON([
            'status' => false,
            'message' => 'This evaluation has already been reviewed.'
        ]);
    }

    $db->transBegin();

    // Update evaluation decision
    $db->table('evaluations')
        ->where('id', $evaluation['id'])
        ->update([
            'status' => $decision,
            'reviewed_by' => $session->get('user_id'),
            'admin_remarks' => $remarks,
            'reviewed_at' => date('Y-m-d H:i:s')
        ]);

    // Update application status
    $db->table('assessment_applications')
        ->where('id', $applicationId)
        ->update([
            'status' => $decision
        ]);

    if ($db->transStatus() === false) {
        $db->transRollback();

        return $this->response->setStatusCode(500)->setJSON([
            'status' => false,
            'message' => 'Failed to update evaluation decision.'
        ]);
    }

    $db->transCommit();

    return $this->response->setJSON([
        'status' => true,
        'message' => 'Evaluation ' . strtolower($decision) . ' successfully.',
        'decision' => [
            'application_id' => $applicationId,
            'evaluation_id' => $evaluation['id'],
            'status' => $decision,
            'admin_remarks' => $remarks,
            'reviewed_by' => $session->get('user_id')
        ]
    ]);
}
}

