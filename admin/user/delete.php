<?php

if (isset($_GET['user_id']))
{
    $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");
    $user_id = $_GET['user_id'];
    $posts = $pdoObj->query("SELECT * FROM posts WHERE user_id='$user_id'")->fetchAll();
    foreach ($posts as $post)
    {
        unlink('../'.$post['picture']);
        $pdoObj->query("DELETE FROM comments WHERE post_id='$post[id]'");
        $pdoObj->query("DELETE FROM posts WHERE id='$post[id]'");
    }
    $user = $pdoObj->query("SELECT * FROM users WHERE id='$user_id'")->fetch();
    unlink('../'.$user['picture']);
    $pdoObj->query("DELETE FROM users WHERE id='$user_id'");

    header('location:index.php?s=user&a=index');
}