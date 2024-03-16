<?php
// index.php for the quotes endpoint

// Include your autoloader and any necessary configuration files
use api\config\Database;
use api\models\Quote;
use api\models\Author;
use api\models\Category;

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Quote.php';
require_once __DIR__ . '/../models/Author.php';
require_once __DIR__ . '/../models/Category.php';

// Set Content-Type header to application/json and allow CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$request_method = $_SERVER['REQUEST_METHOD'];

if ($request_method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Connect to the database
$database = new Database();
$db = $database->getConnection();

// Check for connection error
if ($db === false) {
    // Handle the connection error
    die('Connection failed: Unable to connect to the database');
}

// Instantiate the Quote, Author, and Category models with the database connection
$quote = new Quote($db);
$author = new Author($db);
$category = new Category($db);

// Handle the request based on the method
switch ($request_method) {
    case 'GET':
        // Check if an 'id' is provided
        if (isset($_GET['id'])) {
            $quote->id = $_GET['id'];
            $quote_item = $quote->read_single();

            if ($quote_item) {
                // Successfully found the quote, return it as a JSON object
                http_response_code(200);
                echo json_encode($quote_item);
            } else {
                // No quote found with the provided ID
                http_response_code(200);
                echo json_encode(['message' => 'No Quotes Found']);
            }
        } else {
            // Fetch all quotes if no 'id' parameter
            $stmt = $quote->read();
            $num = $stmt->rowCount();

            if ($num > 0) {
                $quotes_arr = array();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Extract the author and category names directly, avoiding including author_id and category_id
                    $quote_item = array(
                        'id' => $row['id'],
                        'quote' => $row['quote'],
                        'author' => $row['author'], // Use the author name from the JOIN
                        'category' => $row['category'] // Use the category name from the JOIN
                    );

                    array_push($quotes_arr, $quote_item);
                }

                http_response_code(200);
                echo json_encode($quotes_arr);
            } else {
                http_response_code(200);
                echo json_encode(['message' => 'No Quotes Found']);
            }
        }
        break;
    case 'POST':
        // Handle the creation of a new quote
        include 'create.php';
        break;
    case 'PUT':
        // Handle the update of an existing quote
        include 'update.php';
        break;
    case 'DELETE':
        // Handle the deletion of a quote
        include 'delete.php';
        break;
    default:
        // Respond with method not allowed
        header('HTTP/1.1 405 Method Not Allowed');
        header('Allow: GET, POST, PUT, DELETE');
        break;
}



