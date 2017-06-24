<?php
ob_start();
session_start();
require_once('../class/User.class.php');
require_once('../function.php');
require_once('../vendor/autoload.php');

//user class インスタンス生成
$user = new User();

$user->checkCode($_GET['code'], 'code');

if(!empty($_POST)){

    //入力チャック
    $user->validRequired($_POST['password'], 'password');
    $user->validRequired($_POST['password_retype'], 'password_retype');

    if(empty($user->err_msg)){
        $user->validPassType($_POST['password'], 'password');

        if(empty($user->err_msg)){

            $user->validPassLenShot($_POST['password'], 'password');
            $user->validPassLenLarg($_POST['password'], 'password');
        }

        if(empty($user->err_msg)){

            $user->validPassRetype($_POST['password'], $_POST['password_retype'], 'password');

            if(empty($user->err_msg)){
                $user->resetPassword($_POST['password']);

                header('location: login.php');
            }

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
                <?php if(!empty($user->err_msg['code'])): ?>
                    <p><span class="error"><?php echo h($user->err_msg['code']); ?></span></p>
                <?php else: ?>
                    <p><span class="error"><?php if(!empty($user->err_msg['password'])) echo h($user->err_msg['password']); ?></span><input type="password" name="password" value="<?php if(!empty($_POST['password'])) echo h($_POST['password']); ?>" placeholder="Password"></p>
                    <p><span class="error"><?php if(!empty($user->err_msg['password_retype'])) echo h($user->err_msg['password_retype']); ?></span><input type="password" name="password_retype" value="<?php if(!empty($_POST['password_retype'])) echo h($_POST['password_retype']); ?>" placeholder="Password Again"></p>
                    <p class="submit"><input type="submit" value="Submit"></p>
                <?php endif; ?>
            </form>
         </div>
     <?php require '../_include/footer.php'; ?>
