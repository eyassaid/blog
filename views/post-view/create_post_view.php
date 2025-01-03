<?php
require_once __DIR__. '/../../templates/header.php';
if (!$is_logged_in) header('Location:'.$home);
require_once __DIR__. '/../../controllers/PostController.php';
$post_controller = new PostController;
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = htmlspecialchars($_POST['title']);
    $body = htmlspecialchars($_POST['body']);
    $post_controller->create_post($title,$body);
    header('Location:'.$home);
}
?>
<div class="container d-flex justify-content-center m-3  ">
 
    <form method="POST">
        <input type="hidden" name="_method" value="create_post">
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