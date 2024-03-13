<?php

// query categories
$stmt = $category->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0) {
    // categories array
    $categories_arr=array();
    $categories_arr["records"]=array();

    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $category_item=array(
            "id" => $id,
            "category" => $category
        );

        array_push($categories_arr["records"], $category_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show categories data in json format
    echo json_encode($categories_arr);
} else {
    // no categories found will be here
}
?>
