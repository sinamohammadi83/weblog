
<?php

session_start();

if (!isset($_SESSION['user_email']))
    header('location:../login.php');

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

if (isset($_GET['post_id']))
{
    $post_id = $_GET['post_id'];
    $image_link = $_GET['image'];
    $pdoObj->query("DELETE FROM posts where id='$post_id'");
    header('location:./dashboard.php');
    unlink($image_link);
}

$email = $_SESSION['user_email'];


$query = "SELECT * From users WHERE email = '$email'";

$get_id = $pdoObj->query($query)->fetch();

$user_id = $get_id['id'];

$query = "SELECT * from posts WHERE user_id = $user_id;";

$posts = $pdoObj->query($query)->fetchAll();

$queryCategories = "SELECT * FROM category LIMIT 10";

$categories = $pdoObj->query($queryCategories)->fetchAll();

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
            <a href="../login.php" class="text-sm py-2 px-4 flex items-center bg-blue-500 rounded-md text-white">ورود / ثبت نام</a>
        </div>
        <nav class="gap-x-4 flex lg:max-w-screen-xl w-full border-b pb-4 px-10 border-b-gray-300">
            <a href="">درباره ما</a>
            <a href="">ارتباط با ما</a>
        </nav>
    </header>
    <main class="flex w-full lg:max-w-screen-xl">
        <div class="w-9/12 border-l flex flex-col gap-y-6 p-8 pt-16 pr-4">
            <div class="text-xl font-bold mb-5">پست های شما</div>
            <div class="border-b ">
                <button id="draft_button" class="text-sm border-b border-b-black h-full pb-2">پیش نویس ها</button>
                <button id="publish_button" class="text-sm pb-2 mr-5 border-b-black">پست های منتشر شده</button>
            </div>
            <div id="draft_posts">

                <?php

                $post_id = 0;

                foreach ($posts as $post) {

                    $post_id = $post_id + 1;

                    if ($post['status'] == "preview"){

                ?>

                <div class="border-b border-b-slate-700 flex justify-between last:border-b-0 py-5">
                    <div class="flex gap-x-10 pr-10">
                        <div class="text-sm w-5"><?php echo $post_id ?></div>
                        <div class="text-sm w-44 truncate"><?php echo $post['title'] ?></div>
                        <div class="text-sm"><?php $category = $pdoObj->query("SELECT * FROM category WHERE id='$post[category_id]'")->fetch();echo $category['title']?></div>
                    </div>
                    <div class="flex gap-x-2">
                        <a href="edit_post.php?id=<?php echo $post['id'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                        </a>
                        <a href="dashboard.php?post_id=<?php echo $post['id']?>&image=<?php echo $post['picture']?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </a>
                    </div>
                </div>

                <?php } } ?>

            </div>
            <div id="publish_posts" class="hidden">


                <?php

                $post_id = 0;

                foreach ($posts as $post) {

                    $post_id = $post_id + 1;

                    if ($post['status'] == "publish"){

                        ?>

                        <div class="border-b border-b-slate-700 flex justify-between last:border-b-0 py-5">
                            <div class="flex gap-x-10 pr-10">
                                <div class="text-sm w-5"><?php echo $post_id ?></div>
                                <div class="text-sm w-20 truncate"><?php echo $post['title']; ?></div>
                                <div class="text-sm"><?php $category = $pdoObj->query("SELECT * FROM category WHERE id='$post[category_id]'")->fetch();echo $category['title']?></div>
                            </div>
                            <div class="flex gap-x-2">
                                <div class="">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                        </svg>
                                    </span>
                                    <span class="text-xs text-slate-800 text-center mr-1">10</span>
                                </div>
                                <a href="./comments.php?post_id=<?php echo $post['id'] ?>" class="flex flex-col items-center">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                                        </svg>
                                    </span>
                                    <div class="text-xs text-slate-800 text-center w-10 inline-flex justify-center">
                                        <?php
                                            echo $pdoObj->query("SELECT COUNT(id) FROM comments WHERE post_id='$post[id]' ")->fetch()[0]
                                        ?>
                                    </div>
                                </a>
                                <a href="edit_post.php?id=<?php echo $post['id'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                    </svg>
                                </a>
                                <a href="dashboard.php?post_id=<?php echo $post['id']?>&image=<?php echo $post['picture']?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                    <?php } } ?>


            </div>
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
    const button_draft = document.getElementById('draft_button')
    const button_publish = document.getElementById('publish_button')
    const draft_posts = document.getElementById('draft_posts')
    const publish_posts = document.getElementById('publish_posts')
    button_draft.onclick = function (){
        publish_posts.classList.add('hidden')
        draft_posts.classList.remove('hidden')
        button_draft.classList.add('border-b')
        button_draft.classList.remove('border-b-0')
        button_publish.classList.remove('border-b')
        button_publish.classList.add('border-b-0')
    }
    button_publish.onclick = function (){
        publish_posts.classList.remove('hidden')
        draft_posts.classList.add('hidden')
        button_draft.classList.remove('border-b')
        button_draft.classList.add('border-b-0')
        button_publish.classList.add('border-b')
        button_publish.classList.remove('border-b-0')
    }
</script>
</body>
</html>