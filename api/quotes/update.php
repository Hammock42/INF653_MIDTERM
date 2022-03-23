<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
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
    
    // get raw data
    $data = json_decode(file_get_contents("php://input"));
    
    // Set ID to update
    $quotes->id = $data->id;
    $quotes->quote = $data->quote;
    $quotes->authorId = $data->authorId;
    $quotes->categoryId = $data->categoryId;

    if(missingParamsQuotes($quotes->id, $quotes->quote, $quotes->authorId, $quotes->categoryId)){
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }

    $quoteExists = isValid($quotes->id, $quotes);
    if(!$quoteExists) {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
    $authorExists = isValid($quotes->authorId, $author);
    if(!$authorExists) {
        echo json_encode(
            array('message' => 'authorId Not Found')
        );
    }
    $categoryExists = isValid($quotes->categoryId, $category);
    if(!$categoryExists) {
        echo json_encode(
            array('message' => 'categoryId Not Found')
        );
    }

    // Update quote
    else {
        $quotes->update();
        echo json_encode(
            array(
                'id' => $quotes->id,
                'quote' => $quotes->quote,
                'authorId' => $quotes->authorId,
                'categoryId' => $quotes->categoryId 
            )
        );
    }
?>