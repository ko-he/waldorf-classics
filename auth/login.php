<?php
ob_start();
session_start();
require_once('../class/User.class.php');
require_once('../function.php');


if(!empty($_POST)){

    //user class インスタンス生成
    $user = new User();

    //入力チャック
    $user->validRequired($_POST['email'], 'email');
    $user->validRequired($_POST['password'], 'password');

    if(empty($user->err_msg)){

        //login チェック
        $user->login($_POST['email'], $_POST['password'], 'email');

        if(empty($user->err_msg)){
            $_SESSION['id'] = $user->id;
            $_SESSION['time'] = time();
            header('location: https://waldorf-classics.herokuapp.com');
        }
    }
}
?>
    <?php $file_path = '../'; ?>
    <?php require '../_include/header.php'; ?>
            <h1>Waldorf Classics</h1>
            <p class="menu"><a href="register.php"><img src="../images/register.png" alt=""></a></p>
        </header>
        <div class="content">
            <form action="" method="post">
                <p><span class="error"><?php if(!empty($user->err_msg['email'])) echo h($user->err_msg['email']); ?></span>
                <input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo h($_POST['email']); ?>" placeholder="E-mail"></p>
                <p><span class="error"><?php if(!empty($user->err_msg['password'])) echo h($user->err_msg['password']); ?></span>
                <input type="password" name="password" value="<?php if(!empty($_POST['password'])) echo h($_POST['password']); ?>" placeholder="Password"></p>
                <p class="link"><a href="lostpassword.php" onclick="alert('LINE をご利用の場合はトーク画面から [password change] と入力するとパスワード変更画面のURLをお知らせします。');">Forgot Passwrd?</a></p>
                <p class="submit"><input type="submit" value="Login"></p>
            </form>
         </div>
     <?php require '../_include/footer.php'; ?>
