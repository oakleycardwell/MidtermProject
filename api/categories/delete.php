<?php
// get category id
$data = json_decode(file_get_contents("php://input"));

// set category id to be deleted
$category->id = $data->id;

// delete the category
if($category->delete()) {
    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Category was deleted."));
} else {
    // if unable to delete the category, tell the user
    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to delete category."));
}

