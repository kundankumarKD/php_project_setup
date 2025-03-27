# php_project_setup

-- Create database
CREATE DATABASE IF NOT EXISTS `php_crud_api`;
USE `php_crud_api`;

-- Create products table
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample data
INSERT INTO `products` (`name`, `description`, `price`) VALUES
('Laptop', 'High performance laptop with 16GB RAM', 999.99),
('Smartphone', 'Latest smartphone with 5G support', 699.99),
('Headphones', 'Noise cancelling wireless headphones', 249.99),
('Smart Watch', 'Fitness tracking and notifications', 199.99);

Curl Requests:::

1. curl --location --request GET 'http://localhost/php_project_setup/index.php/products' \
--header 'Content-Type: application/json'

2. curl --location --request GET 'http://localhost/php_project_setup/index.php/products/1' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json'

3. curl --location --request POST 'http://localhost/php_project_setup/index.php/products' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "Wireless Keyboard",
    "description": "Ergonomic wireless keyboard",
    "price": 59.99

}'
4. curl --location --request PUT 'http://localhost/php_project_setup/index.php/products/1' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "Updated Product Name",
    "description": "Updated description",
    "price": 99.99
}'

5. curl --location --request DELETE 'http://localhost/php_project_setup/index.php/products/1' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json'
