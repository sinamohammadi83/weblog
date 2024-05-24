<?php

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    $password = $_POST['password'];
    $token = $_POST['token'];

    $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

    $query = "SELECT * From verification WHERE token = '$token' LIMIT 1;";

    $info = $pdoObj->query($query)->fetch();

    if ($info == true){

        $email = $info['email'];

        $queryUser = "SELECT email, password From users WHERE email = '$email' AND password = '$password' LIMIT 1;";

        $user = $pdoObj->query($queryUser)->fetch();

        if ($user == true){

            if ($password == $user['password'] AND $token == $info['token']){

                session_start();

                $_SESSION['user_token'] = $info['token'];
                $_SESSION['user_email'] = $info['user_email'];

                header('Location: /dashboard.php');

            }

        } else {

            header('location: /login_password.php?'."token=$token&error=1");

        }

    } else {
        header('location: /login_password.php?'."token=$token&error=2");
    }

}

?>