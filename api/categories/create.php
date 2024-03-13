<?php

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if (!empty($data->category)) {
    // set category property values
    $category->category = $data->category;

    // create the category
    if($category->create()) {
        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Category was created."));
    } else {
        // if unable to create the category, tell the user
        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create category."));
    }
} else {
    // tell the user data is incomplete
    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create category. Data is incomplete."));
}
?>