<?php
session_start();
require 'function.php';
require 'class/User.class.php';

// if(empty($_SESSION['id'])){
//     header('location: auth/login.php');
// }

$user = new User();
$prof = $user->getUser($_SESSION['id']);
 ?>
<?php require '_include/header.php'; ?>
    <h1>Waldorf Classics</h1>
    <p class="menu"><img src="images/menu.png" alt=""></p>
</header>
<div class="content">
    <div class="prof-box">
        <div class="prof">
            <p class="title">登録情報</p>
            <p class="name">Name：<?php echo h($prof['name']); ?></p>
            <p class="email">E-mail：<?php echo h($prof['email']); ?></p>
            <p class="btn"><a href="">編集</a></p>
        </div>
        <div class="line">
            
        </div>
    </div>
</div>
 <?php require '_include/footer.php'; ?>
