<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'php_crud_api';
    private $username = 'root';
    private $password = 'password';
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            $user = $this->username;
            $password = $this->password;

            $this->conn = new PDO( $dsn, $user, $password );
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
