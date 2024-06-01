<?php

$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");

$post_id = $_GET['post_id'];

$Category = "SELECT * FROM Category";

$get_category = $pdoObj->query($Category)->fetchAll();

$post_query = "SELECT * FROM posts WHERE id='$post_id'";

$get_post = $pdoObj->query($post_query)->fetch();

$post_title = $get_post['title'];

$post_description = $get_post['description'];

$post_status = $get_post['status'];

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    $title = $_POST['title'];
    $slug = implode('-',explode(' ',$title));
    $description = $_POST['description'];
    $status = $_POST['status'];
    $category_id = $_POST['category_id'];
    $description_len = strlen($description);

    $image = $_FILES['image'];
    if ($image['name'])
    {
        unlink('../'.$get_post['picture']);
        $end = explode('.',$image['name'])[1];
        $link = "public/images/post/".token(15).'.'.$end;
        move_uploaded_file($image['tmp_name'],'../'.$link);
    }else{
        $link = $get_post['picture'];
    }

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

    $res = $pdoObj->query("UPDATE posts SET title='$title' ,description='$description' ,status='$status' ,slug='$slug' , category_id='$category_id' ,read_time='$read_time',picture='$link' WHERE id='$post_id'");

    if ($res)
    {
        header('Location: index.php?s=post&a=index');
    }
}

?>
<div class="w-10/12 lg:max-w-screen-lg mb-10 text-xl font-bold">ویرایش مقاله</div>
<div class="bg-white w-10/12 rounded-md shadow p-4 pb-0 text-sm lg:max-w-screen-lg">
    <form method="post" enctype="multipart/form-data">
        <div class="flex w-full gap-x-4 mb-5">
            <div class="w-full">
                <div class="mb-2">عنوان</div>
                <div>
                    <input type="text" name="title" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 " value="<?php echo $post_title ?>">
                </div>
            </div>
            <div class="w-full">
                <div class="mb-2">دسته بندی</div>
                <div>
                    <select type="text" name="category_id" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-10 ">
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
                <textarea type="text" name="description" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-44 resize-none"><?php echo $post_description ?></textarea>
            </div>
        </div>
        <div class="mb-5 flex justify-between">
            <div>
                <div class="text-sm text-slate-800 mb-2">عکس شاخص</div>
                <input type="file" name="image" class="border-2 border-gray-200 w-full p-2 rounded-md outline-none focus:border-blue-500 h-12">
            </div>
            <div>
                <img src="../<?php echo $get_post['picture']?>" class="rounded-md w-44 h-28" alt="">
            </div>
        </div>
        <div class="mb-10 w-44">
            <div class="text-sm text-slate-800 mb-2">وضعیت انتشار</div>
            <div class="flex rounded border border-gray-300 overflow-hidden">
                <button type="button" class="<?php echo $get_post['status']=='preview' ? "bg-orange-500 text-white" : "text-black bg-white"?> text-sm w-full py-2" id="draft">پیش نویس</button>
                <button type="button" class="<?php echo $get_post['status']=='publish' ? "bg-blue-500 text-white" : "text-black bg-white"?> text-sm w-full py-2" id="publish">منتشر شده</button>
            </div>
            <div class="hidden">
                <input type="radio" name="status" id="radio_draft" <?php if ($get_post['status']=='preview') echo "checked" ?> value="preview">
                <input type="radio" name="status" id="radio_publish" <?php if ($get_post['status']=='publish') echo "checked" ?> value="publish">
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