<?php 
class Comment{
    private $pdo,$user_id,$is_logged_in;
    function __construct($pdo)
    {

        $this->pdo = $pdo;
        $this->is_logged_in = $_SESSION['logged_in'] ?? false;
        $this->user_id = $_SESSION['user_id'] ?? null;
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
            select c.id,c.comment,u.name,c.user_id from comments c join users u on c.user_id = u.id where post_id = :post_id
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
     function create_comment ($comment,$post_id){
        try{
            $stmt = $this->pdo->prepare('
            insert into comments(comment,user_id,post_id) 
            values 
            (:comment,:user_id,:post_id);'
        );
            $params = ['comment'=>$comment,'user_id'=>$this->user_id,'post_id'=>$post_id];
            $stmt->execute($params);
            return ['response'=>201,'message'=>'successfully added'];
        }catch(PDOException $e){
            return ['response'=>401,'message'=>$e->getMessage()];
        }

    }
    function edit_comment ($comment,$comment_id){
        try{
            $stmt = $this->pdo->prepare('
            update comments
            set comment = :comment
            where id = :id and user_id = :user_id
            '
        );
            $params = ['comment'=>$comment,'id'=>$comment_id,'user_id'=>$this->user_id];
            $stmt->execute($params);
            return ['response'=>201,'message'=>'successfully added'];
        }catch(PDOException $e){
            return ['response'=>401,'message'=>$e->getMessage()];
        }

    }
     function delete_comment ($comment_id){
        try{
            $stmt = $this->pdo->prepare('delete from comments where id = :id and user_id = :user_id ');
            $params = ['id'=>$comment_id,'user_id'=>$this->user_id];
            $stmt->execute($params);
            return ['response'=>200,'message'=>'successfully removed'];
        }catch(PDOException $e){
            return ['response'=>401,'message'=>$e->getMessage()];
        }
    }
}