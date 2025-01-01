<?php
require_once __DIR__.'/../config/database.php'; // get pdo and the seesion 


class PostController{
    private $pdo,$user_id,$is_logged_in;
    private $create_post_message = 'Post successfully added';
    private $edit_post_message = 'Post successfully edited';
    private $delete_post_message = 'Post successfully deleted';
    private $home_page = __DIR__.'/../index.php'; 
    function __construct($pdo)
    {
        

        $this->pdo = $pdo;
        $this->is_logged_in = $_SESSION['logged_in'] ?? false;
 
        $this->user_id = $_SESSION['user_id'] ?? null;
    }
    private function handle_not_logged_in(){
        header("Location: $this->home_page");
    }

    public function create_post($title,$body){
        if (!$this->is_logged_in) {
            $this->handle_not_logged_in();
            exit;
        };
        try{
            $stmt = $this->pdo->prepare('
            insert into posts(user_id,title,body) 
                values(:user_id,:title,:body)'
        );
            $stmt->execute(['user_id'=>$this->user_id,'title'=>$title,'body'=>$body]);
            return ['status'=>200,'message'=>$this->create_post_message];
        }catch(PDOException $e){
            return ['status'=>401,'message'=>$e->getMessage()];
        }
        
    }
    public function get_post($post_id){
        try{
            $stmt = $this->pdo->prepare('select * from posts where id = :id');
            $stmt->execute(['id'=>$post_id]);
            $post = $stmt->fetch();
            return $post;
        }catch(PDOException $e){
            return ['status'=>401,'message'=>$e->getMessage()];
        }
    }
    public function get_all_posts(){
        try{
            $stmt = $this->pdo->query('select p.*,u.name from posts p join users u on p.user_id = u.id order by p.id desc');
            $posts = $stmt->fetchAll();
            return $posts;
        }catch(PDOException $e){
            return ['status'=>401,'message'=>$e->getMessage()];
        }
    }
    public function edit_post($post_id,$title,$body){
        if (!$this->is_logged_in) {
            $this->handle_not_logged_in();
            exit;
        };
        try{
            $stmt = $this->pdo->prepare('
                update posts 
                set title = :title, body= :body
                where id = :id and user_id = :user_id
                '
        );
            $stmt->execute(['user_id'=>$this->user_id,'id'=>$post_id,'title'=>$title,'body'=>$body]);
            return ['status'=>200,'message'=>$this->edit_post_message];
        }catch(PDOException $e){
            return ['status'=>401,'message'=>$e->getMessage()];
        }
        
    }
    public function delete_post($post_id){
        if (!$this->is_logged_in) {
            $this->handle_not_logged_in();
            exit;
        };
        try{
            $stmt = $this->pdo->prepare('delete from posts where id = :id and user_id = :user_id');
            $params = ['id'=>$post_id,'user_id'=>$this->user_id];
            $stmt->execute($params);
            return ['status'=>200,'message'=>$this->delete_post_message];
        }catch(PDOException $e ){
            return ['status'=>401,'message'=>$e->getMessage()];
        }
  
    }
}

