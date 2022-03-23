<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, categoryization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
    include_once '../../api/functions/isValid.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $category->id = $data->id;

    // Delete category
    /*
    if($category->delete()) {
        echo json_encode(
            array('id' => $category->id)
        );
    } else {
        echo json_encode(
            array('message' => 'Category Not Deleted')
        );
    }
    */

    $categoryExists = isValid($id, $category);
    echo $categoryExists;
    if(!$categoryExists) {
        echo json_encode(
            array('message' => 'Category Not Deleted')
        );
    }
    else {
        echo json_encode(
            array('id' =>  $category->id)
        );
    }
?>