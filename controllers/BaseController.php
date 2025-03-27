<?php
class BaseController {
    protected $db;
    protected $requestMethod;
    protected $itemId;

    public function __construct($db, $requestMethod, $itemId = null) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->itemId = $itemId;
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->itemId) {
                    $response = $this->getSingle();
                } else {
                    $response = $this->getAll();
                }
                break;
            case 'POST':
                $response = $this->create();
                break;
            case 'PUT':
                $response = $this->update();
                break;
            case 'DELETE':
                $response = $this->delete();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    protected function unprocessableEntityResponse() {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    protected function notFoundResponse() {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = json_encode([
            'error' => 'Not Found'
        ]);
        return $response;
    }
}
?>