<?php

if (!isset($_SESSION['user_email']))
    header('location:../login.php');

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

$email = $_SESSION['user_email'];

$query = "SELECT * From users WHERE email = '$email'";

$user = $pdoObj->query($query)->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];


    $linkHeader = "location:./profile.php";
    $error = false;
    if ($firstname == "") {
        $linkHeader .= "&error_firstname=1";
        $error = true;
    }
    if ($lastname == "") {
        $linkHeader .= "&error_lastname=1";
        $error = true;
    }
    if ($password != $repassword) {
        $linkHeader .= "&error_password=2&error_repassword=2";
        $error = true;
    }
    if ($password) {
        $password = md5($password);
    } else {
        $password = $user['password'];
    }
    if ($error) {
        header($linkHeader);
        die();
    }

    $picture = $_FILES['image'];
    $link = "";
    if ($picture['name']) {
        if ($user['picture']) {
            unlink('../' . $user['picture']);
        }

        $end = explode('.', $picture['name'])[1];
        $link = "public/images/users/" . token(15) . '.' . $end;
        move_uploaded_file($picture['tmp_name'], '../' . $link);
    } else {
        $link = $user['picture'];
    }

    $res = $pdoObj->query("UPDATE users SET firstname='$firstname' , lastname='$lastname', password='$password' , picture='$link' WHERE id='$user[id]'");
    if ($res) {
        header('Location: index.php?s=profile&a=profile');
    }
}
?>

<div class="w-10/12 lg:max-w-screen-lg mb-10 text-xl font-bold">ویرایش پروفایل</div>
<div class="bg-white w-10/12 rounded-md shadow p-4 pb-0 text-sm lg:max-w-screen-lg">
    <form method="post" enctype="multipart/form-data">
        <div class="flex gap-x-2 w-full mb-5">
            <div class="w-full">
                <div class="mb-2">نام</div>
                <div>
                    <input type="text" name="firstname" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 " value="<?php echo $user['firstname']; ?>">
                </div>
            </div>
            <div class="w-full">
                <div class="mb-2">نام خانوادگی</div>
                <div>
                    <input type="text" name="lastname" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 " value="<?php echo $user['lastname']; ?>">
                </div>
            </div>
        </div>
        <div class="flex gap-x-2 w-full mb-5">
            <div class="w-full">
                <div class="mb-2">رمز عبور</div>
                <div>
                    <input type="password" name="password" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
                </div>
            </div>
            <div class="w-full">
                <div class="mb-2">تکرار رمز عبور</div>
                <div>
                    <input type="password" name="repassword" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
                </div>
            </div>
        </div>
        <div class="w-full mb-10">
            <div class="mb-2">عکس پروفایل</div>
            <div>
                <input type="file" name="image" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10">
            </div>
        </div>
        <div class="flex justify-end">
            <input type="submit" value="ثبت" class="bg-blue-500 lg:cursor-pointer text-white text-sm rounded-md px-4 py-2 w-1/12"/>
        </div>
    </form>
</div>