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
    include_once '../../api/functions/isValid.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate quote object
    $quotes = new Quote($db);
    $author = new Author($db);
    $category = new Category($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    $quotes->quote = $data->quote;
    $quotes->authorId = $data->authorId;
    $quotes->categoryId = $data->categoryId;

    $quoteExists = isValid($quotes->id, $quotes);
    $authorExists = isValid($quotes->authorId, $author);
    $categoryExists = isValid($quotes->categoryId, $category);

    if(missingParamsQuoteCreate($data->quote, $data->authorId, $data->categoryId)){
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }
    
    // Create category
    else if(!$quoteExists) {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
    else if(!$authorExists) {
        echo json_encode(
            array('message' => 'authorId Not Found')
        );
    }
    else if(!$categoryExists) {
        echo json_encode(
            array('message' => 'categoryId Not Found')
        );
    }
    else{
        $quotes->create();
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