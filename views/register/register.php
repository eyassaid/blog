<?php
// try to modify the html to send one of these outputs
$title = 'register';
require_once __DIR__.'/../../templates/header.php';
$errors = [];
$success = false;
if (isset($_SESSION['logged_in'])){
    header("Location: $home");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (empty($_POST['email']) || empty($_POST['name']) || empty($_POST['password'])){
        array_push($errors,'you need to fill all inputs');
    }else{
        $email = htmlspecialchars($_POST['email']);
        $name = htmlspecialchars($_POST['name']);
        $password = hash('md5',$_POST['password']);        
        $stmt = $pdo->prepare('insert into users(email,password,name) values (:email,:password,:name)');
        $params = ['email'=>$email,'password'=>$password,'name'=>$name];
        $stmt->execute($params);
        $success = true;
    }
  
  

    
}

?>

<div class="container mt-5">
    <?php if (count($errors)) 
        require_once 'message.php'
    ?>
    <?php if ($success): ?>
        <div class='alert alert-success'>successfully registred</div>
        <?php endif ?>
    <form method="POST">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" name='email' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Name</label>
            <input  name='name' class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
    <input required type="password" name='password' class="form-control" id="exampleInputPassword1">
</div>
<button type="submit" class="btn btn-primary">Register</button>
</form>
</form>
</div>