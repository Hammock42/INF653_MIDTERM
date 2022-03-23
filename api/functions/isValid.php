<?php
    include_once '../../config/Database.php';
    include_once '../../config/Quote.php';
    include_once '../../config/Author.php';
    include_once '../../config/Category.php';

    function isValid($id, $model) {
        $model->id = $id;
        $result = $model->read_single();
        return ($result->rowCount()>0);
    }
?>