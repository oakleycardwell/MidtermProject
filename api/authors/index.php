<?php
// Example index.php for the authors endpoint

// Include your autoloader and any necessary configuration files
use api\config\Database;
use api\models\Author;

require_once '../config/Database.php';
require_once '../models/Author.php';

// Connect to the database
$database = new Database();
$db = $database->getConnection();

// Check for connection error
if ($db === false) {
    // Handle the connection error
    die('Connection failed: Unable to connect to the database');
}

// Instantiate the Author model with the database connection
$author = new Author($db);

// Get the request method
$request_method = $_SERVER['REQUEST_METHOD'];

// Handle the request based on the method
switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            if (isset($_GET['id'])) {
                // Handle the request for a single author
                $author->id = $_GET['id'];

                if ($author->read_single()) {
                    // Author exists
                    $author_arr = array(
                        'id' => $author->id,
                        'author' => $author->author
                    );

                    // Set response code - 200 OK
                    http_response_code(200);

                    // Make it json format
                    echo json_encode($author_arr);
                } else {
                    // No author found
                    http_response_code(404);
                    echo json_encode(array('message' => 'No Author Found'));
                }
            }
        } else {
            // Get authors
            $stmt = $author->read();
            $num = $stmt->rowCount();

            // Check if any authors
            if ($num > 0) {
                // Authors array
                $authors_arr = array();
                $authors_arr['data'] = array();

                // Retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    $author_item = array(
                        'id' => $id,
                        'author' => $author
                    );

                    array_push($authors_arr['data'], $author_item);
                }

                // Set response code - 200 OK
                http_response_code(200);

                // Show authors data in json format
                echo json_encode($authors_arr);
            } else {
                // No authors found

                // Set response code - 404 Not Found
                http_response_code(404);

                // Tell the user no authors found
                echo json_encode(array('message' => 'No authors found.'));
            }
        }
        break;
    case 'POST':
        // Handle the creation of a new author
        include 'create.php';
        break;
    case 'PUT':
        // Handle the update of an existing author
        include 'update.php';
        break;
    case 'DELETE':
        // Handle the deletion of an author
        include 'delete.php';
        break;
    default:
        // Respond with method not allowed
        header('HTTP/1.1 405 Method Not Allowed');
        header('Allow: GET, POST, PUT, DELETE');
        break;
}

