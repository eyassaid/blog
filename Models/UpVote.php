<?php

use function Laravel\Prompts\error;

class UpVote{
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    function count_votes($post_id,$comment_id){
        return;
    }

    function add_vote($user_id,$comment_id =null,$post_id= null){
        try{
            if (!$post_id){
                $stmt = $this->pdo->prepare('insert into likes(user_id,comment_id) values(:user_id,:comment_id)');
                $params = ['user_id'=>$user_id,'comment_id'=>$comment_id];
                $stmt->excute($params);
            }else if (!$comment_id){
                $stmt = $this->pdo->prepare('insert into likes(user_id,post_id) values(:user_id,:post_id)');
                $params = ['user_id'=>$user_id,'post_id'=>$post_id];
                $stmt->excute($params);
            }else{
                throw error('Something is missing');
            }



        }catch(PDOException $e){
            $this->remove_vote($user_id,$comment_id,$post_id);
        }
    }
    function remove_vote($user_id,$comment_id,$post_id){
        try{
            if (!$post_id){
                $stmt = $this->pdo->prepare('delete from likes where comment_id = :comment_id');
                $params = ['user_id'=>$user_id,'comment_id'=>$comment_id];
                $stmt->excute($params);
            }else if (!$comment_id){
                $stmt = $this->pdo->prepare('delete from likes where post_id = :post_id');
                $params = ['user_id'=>$user_id,'post_id'=>$post_id];
                $stmt->excute($params);
            }else{
                throw error('Something is missing');
            }
        }catch(PDOException){
            $this->add_vote($user_id,$comment_id,$post_id);
        }
    }
}