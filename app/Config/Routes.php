<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::login');
$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('/profile', 'Auth::profile');
$routes->get('/documents', 'Auth::documents');