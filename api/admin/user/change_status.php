<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

    $status = $_POST['status'];
    $user_id = $_POST['user_id'];

    $pdoObj->query("UPDATE users SET status='$status' WHERE id='$user_id'");

    $msg_status = $status ? 'فعال' : 'غیر فعال';
    echo json_encode([
        'message' => "کاربر مورد نظر با موقیت $msg_status شد."
    ]);
}