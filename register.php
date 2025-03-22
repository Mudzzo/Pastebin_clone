<?php
require_once "config/db.php";
require_once "includes/header.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
    $username = $_POST['username'];
    $email =  $_POST['email'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];

    

    if(empty($username)){
        $errors['username'] = "Username is required!";
    }else{
        $User_Name = htmlspecialchars($username);
        if(!preg_match("/^[a-zA-Z-' ]*$/", $User_Name)){
            $errors['username'] = "Only letters and spaces allowed";
        }
    }

    if(empty($email)){
        $errors['email'] = "Email is Required!";
    }else{
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Invalid email format!';
        }
    }

    if (empty($password)) {
        $errors['password'] = "Password is required!";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters long!";
    } else {
        $password = sha1($_POST['password']);
    }

    if (empty($fullname)) {
        $errors['fullname'] = "Full name is required!";
    } else {
        $fullname = htmlspecialchars($fullname); 
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fullname)) {
            $errors['fullname'] = "Only letters and spaces allowed!";
        }
    }

    if(empty($errors)){
        $stmt = $connect->prepare('INSERT INTO `users` (`username` , `email` , `password` , `full_name` , `status` , `created_at`) VALUES (? , ? , ? , ? , "active" , now() ) ');
        $stmt->execute([$username, $email, $password, $fullname]);

        $_SESSION['FULL_NAME'] = $fullname;
        $_SESSION['IsLoggedIn'] = true;
        $_SESSION['user_id'] = $connect->lastInsertId();
        header('Location:index.php');
    }
}
?>

<div class="container login-container d-flex align-items-center justify-content-center vh-100">


        <div class="col d-flex align-items-center justify-content-center p-0">
            <div class="card login-card">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">    
                    <h2>Register</h2>
                    <form class="mt-3 d-flex flex-column align-items-center justify-content-center" method="POST" action="<?php $_SERVER['PHP_SELF'] ?>">
                        <div class="mb-3 w-100">
                            <label class="form-label">Fullname</label>
                            <input type="text" class="form-control" name="fullname">
                            <p style="color:red;"><?= $errors['fullname'] ?? '' ?></p>
                        </div>
                        <div class="mb-3 w-100">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username">
                            <p style="color:red;"><?= $errors['username'] ?? '' ?></p>
                        </div>
                        <div class="mb-3 w-100">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                            <p style="color:red;"><?= $errors['email'] ?? '' ?></p>
                        </div>
                        <div class="mb-3 w-100">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                            <p style="color:red;"><?= $errors['password'] ?? '' ?></p>
                        </div>
                        <button type="submit" class="btn btn-login mt-1 mb-3 w-100">register</button>
                        <a href="index.php" class="btn btn-login mt-1 w-100">Return</a>
                    </form>
                </div>
            </div>
        </div>

    
</div>