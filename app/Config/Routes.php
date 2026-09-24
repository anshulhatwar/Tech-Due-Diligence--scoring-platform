<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
//$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::login');
$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('/profile', 'Auth::profile');
$routes->get('/documents', 'Auth::documents');
$routes->post('api/register', 'Auth\AuthController::register');

$routes->post('api/login', 'Auth\AuthController::login');

$routes->get('api/me', 'Auth\AuthController::me');
$routes->get('/', 'PublicPage::home');
$routes->get('/home', 'PublicPage::home');