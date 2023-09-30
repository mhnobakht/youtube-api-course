<?php

use Controllers\RouteController;

$route = new RouteController();


// add new routes here.
$route->add('/', 'GET', 'Controllers\HomeController', 'home');
$route->add('/quotes/{id}', 'GET', 'Controllers\QuoteController', 'index');