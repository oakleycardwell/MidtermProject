<?php
// Assume the database connection and necessary includes are already done

// get id of quote to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of quote to be edited
$quote->id = $data->id;

// set quote property values
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

// update the quote
if($quote->update()) {
    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Quote was updated."));
} else {
    // if unable to update the quote, tell the user
    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to update quote."));
}

