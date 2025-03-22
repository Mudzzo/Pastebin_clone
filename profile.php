<?php 
require_once "includes/header.php";
require_once "includes/navbar.php";

if(!isset($_SESSION['IsLoggedIn'])){
    header('Location:index.php');
}
?>

<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $connect->prepare("SELECT full_name, email FROM users WHERE id = ?");
$stmt->bindValue(1, $user_id, PDO::PARAM_INT);

$stmt->execute();
$user = $stmt->fetch();

$snippets_stmt = $connect->prepare("SELECT post_id, title, content, code_lang FROM snippets WHERE user_id = ?");
$snippets_stmt->bindValue(1, $user_id, PDO::PARAM_INT);
$snippets_stmt->execute();
$snippets = $snippets_stmt->fetchAll(PDO::FETCH_ASSOC);;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles-user.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h2>
        <div class="profile">
            <h3>Your Information</h3>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <a href="edit_profile.php" class="btn btn-login">Edit Profile</a>
        </div>
        <div class="snippets">
            <h3>Your Snippets</h3>
            <a href="create_snippet.php" class="btn btn-login mb-3">Create New Snippet</a>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Syntax</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($snippets as $snippet): ?>
                    <tr class="profile-snippets">
                        <td><?php echo htmlspecialchars($snippet['title']); ?></td>
                        <td><?php
                                        $content = htmlspecialchars($snippet['content']);
                                        $lines = explode("\n", $content);
                                        $limitedText = implode("", array_slice($lines, 0, 3));
                                        echo nl2br($limitedText);
                                        ?>
                        </td>
                        <td><?php echo htmlspecialchars($snippet['code_lang']); ?></td>
                        <td>
                            <a href="edit_snippet.php?id=<?php echo $snippet['post_id']; ?>">Edit</a>
                            <a href="delete_snippet.php?id=<?php echo $snippet['post_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>
        </div>
        <a href="logout.php" class="btn btn-login">Logout</a>
    </div>
</body>
</html>

