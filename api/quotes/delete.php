<?php
// Assume the database connection and necessary includes are already done

// get quote id
$data = json_decode(file_get_contents("php://input"));

// set quote id to be deleted
$quote->id = $data->id;

// Check if the quote exists
if (!$quote->read_single()) {
    http_response_code(200);
    echo json_encode(array('message' => 'No Quotes Found'));
    return;
}

// delete the quote
if($quote->delete()) {
    // set response code - 200 ok
    http_response_code(200);

    $quote_item=array(
        "id" => $quote -> id,
    );
    // tell the user
    echo json_encode($quote_item);
} else {
    // if unable to delete the quote, tell the user
    // set response code - 503 service unavailable
    http_response_code(200);

    // tell the user
    echo json_encode(array('message' => 'No Quotes Found'));
}

