
<?php
include 'jdf.php';
include 'functions.php';

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
        <div class="flex justify-between py-10 w-full px-10">
            <a href="./index.php" class="text-3xl font-bold">وبلاگ</a>
            <form method="get">
                <input type="text" class="bg-gray-100 w-96 h-10 rounded-md outline-none px-2" name="search"/>
            </form>
            <a href="./login.php" class="text-sm py-2 px-4 flex items-center bg-blue-500 rounded-md text-white">ورود / ثبت نام</a>
        </div>
        <nav class="gap-x-4 flex lg:max-w-screen-xl w-full border-b pb-4 px-10 border-b-gray-300">
            <a href="">درباره ما</a>
            <a href="">ارتباط با ما</a>
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
                            <a href="post.php?post=<?php echo $post['slug'] ?>" class="text-xl font-bold mb-2 block">
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
                    +'<a href="post.php?post=" class="text-xl font-bold mb-2 block">'
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
                        +'<a href="post.php?post=">'
                            +'<img src="'+post.picture+'" class="w-40 h-40 rounded object-cover" alt="">'
                        +'</a>'
                    +'</div>'
                +'</div>')
                }
            }
        })
    }
</script>
</body>
</html>