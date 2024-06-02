<?php

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
        <div class="text-xs text-gray-400 w-full text-center mb-16">برای ورود یا ثبت نام رمز عبور خود را وارد کنید</div>
        <div class="w-full px-5">
            <form method="post" action="verify_password.php">
                <div class="mb-2">رمز عبور</div>
                <input type="password" name="password"
                       class="bg-gray-200 outline-none focus:bg-white focus:border-2 focus:border-blue-500 w-full rounded-md p-2">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'])?>">
                <a href="./submit_code.php?token=<?php echo htmlspecialchars($_GET['token'])?>" class="text-sm text-blue-500 underline mt-2 block">ورود با کد یکبار مصرف</a>
                <div class="flex justify-end w-full">
                    <input type="submit"
                           class="bg-blue-500 lg:cursor-pointer text-white px-4 py-2 rounded-md text-sm mt-24"
                           value="مرحله بعد">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>