<?php
// routes/products.php - Product route handler

/**
 * Handle product routes
 * 
 * @param string $requestMethod HTTP method (GET, POST, etc.)
 * @param int|null $productId ID of the product (for single item operations)
 * @param PDO $db Database connection
 */
function handleProductRoutes($requestMethod, $productId, $db) {
    // Include the ProductController
    require_once '../controllers/ProductController.php';
    
    // Initialize ProductController
    $controller = new ProductController($db, $requestMethod, $productId);
    
    // Process the request
    $controller->processRequest();
}
?>