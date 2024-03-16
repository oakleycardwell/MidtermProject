<?php
// Assume we're in the authors directory and the necessary includes have already been done

// Get the posted data
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->author)) {
    // Assign the author name to the author object
    $author->author = $data->author;

    // Create the author
    if ($author->create()) {
        // Prepare data to return
        $newAuthor = array(
            'id' => $author->id,
            'author' => $author->author,
        );

        // Set response code - 201 created
        http_response_code(201);
        echo json_encode($newAuthor);
    } else {
        // Set response code - 503 service unavailable
        http_response_code(503);
        echo json_encode(array('message' => 'Unable to create author'));
    }
} else {
    // Data is incomplete
    http_response_code(200);
    echo json_encode(array('message' => 'Missing Required Parameters'));
}
