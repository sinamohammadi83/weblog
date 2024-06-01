<?php

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    $title = $_POST['title'];

    $linkHeader = "location:index.php?s=category&a=create";
    $error = false;

    if ($title == "")
    {
        $linkHeader.="&error_title=1";
        $error = true;
    }
    if ($error)
    {
        header($linkHeader);
        die();
    }

    $res = $pdoObj->query("INSERT INTO category (title) VALUES ('$title')");

    if ($res)
    {
        header('Location: index.php?s=category&a=index');
    }
}

?>

<div class="w-10/12 lg:max-w-screen-lg mb-10 text-xl font-bold">ایجاد دسته بندی</div>
<div class="bg-white w-10/12 rounded-md shadow p-4 pb-0 text-sm lg:max-w-screen-lg">
    <form method="post">
        <div class="w-full mb-10">
            <div class="mb-2">عنوان</div>
            <div>
                <input type="text" name="title" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
            </div>
        </div>
        <div class="flex justify-end">
            <input type="submit" value="ثبت" class="bg-blue-500 lg:cursor-pointer text-white text-sm rounded-md px-4 py-2 w-1/12"/>
        </div>
    </form>
</div>