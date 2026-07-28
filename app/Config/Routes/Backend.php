<?php

use CodeIgniter\Router\RouteCollection;
/** @var RouteCollection $routes */

$routes->group('admin', static function ($routes) {

    $routes->post('login', 'Backend\Auth::attemptLogin');
    $routes->get('logout', 'Backend\Auth::logout');
    $routes->get('dashboard', 'Backend\Dashboard::index', [ 'filter' => 'AuthFilter' ]);
    $routes->get('/', 'Backend\Auth::login');

    $routes->post('administrators/(:num)/toggle-status', 'Backend\Administrators::toggleStatus/$1');
    
    // Routes for CRUD operations
    $routes->resource('administrators', ['controller' => 'Backend\Administrators']);
    $routes->post('journals/upload-cover', 'Backend\Journals::uploadCover');
    $routes->post('journals/(:num)/delete-cover', 'Backend\Journals::deleteCover/$1');
    $routes->resource('journals', ['controller' => 'Backend\Journals']);
    $routes->get('stamps/by-journal/(:num)', 'Backend\Stamps::byJournal/$1');
    $routes->resource('stamps', ['controller' => 'Backend\Stamps']);

});
