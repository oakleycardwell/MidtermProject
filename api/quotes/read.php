<?php
// Assume the database connection and necessary includes are already done

// query quotes
$stmt = $quote->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0) {
    // quotes array
    $quotes_arr=array();
    $quotes_arr["records"]=array();

    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item=array(
            "id" => $id,
            "quote" => $quote,
            "author_id" => $author_id,
            "category_id" => $category_id
        );

        array_push($quotes_arr["records"], $quote_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show quotes data in json format
    echo json_encode($quotes_arr);
} else {
    // no quotes found will be here
    http_response_code(404);
    echo json_encode(array("message" => "No quotes found."));
}
