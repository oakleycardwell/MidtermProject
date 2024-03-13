<?php
// Assume the database connection and necessary includes are already done

// get quote id
$data = json_decode(file_get_contents("php://input"));

// set quote id to be deleted
$quote->id = $data->id;

// delete the quote
if($quote->delete()) {
    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Quote was deleted."));
} else {
    // if unable to delete the quote, tell the user
    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to delete quote."));
}

