<?php

use Controllers\RouteController;

$route = new RouteController();


// Home Routes
$route->add('/', 'GET', 'Controllers\HomeController', 'home');

// Quote Routes
$route->auth()->add('/quotes', 'GET', 'Controllers\QuoteController', 'index');
$route->auth()->add('/quotes/{id}', 'GET', 'Controllers\QuoteController', 'getQuote');
$route->auth()->add('/quotes', 'POST', 'Controllers\QuoteController', 'store');
$route->auth()->add('/quotes/{id}', 'PUT', 'Controllers\QuoteController', 'update');
$route->auth()->add('/quotes/{id}', 'DELETE', 'Controllers\QuoteController', 'delete');
$route->auth()->add('/quotes/author/{author}', 'GET', 'Controllers\QuoteController', 'quoteByAuthor');
$route->auth()->add('/quotes/user/{id}', 'GET', 'Controllers\QuoteController', 'getQuoteByUserId');