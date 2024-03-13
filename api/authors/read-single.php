<?php
// Assume that we have the necessary headers and database connection above this code

// Get ID from URL, if present
$author_id = isset($_GET['id']) ? $_GET['id'] : die();

// Get the single author
$author->id = $author_id;
$author->read_single();

if($author->name != null) {
    // Create array
    $author_arr = array(
        'id' => $author->id,
        'name' => $author->name
    );

    // Set response code - 200 OK
    http_response_code(200);

    // Make it json format
    echo json_encode($author_arr);
} else {
    // Set response code - 404 Not found
    http_response_code(404);

    // No authors
    echo json_encode(
        array('message' => 'No Author Found')
    );
}
?>