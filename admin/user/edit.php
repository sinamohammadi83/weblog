<?php
$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");
$user_id = $_GET['user_id'];
$user = $pdoObj->query("SELECT * FROM users WHERE id='$user_id'")->fetch();
if ($_SERVER['REQUEST_METHOD'] == "POST"){

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $linkHeader = "location:index.php?s=user&a=edit&user_id=$user_id";
    $error = false;
    if ($firstname == "")
    {
        $linkHeader.="&error_firstname=1";
        $error = true;
    }
    if ($lastname == "")
    {
        $linkHeader.="&error_lastname=1";
        $error = true;
    }
    if ($email == "")
    {
        $linkHeader.="&error_email=1";
        $error = true;
    }
    if ($password != $repassword)
    {
        $linkHeader.="&error_password=2&error_repassword=2";
        $error = true;
    }
    if ($password){
        $password = md5($password);
    }else{
        $password = $user['password'];
    }
    $emailExists = $pdoObj->query("SELECT * FROM users WHERE email='$email'")->fetch();
    if ($emailExists['id']!=$user['id']){
        $linkHeader.="&error_email=2";
        $error = true;
    }
    if ($error)
    {
        header($linkHeader);
        die();
    }
    $role = $_POST['role'];
    $picture = $_FILES['picture'];
    $link = "";
    if ($picture['name'])
    {
        unlink('../'.$user['picture']);
        $end = explode('.',$picture['name'])[1];
        $link = "public/images/users/".token(15).'.'.$end;
        move_uploaded_file($picture['tmp_name'],'../'.$link);
    }else{
        $link = $user['picture'];
    }

    $res = $pdoObj->query("UPDATE users SET firstname='$firstname' , lastname='$lastname' , email='$email' , password='$password' , picture='$link' , role='$role' WHERE id='$user[id]'");
    if ($res)
    {
        header('Location: index.php?s=user&a=index');
    }
}

?>
<div class="w-10/12 lg:max-w-screen-lg mb-10 text-xl font-bold">ویرایش کاربر</div>
<div class="bg-white w-10/12 rounded-md shadow p-4 pb-0 text-sm lg:max-w-screen-lg">
    <form method="post" enctype="multipart/form-data">
        <div class="w-full mb-5">
            <div class="mb-2">نام</div>
            <div>
                <input type="text" value="<?php echo $user['firstname'] ?>" name="firstname" class="border-2 border-gray-200 <?php if (isset($_GET['error_firstname'])) echo 'border-red-500'?> w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
            </div>
            <?php
            if (isset($_GET['error_firstname']))
            {
                if ($_GET['error_firstname'] == 1)
                {
                    ?>
                    <div class="text-xs text-red-500 mt-2">فیلد نام اجباری است.</div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="w-full mb-5">
            <div class="mb-2">نام خانوادگی</div>
            <div>
                <input type="text" value="<?php echo $user['lastname'] ?>" name="lastname" class="border-2 border-gray-200 <?php if (isset($_GET['error_lastname'])) echo 'border-red-500'?> w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
            </div>
            <?php
            if (isset($_GET['error_lastname']))
            {
                if ($_GET['error_lastname'] == 1)
                {
                    ?>
                    <div class="text-xs text-red-500 mt-2">فیلد نام خانوادگی اجباری است.</div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="w-full mb-5">
            <div class="mb-2">ایمیل</div>
            <div>
                <input type="text" value="<?php echo $user['email'] ?>" name="email" class="border-2 border-gray-200 <?php if (isset($_GET['error_email'])) echo 'border-red-500'?> w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
            </div>
            <?php
            if (isset($_GET['error_email']))
            {
                if ($_GET['error_email'] == 1)
                {
                    ?>
                    <div class="text-xs text-red-500 mt-2">فیلد ایمیل اجباری است.</div>
                    <?php
                }else if ($_GET['error_email'] == 2){
                    ?>
                    <div class="text-xs text-red-500 mt-2">ایمیل تکراری است ایمیل دیگری را وارد نمایید.</div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="w-full mb-5">
            <div class="mb-2">رمز عبور</div>
            <div>
                <input type="password" name="password" class="border-2 border-gray-200 <?php if (isset($_GET['error_password'])) echo 'border-red-500'?> w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
            </div>
            <?php
            if (isset($_GET['error_password']))
            {
                if ($_GET['error_password'] == 1)
                {
                    ?>
                    <div class="text-xs text-red-500 mt-2">فیلد رمز عبور اجباری است.</div>
                    <?php
                }else if ($_GET['error_password'] == 2){
                    ?>
                    <div class="text-xs text-red-500 mt-2">فیلد رمز عبور و تکرار آن یکسان نیست</div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="w-full mb-5">
            <div class="mb-2">تکرار رمز عبور</div>
            <div>
                <input type="password" name="repassword" class="border-2 border-gray-200 <?php if (isset($_GET['error_repassword'])) echo 'border-red-500'?> w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
            </div>
            <?php
            if (isset($_GET['error_repassword']))
            {
                if ($_GET['error_repassword'] == 1)
                {
                    ?>
                    <div class="text-xs text-red-500 mt-2">فیلد تکرار رمز عبور اجباری است.</div>
                    <?php
                }else if ($_GET['error_repassword'] == 2){
                    ?>
                    <div class="text-xs text-red-500 mt-2">فیلد رمز عبور و تکرار آن یکسان نیست</div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="w-full mb-5">
            <div class="mb-2">عکس پروفایل</div>
            <div>
                <input type="file" name="picture" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
            </div>
        </div>
        <div class="w-full mb-5">
            <div class="mb-2">نقش</div>
            <div>
                <select name="role" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
                    <option <?php
                        if ($user['role'] == 'user')
                            echo 'selected'
                    ?> value="user">کاربر</option>
                    <option <?php
                        if ($user['role'] == 'admin')
                            echo 'selected'
                    ?> value="admin">مدیر</option>
                </select>
            </div>
        </div>
        <div class="flex justify-end">
            <input type="submit" value="بروزرسانی" class="bg-blue-500 lg:cursor-pointer text-white text-sm rounded-md px-4 py-2"/>
        </div>
    </form>
</div>