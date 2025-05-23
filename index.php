
<?php
include 'jdf.php';
include 'functions.php';
session_start();
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
    <main class="flex w-full lg:max-w-screen-xl">
        <div class="w-9/12  p-8 pr-4">
            <div class="w-full border-l flex flex-col gap-y-6" id="posts">
                <?php

                foreach ($posts as $post) {
                    ?>
                    <div class="flex p-4 border-b">
                        <div class="w-9/12">
                            <div class="flex mb-5">
                                <a href="" class="text-xs flex items-center gap-x-1">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </span>
                                    <span><?php if ($post['user_id'] == 0){ echo "admin"; } else {$user = $pdoObj->query("SELECT * FROM users WHERE id='$post[user_id]'")->fetch();echo $user['firstname']." ".$user["lastname"];}  ?></span>
                                    <span class="text-slate-500"><?php echo convert_date($post['post_date']) ?></span>
                                </a>
                            </div>
                            <a href="post.php?post=<?php echo $post['slug'] ?>" class="text-xl font-bold mb-2 block break-words">
                                <?php echo $post['title'] ?>
                            </a>
                            <div class="text-xs text-slate-400 w-9/12 leading-6 mb-5 break-words">
                                <?php echo substr($post['description'],0,259) ?>
                            </div>
                            <div class="flex gap-x-4 items-center">
                                <span class="text-slate-700 bg-gray-300 text-xs p-1 px-2 rounded"><?php $category = $pdoObj->query("SELECT * FROM category WHERE id='$post[category_id]'")->fetch();echo $category['title']?></span>
                                <span class="text-xs text-slate-400">خواندن <span><?php echo $post['read_time']?></span> دقیقه</span>
                            </div>
                        </div>
                        <div class="w-3/12">
                            <a href="post.php?post=<?php echo $post['slug'] ?>">
                                <img src="<?php echo $post['picture'] ?>" class="w-40 h-40 rounded object-cover" alt="">
                            </a>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <div class="flex justify-center mt-5" id="button_more">
                <button class="bg-gray-50 w-2/12 text-sm p-2 rounded-md shadow text-slate-600">مقاله های بیشتر</button>
            </div>
        </div>

        <div class="w-4/12 flex flex-col items-center pt-5 rounded-md">
            <div class="border-black border w-10/12 h-20 rounded-md flex justify-center items-center text-sm mb-5">
                سفارش این بنر
            </div>
            <div class="w-10/12">
                <div class="mb-5 flex gap-x-2">
                    <span>موضوعات پیشنهادی</span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-500">
                            <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 0 0 5.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 0 0-2.122-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
                <div class="flex gap-2 flex-wrap">
                    <?php foreach ($categories as $category){ ?>
                        <a href="index.php?suggestion_id=<?php echo $category['id'] ?>" class="border border-black rounded-md text-sm py-1 px-2 whitespace-nowrap">
                            <?php echo $category['title'] ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
    var limit = 3;
    const button_more = document.getElementById('button_more')
    button_more.onclick = function () {
        $.ajax({
            url : './api/index.php?limit='+Number(limit+3),
            method : 'get',
            success : function (data){
                limit=limit+3
                const posts = JSON.parse(data).posts
                $('#posts').html(" ")
                for (let post of posts)
                {

                    $('#posts').append('<div class="flex p-4 border-b">'
                +'<div class="w-9/12">'
                    +'<div class="flex mb-5">'
                    +'<a href="" class="text-xs flex items-center gap-x-1">'
                    +'<span>'
                    +'<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">'
                    +'<path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />'
                    +'</svg>'
                +'</span>'
                    +'<span>'+post.firstname+' '+post.lastname+'</span>'
                    +'<span class="text-slate-500">'+post.post_date+'</span>'
                +'</a>'
                +'</div>'
                    +'<a href="post.php?post='+post.slug+'" class="text-xl font-bold mb-2 block break-words">'
                    +post.title
                    +'</a>'
                    +'<div class="text-xs text-slate-400 w-9/12 leading-6 mb-5 break-words">'
                    +post.description
                    +'</div>'
                    +'<div class="flex gap-x-4 items-center">'
                        +'<span class="text-slate-700 bg-gray-300 text-xs p-1 px-2 rounded">'+post.categoryTitle+'</span>'
                        +'<span class="text-xs text-slate-400">خواندن <span>'+post.read_time+'</span> دقیقه</span>'
                    +'</div>'
                +'</div>'
                    +'<div class="w-3/12">'
                        +'<a href="post.php?post='+post.slug+'">'
                            +'<img src="'+post.picture+'" class="w-40 h-40 rounded object-cover" alt="">'
                        +'</a>'
                    +'</div>'
                +'</div>')
                }
            }
        })
    }
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