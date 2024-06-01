<?php

if (isset($_GET['post_id'])){

    $post_id = $_GET['post_id'];

    $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

    $query = "DELETE FROM posts WHERE id = '$post_id'";

    $delete = $pdoObj->query($query);

    if ($delete){

        header('location: index.php?s=post&a=index');

    }

}

?>