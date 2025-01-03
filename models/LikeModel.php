<?php 
require_once __DIR__.'/../config/database.php'; 
class LikeModel{
    private $pdo;
    private $user_id;
    function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
        $this->user_id = $_SESSION['user_id'];
    }

    function check_user_likes_comment($comment_id){
        try{

            $stmt = $this->pdo->prepare('select * from likes where 
            comment_id = :comment_id and user_id = :user_id
            ');
            $params = ['comment_id'=>$comment_id,'user_id'=>$this->user_id];
            $stmt->execute($params);
            $result = $stmt->fetch();

            return $result;
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
    function check_user_likes_post($post_id){
        try{

            $stmt = $this->pdo->prepare('select * from likes where 
            post_id = :post_id and user_id = :user_id
            ');
            $params = ['post_id'=>$post_id,'user_id'=>$this->user_id];
            $stmt->execute($params);
            $result = $stmt->fetch();
            return $result;
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
    function add_like_to_comment($comment_id,$post_id){

        try{
            $likeExists = $this->check_user_likes_comment($comment_id);
            if (!$likeExists){
                // add like to a comment ---------------------------------------------
                $stmt = $this->pdo->prepare('insert into likes(user_id,comment_id,post_id) 
                values(:user_id,:comment_id,:post_id)');
                $params = ['user_id'=>$this->user_id,'comment_id'=>$comment_id,'post_id'=>$post_id];
                $stmt->execute($params);
                //--------------------------------------------------------------------    
            }
            else{
                $this->remove_like_from_comment($comment_id);
            }
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
    function add_like_to_post($post_id){

        try{
            $likeExists = $this->check_user_likes_post($post_id);
            if (!$likeExists){
                // add like to a comment ---------------------------------------------
                $stmt = $this->pdo->prepare('insert into likes(user_id,post_id) 
                values(:user_id,:post_id)');
                $params = ['user_id'=>$this->user_id,'post_id'=>$post_id];
                $stmt->execute($params);
                //--------------------------------------------------------------------    
            }
            else{
                $this->remove_like_from_post($post_id);
            }
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
    private function remove_like_from_comment($comment_id){
        try{
           
                $stmt = $this->pdo->prepare('delete from likes where comment_id = :comment_id and user_id= :user_id');
                $params = ['comment_id'=>$comment_id,'user_id'=>$this->user_id];
                $stmt->execute($params);


        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
    private function remove_like_from_post($post_id){
        try{
           
                $stmt = $this->pdo->prepare('delete from likes where post_id = :post_id');
                $params = ['post_id'=>$post_id];
                $stmt->execute($params);


        }catch(PDOException $e){
            return $e->getMessage();
        }
    }
}



?>