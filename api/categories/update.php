<?php

// get id of category to be edited
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty and id is set
if (!empty($data->id) && !empty($data->category)) {

    // set ID property of category to be edited
    $category->id = $data->id;

    // set category property values
    $category->category = $data->category;

    // update the category
    if ($category->update()) {
        // set response code - 200 ok
        http_response_code(200);

        // prepare the response data
        $category_updated = array(
            'id' => $category->id,
            'category' => $category->category,
        );

        // return the updated category
        echo json_encode($category_updated);
    }
} else {
    // if unable to update the category, tell the user
    // set response code - 503 service unavailable
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Missing Required Parameters"));
}
