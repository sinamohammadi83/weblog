
<?php
session_start();

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

$user_login = "";
if (isset($_SESSION['user_email']))
    $user_login = $pdoObj->query("SELECT * FROM users WHERE email='$_SESSION[user_email]'")->fetch();

$slug = $_GET['post'];

$query = "SELECT * From posts where slug='$slug'";

$post = $pdoObj->query($query)->fetch();

$comments = $pdoObj->query("SELECT * FROM comments WHERE post_id='$post[id]'");

$queryCategories = "SELECT * FROM category LIMIT 10";

$categories = $pdoObj->query($queryCategories)->fetchAll();

$user = $pdoObj->query("SELECT * FROM users WHERE id='$post[user_id]'")->fetch();
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
            <input type="text" class="bg-gray-100 w-96 h-10 rounded-md outline-none px-2"/>
            <a href="./login.php" class="text-sm py-2 px-4 flex items-center bg-blue-500 rounded-md text-white">ورود / ثبت نام</a>
        </div>
        <nav class="gap-x-4 flex lg:max-w-screen-xl w-full border-b pb-4 px-10 border-b-gray-300">
            <a href="">درباره ما</a>
            <a href="">ارتباط با ما</a>
        </nav>
    </header>
    <main class="flex w-full lg:max-w-screen-xl">
        <div class="w-9/12 border-l flex flex-col gap-y-6  pr-4">
            <div class="p-4 border-b">
                <div class="flex mb-5">
                    <a href="" class="text-xs flex items-center gap-x-1">
                        <?php
                            if ($user['picture'])
                            {
                        ?>
                            <img class="w-10 h-10 rounded-full" src="<?php echo $user['picture'] ?>" alt="<?php echo $user['firstname']." ".$user["lastname"] ?>">
                        <?php
                            }else{
                        ?>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </span>
                        <?php
                            }

                        ?>
                        <span><?php echo $user['firstname']." ".$user["lastname"]?></span>
                        <span class="text-slate-500">. 2 ساعت پیش</span>
                    </a>
                </div>
                <div class="text-2xl font-bold mb-5">
                    <?php echo $post['title'] ?>
                </div>
                <div class="text-sm text-slate-800 w-10/12 leading-8 mb-10 break-words">
                    <?php echo $post['description'] ?>
                </div>
                <div class="flex gap-x-4 items-center mb-10">
                    <span class="text-slate-700 bg-gray-300 text-sm p-1 px-2 rounded">امنیت سایبری</span>
                    <span class="text-slate-700 bg-gray-300 text-sm p-1 px-2 rounded">امنیت سایبری</span>
                    <span class="text-slate-700 bg-gray-300 text-sm p-1 px-2 rounded">امنیت سایبری</span>
                </div>
                <div>
                    <div class="text-2xl mb-5">نظرات</div>
                    <?php
                        if (isset($_SESSION['user_email'])){
                    ?>
                    <div class="mb-10">
                        <textarea id="content" class="w-full h-44 outline-none border border-gray-400 p-4 rounded focus:border-2 focus:border-blue-500 resize-none" cols="30" rows="10"></textarea>
                        <div class="mt-5 flex justify-end">
                            <button class="bg-blue-500 text-white rounded-md px-4 py-2 text-sm" id="send_comment">فرستادن دیدگاه</button>
                        </div>
                    </div>
                    <?php } ?>
                    <div id="comments">
                        <?php foreach ($comments as $comment){ ?>
                        <div class="border-blue-200 border p-4 rounded-md w-8/12 mb-5 shadow" id="comment-<?php echo $comment['id']?>">
                            <div class="mb-5 flex items-center">
                                <span class=" border-slate-800 border rounded-full p-1 w-10 h-10 flex justify-center items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5">
                                        <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/>
                                    </svg>
                                </span>
                                <span class="text-sm text-slate-800 mr-3">
                                    <?php
                                        $comment_user = $pdoObj->query("SELECT * FROM users WHERE id='$comment[user_id]'")->fetch();
                                        echo $comment_user['firstname'] . ' ' . $comment_user['lastname']
                                    ?>
                                </span>
                                <span class="text-xs text-slate-500 mr-1"> .
                                    <?php echo $comment['comment_date']?>
                                </span>
                            </div>
                            <div class="break-words text-sm text-slate-800 leading-8">
                                <?php echo $comment['contents']?>
                            </div>
                            <div class="flex justify-end gap-x-2">
                                <button class="text-xs text-blue-500 underline">پاسخ</button>
                                <?php if ($user_login && $comment['user_id'] == $user_login['id']){ ?>
                                    <button class="text-xs text-red-500 underline delete_comment" id="delete-comment-<?php echo $comment['id']?>">حذف</button>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
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
                        <a href="" class="border border-black rounded-md text-sm py-1 px-2 whitespace-nowrap">
                            <?php echo $category['title'] ?>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
    const content = document.getElementById('content')
    const send_comment = document.getElementById('send_comment')
    const comments = document.getElementById('comments')
    const delete_comment = document.getElementsByClassName('delete_comment')
    send_comment.onclick = function (){
        $.ajax({
            url : './api/comment.php?a=add',
            method : 'post',
            data : {
                content : content.value,
                post_id : <?php echo $post['id']?>
            },
            success : function (data){
                content.value=""
                const befor = comments.innerHTML
                const comment = JSON.parse(data).comment
                comments.innerHTML=
                '<div class="border-blue-200 border p-4 rounded-md w-8/12 mb-5 shadow" id="comment-'+comment.id+'">'
                    +'<div class="mb-5 flex items-center">'
                        +'<span class=" border-slate-800 border rounded-full p-1 w-10 h-10 flex justify-center items-center">'
                            +'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5">'
                            +'<path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/>'
                            +'</svg>'
                        +'</span>'
                        +'<span class="text-sm text-slate-800 mr-3">'
                            +comment.user.firstname
                        +'</span>'
                        +'<span class="text-xs text-slate-500 mr-1"> .'
                            +comment.comment_date
                        +'</span>'
                    +'</div>'
                    +'<div class="break-words text-sm text-slate-800 leading-8">'
                        +comment.content
                    +'</div>'
                    +'<div class="flex justify-end gap-x-2">'
                        +'<button class="text-xs text-blue-500 underline">پاسخ</button>'
                        +'<button class="text-xs text-red-500 underline delete_comment" id="delete-comment-'+comment.id+'">حذف</button>'
                    +'</div>'
                +'</div>'+befor
            }
        })
    }
    $(document).on('click',".delete_comment", function() {
        const comment_id = $(this)[0].id.split('-')[2]
        const comment = $('#comment-'+comment_id)
        $.ajax({
            url: './api/comment.php?a=delete',
            method: 'post',
            data : {
                comment_id,
            },
            success : function (data) {
                comment.remove()
            }
        })
    });


</script>

</body>
</html>
