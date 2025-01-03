<?php
require_once __DIR__. '/config.php';
$host = 'localhost';
$port = 3306;
$dbName = 'test';
$username = 'eyas';
$password ='eyas';

$dsn = "mysql:dbname={$dbName};port={$port};host={$host}";

try{
    
$pdo = new PDO($dsn,$username,$password);
$pdo->setAttribute(PDO::FETCH_DEFAULT,PDO::FETCH_ASSOC);
session_start();
$is_logged_in = $_SESSION['logged_in'] ?? false;
$user_id = $_SESSION['user_id'] ?? null;
$name = $_SESSION['name'] ?? null;
$home = $nav['home'];
}catch(PDOException $e){
    echo 'connection failed'.' '. $e->getMessage();
}
