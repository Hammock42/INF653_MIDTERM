<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
    include_once '../../api/functions/missingParams.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object
    $author = new Author($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $author->id = $data->id;
    $author->author = $data->author;

    if(missingParams($author->id, $author->author)){
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }

    // Update author
    else {
        $author->update();
        echo json_encode(
            array(
                'id' => $author->id,
                'author' => $author->author
            )
        );
    }
?>