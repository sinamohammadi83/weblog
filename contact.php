
<?php
session_start();
include 'jdf.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require './functions.php';
require './vendor/PHPMailer/phpmailer/src/Exception.php';
require './vendor/PHPMailer/phpmailer/src/PHPMailer.php';
require './vendor/PHPMailer/phpmailer/src/SMTP.php';



$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

if (isset($_GET['suggestion_id'])){

    $suggestion_id = $_GET['suggestion_id'];

    $query = "SELECT * From posts WHERE status = 'publish' AND category_id = '$suggestion_id' LIMIT 3;";

    $posts = $pdoObj->query($query)->fetchAll();

} else if (isset($_GET['search'])) {

    $search = $_GET['search'];

    $query = "SELECT * From posts WHERE status = 'publish' and title like '%$search%' or description like '%$search%' LIMIT 3;";

    $posts = $pdoObj->query($query)->fetchAll();

} else {

    $query = "SELECT * From posts WHERE status = 'publish' LIMIT 3;";

    $posts = $pdoObj->query($query)->fetchAll();

}

$queryCategories = "SELECT * FROM category LIMIT 10";

$categories = $pdoObj->query($queryCategories)->fetchAll();

if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];

    $query = "SELECT * From users WHERE email = '$email'";

    $userLogin = $pdoObj->query($query)->fetch();
}





if ($_SERVER['REQUEST_METHOD'] == "POST")
{

    $email = $_POST['email'];
    $name = $_POST['name'];
    $content = $_POST['content'];

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
    $mail->addAddress('sinamohammadi83a@gmail.com', 'weblog');     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'contact';
    $mail->Body    = "
    <div>
        <div>
            <span>نام : </span>
            <span>$name</span>
        </div>
        <div>
            <span>ایمیل : </span>
            <span>$email</span>
        </div>
        <div>
            <span>محتوا : </span>
            <span>$content</span>
        </div>
    </div>
    ";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

    header('location:contact.php?success=1');

}
?>

<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وبلاگ</title>
    <link rel="stylesheet" href="./public/css/style.css">
    <script src="./public/js/jquery-3.7.1.min.js"></script>
