<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();
    
    // Instantiate quote object    
    $quote = new Quote($db);
    
    // get ID
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();
    
    // get quote    
    $quote->read_single();
    
    // Create array
    $quote_arr = array (
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author,
        'category' => $quote->category
    );
    
    // convert to json
    if($quote->id !== null) {
        echo json_encode($quote_arr);
    }
    else {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
?>