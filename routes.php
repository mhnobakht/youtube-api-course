<?php

use Controllers\RouteController;

$route = new RouteController();


// Home Routes
$route->add('/', 'GET', 'Controllers\HomeController', 'home');

// Quote Routes
$route->add('/quotes', 'GET', 'Controllers\QuoteController', 'index');
$route->add('/quotes/{id}', 'GET', 'Controllers\QuoteController', 'getQuote');
$route->add('/quotes', 'POST', 'Controllers\QuoteController', 'store');
$route->add('/quotes/{id}', 'PUT', 'Controllers\QuoteController', 'update');
$route->add('/quotes/{id}', 'DELETE', 'Controllers\QuoteController', 'delete');
$route->add('/quotes/author/{author}', 'GET', 'Controllers\QuoteController', 'quoteByAuthor');