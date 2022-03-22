<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, categoryization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Author.php';
    include_once '../../models/Category.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate quote object
    $quote = new Quote($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->authorId = $data->authorId;
    $quote->categoryId = $data->categoryId;

    // Create quote
    if($quote->create()) {
        echo json_encode(
            array(
                'id' => $db->lastInsertId(),
                'quote' => $quote->quote,
                'authorId' => $quote->authorId,
                'categoryId' => $quote->categoryId
                )
        );
    } else {
        echo json_encode(
            array('message' => 'Quote Not Created')
        );
    }
?>