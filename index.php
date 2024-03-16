<?php
// index.php - Simplistic routing mechanism

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$request_method = $_SERVER['REQUEST_METHOD'];

if ($request_method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Parse the request URI to get the path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Define the base directory for the API handlers
$baseDir = __DIR__;

// Route the request to the appropriate handler based on the path
switch ($path) {
    case '/api/quotes/':
        require_once "{$baseDir}/api/quotes/index.php";
        break;
    case '/api/authors/':
        require_once "{$baseDir}/api/authors/index.php";
        break;
    case '/api/categories/':
        require_once "{$baseDir}/api/categories/index.php";
        break;
    default:
        // Handle 404 Not Found
        header("HTTP/1.0 404 Not Found");
        echo '404 Not Found';
        exit;
}
