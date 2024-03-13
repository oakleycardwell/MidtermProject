<?php
// Example index.php for the categories endpoint

// Include your autoloader and any necessary configuration files
use api\config\Database;
use api\models\Category;

require_once '../config/Database.php';
require_once '../models/Category.php';

// Connect to the database
$database = new Database();
$db = $database->getConnection();

// Check for connection error
if ($db === false) {
    // Handle the connection error
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
            // Handle the request for a single category
            $category->id = $_GET['id'];

            if ($category->read_single()) {
                // Category exists
                $category_arr = array(
                    'id' => $category->id,
                    'category' => $category->category
                );

                // Set response code - 200 OK
                http_response_code(200);

                // Make it json format
                echo json_encode($category_arr);
            } else {
                // No category found
                http_response_code(404);
                echo json_encode(array('message' => 'No Category Found'));
            }
        } else {
            // Get categories
            $stmt = $category->read();
            $num = $stmt->rowCount();

            // Check if any categories
            if ($num > 0) {
                // Categories array
                $categories_arr = array();
                $categories_arr['data'] = array();

                // Retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    $category_item = array(
                        'id' => $id,
                        'category' => $category
                    );

                    array_push($categories_arr['data'], $category_item);
                }

                // Set response code - 200 OK
                http_response_code(200);

                // Show categories data in json format
                echo json_encode($categories_arr);
            } else {
                // No categories found

                // Set response code - 404 Not Found
                http_response_code(404);

                // Tell the user no categories found
                echo json_encode(array('message' => 'No categories found.'));
            }
        }
        break;
    case 'POST':
        // Handle the creation of a new category
        include 'create.php';
        break;
    case 'PUT':
        // Handle the update of an existing category
        include 'update.php';
        break;
    case 'DELETE':
        // Handle the deletion of a category
        include 'delete.php';
        break;
    default:
        // Respond with method not allowed
        header('HTTP/1.1 405 Method Not Allowed');
        header('Allow: GET, POST, PUT, DELETE');
        break;
}

