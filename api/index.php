<?php

$limit = $_GET['limit'];

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

$posts = $pdoObj->query("SELECT posts.*,category.title as categoryTitle,users.firstname,users.lastname,users.picture as userPicture
FROM posts 
INNER JOIN category 
ON posts.category_id=category.id
INNER JOIN users
ON posts.user_id=users.id
WHERE posts.status = 'publish' LIMIT $limit")->fetchAll();

include '../jdf.php';
include '../functions.php';

for ($i = 0; $i < count($posts); $i++) {
    $posts[$i]['6'] = convert_date($posts[$i]['6'], true);
}

echo json_encode(['posts' => $posts]);