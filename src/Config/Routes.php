<?php

// Create a new instance of our RouteCollection class.
$routes = service('routes');

$routes->post('_cellular', '\Cellular\Controllers\CellularController::index');
$routes->get('_cellular/scripts', '\Cellular\Controllers\AssetController::scripts');
$routes->get('_cellular/styles', '\Cellular\Controllers\AssetController::styles');
