<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Author.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate quote object
    $quotes = new Quote($db);

    $quotes->authorId = isset($_GET['authorId']) ? $_GET['authorId'] : die();

    // quote query
    $result = $quotes->read_by_author_id();
    // Get row count
    $num = $result->rowCount();

    // check if any quotes
    if($num > 0) {
        // quote array
        $quote_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array( 
                'id' => $id,
                'quote' => html_entity_decode($quote),
                'author' => $author,
                'category' => $category
            );
            // push to array
            array_push($quote_arr, $quote_item);
        }
        // turn to JSON & output
        echo json_encode($quote_arr);
    } else {
        echo json_encode(
            array('message' => 'No quotes found')
        );
    }
?>