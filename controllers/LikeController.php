<?php 
require_once __DIR__.'/../models/LikeModel.php';

class LikeController{
  private $post_id,$like_model;
  function __construct()
  {
    $this->post_id = htmlspecialchars($_GET['post_id'] ?? null);
    $this->like_model = new LikeModel(); 
  }
  function add_like_to_comment($comment_id){
    $this->like_model->add_like_to_comment($comment_id,$this->post_id);
  }
}

    
?>