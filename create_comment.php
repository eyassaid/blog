<?php
require_once 'header.php';
if (!isset($_SESSION['logged_in'])) header('index.php');
require './classes/Comment.php';
$post_id = $_POST['post_id'] ?? null;
$comment = $_POST['comment'] ?? null;
$user_id = $_SESSION['id'];
if (!$post_id || !$comment) exit();
$Comment = new Comment($pdo);
$Comment->create_comment($comment,$user_id,$post_id);

?>
