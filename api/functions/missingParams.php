<?php
    include_once '../../config/Database.php';
    include_once '../../config/Quote.php';
    include_once '../../config/Author.php';
    include_once '../../config/Category.php';

    function missingParamsQuotes($id, $quote, $author, $category) {
        if($id === null || $quote === null || $author === null || $category === null){
            return true;
        }
        return false;
    }

    function missingParams($id, $model) {
        if($id === null || $model === null){
            return true;
        }
        return false;
    }

?>