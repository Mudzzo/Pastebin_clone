<?php
require_once 'config/db.php';
require_once "includes/header.php";
require_once "includes/navbar.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $connect->prepare("SELECT full_name, email FROM users WHERE id = :id");
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (!empty($name) && !empty($email)) {
        try {
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update_stmt = $connect->prepare("UPDATE users SET full_name = :name, email = :email, password = :password WHERE id = :id");
                $update_stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':password' => $hashed_password,
                    ':id' => $user_id
                ]);
            } else {
                $update_stmt = $connect->prepare("UPDATE users SET full_name = :name, email = :email WHERE id = :id");
                $update_stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':id' => $user_id
                ]);
            }
            $_SESSION['success_msg'] = "Profile updated successfully.";
            $_SESSION['FULL_NAME'] = $name;
            header("Location: profile.php");
            exit();
        } catch (PDOException $e) {
            $error = "Error updating profile: " . $e->getMessage();
        }
    } else {
        $error = "Name and email are required.";
    }
}
?>

<div class="container-fluid mt-auto py-3 vh-100">
    <div class="container-lg">
        <div class="row d-flex vh-100 justify-content-center align-items-center">
            <div class="col-8">
                <div class="card bg-dark text-light p-4 rounded-3 shadow-lg">
                    <h2 class="text-center mb-4">Edit Profile</h2>
                    <?php if (isset($error)): ?>
                    <div class="alert alert-danger"> <?= $error ?> </div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="name" class="form-control bg-secondary text-light border-0"
                                value="<?= htmlspecialchars($user['full_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control bg-secondary text-light border-0"
                                value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">New Password (optional)</label>
                            <input type="password" name="password"
                                class="form-control bg-secondary text-light border-0">
                        </div>
                        <button type="submit" class="btn btn-login w-100 fw-bold">Update Profile</button>
                    </form>
                    <a href="profile.php" class="btn btn-login fw-bold">Back to Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>