<?php
require_once __DIR__.'/../models/PostModel.php';

class PostController{
    private $post_id,$post_model;
    function __construct()
    {
        $this->post_id = htmlspecialchars($_GET['post_id'] ?? null);
        $this->post_model = new PostModel;
    }
    function create_post($title,$body){
        $title = htmlspecialchars($title);
        $body = htmlspecialchars($body);
        $this->post_model->create_post($title,$body);

    }
    function get_post(){

        return $this->post_model->get_post($this->post_id);
    }
    function get_all_posts(){
        return $this->post_model->get_all_posts();
    }
    function edit_post($title,$body){
        $title = htmlspecialchars($title);
        $body = htmlspecialchars($body);
        $this->post_model->edit_post($this->post_id,$title,$body);
    }
    function delete_post(){
        $this->post_model->delete_post($this->post_id);
    }
}
















?>