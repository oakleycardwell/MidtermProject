<?php
// Assuming database connection and necessary includes are already done

// Get the posted data
$data = json_decode(file_get_contents("php://input"));

// Check if all necessary data is present
if (!empty($data->quote) && !empty($data->author_id) && !empty($data->category_id)) {
    // Assign data to the quote object
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Attempt to create the quote
    $createResult = $quote->create();
    if ($createResult === true) {
        // Prepare data to return
        $newQuote = array(
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author_id' => $quote->author_id,
            'category_id' => $quote->category_id,
        );

        // Set response code - 201 created
        http_response_code(201);
        echo json_encode($newQuote);
    } else {
        // Depending on the error returned from create(), return the specific message
        http_response_code(200);
        if ($createResult == 'author_not_found') {
            echo json_encode(array('message' => 'author_id Not Found'));
        } elseif ($createResult == 'category_not_found') {
            echo json_encode(array('message' => 'category_id Not Found'));
        } else {
            // General error message
            echo json_encode(array('message' => 'Unable to create quote'));
        }
    }
} else {
    // If data is incomplete
    http_response_code(200);
    echo json_encode(array('message' => 'Missing Required Parameters'));
}

