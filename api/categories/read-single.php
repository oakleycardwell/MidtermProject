<?php

// set ID property of category to be edited
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of category to be edited
$category->read_single();

if($category->category!=null) {
    // create array
    $category_arr = array(
        "id" =>  $category->id,
        "category" => $category->category
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($category_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user category does not exist
    echo json_encode(array("message" => "Category does not exist."));
}
