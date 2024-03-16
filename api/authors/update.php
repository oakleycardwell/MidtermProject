<?php
// Assume we're in the authors directory and the necessary includes have already been done

// Get the posted data
$data = json_decode(file_get_contents("php://input"));

// Make sure ID and author name are provided
if (!empty($data->id) && !empty($data->author)) {
    // Set ID of the author to be updated
    $author->id = $data->id;
    $author->author = $data->author;

    // Attempt to update the author
    if ($author->update()) {
        // Prepare the response data
        $author_updated = array(
            'id' => $author->id,
            'author' => $author->author,
        );

        // Set response code - 200 ok
        http_response_code(200);

        // Return the updated author details
        echo json_encode($author_updated);
    } else {
        // If unable to update the author, inform the user
        // Set response code - 503 service unavailable
        http_response_code(200);
        echo json_encode(array('message' => 'Unable to update author'));
    }
} else {
    // If data is incomplete, inform the user
    http_response_code(200); // Bad Request
    echo json_encode(array('message' => 'Missing Required Parameters'));
}
