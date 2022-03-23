<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, categoryization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
    include_once '../../api/functions/missingParams.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $categorys = new Category($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    $categorys->category = $data->category;

    if(missingParam($categorys->category)){
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }
    
    // Create category
    else{
        $categorys->create();
        echo json_encode(
            array(
                'id' => $db->lastInsertId(),
                'category' => $categorys->category
                )
        );
    }
?>