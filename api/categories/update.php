<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, categoryization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
    include_once '../../api/functions/missingParams.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $category->id = $data->id;
    $category->category = $data->category;
    echo json_encode(array('id = ' . $category->id . ' category = '. $category->category));
    if(missingParams($category->id, $category->category)){
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }

    // Update author
    else {
        $category->update();
        echo json_encode(
            array(
                'id' => $category->id,
                'author' => $category->category
            )
        );
    }

?>