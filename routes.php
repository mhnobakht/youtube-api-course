<?php

use Controllers\RouteController;

$route = new RouteController();


// Home Routes
$route->add('/', 'GET', 'Controllers\HomeController', 'home');

// Quote Routes
$route->add('/quotes', 'GET', 'Controllers\QuoteController', 'index');
$route->add('/quotes/{id}', 'GET', 'Controllers\QuoteController', 'getQuote');
