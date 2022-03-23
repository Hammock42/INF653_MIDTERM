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
    include_once '../../api/functions/missingParams.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate quote object
    $quotes = new Quote($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    $quotes->quote = $data->quote;
    $quotes->authorId = $data->authorId;
    $quotes->categoryId = $data->categoryId;

    if(missingParamsQuoteCreate($quotes->quote, $quotes->authorId, $quotes->categoryId)){
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }
    // Create category
    else{
        $quotes->create();
        echo json_encode(
            array("Checking if this prints also")
        );
        echo json_encode(
            array(
                'id' => $db->lastInsertId(),
                'quote' => $quotes->quote,
                'authorId' => $quotes->authorId,
                'categoryId' => $quotes->categoryId
                )
        );
    }
?>