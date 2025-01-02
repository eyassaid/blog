<?php 
$app_url = 'http://localhost/blog';

$nav = [
    'controllers'=>$app_url.'/controllers',
    'post_controller'=>$app_url.'/controllers/PostController.php',
    'comment_controller'=>$app_url.'/controllers/CommentController.php',
    'up_vote_controller'=>$app_url.'/controllers/VoteController.php',
    'templates'=>$app_url.'/templates',
    'views' => $app_url.'/views',
    'login'=>$app_url.'/views'.'/register/login.php',
    'register'=>$app_url.'/views'.'/register/register.php',
    'logout'=>$app_url.'/views'.'/register/logout.php',
    'post_views' =>$app_url.'/views'.'/post-view',
    'home'=>$app_url.'/index.php',
    'post_view'=>$app_url.'/views/post-view/post_view.php',
    'edit_post_view'=>$app_url.'/views/post-view/edit_post_view.php',
    'create_post_view'=>$app_url.'/views/post-view/create_post_view.php',
    'delete_post'=>$app_url.'/views/post-view/delete_post.php',
    'message_view'=>$app_url.'/views/message.php'     
];

?>