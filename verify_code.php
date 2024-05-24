<?php

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    $code = $_POST['code'];
    $token = $_POST['token'];

    $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

    $query = "SELECT * From verification WHERE code = '$code' AND token = '$token' LIMIT 1;";

    $info = $pdoObj->query($query)->fetch();

    if ($info == true){

        if ($code == $info['code'] AND $token == $info['token']){

            session_start();

            $_SESSION['user_token'] = $info['token'];
            $_SESSION['user_email'] = $info['email'];

            header('Location: ./dashboard.php');

        }

    } else {
        header('location: ./submit_code.php?'."token=$token&error=1");
    }

}

?>