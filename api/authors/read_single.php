<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object
    $authors = new Author($db);

    // Get ID
    $authors->id = isset($_GET['id']) ? $_get['id'] : die();

    // Get author
    $authors->read_single();

    // Create array
    $author_arr = array(
        'id' => $authors->id,
        'author' => $authors->author
    );

    // Make JSON
    echo json_encode("id = " . $authors->id);
    if($authors->id !== null) {
        echo json_encode($author_arr);
    }
    else {
        echo json_encode(
            array('message' => 'authorId Not Found')
        );
    }
?>