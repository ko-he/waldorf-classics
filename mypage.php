<?php
session_start();
require 'function.php';
require 'class/User.class.php';

if(empty($_SESSION['id'])){
    header('location: auth/login.php');
}

$user = new User();
$prof = $user->getUser($_SESSION['id']);
 ?>
<?php require '_include/header.php'; ?>
        
 <?php require '_include/footer.php'; ?>