</head>
<body>
<div class="flex flex-col items-center w-full">
    <header class="w-full lg:max-w-screen-xl">
        <div class="flex items-center justify-between py-10 w-full px-10">
            <a href="./index.php" class="text-3xl font-bold">وبلاگ</a>
            <form method="get">
                <input type="text" class="bg-gray-100 w-96 h-10 rounded-md outline-none px-2" name="search"/>
            </form>
            <?php
            if (!isset($_SESSION['user_email'])){
                ?>
                <a href="login.php" class="text-sm py-2 px-4 flex items-center bg-blue-500 rounded-md text-white">ورود / ثبت نام</a>
                <?php
            } else{
                ?>
                <button id="button_menu" class="rounded-full border-2 border-slate-700 w-10 h-10 relative">
                    <?php
                    if ($userLogin['picture'])
                    {
                        ?>
                        <img src="<?php echo $userLogin['picture']?>" class="w-full h-full object-cover rounded-full" alt="">
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
                        <a href="./logout.php" class="py-2 flex pr-4 gap-x-2 items-center hover:text-blue-500">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" class="w-4 h-4">
                                    <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                                </svg>
                            </span>
                            <span class="text-sm">خروج</span>
                        </a>
                        <a href="./client/profile.php" class="py-2 flex pr-4 gap-x-2 items-center hover:text-blue-500">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                            </span>
                            <span class="text-sm">ویرایش پروفایل</span>
                        </a>
                        <a href="./client/dashboard.php" class="py-2 flex pr-4 gap-x-2 items-center hover:text-blue-500">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor" class="w-5 h-5">
                                    <path d="M272.5 5.7c9-7.6 22.1-7.6 31.1 0l264 224c10.1 8.6 11.4 23.7 2.8 33.8s-23.7 11.3-33.8 2.8L512 245.5V432c0 44.2-35.8 80-80 80H144c-44.2 0-80-35.8-80-80V245.5L39.5 266.3c-10.1 8.6-25.3 7.3-33.8-2.8s-7.3-25.3 2.8-33.8l264-224zM288 55.5L112 204.8V432c0 17.7 14.3 32 32 32h48V312c0-22.1 17.9-40 40-40H344c22.1 0 40 17.9 40 40V464h48c17.7 0 32-14.3 32-32V204.8L288 55.5zM240 464h96V320H240V464z"/>
                                </svg>
                            </span>
                            <span class="text-sm">پنل کاربری</span>
                        </a>
                    </div>
                </button>
            <?php } ?>
        </div>
        <nav class="gap-x-4 flex lg:max-w-screen-xl w-full border-b pb-4 px-10 border-b-gray-300">
            <a href="about.php">درباره ما</a>
            <a href="contact.php">ارتباط با ما</a>
        </nav>
    </header>
    <main class="flex flex-col items-center w-full lg:max-w-screen-xl pt-5">
        <?php
            if (isset($_GET['success']) && $_GET['success'] == 1)
            {
        ?>
            <div class="bg-white border-2 border-green-500 text-green-800 text-xs w-72 p-2 rounded-md flex justify-between items-center">
                <span>فرم تماس با موفقیت ارسال شد.</span>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor" class="w-5 h-5">
                        <path d="M441 103c9.4 9.4 9.4 24.6 0 33.9L177 401c-9.4 9.4-24.6 9.4-33.9 0L7 265c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l119 119L407 103c9.4-9.4 24.6-9.4 33.9 0z"/>
                    </svg>
                </span>
            </div>
        <?php
            }
        ?>
        <div class="flex w-10/12 mb-20">
            <form method="post" class="bg-white w-5/12 rounded-lg shadow-lg pb-5">
                <div class="text-xl text-center py-4">فرم تماس</div>
                <div class="text-xs text-slate-500 text-center mb-10">میتوانید از طریق فرم زیر پیشنهادات یا انتقادات خود را برای ما ارسال کنید</div>
                <div class="px-4 mb-5">
                    <div class="text-sm mb-2">نام</div>
                    <input type="text" name="name" class="text-sm w-full border-2 border-gray-300 focus:border-blue-500 outline-none rounded-md p-2">
                </div>
                <div class="px-4 mb-5">
                    <div class="text-sm mb-2">ایمیل</div>
                    <input type="email" name="email" class="text-sm w-full border-2 border-gray-300 focus:border-blue-500 outline-none rounded-md p-2">
                </div>
                <div class="px-4 mb-10">
                    <div class="text-sm mb-2">متن پیام</div>
                    <textarea name="content" class="text-sm w-full border-2 border-gray-300 focus:border-blue-500 outline-none rounded-md h-44 resize-none p-2"></textarea>
                </div>
                <div class="flex justify-end px-4">
                    <input type="submit" value="ارسال" class="bg-blue-500 rounded-md px-4 py-2 shadow text-sm text-white lg:cursor-pointer">
                </div>
            </form>
            <div class="flex flex-col items-start pr-20 justify-center w-6/12">
                <div class="text-slate-800 mb-5">میتوانید از طریق روش های زیر با ما در ارتباط باشید.</div>
                <div class="flex gap-x-2 mb-2 w-10">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" class="w-5 h-5 text-blue-500">
                            <path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/>
                        </svg>
                    </span>
                    <span>09306747180</span>
                </div>
                <div class="flex gap-x-2 mb-2 w-10">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" class="w-5 h-5 text-blue-500">
                            <path d="M256 64C150 64 64 150 64 256s86 192 192 192c17.7 0 32 14.3 32 32s-14.3 32-32 32C114.6 512 0 397.4 0 256S114.6 0 256 0S512 114.6 512 256v32c0 53-43 96-96 96c-29.3 0-55.6-13.2-73.2-33.9C320 371.1 289.5 384 256 384c-70.7 0-128-57.3-128-128s57.3-128 128-128c27.9 0 53.7 8.9 74.7 24.1c5.7-5 13.1-8.1 21.3-8.1c17.7 0 32 14.3 32 32v80 32c0 17.7 14.3 32 32 32s32-14.3 32-32V256c0-106-86-192-192-192zm64 192a64 64 0 1 0 -128 0 64 64 0 1 0 128 0z"/>
                        </svg>
                    </span>
                    <span>weblog71@gmail.com</span>
                </div>
                <div class="flex gap-x-2 mb-2 w-10">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" fill="currentColor" class="w-5 h-5 text-blue-500">
                            <path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z"/>
                        </svg>
                    </span>
                    <span>09306747180</span>
                </div>
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