<?php
// index.php for the authors endpoint

use api\config\Database;
use api\models\Author;

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Author.php';

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
    die('Connection failed: Unable to connect to the database');
}

// Instantiate the Author model with the database connection
$author = new Author($db);

// Handle the request based on the method
switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $author->id = $_GET['id'];
            if ($author->read_single()) {
                $author_arr = array(
                    'id' => $author->id,
                    'author' => $author->author
                );
                http_response_code(200);
                echo json_encode($author_arr);
            } else {
                http_response_code(200);
                echo json_encode(array('message' => 'author_id Not Found'));
            }
        } else {
            $stmt = $author->read();
            $num = $stmt->rowCount();
            if ($num > 0) {
                $authors_arr = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $author_item = array(
                        'id' => $row['id'],
                        'author' => $row['author']
                    );
                    array_push($authors_arr, $author_item);
                }
                http_response_code(200);
                echo json_encode($authors_arr);
            } else {
                http_response_code(200);
                echo json_encode(array('message' => 'author_id Not Found'));
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


