<?php

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

$Category = "SELECT * FROM Category";

$get_category = $pdoObj->query($Category)->fetchAll();

$user = $pdoObj->query("SELECT * FROM users WHERE email='$_SESSION[user_email]'")->fetch();

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    $image = $_FILES['image'];
    $endLink = explode('.',$image['name']);
    $link = "public/images/post/".token(15).".".$endLink[1];
    move_uploaded_file($image['tmp_name'],"../".$link);

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

    $linkHeader = "location:index.php?s=post&a=create";
    $error = false;
/*    if (!isset($image))
    {
        $linkHeader.="&error_image=1";
        $error = true;
    }*/
    if ($title == "")
    {
        $linkHeader.="&error_title=1";
        $error = true;
    }
    if ($description == "")
    {
        $linkHeader.="&error_description=1";
        $error = true;
    }
    if ($status == "")
    {
        $linkHeader.="&error_status=1";
        $error = true;
    }
    if ($category_id == "")
    {
        $linkHeader.="&error_category_id=1";
        $error = true;
    }
    if ($error)
    {
        header($linkHeader);
        die();
    }

    $res = $pdoObj->query("INSERT INTO posts (title,description,user_id,status,slug, category_id, read_time, picture) VALUES ('$title','$description','$user[id]','$status','$slug','$category_id','$read_time','$link')");

    if ($res)
    {
        header('Location: index.php?s=post&a=index');
    }
}

?>
    <div class="w-10/12 lg:max-w-screen-lg mb-10 text-xl font-bold">ایجاد مقاله</div>
    <div class="bg-white w-10/12 rounded-md shadow p-4 pb-0 text-sm lg:max-w-screen-lg">
        <form method="post" enctype="multipart/form-data">
            <div class="flex w-full gap-x-4 mb-5">
                <div class="w-full">
                    <div class="mb-2">عنوان</div>
                    <div>
                        <input type="text" name="title" class="border-2 border-gray-200 <?php if (isset($_GET['error_title'])) echo 'border-red-500'?> w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
                    </div>
                    <?php
                    if (isset($_GET['error_title']))
                    {
                        if ($_GET['error_title'] == 1)
                        {
                            ?>
                            <div class="text-xs text-red-500 mt-2">فیلد عنوان اجباری است.</div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="w-full">
                    <div class="mb-2">دسته بندی</div>
                    <div>
                        <select type="text" name="category_id" class="border-2 border-gray-200  w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
                            <?php foreach ($get_category as $category){

                                ?>

                                <option value="<?php echo $category['id']?>"><?php echo $category['title'] ?></option>

                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="w-full mb-5">
                <div class="mb-2">محتوا</div>
                <div>
                    <textarea type="text" name="description" class="border-2 border-gray-200 <?php if (isset($_GET['error_description'])) echo 'border-red-500'?> w-full p-2 rounded-md outline-none focus:border-blue-500 h-44 resize-none"></textarea>
                </div>
                <?php
                if (isset($_GET['error_description']))
                {
                    if ($_GET['error_description'] == 1)
                    {
                        ?>
                        <div class="text-xs text-red-500 mt-2">فیلد محتوا اجباری است.</div>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="mb-5">
                <div class="text-sm text-slate-800 mb-2">عکس شاخص</div>
                <input type="file" name="image">
            </div>
            <div class="mb-10 w-44">
                <div class="text-sm text-slate-800 mb-2">وضعیت انتشار</div>
                <div class="flex rounded border border-gray-300 overflow-hidden">
                    <button type="button" class="bg-orange-500 text-white text-sm w-full py-2" id="draft">پیش نویس</button>
                    <button type="button" class="bg-white text-black text-sm w-full py-2" id="publish">منتشر شده</button>
                </div>
                <div class="hidden">
                    <input type="radio" name="status" id="radio_draft" checked value="preview">
                    <input type="radio" name="status" id="radio_publish" value="publish">
                </div>
            </div>
            <div class="flex justify-end">
                <input type="submit" value="ثبت" class="bg-blue-500 lg:cursor-pointer text-white text-sm rounded-md px-4 py-2 w-1/12"/>
            </div>
        </form>
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