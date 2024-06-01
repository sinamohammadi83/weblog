<?php

session_start();

$email = $_SESSION['user_email'];

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

$query = "SELECT * from users where email='$email'";

$get_info = $pdoObj->query($query)->fetch();

$user_id = $get_info['id'];

$post_id = $_POST['post_id'];

$query = "SELECT * from likes where post_id='$post_id' and user_id='$user_id'";

$results = $pdoObj->query($query)->fetch();

if ($results){

    $query = "DELETE FROM likes WHERE post_id='$post_id' and user_id='$user_id'";

    $delete = $pdoObj->query($query);

} else {

    $query = "INSERT INTO likes (post_id,user_id) VALUES ('$post_id','$user_id')";

    $do_like = $pdoObj->query($query);

}

$count = $pdoObj->query("SELECT COUNT(post_id) FROM likes WHERE post_id='$post_id'")->fetch()[0];

echo json_encode([
    'count' => $count
])

?>