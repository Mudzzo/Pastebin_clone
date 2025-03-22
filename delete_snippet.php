<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$snippet_id = intval($_GET['id']);

$stmt = $connect->prepare("DELETE FROM snippets WHERE post_id = :id");
$stmt->execute([':id' => $snippet_id]);

header("Location: profile.php");
exit();
?>