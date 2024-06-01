<?php

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    session_start();

    $code = $_POST['code'];
    $token = $_POST['token'];

    $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

    $query = "SELECT * From verification WHERE code = '$code' AND token = '$token' LIMIT 1;";

    $info = $pdoObj->query($query)->fetch();

    $user = $pdoObj->query("SELECT * FROM users WHERE email='$info[email]'")->fetch();

    if ($info){

        if ($code == $info['code'] AND $token == $info['token']){

            if (isset($_SESSION['is_register'])){

                header('Location: ./set_name.php?token='.$token);

            } else {

                $_SESSION['user_token'] = $info['token'];
                $_SESSION['user_email'] = $info['email'];
                $_SESSION['user_role'] = $user['role'];

                if ($user['role'] == 'user'){
                    header('Location: ./client/dashboard.php');
                }else{
                    header('Location: ./admin/index.php');
                }

            }

        }

    } else {
        header('location: ./submit_code.php?'."token=$token&error=1");
    }

}

?>