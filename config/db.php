<?php
// PDO => php data object 
try {
    $dest = 'mysql:host=localhost;dbname=pastebin_clone';
    $user = 'root';
    $pass = '';
    $connect = new PDO($dest, $user, $pass);
    // echo "connect";
} catch (PDOException $error) {
    echo $error->getMessage();
}