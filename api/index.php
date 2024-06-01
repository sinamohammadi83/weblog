<?php

$limit = $_GET['limit'];

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

$posts = $pdoObj->query("SELECT * FROM posts WHERE status='publish' LIMIT $limit")->fetchAll();
$array = [];
foreach ($posts as $post)
{
    $user = $pdoObj->query("SELECT * FROM users WHERE id='$post[user_id]'")->fetch();
    $category = $pdoObj->query("SELECT * FROM category WHERE id='$post[category_id]'")->fetch();

}
echo json_encode([
    'posts' => $posts
]);