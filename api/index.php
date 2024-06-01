<?php

$limit = $_GET['limit'];

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

$posts = $pdoObj->query("SELECT posts.*,category.title as categoryTitle,users.firstname,users.lastname,users.picture as userPicture
FROM posts 
INNER JOIN category 
ON posts.category_id=category.id
INNER JOIN users
ON posts.user_id=users.id
WHERE posts.status = 'publish'")->fetchAll();

echo json_encode([
    'posts' => $posts
]);