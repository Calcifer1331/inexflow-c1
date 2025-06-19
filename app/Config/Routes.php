<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rutas del usuario
// vistas
$routes->get('/', 'UserController::login');
$routes->get('user', 'UserController::show');
$routes->get('users', 'UserController::index'); 
$routes->get('users/new', 'UserController::new');
$routes->get('recovery', 'UserController::recovery');
// otras
$routes->post('/', 'UserController::verify');
$routes->put('user', 'UserController::update');
$routes->delete('user/(:segment)', 'UserController::delete/$1');
$routes->put('user/(:segment)/activate', 'UserController::activate/$1');
$routes->post('users', 'UserController::create');
$routes->get('logout', 'UserController::logout');
$routes->post('recovery', 'UserController::recovery');

// Rutas del negocio
// vistas
$routes->get('user/business', 'BusinessController::show');
$routes->get('user/business/new', 'BusinessController::new');
// otras
$routes->post('user', 'BusinessController::create');
$routes->put('user/business', 'BusinessController::update');

// Rutas de Categoría
//vistas
$routes->get('categories/new', 'CategoryController::new');
// otras
$routes->post('categories', 'CategoryController::create');
