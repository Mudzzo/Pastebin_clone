<?php
require_once "config/db.php";
require_once "includes/header.php";

if(!isset($_SESSION['IsLoggedIn'])){
    header('Location:index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    //bind parameters for data 
    $stmt = $connect->prepare('SELECT * FROM `users` WHERE `email` = ? AND `password` = ? LIMIT 1 ');
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch(); 
    $inDb = $stmt->rowCount(); 
    if ($inDb == 1) {
        $_SESSION['FULL_NAME'] = $user['full_name'];
        $_SESSION['IsLoggedIn'] = true;
        $_SESSION['user_id']= $user['id'];
        header('Location:index.php');
    } else {
        $_SESSION['login_error'] = "user doesnt exist";
    }
}
?>

<div class="container login-container d-flex align-items-center justify-content-center vh-100">


        <div class="col d-flex align-items-center justify-content-center p-0">
            <div class="card login-card">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">    
                    <h2 class="fw-bold">Login</h2>
                    <form class="mt-3 d-flex flex-column align-items-center justify-content-center" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                        <div class="mb-3 w-100">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                        </div>
                        <div class="mb-3 w-100">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                        </div>
                        <a href="register.php" class="mb-3 register-link">Don't have an account?</a>
                        <button type="submit" class="btn btn-login mt-1 mb-3 w-100">Login</button>
                        <p style="color:red;" class="fw-bold"><?= $_SESSION['login_error'] ?? '' ?></p>
                    </form>
                </div>
            </div>
        </div>

    
</div>