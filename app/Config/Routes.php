<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/iclock/cdata', 'IClockController::cdata');
$routes->get('/iclock/cdata', 'IClockController::get_cdata');
$routes->get('/iclock/getrequest', 'IClockController::getrequest');
