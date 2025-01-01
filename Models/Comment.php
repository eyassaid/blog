<?php
class Comment{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    function user_info($comment_id,$user_id){
        try{
            $stmt = $this->pdo->query("select u.id,u.name from users join comments c on u.id =  c.user_id 
                where c.id = $comment_id and u.id = $user_id
            ");
            return $stmt->fetch();
        }catch(PDOException $e){
          return ['response'=>401,'message'=>$e->getMessage()];
        }
    }
    function post_info($comment_id,$post_id){
        try{
            $stmt = $this->pdo->query("select p.id,p.title from users join comments c on p.id =  c.post_id 
                where c.id = $comment_id and p.id = $$post_id
            ");
            return $stmt->fetch();
        }catch(PDOException $e){
          return ['response'=>401,'message'=>$e->getMessage()];
        }
    }
     function all_comments ($post_id){
        try{
  
            $stmt = $this->pdo->prepare(
                '
            select c.id,c.comment,u.name from comments c join users u on c.user_id = u.id where post_id = :post_id
             ');

             $params = ['post_id'=>$post_id];
             $stmt->execute($params);
             return $stmt->fetchAll();
        }catch(PDOException $e){
            return $e->getMessage();
        }

    }
    function up_vote(){

    }
     function create_comment ($comment,$user_id,$post_id){
        try{
            $stmt = $this->pdo->prepare('insert into comments(comment,user_id,post_id) values (:comment,:user_id,:post_id) ');
            $params = ['comment'=>$comment,'user_id'=>$user_id,'post_id'=>$post_id];
            $stmt->execute($params);
            return ['response'=>201,'message'=>'successfully added'];
        }catch(PDOException $e){
            return ['response'=>401,'message'=>$e->getMessage()];
        }

    }
     function delete_comment ($comment_id,$user_id){
        $check = $this->user_info($comment_id,$user_id);
        if (!count($check)) return;
        try{
            $stmt = $this->pdo->prepare('delete from comments where id = :id ');
            $params = ['id'=>$comment_id];
            $stmt->execute($params);
            return ['response'=>201,'message'=>'successfully added'];
        }catch(PDOException $e){
            return ['response'=>401,'message'=>$e->getMessage()];
        }
    }
}


?>