<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('page/(:num)', 'Home::index/$1');
$routes->get('api/cells/(:num)', 'Home::cells/$1');
