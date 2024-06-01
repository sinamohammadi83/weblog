<?php

if (isset($_GET['comment_id'])){

    $comment_id = $_GET['comment_id'];

    $post_id = $_GET['post_id'];

    $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

    $query = "DELETE FROM comments WHERE id = '$comment_id'";

    $delete = $pdoObj->query($query);

    if ($delete){

        header('location: index.php?s=post&a=comments&post_id=' . $post_id);

    }

}

?>