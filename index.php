<?php
// set header

use Controllers\AuthController;

header('Content-Type: application/json');

// include files
require_once 'autoload.php';
require_once 'routes.php';

$auth = new AuthController();

if($auth->validateToken()) {
    //  GET URL & REQUEST TYPE 
    $requestUrl = parse_url(htmlspecialchars($_SERVER['REQUEST_URI']), PHP_URL_PATH);
    $requestMethod = htmlspecialchars($_SERVER['REQUEST_METHOD']);

    // load routes here.
    $route->match($requestUrl, $requestMethod);
} else {
    $auth->unauthorizedUser();
}