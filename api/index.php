<?php

use api\config\Database;
use api\models\Quote;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/config/Database.php';
include_once __DIR__ . '/models/Quote.php';

$database = new Database();
$db = $database->getConnection();

$quote = new Quote($db);

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch($requestMethod) {
    case 'GET':
        if (!empty($_GET['id'])) {
            // Handle the request for a single quote
        } else {
            // Handle the request for all quotes
            $stmt = $quote->read();
            $rowCount = $stmt->rowCount();

            if($rowCount > 0) {
                $quotesArray = array();
                $quotesArray["body"] = array();
                $quotesArray["itemCount"] = $rowCount;

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $e = array(
                        "id" => $id,
                        "quote" => $quote,
                        "author_id" => $author_id,
                        "category_id" => $category_id
                    );
                    array_push($quotesArray["body"], $e);
                }
                echo json_encode($quotesArray);
            } else {
                echo json_encode(array("message" => "No record found."));
            }
        }
        break;
    // Handle other HTTP methods (POST, PUT, DELETE) with appropriate cases
    default:
        // Request method not supported
        header("HTTP/1.1 405 Method Not Allowed");
        break;
}

