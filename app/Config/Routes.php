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


// =========================
// AUTH APIs
// =========================

$routes->post('api/register', 'Auth\AuthController::register');
$routes->post('api/login', 'Auth\AuthController::login');
$routes->get('api/me', 'Auth\AuthController::me');
$routes->post('api/logout', 'Auth\AuthController::logout');


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