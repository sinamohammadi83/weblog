
<?php

session_start();

if (!isset($_SESSION['user_email']))
    header('location:./login.php');

$post_id = $_GET['post_id'];

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

$email = $_SESSION['user_email'];

$query = "SELECT * From users WHERE email = '$email'";

$get_id = $pdoObj->query($query)->fetch();

$user_id = $get_id['id'];

$query = "SELECT * from comments WHERE post_id='$post_id'";

$comments = $pdoObj->query($query)->fetchAll();

$queryCategories = "SELECT * FROM category LIMIT 10";

$categories = $pdoObj->query($queryCategories)->fetchAll();

?>

<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وبلاگ</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <script src="../public/js/jquery-3.7.1.min.js"></script>
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
            <div class="text-xl font-bold mb-5">
                <span>نظرات</span>
                <span class="font-normal text-sm">(<?php echo count($comments); ?>)</span>
            </div>
            <div>

                <?php
                    if (empty($comments))
                        echo "هنوز نظری ثبت نشده است.";
                foreach ($comments as $comment){
                ?>
                    <div class="border-b border-b-slate-700 flex justify-between last:border-b-0 py-5" id="comment-<?php echo $comment['id']?>">
                        <div class="flex gap-x-10 pr-10">
                            <div class="text-sm w-5"><?php echo $comment['id'] ?></div>
                            <div class="text-sm"><?php
                                $user = $pdoObj->query("SELECT * FROM users WHERE id='$comment[user_id]'")->fetch();
                                echo $user['firstname'].' '.$user['lastname']?>
                            </div>
                            <div class="text-sm w-44 break-words"><?php echo $comment['contents'] ?></div>
                        </div>
                        <div class="flex items-center gap-x-2">
                            <a href="edit_post.php?id=<?php echo $post['id'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                            <button class="delete_comment" id="delete-comment-<?php echo $comment['id']?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php } ?>
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
    $(document).on('click',".delete_comment", function() {
        const comment_id = $(this)[0].id.split('-')[2]
        const comment = $('#comment-'+comment_id)
        $.ajax({
            url: '../api/client/comment.php?a=delete',
            method: 'post',
            data : {
                comment_id,
                post_id: <?php echo $_GET['post_id']?>
            },
            success : function (data) {
                comment.remove()
            }
        })
    });
</script>
</body>
</html>