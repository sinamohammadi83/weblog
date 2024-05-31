<?php

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

$query = "SELECT * From users";

$users = $pdoObj->query($query)->fetchAll();

?>

<div class="flex justify-between w-full lg:max-w-screen-xl items-center mb-10">
    <div class="text-2xl font-bold">لیست کاربران</div>
    <a href="index.php?s=user&a=create" class="bg-white rounded-md p-2 shadow">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5">
            <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
        </svg>
    </a>
</div>
<div class="bg-white shadow w-full lg:max-w-screen-xl rounded-md p-4 h-5/6 overflow-hidden">
    <div class="bg-sky-200 rounded-md w-full p-1 mb-5">
        <input type="text" placeholder="عنوان ..." class="p-2 rounded-md text-sm outline-none w-72">
    </div>
    <div class="bg-sky-100 w-full p-1 py-3 rounded-md flex gap-x-4 justify-between">
        <div class="flex pr-3 text-sm">
            <div class="w-10">#</div>
            <div class="w-44">نام و نام خانوادگی</div>
            <div class="w-48">ایمیل</div>
            <div class="w-20">تاریخ ثبت نام</div>
        </div>
        <div class="flex justify-center w-56 text-sm">
            <div class="w-5">عملیات</div>
        </div>
    </div>
    <div class="divide-y divide-gray-300 h-full overflow-y-auto pb-24">

        <?php

        if ($users){

            foreach ($users as $user){

                ?>

                <div class="flex justify-between pt-4 pb-1 ">
                    <div class="flex pr-3 text-sm">
                        <div class="w-10"><?php echo $user['id'] ?></div>
                        <div class="w-44 truncate"><?php echo $user['firstname'] .' '.$user['lastname'] ?></div>
                        <div class="w-44 truncate"><?php echo $user['email'] ?></div>
                        <div class="w-20 mr-5"><?php echo convert_date($user['reg_date'])?></div>
                    </div>
                    <div class="justify-center w-52 text-sm flex gap-x-2">
                        <a href="" class="flex flex-col items-center">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="w-5 h-5">
                                    <path d="M320 480H64c-17.7 0-32-14.3-32-32V64c0-17.7 14.3-32 32-32H192V144c0 26.5 21.5 48 48 48H352V448c0 17.7-14.3 32-32 32zM240 160c-8.8 0-16-7.2-16-16V32.5c2.8 .7 5.4 2.1 7.4 4.2L347.3 152.6c2.1 2.1 3.5 4.6 4.2 7.4H240zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V163.9c0-12.7-5.1-24.9-14.1-33.9L254.1 14.1c-9-9-21.2-14.1-33.9-14.1H64zm0 80c0 8.8 7.2 16 16 16h64c8.8 0 16-7.2 16-16s-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zm0 64c0 8.8 7.2 16 16 16h64c8.8 0 16-7.2 16-16s-7.2-16-16-16H80c-8.8 0-16 7.2-16 16zM224 432c0 8.8 7.2 16 16 16h64c8.8 0 16-7.2 16-16s-7.2-16-16-16H240c-8.8 0-16 7.2-16 16zm64-96H96V272H288v64zM96 240c-17.7 0-32 14.3-32 32v64c0 17.7 14.3 32 32 32H288c17.7 0 32-14.3 32-32V272c0-17.7-14.3-32-32-32H96z"/>
                                </svg>
                            </span>
                            <div class="text-xs text-slate-800 text-center w-10 inline-flex justify-center mt-1">
                                <?php echo $pdoObj->query("SELECT COUNT(id) FROM posts WHERE user_id='$user[id]'")->fetch()[0]?>
                            </div>
                        </a>
                        <a href="index.php?s=user&a=edit&user_id=<?php echo $user['id'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                        </a>
                        <a href="index.php?s=user&a=delete&user_id=<?php echo $user['id'] ?>" class="mr-2 block">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </a>
                    </div>
                </div>

            <?php } } ?>
    </div>
</div>