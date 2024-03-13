<?php
// Example index.php for the quotes endpoint

// Include your autoloader and any necessary configuration files
use api\config\Database;
use api\models\Quote;
use api\models\Author;
use api\models\Category;

require_once '../config/Database.php';
require_once '../models/Quote.php';
require_once '../models/Author.php';
require_once '../models/Category.php';

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

// Get the request method
$request_method = $_SERVER['REQUEST_METHOD'];

// Handle the request based on the method
switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Handle the request for a single quote
            $quote->id = $_GET['id'];
            if ($quote->read_single()) {
                // Quote exists
                $author->id = $quote->author_id;
                $author->read_single();

                $category->id = $quote->category_id;
                $category->read_single();

                $quote_arr = array(
                    'id' => $quote->id,
                    'quote' => $quote->quote,
                    'author' => $author->author,
                    'category' => $category->category
                );

                // Set response code - 200 OK
                http_response_code(200);

                // Make it json format
                echo json_encode($quote_arr);
            } else {
                // No quote found
                http_response_code(404);
                echo json_encode(array('message' => 'No Quote Found'));
            }
        } else {
            // Get all quotes
            $stmt = $quote->read();
            $num = $stmt->rowCount();

            // Check if any quotes
            if ($num > 0) {
                // Quotes array
                $quotes_arr = array();
                $quotes_arr['data'] = array();

                // Retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Remove the extract($row);

                    $author->id = $row['author_id'];
                    $author->read_single();

                    $category->id = $row['category_id'];
                    $category->read_single();

                    $quote_item = array(
                        'id' => $row['id'],
                        'quote' => $row['quote'],
                        'author' => $author->author,
                        'category' => $category->category
                    );

                    array_push($quotes_arr['data'], $quote_item);
                }

                // Set response code - 200 OK
                http_response_code(200);

                // Show quotes data in json format
                echo json_encode($quotes_arr);
            } else {
                // No quotes found
                http_response_code(404);
                echo json_encode(array('message' => 'No quotes found.'));
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



