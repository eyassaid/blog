<?php
require_once __DIR__. '/../../templates/header.php';
require_once __DIR__.'/../../controllers/PostController.php';
if (!$is_logged_in) header('Location:'.$home);
$error=false;
if ($_SERVER['REQUEST_METHOD'] === "POST"){
    $title = htmlspecialchars($_POST['title']) ?? null;
    $body = htmlspecialchars($_POST['body']) ?? null;
    if (!$title || !$body) {
        $error = true;
        require __DIR__.'/../message.php';
    }else{
        $stmt = new PostController($pdo);
        $stmt->create_post($title,$body,$user_id);
        header('location:'.$home);
    }


}
?>
    <?php if ($error) Message::error('all fields are required')?>
<div class="container d-flex justify-content-center m-3  ">
 
    <form method="POST">
        <div class='form-group m-2'>
            <input name='title' id='title' class="form-control" placeholder="title">
        </div>
        <div class='form-group m-2'>
            <textarea name="body" id="body" cols="30" rows="10"></textarea>
        </div>
        <div class="form-group m-2">
            <button type="submit" class="btn btn-primary">Create</button>

        </div>
    </form>
</div>