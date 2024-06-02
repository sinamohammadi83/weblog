<?php

$user_id = $_GET['user_id'];

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

$queryinfo = "SELECT firstname, lastname from users where id = '$user_id'";

$info = $pdoObj->query($queryinfo)->fetch();

$fullname = $info['firstname']." ".$info['lastname'];

$query = "SELECT * From posts where user_id = '$user_id'";

$posts = $pdoObj->query($query)->fetchAll();

?>

<div class="flex justify-between w-full lg:max-w-screen-xl items-center mb-10">
    <div class="text-2xl font-bold"> لیست مقاله های <?php echo $fullname; ?></div>
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
            <div class="w-20">عنوان</div>
            <div class="w-28">دسته بندی</div>
        </div>
        <div class="pl-20 text-sm">
            <div class="w-5">عملیات</div>
        </div>
    </div>
    <div class="divide-y divide-gray-300 h-full overflow-y-auto pb-24">

        <?php

        if ($posts){

            foreach ($posts as $post){

                ?>

                <div class="flex justify-between pt-4 pb-1 ">
                    <div class="flex pr-3 text-sm">
                        <div class="w-5"><?php echo $post['id'] ?></div>
                        <div class="w-20 truncate"><?php echo $post['title'] ?></div>
                        <div class="w-28"><?php $category = $pdoObj->query("SELECT * FROM category WHERE id='$post[category_id]'")->fetch();echo $category['title']?></div>
                    </div>
                    <div class="pl-5 text-sm flex gap-x-2">
                        <div class="">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </span>
                            <span class="text-xs text-slate-800 text-center mr-2">
                                <?php echo $pdoObj->query("SELECT COUNT(post_id) FROM likes WHERE post_id='$post[id]'")->fetch()[0]?>
                            </span>
                        </div>
                        <a href="index.php?s=post&a=comments&post_id=<?php echo $post['id'] ?>" class="flex flex-col items-center">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                                </svg>
                            </span>
                                <div class="text-xs text-slate-800 text-center w-10 inline-flex justify-center">
                                    <?php echo $pdoObj->query("SELECT COUNT(id) FROM comments WHERE post_id='$post[id]'")->fetch()[0]?>
                                </div>
                            </a>
                        <a href="index.php?s=post&a=edit&post_id=<?php echo $post['id'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                        </a>
                        <a href="index.php?s=post&a=delete&post_id=<?php echo $post['id'] ?>" class="mr-2 block">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </a>
                    </div>
                </div>

            <?php } } ?>
    </div>
</div>