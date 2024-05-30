<?php

$action = $_GET['a'];
$pdoObj = new PDO("mysql:host=localhost;dbname=weblog","root","");
switch ($action){
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
            header('Content-type: text/plain; charset=utf-8');
            session_start();
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
        $comment_id = $_POST['comment_id'];
        $pdoObj->query("DELETE FROM comments WHERE id='$comment_id'");
        echo "دیدگاه با موفقیت حذف شد.";
    break;
}