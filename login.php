<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require './functions.php';
require './vendor/PHPMailer/phpmailer/src/Exception.php';
require './vendor/PHPMailer/phpmailer/src/PHPMailer.php';
require './vendor/PHPMailer/phpmailer/src/SMTP.php';



    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        
        $email = $_POST['email'];
        $code = random_int(111111,999999);
        $token = token(20);
        $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");
        
        $pdoObj->query("INSERT INTO verification (token,email,code) VALUES ('$token','$email','$code')");

        $mail = new PHPMailer(true);

        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'weblog71@gmail.com';                     //SMTP username
        $mail->Password   = 'aqsk yalp oahm dyxd';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;
        $mail->SMTPDebug  = SMTP::DEBUG_OFF;
        //Recipients
        $mail->setFrom('weblog71@gmail.com', 'weblog');
        $mail->addAddress($email, 'weblog');     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'submit code';
        $mail->Body    = "$code";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();

        $res = $pdoObj->query("SELECT token FROM verification WHERE email='$email' ORDER BY id DESC")->fetch();

        $userExists = $pdoObj->query("SELECT * FROM users WHERE email ='$email'")->fetch();

        if(!$userExists)
        {
            $password = md5($code);
            $pdoObj->query("INSERT INTO users (email,password) VALUES ('$email','$password')");
        }

        header("location:./submit_code.php?token=$res[token]");
    }
?>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ورود</title>
    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
    <div class="bg-gray-200 w-full flex justify-center items-center h-screen">
        <div class="bg-white w-96 h-96 rounded-md">
            <div class="text-2xl text-center w-full pt-5 mb-2">وبلاگ</div>
            <div class="text-xs text-gray-400 w-full text-center mb-16">برای ورود یا ثبت نام ایمیل خود را وارد کنید</div>
            <div class="w-full px-5">
                <form method="post">
                    <div class="mb-2">ایمیل</div>
                    <input type="text" name="email" class="bg-gray-200 outline-none focus:bg-white focus:border-2 focus:border-blue-500 w-full rounded-md p-2">
                    <div class="flex justify-end w-full">
                        <input type="submit" class="bg-blue-500 lg:cursor-pointer text-white px-4 py-2 rounded-md text-sm mt-28" value="مرحله بعد">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>