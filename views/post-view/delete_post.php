<?php
require_once __DIR__.'/../../templates/header.php';
require_once __DIR__.'/../../controllers/PostController.php';
$post_id = $_GET['post_id'] ?? null;

if (!$is_logged_in || !$post_id) header('location'.$home);
$post = new PostController;
$post->delete_post();
header("location:".$home);