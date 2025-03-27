<?php
// index.php - Main entry point for the API

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include configuration
require_once __DIR__.'/config/Database.php';

// Get request method and URI
$requestMethod = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uriSegments = explode('/', trim($uri, '/'));

// Database connection
$database = new Database();
$db = $database->getConnection();


// Route the request
if ($uriSegments[2] === 'products') {
    // Include ProductController
    require_once __DIR__.'/controllers/ProductController.php';
    
    // Get product ID if exists
    $productId = isset($uriSegments[2]) ? (int)$uriSegments[2] : null;
    
    // Initialize and process request
    $controller = new ProductController($db, $requestMethod, $productId);
    $controller->processRequest();
} else {
    // 404 Not Found
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["message" => "Endpoint not found"]);
}