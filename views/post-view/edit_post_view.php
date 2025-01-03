<?php
require_once __DIR__.'/../../templates/header.php';
$post_id = $_GET['post_id'] ?? null;
$success = false;
if (!$is_logged_in || !$post_id) header($home);
require_once __DIR__.'/../../controllers/PostController.php';
require_once __DIR__.'/../message.php';

$post_controller = new PostController();
// i can't access the post_id  if form action was directed to the controller page 
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $title = htmlspecialchars($_POST['title']);
    $body = htmlspecialchars($_POST['body']);
    $post_controller->edit_post($title,$body);
    header('Location:'.$home);
}


$current_post =$post_controller->get_post();

if ($current_post['user_id'] != $user_id ) header('Location:'.$home);

?>
<?php if ($success) Message::success('successfully updated') ?>
<div class="container d-flex justify-content-center m-3  ">
 
    <form method="POST">
        <div class='form-group m-2'>
            <input type="hidden" name="_method" value="edit_post">
            <input name='title' id='title' value="<?= $current_post['title'] ?>" class="form-control" placeholder="title">
        </div>
        <div class='form-group m-2'>
            <textarea name="body" id="body" cols="30" rows="10">
                <?= $current_post['body'] ?>
            </textarea>
        </div>
        <div class="form-group m-2">
            <button type="submit" class="btn btn-primary">edit</button>

        </div>
    </form>
</div>