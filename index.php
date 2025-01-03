<?php 
$title = 'Home';
require_once __DIR__ .'/templates/header.php';
require_once __DIR__ .'/controllers/PostController.php';
$post_controller = new PostController;
$posts = $post_controller->get_all_posts();



?>
<div class='container'>

    <?php if ($is_logged_in) :?>
        <div class="d-flex justify-content-center m-3">
            
            <h1>Hello <?= $_SESSION['name'] ?></h1>
        </div>    
        <?php endif ?>
        
    </div>
    <?php foreach($posts as $post) :?>
        <div class="m-2 col-3" style='display:inline-block'>

            <div class="card " style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?= $post['title'] ?></h5>
                    <p class="card-text"><?=strlen($post['body']) < 30 ? $post['body'] :substr($post['body'],0,30).'...'  ?></p>
                    <a href="<?= $nav['post_view']?>?post_id=<?=$post['id'] ?>">Go to post</a>
                    <?php if ($is_logged_in):?>
                        <form method="POST" class="m-2" action="<?= $nav['post_view']?>">
                        <input type="hidden" name="_method" value="add_like">
                        <input type="hidden" name="post_id" value="<?= $post['id']?>">
                        <button type="submit" class="small text-muted mb-0 btn btn-success btn-sm">Upvote?</button>
                        </form>
                        <i class="far fa-thumbs-up mx-2 fa-xs text-body" style="margin-top: -0.16rem;"></i>
                        <p class="small text-muted mb-0">place holder for likes</p>
                    <?php endif ?>
                </div>  
                <div class="card-footer text-muted">
                    <?php if ($post['user_id'] == $user_id) :?>
                        
                      
                        <p>created by you 
                        <span><a class="btn btn-success" href="<?= $nav['edit_post_view'] ?>?post_id=<?=$post['id']?>">edit</a></span>
                        <span><a class="btn btn-danger" href="<?= $nav['delete_post'] ."?post_id=" .$post['id'] ?> ">delete</a></span>
                    </p>
                        
                    <?php else :?>
                       <?php
                        $name = $post['name'];
                        echo "created by $name"; ?>

                        <?php endif ?>
                </div>
            </div>
        </div>

    <?php endforeach ?>
<?php include './templates/footer.php';


?>