<?php
// Assume that we have the necessary headers and database connection above this code

// Author read query
$result = $author->read();

// Get row count
$num = $result->rowCount();

// Check if any authors
if($num > 0) {
    // Author array
    $authors_arr = array();
    $authors_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $author_item = array(
            'id' => $id,
            'name' => $name
        );

        // Push to "data"
        array_push($authors_arr['data'], $author_item);
    }

    // Turn to JSON & output
    echo json_encode($authors_arr);
} else {
    // No Authors
    echo json_encode(
        array('message' => 'No Authors Found')
    );
}
?>