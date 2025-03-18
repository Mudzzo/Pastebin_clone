<?php 
require_once "includes/header.php";
require_once "includes/navbar.php";

if(!isset($_SESSION['IsLoggedIn'])){
    header('Location:index.php');
}
?>

<?php 
require_once "includes/footer.php";
?>