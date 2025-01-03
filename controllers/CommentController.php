<?php 
require_once __DIR__.'/../models/CommentModel.php';




class CommentController{
   private $post_id,$comment_model;
   function __construct()
   {
       $this->post_id = htmlspecialchars($_GET['post_id'] ?? null);
       $this->comment_model = new CommentModel;
   }
   function all_comments(){
      return $this->comment_model->all_comments($this->post_id);
   }
   function create_comment($comment){
      $this->comment_model->create_comment($comment,$this->post_id);
   }
   function edit_comment($comment,$comment_id){
      $this->comment_model->edit_comment($comment,$comment_id);
   }
   function delete_comment($comment_id){
      $this->comment_model->delete_comment($comment_id);
   }
}





// $comment_controller = new Comment();
// $comments = $comment_controller->all_comments($post_id);
// if ($_SERVER['REQUEST_METHOD'] ==='POST'){

//         $post_id = $_POST['post_id'] ?? null;

//         $method = htmlspecialchars($_POST['_method']);
//         // new_comment is used in create and edit post
//         $new_comment = htmlspecialchars($_POST['comment'] ?? null) ;
//         $comment_id =  htmlspecialchars($_POST['comment_id'] ?? null);

//         echo $new_comment . "<br>" . $post_id;
//         //add comment to the post-------------------------------
//       if ($method ==='create_comment'){
//        $comment_controller->create_comment($new_comment,$post_id);
    
//       }
//       //-------------------------------------------------------
    
//       // edit comment in the post------------------------------
//       if ($method === 'edit_comment'){
//          $comment_controller->edit_comment($new_comment,$comment_id);
//       }
//       //-------------------------------------------------------
//         // delete comment in the post----------------------------
//         if ($method === 'delete_comment'){
//            $comment_controller->delete_comment($comment_id);
//         }
//         //-------------------------------------------------------
//         header('Location:'.$nav['post_view']."?post_id=$post_id");
//     }
    





// ?>