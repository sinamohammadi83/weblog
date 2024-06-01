<?php
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $linkHeader = "location:index.php?s=user&a=create";
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
    if ($password == "")
    {
        $linkHeader.="&error_password=1";
        $error = true;
    }
    if ($repassword == "")
    {
        $linkHeader.="&error_repassword=1";
        $error = true;
    }
    if ($password != $repassword)
    {
        $linkHeader.="&error_password=2&error_repassword=2";
        $error = true;
    }
    $emailExists = $pdoObj->query("SELECT * FROM users WHERE email='$email'")->fetch();
    if ($emailExists){
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
        $end = explode('.',$picture['name'])[1];
        $link = "public/images/users/".token(15).'.'.$end;
        move_uploaded_file($picture['tmp_name'],'../'.$link);
    }else{
        $link = "";
    }

    $res = $pdoObj->query("INSERT INTO users (firstname,lastname,email,password,role,picture) VALUES ('$firstname','$lastname','$email',md5('$password'),'$role','$link')");
    if ($res)
    {
        header('Location: index.php?s=user&a=index');
    }
}

?>
<div class="w-10/12 lg:max-w-screen-lg mb-10 text-xl font-bold">ایجاد کاربر</div>
<div class="bg-white w-10/12 rounded-md shadow p-4 pb-0 text-sm lg:max-w-screen-lg">
    <form method="post" enctype="multipart/form-data">
        <div class="w-full mb-5">
            <div class="mb-2">نام</div>
            <div>
                <input type="text" name="firstname" class="border-2 border-gray-200 <?php if (isset($_GET['error_firstname'])) echo 'border-red-500'?> w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
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
                <input type="text" name="lastname" class="border-2 border-gray-200 <?php if (isset($_GET['error_lastname'])) echo 'border-red-500'?> w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
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
                <input type="text" name="email" class="border-2 border-gray-200 <?php if (isset($_GET['error_email'])) echo 'border-red-500'?> w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
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
                    <option value="user">کاربر</option>
                    <option value="admin">مدیر</option>
                </select>
            </div>
        </div>
        <div class="flex justify-end">
            <input type="submit" value="ثبت" class="bg-blue-500 lg:cursor-pointer text-white text-sm rounded-md px-4 py-2 w-1/12"/>
        </div>
    </form>
</div>