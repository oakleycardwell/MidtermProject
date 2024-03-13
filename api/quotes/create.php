<?php
// Assume the database connection and necessary includes are already done

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if (!empty($data->quote) && !empty($data->author_id) && !empty($data->category_id)) {
    // set quote property values
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // create the quote
    if($quote->create()) {
        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Quote was created."));
    } else {
        // if unable to create the quote, tell the user
        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create quote."));
    }
} else {
    // tell the user data is incomplete
    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create quote. Data is incomplete."));
}

