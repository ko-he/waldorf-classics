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
    <h1>Waldorf Classics</h1>
    <p class="menu"><img src="images/menu.png" alt=""></p>
    <nav>
        <ul>
            <li><a href="https://waldorf-classics.herokuapp.com"><img src="images/home.png" alt=""></a></li>
            <li><a href="apps/logout.php"><img src="images/logout.png" alt=""></a></li>
        </ul>
    </nav>
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
            <p class="title">LINE を利用する</p>
                <p class="line-code">承認コード：<?php if(!empty($prof['line_code'])){echo h($prof['line_code']); }else{echo '承認済み';} ?></p>
                <p class="line-btn"><a href="https://line.me/R/ti/p/%40qyf6351f"><img height="40" border="0" alt="友だち追加" src="https://scdn.line-apps.com/n/line_add_friends/btn/ja.png"></a></p>
        </div>
    </div>
</div>
 <?php require '_include/footer.php'; ?>
