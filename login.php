<?php
require_once "config/db.php";
require_once "includes/header.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    print_r($_POST);
    $email = $_POST['email'];
    $password = $_POST['password'];
    //bind parameters for data 
    $stmt = $connect->prepare('SELECT * FROM `users` WHERE `email` = ? AND `password` = ? LIMIT 1 ');
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch(); //return array;
    $inDb = $stmt->rowCount(); 
    if ($inDb == 1) {
        $_SESSION['FULL_NAME'] = $user['full_name'];
        $_SESSION['IsLoggedIn'] = true;
        print_r($_SESSION);
        // exit();
        header('Location:index.php');
    } else {
        echo "user doesnt exist";
    }
}
?>

<div class="container login-container d-flex align-items-center justify-content-center">

    <div class="login-form row">
        <div class="col d-flex align-items-center justify-content-center p-0">
            <div class="card m-0" id="login-card">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">    
                    <h2>Login</h2>
                    <form class="mt-3" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                        </div>
                        <button type="submit" class="btn btn-login">Login</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col d-flex align-items-center justify-content-center p-0">
            <div class="card m-0" id="register-card">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">    
                    <h2>Register</h2>
                    <form class="mt-3" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Confirm-Password</label>
                            <input type="password" class="form-control" " name="confirm-password">
                        </div>
                        <button type="submit" class="btn btn-login">Register!</button>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
    
</div>