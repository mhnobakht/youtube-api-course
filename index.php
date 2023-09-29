<?php
header('Content-Type: application/json');
use Controllers\Route;

require_once 'autoload.php';

//  GET URL & REQUEST TYPE 

$requestUrl = parse_url(htmlspecialchars($_SERVER['REQUEST_URI']), PHP_URL_PATH);
$requestMethod = htmlspecialchars($_SERVER['REQUEST_METHOD']);

$route = new Route();

$route->add('/', 'GET', 'Controllers\HomeController', 'home');
$route->add('/quotes/{id}', 'GET', 'Controllers\QuoteController', 'index');


$route->match($requestUrl, $requestMethod);