<?php

$post_id = $_GET['post_id'];

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

$queryinfo = "SELECT title from posts where id = '$post_id'";

$info = $pdoObj->query($queryinfo)->fetch();

$title = $info['title'];

$query = "SELECT * From comments where post_id = '$post_id'";

$comments = $pdoObj->query($query)->fetchAll();

?>

<div class="flex justify-between w-full lg:max-w-screen-xl items-center mb-10">
    <div class="text-2xl font-bold"> لیست نظر های <?php echo $title; ?></div>
    <!--<a href="index.php?s=post&a=create" class="bg-white rounded-md p-2 shadow">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5">
            <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
        </svg>
    </a>-->
</div>
<div class="bg-white shadow w-full lg:max-w-screen-xl rounded-md p-4 h-5/6 overflow-hidden">
    <div class="bg-sky-200 rounded-md w-full p-1 mb-5">
        <input type="text" placeholder="عنوان ..." class="p-2 rounded-md text-sm outline-none w-72">
    </div>
    <div class="bg-sky-100 w-full p-1 py-3 rounded-md flex gap-x-4 justify-between">
        <div class="flex pr-3 text-sm">
            <div class="w-5">#</div>
            <div class="w-20">کاربر</div>
            <div class="w-28">تاریخ</div>
            <div class="w-28">محنوا</div>
        </div>
    </div>
    <div class="divide-y divide-gray-300 h-full overflow-y-auto pb-24">

        <?php

        if ($comments){

            foreach ($comments as $comment){

                ?>

                <div class="flex justify-between pt-4 pb-1 ">
                    <div class="flex pr-3 text-sm">
                        <div class="w-5"><?php echo $comment['id'] ?></div>
                        <div class="w-30 truncate"><?php $user = $pdoObj->query("SELECT * FROM users WHERE id='$comment[user_id]'")->fetch();echo $user['firstname']." ".$user["lastname"]; ?></div>
                        <div class="w-28"><?php echo convert_date($comment['comment_date'], true) ?></div>
                        <div class="w-28"><?php echo $comment['contents'] ?></div>
                    </div>

                </div>

            <?php } } ?>
    </div>
</div>