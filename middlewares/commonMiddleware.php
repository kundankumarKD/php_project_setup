<?php
// Middleware function to check API key
function api_key_middleware() {
    // Get all incoming request headers
    $headers = getallheaders();

    // Check if 'api_key' exists in the headers
    if (!isset($headers['api_key']) || $headers['api_key'] != '123') {
        // If the API key is missing or invalid, return error response
        $err_response = [
            "error" => true,
            "message" => "Unauthorized Request",
            "data" => []
        ];

        // Set the correct HTTP status code for Unauthorized
        header("HTTP/1.1 400 an");

        // Send JSON response
        echo json_encode($err_response);

        // Terminate further script execution
        exit();
    }

    // If the API key is valid, allow the request to continue
    return true;
}
?>
