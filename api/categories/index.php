<?php
// index.php for the categories endpoint

use api\config\Database;
use api\models\Category;

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Category.php';

// Set Content-Type header to application/json
header('Content-Type: application/json');

// Connect to the database
$database = new Database();
$db = $database->getConnection();

// Check for connection error
if ($db === false) {
    die('Connection failed: Unable to connect to the database');
}

// Instantiate the Category model with the database connection
$category = new Category($db);

// Get the request method
$request_method = $_SERVER['REQUEST_METHOD'];

// Handle the request based on the method
switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $category->id = $_GET['id'];
            if ($category->read_single()) {
                $category_arr = array(
                    'id' => $category->id,
                    'category' => $category->category
                );
                http_response_code(200);
                echo json_encode($category_arr);
            } else {
                http_response_code(200);
                echo json_encode(array('message' => 'category_id Not Found'));
            }
        } else {
            $stmt = $category->read();
            $num = $stmt->rowCount();
            if ($num > 0) {
                $categories_arr = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $category_item = array(
                        'id' => $row['id'],
                        'category' => $row['category']
                    );
                    array_push($categories_arr, $category_item);
                }
                http_response_code(200);
                echo json_encode($categories_arr);
            } else {
                http_response_code(200);
                echo json_encode(array('message' => 'category_id Not Found'));
            }
        }
        break;
    case 'POST':
        include 'create.php';
        break;
    case 'PUT':
        include 'update.php';
        break;
    case 'DELETE':
        include 'delete.php';
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
        header('Allow: GET, POST, PUT, DELETE');
        break;
}

