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
            <div class="w-10">#</div>
            <div class="w-44">کاربر</div>
            <div class="w-32">تاریخ</div>
            <div class="w-72 mr-16">محتوا</div>
        </div>
        <div class="w-44 flex justify-center text-sm">
            <div class="w-10">عملیات</div>
        </div>
    </div>
    <div class="divide-y divide-gray-300 h-full overflow-y-auto pb-24">

        <?php

        if ($comments){

            foreach ($comments as $comment){

                ?>

                <div class="flex justify-between pt-4 pb-1 ">
                    <div class="flex pr-3 text-sm">
                        <div class="w-10"><?php echo $comment['id'] ?></div>
                        <div class="w-44 truncate"><?php $user = $pdoObj->query("SELECT * FROM users WHERE id='$comment[user_id]'")->fetch();echo $user['firstname']." ".$user["lastname"]; ?></div>
                        <div class="w-32"><?php echo convert_date($comment['comment_date'], true) ?></div>
                        <div class="w-72 mr-16"><?php echo $comment['contents'] ?></div>
                    </div>
                    <div class="w-44 justify-center text-sm flex gap-x-2">
                        <a href="index.php?s=comment&a=delete&id=<?php echo $comment['id'] ?>" class="mr-2 block">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </a>
                    </div>
                </div>

            <?php } } ?>
    </div>
</div>