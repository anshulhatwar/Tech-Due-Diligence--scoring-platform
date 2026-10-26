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

$routes->get('/', 'PublicPage::home');
$routes->get('/home', 'PublicPage::home');
$routes->get('/apply', 'Auth::apply');
$routes->get('/admin', 'Auth::adminDashboard');
$routes->get('/admin/params', 'Auth::adminParams');


// =========================
// AUTH APIs
// =========================

$routes->post('api/register', 'Auth\AuthController::register');
$routes->post('api/login', 'Auth\AuthController::login');
$routes->get('api/me', 'Auth\AuthController::me');
$routes->post('api/logout', 'Auth\AuthController::logout');
$routes->post('/documents/save', 'Auth::documentsSave');
$routes->post('/profile/save', 'Auth::profileSave');


// =========================
// COMPANY PROFILE APIs
// =========================

$routes->post('api/company', 'Company\CompanyController::create');
$routes->get('api/company', 'Company\CompanyController::show');
$routes->put('api/company', 'Company\CompanyController::update');
// =====================================