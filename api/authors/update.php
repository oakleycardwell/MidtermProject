<?php
// Assume we're in the authors directory and the necessary includes have already been done

// Get the posted data
$data = json_decode(file_get_contents("php://input"));

// Make sure ID is included
if(!empty($data->id) && !empty($data->author)) {
    // Set ID to update
    $author->id = $data->id;
    $author->author = $data->author;

    // Update the author
    if($author->update()) {
        // Set response code - 200 ok
        http_response_code(200);
        echo json_encode(array('message' => 'Author Updated'));
    } else {
        // Set response code - 503 service unavailable
        http_response_code(503);
        echo json_encode(array('message' => 'Unable to update author'));
    }
} else {
    // Data is incomplete
    http_response_code(400);
    echo json_encode(array('message' => 'Unable to update author. Data is incomplete.'));
}
