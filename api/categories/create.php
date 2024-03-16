<?php

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if (!empty($data->category)) {
    // set category property values
    $category->category = $data->category;

    // create the category
    if($category->create()) {
        // Prepare the response data
        $newCategory = array(
            'id' => $category->id,
            'category' => $category->category,
        );

        // set response code - 201 created
        http_response_code(201);

        // return the newly created category
        echo json_encode($newCategory);
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
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Missing Required Parameters"));
}
