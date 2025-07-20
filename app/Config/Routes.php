<?php

use App\Controllers\ReportsController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rutas de User
// vistas
$routes->get('/', 'UserController::login');
$routes->get('user', 'UserController::show');
$routes->get('users', 'UserController::index');
$routes->get('users/new', 'UserController::new');
$routes->get('password', 'UserController::password');
$routes->get('recovery', 'UserController::recovery');
$routes->get('token', 'UserController::token');
// otras
$routes->post('/', 'UserController::verify');
$routes->put('user', 'UserController::update');
$routes->put('user/(:segment)/activate', 'UserController::activate/$1');
$routes->post('users/new', 'UserController::create');
$routes->delete('users/(:segment)', 'UserController::delete/$1');
$routes->get('logout', 'UserController::logout');
$routes->post('password', 'UserController::password');
$routes->post('recovery', 'UserController::recovery');
$routes->post('token', 'UserController::token');

// Rutas de Business
// vistas
$routes->get('business', 'BusinessController::show');
$routes->get('business/new', 'BusinessController::new');
// otras
$routes->post('business', 'BusinessController::create');
$routes->put('business', 'BusinessController::update');

// Rutas de Contact
// vistas
$routes->get('contacts', 'ContactController::index');
$routes->get('contacts/new', 'ContactController::new');
$routes->get('contacts/(:segment)', 'ContactController::show/$1');
// otras
$routes->post('contacts', 'ContactController::create');
$routes->put('contacts/(:segment)', 'ContactController::update/$1');
$routes->delete('contacts/(:segment)', 'ContactController::delete/$1');

// Rutas de Item
// vistas
$routes->get('services', 'Items\ServiceController::index');
$routes->get('services/new', 'Items\ServiceController::new');
$routes->get('services/(:segment)', 'Items\ServiceController::show/$1');
// otras
$routes->post('services', 'Items\ServiceController::create');
$routes->put('services/(:segment)', 'Items\ServiceController::update/$1');
$routes->delete('services/(:segment)', 'Items\ServiceController::delete/$1');

$routes->get('products', 'Items\ProductController::index');
$routes->get('products/new', 'Items\ProductController::new');
$routes->get('products/(:segment)', 'Items\ProductController::show/$1');
// otras
$routes->post('products', 'Items\ProductController::create');
$routes->put('products/(:segment)', 'Items\ProductController::update/$1');
$routes->delete('products/(:segment)', 'Items\ProductController::delete/$1');


// Rutas de Category
// vistas
$routes->get('categories', 'CategoryController::index');
$routes->get('categories/new', 'CategoryController::new');
$routes->get('categories/(:segment)', 'CategoryController::show/$1');
// otras
$routes->post('categories', 'CategoryController::create');
$routes->put('categories/(:segment)', 'CategoryController::update/$1');
$routes->delete('categories/(:segment)', 'CategoryController::delete/$1');


// Rutas de Transaction
// vistas
$routes->get('transactions', 'TransactionController::index');
$routes->get('transactions/new', 'TransactionController::new');
$routes->get('transactions/(:segment)', 'TransactionController::show/$1');
// otras
$routes->post('transactions', 'TransactionController::create');
$routes->put('transactions/(:segment)', 'TransactionController::update/$1');

$routes->get('api/reports', 'ReportsController::index');

$routes->get('/example', 'ExampleController::index');
