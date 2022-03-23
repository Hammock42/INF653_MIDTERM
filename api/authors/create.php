<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
    include_once '../../api/functions/missingParams.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $authors = new Author($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $authors->author = $data->author;

    if(missingParam($authors->author)){
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }
    
    // Create author
    else{
        echo json_encode(
            array("Checking if this prints")
        );
        $authors->create();
        echo json_encode(
            array("Checking if this prints also")
        );
        echo json_encode(
            array(
                'id' => $db->lastInsertId(),
                'author' => $authors->author
                )
        );
    }
?>