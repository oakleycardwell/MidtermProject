<?php
// Assume necessary includes and object instantiation are already done

// Get the ID of the author to delete
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)) {
    $author->id = $data->id;

    // Delete the author
    if($author->delete()) {
        $quote_item=array(
            "id" => $author -> id,
        );

        // Set response code - 200 OK
        http_response_code(200);
        echo json_encode($quote_item);
    } else {
        // Set response code - 503 Service Unavailable
        http_response_code(503);
        echo json_encode(array('message' => 'Unable to delete author.'));
    }
} else {
    // Set response code - 400 Bad Request
    http_response_code(400);
    echo json_encode(array('message' => 'Unable to delete author. Data is incomplete.'));
}
