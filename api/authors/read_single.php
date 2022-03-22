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
    $author = new Author($db);

    // Get ID
    $author->id = isset($_GET['id']) ? $_get['id'] : die();

    // Get author
    $author->read_single();

    // Create array
    $author_arr = array(
        'id' => $author->id,
        'author' => $author->author
    );

    // Make JSON
    if($author->id !== null) {
        print_r(json_encode($author_arr));
    }
    else {
        echo json_encode(array('message' => 'authorId Not Found'));
    }
?>