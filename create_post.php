<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST"){

        session_start();

        $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

        $title = $_POST['title'];
        $description = $_POST['description'];

        $user = $pdoObj->query("SELECT * FROM users WHERE email='$_SESSION[user_email]'")->fetch();

        $res = $pdoObj->query("INSERT INTO posts (title,description,user_id,status) VALUES ('$title','$description','$user[id]','publish')");

        if ($res)
        {
            header('location:./dashboard.php');
        }
    }
?>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ایجاد مقاله</title>
    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
    <div class="w-full flex justify-center h-screen bg-gray-50">
        <form method="post" class="lg:max-w-screen-lg w-full pt-10">
            <div class="flex items-center justify-between mb-10">
                <div class="flex gap-x-5">
                    <div class="text-2xl">وبلاگ</div>
                    <a href="./dashboard.php" class="text-blue-500 underline">رفتن به پیش نویس ها</a>
                </div>
                <input type="submit" value="انتشار نوشته" class="bg-inherit lg:cursor-pointer border-2 text-blue-500 font-bold border-blue-500 rounded-md px-4 py-2"/>
            </div>
            <div>
                <input name="title" type="text" class="bg-inherit placeholder:text-gray-400 placeholder:font-bold text-xl mb-5 outline-none mr-10" placeholder="عنوان را اینجا وارد کنید">
                <textarea name="description" id="" cols="30" rows="10" class="bg-inherit w-full placeholder:text-slate-300 outline-none" placeholder="متن مقاله ..."></textarea>
            </div>
        </form>
    </div>
</body>
</html>