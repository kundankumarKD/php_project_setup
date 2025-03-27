<?php
require_once 'BaseController.php';
require_once __DIR__ . '/../models/Product.php';

class ProductController extends BaseController {
    private $product;

    public function __construct($db, $requestMethod, $itemId) {
        parent::__construct($db, $requestMethod, $itemId);
        $this->product = new Product($db);
    }

    public function getAll() {
        $stmt = $this->product->read();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $products_arr = array();
            $products_arr['data'] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $product_item = array(
                    'id' => $id,
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at
                );
                array_push($products_arr['data'], $product_item);
            }

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($products_arr);
        } else {
            $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
            $response['body'] = json_encode(array('message' => 'No products found'));
        }
        return $response;
    }

    public function getSingle() {
        $this->product->id = $this->itemId;
        $stmt = $this->product->readSingle();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);

            $product_item = array(
                'id' => $id,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            );

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($product_item);
        } else {
            $response = $this->notFoundResponse();
        }
        return $response;
    }

    public function create() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (!$this->validateProduct($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->product->name = $input['name'];
        $this->product->description = $input['description'];
        $this->product->price = $input['price'];

        if ($this->product->create()) {
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = json_encode(array('message' => 'Product created'));
        } else {
            $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
            $response['body'] = json_encode(array('message' => 'Unable to create product'));
        }
        return $response;
    }

    public function update() {
        $this->product->id = $this->itemId;
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (!$this->validateProduct($input)) {
            return $this->unprocessableEntityResponse();
        }

        $this->product->name = $input['name'];
        $this->product->description = $input['description'];
        $this->product->price = $input['price'];

        if ($this->product->update()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(array('message' => 'Product updated'));
        } else {
            $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
            $response['body'] = json_encode(array('message' => 'Unable to update product'));
        }
        return $response;
    }

    public function delete() {
        $this->product->id = $this->itemId;

        if ($this->product->delete()) {
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode(array('message' => 'Product deleted'));
        } else {
            $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
            $response['body'] = json_encode(array('message' => 'Unable to delete product'));
        }
        return $response;
    }

    private function validateProduct($input) {
        if (!isset($input['name']) || !isset($input['description']) || !isset($input['price'])) {
            return false;
        }
        return true;
    }
}
?>