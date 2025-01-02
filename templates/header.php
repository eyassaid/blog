<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config.php';
$login_page = __DIR__. '/../views/register/login.php';
// global variables
$home = $nav['home'];
$is_logged_in = $_SESSION['logged_in'] ?? false;
$user_id = $_SESSION['user_id'] ?? null;
$name = $_SESSION['name'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title><?= "Blog". " | ".$title ?? 'no-title' ?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= $nav['home'] ?>">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if (!$is_logged_in) : ?>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?=$nav['login'] ?>">login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?=$nav['register'] ?>">register</a>
        </li>
        <?php else : ?>

            <li class="nav-item">
                
          <a class="nav-link active" aria-current="page" href="<?=$nav['logout'] ?>">logout</a>
        </li> 
        <li class="nav-item">
                <a class="btn btn-primary ml-auto" aria-current="page" href="<?=$nav['create_post_view'] ?>">create post</a>
              </li> 
                
       
        <?php endif ?>


      </ul>  
    </div>
  </div>
</nav> 
