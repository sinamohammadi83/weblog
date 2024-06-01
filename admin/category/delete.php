<?php

if (isset($_GET['id'])){

    $category_id = $_GET['id'];

    $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

    $query = "DELETE FROM category WHERE id = '$category_id'";

    $delete = $pdoObj->query($query);

    if ($delete){
        echo "Category Deleted";
    } else{
        echo "Category Not Deleted";
    }

}

?>