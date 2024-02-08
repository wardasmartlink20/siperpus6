<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');

$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/books', 'BookController::index');
$routes->get('/payment', 'PaymentController::index');
$routes->get('/report', 'ReportController::index');
