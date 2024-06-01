
<?php

session_start();

include "../functions.php";

if (!isset($_SESSION['user_email']))
    header('location:../login.php');

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

$email = $_SESSION['user_email'];

$query = "SELECT * From users WHERE email = '$email'";

$user = $pdoObj->query($query)->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];


    $linkHeader = "location:./profile.php";
    $error = false;
    if ($firstname == "")
    {
        $linkHeader.="&error_firstname=1";
        $error = true;
    }
    if ($lastname == "")
    {
        $linkHeader.="&error_lastname=1";
        $error = true;
    }
    if ($password != $repassword)
    {
        $linkHeader.="&error_password=2&error_repassword=2";
        $error = true;
    }
    if ($password){
        $password = md5($password);
    }else{
        $password = $user['password'];
    }
    if ($error)
    {
        header($linkHeader);
        die();
    }

    $picture = $_FILES['image'];
    $link = "";
    if ($picture['name'])
    {
        if ($user['picture']){
            unlink('../'.$user['picture']);
        }

        $end = explode('.',$picture['name'])[1];
        $link = "public/images/users/".token(15).'.'.$end;
        move_uploaded_file($picture['tmp_name'],'../'.$link);
    }else{
        $link = $user['picture'];
    }

    $res = $pdoObj->query("UPDATE users SET firstname='$firstname' , lastname='$lastname', password='$password' , picture='$link' WHERE id='$user[id]'");
    if ($res)
    {
        header('Location: profile.php');
    }

}

?>

<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وبلاگ</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<div class="flex flex-col items-center w-full">
    <header class="w-full lg:max-w-screen-xl">
        <div class="flex justify-between py-10 w-full px-10">
            <a href="../index.php" class="text-3xl font-bold">وبلاگ</a>
            <input type="text" class="bg-gray-100 w-96 h-10 rounded-md outline-none px-2"/>
            <?php
            if (!isset($_SESSION['user_email'])){
                ?>
                <a href="../login.php" class="text-sm py-2 px-4 flex items-center bg-blue-500 rounded-md text-white">ورود / ثبت نام</a>
                <?php
            } else{
                ?>
                <button id="button_menu" class="rounded-full border-2 border-slate-700 w-10 h-10 relative">
                    <?php
                    if ($user['picture'])
                    {
                        ?>
                        <img src="../<?php echo $user['picture']?>" class="w-full h-full object-cover rounded-full" alt="">
                        <?php
                    }else{
                        ?>
                        <span>
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                          </span>
                        <?php
                    }
                    ?>
                    <div id="menu" class="rounded-md text-black bg-white border shadow w-44 h-36 z-[100] absolute top-14 -left-5 pt-4 hidden">
                        <a href="../logout.php" class="py-2 flex pr-4 gap-x-2 items-center hover:text-blue-500">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" class="w-4 h-4">
                                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                                </svg>
                            </span>
                            <span class="text-sm">خروج</span>
                        </a>
                        <a href="" class="py-2 flex pr-4 gap-x-2 items-center hover:text-blue-500">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                            </span>
                            <span class="text-sm">ویرایش پروفایل</span>
                        </a>
                        <a href="../" class="py-2 flex pr-4 gap-x-2 items-center hover:text-blue-500">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor" class="w-5 h-5">
                                    <path d="M272.5 5.7c9-7.6 22.1-7.6 31.1 0l264 224c10.1 8.6 11.4 23.7 2.8 33.8s-23.7 11.3-33.8 2.8L512 245.5V432c0 44.2-35.8 80-80 80H144c-44.2 0-80-35.8-80-80V245.5L39.5 266.3c-10.1 8.6-25.3 7.3-33.8-2.8s-7.3-25.3 2.8-33.8l264-224zM288 55.5L112 204.8V432c0 17.7 14.3 32 32 32h48V312c0-22.1 17.9-40 40-40H344c22.1 0 40 17.9 40 40V464h48c17.7 0 32-14.3 32-32V204.8L288 55.5zM240 464h96V320H240V464z"/>
                                </svg>
                            </span>
                            <span class="text-sm">وبلاگ</span>
                        </a>
                    </div>
                </button>
            <?php } ?>
        </div>
        <nav class="gap-x-4 flex lg:max-w-screen-xl w-full border-b pb-4 px-10 border-b-gray-300">
            <a href="">درباره ما</a>
            <a href="">ارتباط با ما</a>
        </nav>
    </header>
    <main class="flex w-full lg:max-w-screen-xl">
        <div class="w-9/12 border-l flex flex-col gap-y-6 p-8 pt-16 pr-4">
            <div class="text-xl font-bold mb-5">ویرایش پروفایل</div>
            <form method="post" class="w-full" enctype="multipart/form-data">
                <div class="flex w-full gap-x-8 mb-5">
                    <div class="w-full">
                        <div class="mb-2 text-slate-800 text-sm">
                            نام
                        </div>
                        <input type="text" name="firstname" class="rounded-md outline-none text-sm w-full border-gray-300 border-2 focus:border-blue-600 p-2" value="<?php echo $user['firstname']; ?>">
                    </div>
                    <div class="w-full">
                        <div class="mb-2 text-slate-800 text-sm">
                            نام خانوادگی
                        </div>
                        <input type="text" name="lastname" class="rounded-md outline-none text-sm w-full border-gray-300 border-2 focus:border-blue-600 p-2" value="<?php echo $user['lastname'] ?>">
                    </div>
                </div>
                <div class="flex w-full gap-x-8 mb-5">
                    <div class="w-full">
                        <div class="mb-2 text-slate-800 text-sm">
                            رمز عبور
                        </div>
                        <input type="password" name="password" class="rounded-md outline-none text-sm w-full border-gray-300 border-2 focus:border-blue-600 p-2">
                    </div>
                    <div class="w-full">
                        <div class="mb-2 text-slate-800 text-sm">
                            تکرار رمز عبور
                        </div>
                        <input type="password" name="repassword" class="rounded-md outline-none text-sm w-full border-gray-300 border-2 focus:border-blue-600 p-2">
                    </div>
                </div>
                <div class="w-full mb-10">
                    <div class="mb-2 text-slate-800 text-sm">
                        عکس پروفایل
                    </div>
                    <input type="file" name="image" class="rounded-md outline-none text-sm w-full border-gray-300 border-2 focus:border-blue-600 p-2">
                </div>
                <div class="flex justify-end">
                    <input type="submit" value="ثبت" class="bg-blue-500 text-white rounded-md px-4 py-2 shadow text-sm">
                </div>
            </form>
        </div>
        <div class="w-4/12 flex flex-col items-center pt-5 rounded-md">
            <div class="border-black border w-10/12 h-20 rounded-md flex justify-center items-center text-sm mb-5">
                سفارش این بنر
            </div>
            <div class="w-10/12 mt-5">
                <div class="mb-5 flex gap-x-2">
                    <span class="font-bold text-xl">لینک های کمکی</span>
                </div>
                <a href="create_post.php" class="block mb-2">مقاله جدید</a>
                <a href="" class="block mb-2">مشاهده آمار</a>
                <a href="" class="block mb-2">آموزش انتشار نوشته</a>
            </div>
        </div>
    </main>
</div>
<script>
    const button_menu = document.getElementById('button_menu')
    const menu = document.getElementById('menu')
    button_menu.onclick = function (){
        if (menu.classList.contains('hidden'))
        {
            menu.classList.remove('hidden')
        }else{
            menu.classList.add('hidden')
        }
    }
</script>
</body>
</html>