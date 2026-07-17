<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Carga la página inicial
$routes->get('/', 'Home::index');

// Carga de páginas por javascript
$routes->get('page/(:num)', 'Page::getPage/$1');
//$routes->get('api/cells/(:num)', 'Page::cells/$1');
