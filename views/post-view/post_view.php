<?php
require_once __DIR__.'/../../templates/header.php';
if (!isset($_GET['post_id'])) header('Location:'.$home);
require_once __DIR__.'/../../controllers/CommentController.php';
require_once __DIR__.'/../../Models/UpVote.php';
require_once __DIR__.'/../../controllers/PostController.php';
// classes
$comment_controller = new Comment($pdo);
$UpVote = new UpVote($pdo);

// need to be fixed because the user can enter invalid post id
$post_id = $_GET['post_id'];
$user_id = $_SESSION['user_id'] ?? null;
$comments = $comment_controller->all_comments($post_id);

$posts = new PostController($pdo);
$post = $posts->get_post($post_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  $method = htmlspecialchars($_POST['_method']);
  $new_comment = htmlspecialchars($_POST['comment'] ?? null) ;
  $comment_id =  htmlspecialchars($_POST['comment_id'] ?? null);
  //add comment to the post-------------------------------
  if ($method ==='create_comment'){
  $result = $comment_controller->create_comment($new_comment,$post_id);

  }
  //-------------------------------------------------------

  // edit comment in the post------------------------------
  if ($method === 'edit_comment'){
    $comment_controller->edit_comment($new_comment,$comment_id);
  }
  //-------------------------------------------------------
    // edit comment in the post------------------------------
    if ($method === 'delete_comment'){
      $comment_controller->delete_comment($comment_id);
    }
    //-------------------------------------------------------
}

$comments = $comment_controller->all_comments($post_id);

?>
<div class="d-flex m-3 justify-content-center">
    <div class="card " style="width:100%;text-align:center;">
        <div class="card-body">
            <h5 class="card-title"><?= $post['title'] ?></h5>
            <p class="card-text"><?=$post['body'] ?></p>
        </div>
    </div>
</div>

<form method="POST">
<div class="row d-flex justify-content-center">
  <div class="col-md-8 col-lg-6">
    <div class="card shadow-0 border" style="background-color: #f0f2f5;">
      <div class="card-body p-4">
        <?php if ($is_logged_in) :?>
        <div data-mdb-input-init class="form-outline mb-4">
          <input type="hidden" name="_method" value="create_comment">
          <input type="text" name='comment' id="addANote" class="form-control" placeholder="Type comment..." />
          <button class="btn btn-success mt-1" type="submit">send</button>
        </div>
        <?php endif?>
            

</form>
<?php foreach($comments as $comment): ?>
    <div class="card mb-4">
          <div class="card-body">
            <p><?=$comment['comment'] ?> </p>

            <div class="d-flex justify-content-between ">
              <div class="d-flex flex-row align-items-center">
                <p class="small mb-0 ms-2"><strong><?= $comment['name'] === $name? 'You' : $comment['name']  ?></strong> </p>
              </div>
              <div class="d-flex flex-row align-items-center">
                <?php  if($is_logged_in): ?>
                <form method="POST" class="m-2">
                  <input type="hidden" name="comment_id" value="<?= $comment['id']?>">
                  <button type="submit" class="small text-muted mb-0 btn btn-success btn-sm">Upvote?</button>
                </form>
                <?php endif ?>
                <?php if ($comment['user_id'] == $user_id): ?>
    <div id="comment-<?= $comment['id'] ?>">
       
        <button type="button" class="btn btn-primary btn-sm edit-comment" data-id="<?= $comment['id'] ?>" data-text="<?= htmlspecialchars($comment['comment']) ?>">Edit</button>
    </div>
    <form id="edit-form-<?= $comment['id'] ?>" class="edit-comment-form d-none m-2" method="POST">
        <input type="hidden" name="_method" value="edit_comment">
        <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
        <textarea name="comment" class="form-control"><?= htmlspecialchars($comment['comment']) ?></textarea>
        <button type="submit" class="btn btn-primary btn-sm">Save</button>
        <button type="button" class="btn btn-secondary btn-sm cancel-edit" data-id="<?= $comment['id'] ?>">Cancel</button>
    </form>
    <form method="POST" class="m-2">
                  <input type="hidden" name="_method" value="delete_comment">
                  <input type="hidden" name= "comment_id" value="<?= $comment['id'] ?>">
                  <button type="sumbit" class="btn btn-danger btn-sm">delete comment</button>
                </form>
<?php endif ?>
                <i class="far fa-thumbs-up mx-2 fa-xs text-body" style="margin-top: -0.16rem;"></i>
                <p class="small text-muted mb-0">place holder for number of votes</p>
               
              </div>
            </div>
          </div>
        </div>

<?php endforeach ?>
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".edit-comment").forEach(button => {
        button.addEventListener("click", () => {
            const commentId = button.dataset.id;
            const commentText = button.dataset.text;
            
            // Toggle visibility
            document.querySelector(`#comment-${commentId}`).style.display = "none";
            const editForm = document.querySelector(`#edit-form-${commentId}`);
            editForm.classList.remove("d-none");
            editForm.querySelector("textarea").value = commentText;
        });
    });

    document.querySelectorAll(".cancel-edit").forEach(button => {
        button.addEventListener("click", () => {
            const commentId = button.dataset.id;

            // Toggle visibility
            document.querySelector(`#comment-${commentId}`).style.display = "block";
            document.querySelector(`#edit-form-${commentId}`).classList.add("d-none");
        });
    });
});
</script>
