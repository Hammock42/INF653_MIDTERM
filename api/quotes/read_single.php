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
    $quotes = new Quote($db);
    
    // get ID
    $quotes->id = isset($_GET['id']) ? $_GET['id'] : die();
    
    if($quotes->read_single()){
        $quote_arr = array (
          'id' => $quotes->id,
          'quote' => $quotes->quote,
          'author' => $quotes->author,
          'category' => $quotes->category
        );
      
        echo json_encode($quote_arr);
      } else {
      
        echo json_encode(
           array('message' => 'No Quotes Found')
        );
      }
    /*
    // get quote    
    $quotes->read_single();
    
    // Create array
    $quote_arr = array (
        'id' => $quotes->id,
        'quote' => $quotes->quote,
        'author' => $quotes->author,
        'category' => $quotes->category
    );
    
    // convert to json
    if($quotes->read_single()) {
        echo json_encode($quote_arr);
    }
    else {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
    */
?>