<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// =========================
// PAGE ROUTES
// =========================

$routes->get('/login', 'Auth::login');
$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('/profile', 'Auth::profile');
$routes->get('/documents', 'Auth::documents');
$routes->get('evaluator-assignment','Auth::evaluatorAssignment');
$routes->get('/evaluation-scoring', 'Auth::evaluationScoring');
$routes->get('/credence-review', 'Auth::credenceReview');
$routes->get('/certificate-verification', 'Auth::certificateVerification');

$routes->get('/', 'PublicPage::home');
$routes->get('/home', 'PublicPage::home');
$routes->get('/apply', 'Auth::apply');
$routes->get('/admin', 'Auth::adminDashboard');
$routes->get('/admin/params', 'Auth::adminParams');
$routes->get('/eval', 'Auth::evalDashboard');
$routes->get('/verify', 'Auth::verify');



// =========================
// AUTH APIs
// =========================

$routes->post('api/register', 'Auth\AuthController::register');
$routes->post('api/login', 'Auth\AuthController::login');
$routes->get('api/me', 'Auth\AuthController::me');
$routes->post('api/logout', 'Auth\AuthController::logout');
$routes->post('/documents/save', 'Auth::documentsSave');
$routes->post('/profile/save', 'Auth::profileSave');
$routes->post('/profile/complete', 'Auth::profileComplete');


// =========================
// COMPANY PROFILE APIs
// =========================

$routes->post('api/company', 'Company\CompanyController::create');
$routes->get('api/company', 'Company\CompanyController::show');
$routes->put('api/company', 'Company\CompanyController::update');

// DOCUMENT APIs
$routes->post('api/documents', 'Document\DocumentController::upload');
$routes->get('api/documents', 'Document\DocumentController::index');
$routes->get('api/documents/(:num)', 'Document\DocumentController::show/$1');
$routes->delete('api/documents/(:num)', 'Document\DocumentController::deleteDocument/$1');
$routes->put('api/documents/(:num)/status', 'Document\DocumentController::updateStatus/$1');

// =========================
// ASSESSMENT APPLICATION APIs
// =========================

$routes->post('api/applications', 'Application\ApplicationController::create');
$routes->get('api/applications', 'Application\ApplicationController::index');
$routes->get('api/applications/(:num)', 'Application\ApplicationController::show/$1');
$routes->get('api/admin/applications', 'Application\ApplicationController::adminIndex');
$routes->get('api/admin/evaluations/(:num)', 'Evaluation\EvaluationController::review/$1');
// Admin Evaluation Scoring APIs
$routes->get('api/admin/evaluation/parameters/(:num)','Evaluation\EvaluationController::parameters/$1');
$routes->post('api/admin/evaluation/submit','Evaluation\EvaluationController::submit');
// =========================
// EVALUATOR ASSIGNMENT APIs
// =========================

$routes->get(
'api/admin/evaluators',
'Application\ApplicationController::evaluators'
);

$routes->post(
'api/admin/assign-evaluator',
'Application\ApplicationController::assignEvaluator'
);

$routes->get(
    'api/evaluator/applications',
    'Application\ApplicationController::assignedApplications'
);

// Evaluator Evaluation APIs
$routes->get(
    'api/evaluator/parameters/(:num)',
    'Evaluation\EvaluationController::parameters/$1'
);

$routes->post(
    'api/evaluator/submit',
    'Evaluation\EvaluationController::submit'
);

$routes->post(
    'api/admin/evaluations/decision',
    'Evaluation\EvaluationController::approveReject'
);

$routes->get('api/verify-certificate', 'Auth::verifyCertificate');

// Certificate Generation
$routes->get(
    'admin/certificate/generate/(:segment)',
    'CertificateController::generate/$1'
);

$routes->get(
    'certificate/generate/(:segment)',
    'CertificateController::generate/$1'
);

$routes->get(
    'api/certificate/download/(:segment)',
    'CertificateController::download/$1'
);

// Razorpay Payment Routes

$routes->post(
    'api/payment/create-order',
    'PaymentController::createOrder'
);

$routes->post(
    'api/payment/verify',
    'PaymentController::verifyPayment'
);

$routes->get(
    'api/payment/status/(:num)',
    'PaymentController::paymentStatus/$1'
);

$routes->get(
    'api/startup/status',
    'Application\ApplicationController::startupStatus'
);

$routes->get(
    'api/verified-directory',
    'Application\ApplicationController::verifiedDirectory'
);

$routes->get(
    'api/company/progress',
    'Company\CompanyController::getWizardProgress'
);

$routes->put(
    'api/company/progress',
    'Company\CompanyController::saveWizardProgress'
);