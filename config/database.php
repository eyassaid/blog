<?php

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
}catch(PDOException $e){
    echo 'connection failed'.' '. $e->getMessage();
}
