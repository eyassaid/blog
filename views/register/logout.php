<?php
require_once __DIR__.'/../../templates/header.php';
if (isset($_SESSION['logged_in'])){
    session_destroy();
    header("Location: $home");
}else{
    header("Location: $home");
}
?>