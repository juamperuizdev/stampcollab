<?php

use CodeIgniter\Router\RouteCollection;
/** @var RouteCollection $routes */

// Carga la página inicial
$routes->get('/', 'Home::index');

// Carga de páginas por javascript
$routes->get('page/(:num)/(:num)', 'Page::getPage/$2/$1');

// Página about
$routes->get('about', 'About::index');

// Subida de imagen de sello
$routes->post('upload/stamp', 'Stamps::upload');