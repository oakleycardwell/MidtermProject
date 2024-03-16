<?php
// Assuming the database connection and necessary includes are already done

// Get the posted data
$data = json_decode(file_get_contents("php://input"));

// Check if all necessary data is present
if (!empty($data->id) && !empty($data->quote) && !empty($data->author_id) && !empty($data->category_id)) {
    // Set ID property of quote to be edited
    $quote->id = $data->id;

    // Check if the quote exists
    if (!$quote->read_single()) {
        http_response_code(200);
        echo json_encode(array('message' => 'No Quotes Found'));
        return;
    }

    // Check if author_id exists
    if (!$quote->authorExists($data->author_id)) {
        http_response_code(200);
        echo json_encode(array('message' => 'author_id Not Found'));
        return;
    }

    // Check if category_id exists
    if (!$quote->categoryExists($data->category_id)) {
        http_response_code(200);
        echo json_encode(array('message' => 'category_id Not Found'));
        return;
    }

    // Set quote property values
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Attempt to update the quote
    if ($quote->update()) {
        http_response_code(200);
        $quote_item = array(
            "id" => $quote->id,
            "quote" => $quote->quote,
            "author_id" => $quote->author_id,
            "category_id" => $quote->category_id
        );
        echo json_encode($quote_item);
    } else {
        http_response_code(200);
        echo json_encode(array('message' => 'Unable to update quote.'));
    }
} else {
    // If data is incomplete
    http_response_code(200);
    echo json_encode(array('message' => 'Missing Required Parameters'));
}

