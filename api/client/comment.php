<?php
session_start();
$action = $_GET['a'];
$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");
switch ($action){
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['user_email']))
        {
            header('Content-type: text/plain; charset=utf-8');

            $content = $_POST['content'];
            if (strlen($content) > 50)
            {
                $user_email = $_SESSION['user_email'];
                $user = $pdoObj->query("SELECT * FROM users WHERE email='$user_email'")->fetch();
                $post_id = $_POST['post_id'];

                $comment = $pdoObj->query("INSERT INTO comments (user_id,post_id,contents) VALUES ('$user[id]','$post_id','$content')");
                echo json_encode([
                    'comment' => [
                        'id' => $pdoObj->lastInsertId(),
                        'user' => [
                            'firstname' => $user['firstname'],
                            'lastname' => $user['lastname'],
                        ],
                        'content' => $content,
                        'comment_date' => '1403/2/2'
                    ]
                ]);
            }
        }
        break;
    case 'delete':
        if (isset($_SESSION['user_email'])) {
            $comment_id = $_POST['comment_id'];
            $user = $pdoObj->query("SELECT * FROM users WHERE email='$_SESSION[user_email]'")->fetch();
            $post_id = $_POST['post_id'];
            $post = $pdoObj->query("SELECT * FROM posts WHERE id='$post_id' AND user_id='$user[id]'")->fetch();
            $pdoObj->query("DELETE FROM comments WHERE id='$comment_id' AND post_id='$post[id]'");
            echo "دیدگاه با موفقیت حذف شد.";
        }
        break;
}