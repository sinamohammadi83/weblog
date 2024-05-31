<?php

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $res = $pdoObj->query("INSERT INTO users (firstname,lastname,email,password) VALUES ('$firstname','$lastname','$email','$password')");

    if ($res)
    {
        header('Location: index.php?s=user&a=index');
    }
}

?>
<div class="w-10/12 lg:max-w-screen-lg mb-10 text-xl font-bold">ایجاد مقاله</div>
<div class="bg-white w-10/12 rounded-md shadow p-4 pb-0 text-sm lg:max-w-screen-lg">
    <form method="post">
        <div class="w-full mb-5">
            <div class="mb-2">نام</div>
            <div>
                <input type="text" name="firstname" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
            </div>
        </div>
        <div class="w-full mb-5">
            <div class="mb-2">نام خانوادگی</div>
            <div>
                <input type="text" name="lastname" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
            </div>
        </div>
        <div class="w-full mb-5">
            <div class="mb-2">ایمیل</div>
            <div>
                <input type="text" name="email" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
            </div>
        </div>
        <div class="w-full mb-5">
            <div class="mb-2">رمز عبور</div>
            <div>
                <input type="password" name="password" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
            </div>
        </div>
        <div class="flex justify-end">
            <input type="submit" value="ثبت" class="bg-blue-500 lg:cursor-pointer text-white text-sm rounded-md px-4 py-2 w-1/12"/>
        </div>
    </form>
</div>