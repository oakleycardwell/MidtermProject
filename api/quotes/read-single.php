<?php
// Assume the database connection and necessary includes are already done

// set ID property of quote to be edited
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of quote to be edited
$quote->read_single();

if($quote->quote!=null) {
    // create array
    $quote_arr = array(
        "id" =>  $quote->id,
        "quote" => $quote->quote,
        "author_id" => $quote->author_id,
        "category_id" => $quote->category_id
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($quote_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user quote does not exist
    echo json_encode(array("message" => "Quote does not exist."));
}

