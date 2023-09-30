<?php

use Controllers\Route;

$route = new Route();


// add new routes here.
$route->add('/', 'GET', 'Controllers\HomeController', 'home');
$route->add('/quotes/{id}', 'GET', 'Controllers\QuoteController', 'index');