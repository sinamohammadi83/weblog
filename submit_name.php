<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    if ($_SESSION['is_register']){

        $firstName = $_POST['firstname'];
        $lastName = $_POST['lastname'];
        $token = $_POST['token'];

        $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

        $query = "SELECT * From verification WHERE token = '$token' LIMIT 1;";

        $info = $pdoObj->query($query)->fetch();

        if ($info){

            $email = $info['email'];

            $query = "UPDATE users SET firstname = '$firstName', lastname = '$lastName' WHERE email = '$email';";

            $update = $pdoObj->query($query);

            if ($update){

                $_SESSION['user_token'] = $info['token'];
                $_SESSION['user_email'] = $info['email'];

                unset($_SESSION['is_register']);

                header('Location: ./client/dashboard.php');

            }

        }

    } else {

        header('Location: ./index.php');

    }

}

?>