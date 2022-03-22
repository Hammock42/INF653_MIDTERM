<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Author.php';
    include_once '../../models/Category.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate quote object
    $quote = new Quote($db);

    $quote->categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : die();
    $quote->authorId = isset($_GET['authorId']) ? $_GET['authorId'] : die();
    
    // quote query
    $result = $quote->read_by_author_and_category_id();
    // get row count
    $num = $result->rowCount();

    // check if any quotes
    if($num > 0) {
        // quote array
        $quote_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array( 
                'id' => $id,
                'quote' => html_entity_decode($quote->quote),
                'author' => $author,
                'category' => $category   
            );

            // Push to array
            array_push($quote_arr, $quote_item);
        }
        
        // Turn to JSON & output
        echo json_encode($quote_arr);

    } else {
        echo json_encode(
            array('message' => 'No quotes found')
        );
    }
?>