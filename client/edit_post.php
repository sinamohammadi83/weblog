<?php
if (isset($_GET['id'])){

    $pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

    $post_id = $_GET['id'];

    $query_find_post = "SELECT * FROM POSTS where id = $post_id";

    $post = $pdoObj->query($query_find_post)->fetch();

    if ($post){

$Category = "SELECT * FROM Category";

$get_category = $pdoObj->query($Category)->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    session_start();
    $picture = "";
    $image = $_FILES['image'];
    if ($image['name']){
        unlink($post['picture']);
        $endLink = explode('.',$image['name']);
        $link = "./public/images/post/".rand(1111111111,9999999999).".".$endLink[1];
        move_uploaded_file($image['tmp_name'],$link);
        $picture = $link;
    }else{
        $picture = $post['picture'];
    }


    $title = $_POST['title'];
    $slug = implode('-',explode(' ',$title));
    $description = $_POST['description'];
    $status = $_POST['status'];
    $category_id = $_POST['category_id'];
    $description_len = strlen($description);

    switch ($description_len){

        case $description_len < 500:
            $read_time = 2;
            break;
        case $description_len < 1000:
            $read_time = 3;
            break;
        case $description_len < 1500:
            $read_time = 4;
            break;
        case $description_len < 2000:
            $read_time = 5;
            break;
        case $description_len > 2500:
            $read_time = 6;
            break;
        default:
            $read_time = 1;

    }

    $user = $pdoObj->query("SELECT * FROM users WHERE email='$_SESSION[user_email]'")->fetch();

    $res = $pdoObj->query("UPDATE posts SET title='$title' ,description='$description' ,status='$status' ,slug='$slug' , category_id='$category_id' ,read_time='$read_time' , picture='$picture' WHERE id='$post[id]'");

    if ($res)
    {
        header('location:./dashboard.php');
    }
}
?>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ایجاد مقاله</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<div class="w-full h-screen bg-gray-50 overflow-x-hidden">
    <div class="flex justify-center w-full">
        <div class="lg:max-w-screen-lg w-full pt-10">
            <div class="flex items-center justify-between mb-10">
                <div class="flex gap-x-5">
                    <div class="text-2xl">وبلاگ</div>
                    <a href="dashboard.php" class="text-blue-500 underline">رفتن به پیش نویس ها</a>
                </div>
            </div>
        </div>
    </div>
    <div class="flex w-full">
        <form method="post" class="flex w-full" enctype="multipart/form-data">
            <div class="w-8/12 mr-56">
                <input value="<?php echo $post['title']?>" name="title" type="text" class="bg-inherit placeholder:text-gray-400 placeholder:font-bold text-xl mb-5 outline-none mr-10" placeholder="عنوان را اینجا وارد کنید">
                <textarea name="description" id="" cols="30" rows="10" class="bg-inherit w-full placeholder:text-slate-300 outline-none resize-none" placeholder="متن مقاله ..."><?php echo $post['description']?></textarea>
            </div>
            <div class="bg-white p-4 rounded-md w-64 shadow">
                <div class="mb-5">
                    <div class="text-sm text-slate-800 mb-2">عکس شاخص</div>
                    <img src="<?php echo $post['picture']?>" class="w-full rounded h-28 object-cover mb-3" alt="">
                    <input type="file" name="image">
                </div>
                <div class="mb-5">
                    <div class="text-sm text-slate-800 mb-2">دسته بندی</div>
                    <select name="category_id" class="border border-slate-800 rounded w-full py-1 text-sm">

                        <?php foreach ($get_category as $category){

                            ?>

                            <option <?php
                                if ($category['id'] == $post['category_id'])
                                    echo "selected"
                            ?> value="<?php echo $category['id']?>"><?php echo $category['title'] ?></option>

                        <?php } ?>
                    </select>
                </div>
                <div class="mb-10">
                    <div class="text-sm text-slate-800 mb-2">وضعیت انتشار</div>
                    <div class="flex rounded border border-gray-300 overflow-hidden">
                        <button type="button" class=" <?php
                        if ($post['status'] == "preview")
                            echo "bg-orange-500 text-white";
                        else
                            echo "bg-white text-black"
                        ?>  text-sm w-full py-2" id="draft">پیش نویس</button>
                        <button type="button" class=" <?php
                        if ($post['status'] == "publish")
                            echo "bg-blue-500 text-white";
                        else
                            echo "bg-white text-black"
                        ?> text-sm w-full py-2" id="publish">منتشر شده</button>
                    </div>
                    <div class="hidden">
                        <input type="radio" <?php
                        if ($post['status'] == "preview")
                            echo "checked"
                        ?> name="status" id="radio_draft" checked value="preview">
                        <input  <?php
                        if ($post['status'] == "publish")
                            echo "checked"
                        ?> type="radio" name="status" id="radio_publish" value="publish">
                    </div>
                </div>
                <input type="submit" value="انتشار نوشته" class="bg-blue-500 lg:cursor-pointer text-white text-sm rounded-md px-4 py-2 w-full"/>
            </div>
        </form>
    </div>
</div>
<script>
    const draft_button = document.getElementById('draft');
    const publish_button = document.getElementById('publish');
    const radio_draft = document.getElementById('radio_draft');
    const radio_publish = document.getElementById('radio_publish');

    draft_button.onclick = function (){
        draft_button.classList.add('bg-orange-500','text-white');
        draft_button.classList.remove('bg-white','text-black');
        publish_button.classList.remove('bg-blue-50','text-white');
        publish_button.classList.add('bg-white','text-black');
        radio_draft.checked = true;
    }

    publish_button.onclick = function (){
        draft_button.classList.remove('bg-orange-500','text-white');
        draft_button.classList.add('bg-white','text-black');
        publish_button.classList.add('bg-blue-500','text-white');
        publish_button.classList.remove('bg-white','text-black');
        radio_publish.checked = true;
    }
</script>
</body>
</html>
<?php
    }else{
        header('Location: ./404.html');
    }

    }else{
    header('location:./dashboard.php');
}