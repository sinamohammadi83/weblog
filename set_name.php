<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {

   $token = $_GET["token"];

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
        <div class="text-xs text-gray-400 w-full text-center mb-10">برای ثبت نام در سایت نام و نام خانوادگی خود را وارد کنید.</div>
        <div class="w-full px-5">
            <form method="post" action="submit_name.php">
                <div class="mb-2">نام</div>
                <input type="text" name="firstname"
                       class="bg-gray-200 h-10 outline-none focus:bg-white focus:border-2 focus:border-blue-500 w-full rounded-md p-2 mb-5">
                <div class="mb-2">نام خانوادگی</div>
                <input type="text" name="lastname"
                       class="bg-gray-200 h-10 outline-none focus:bg-white focus:border-2 focus:border-blue-500 w-full rounded-md p-2">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'])?>">
                <div class="flex justify-end w-full">
                    <input type="submit"
                           class="bg-blue-500 lg:cursor-pointer text-white px-4 py-2 rounded-md text-sm mt-14"
                           value="مرحله بعد">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>