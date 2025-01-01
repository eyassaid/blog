<?php
$title = 'login';
require_once __DIR__.'/../../templates/header.php';

if ($is_logged_in){
    header("Location: $home");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'];
    $password = hash('md5',$_POST['password']);
    $stmt= $pdo->prepare("select id,email,password,name from users where email = :email");
    $stmt->execute(['email'=>$email]);
    $user =$stmt->fetch(PDO::FETCH_ASSOC);

    if ($user){
         if($password == $user['password']) 
         {
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = true;
            header('Location:'.$home);
        }else{
            echo 'password is not correct';
        }
    }else{
        echo 'email doesn\'t exists';
    }
}


?>

<div class="container mt-5">

    <form method="POST">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input name='email' type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
    <input name='password' type="password" class="form-control" id="exampleInputPassword1">
</div>
<button type="submit" class="btn btn-primary">Login</button>
</form>
</form>
</div>