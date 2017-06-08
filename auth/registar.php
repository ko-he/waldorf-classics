<?php
ob_start();
session_start();
require_once('../class/User.class.php');
require_once('../function.php');


if(!empty($_POST)){
    $user = new User();

    $user->validRequired($_POST['name'], 'name');
    $user->validRequired($_POST['email'], 'email');
    $user->validRequired($_POST['password'], 'password');
    $user->validRequired($_POST['password_retype'], 'password_retype');

    if(empty($user->err_msg)){

        $user->validEmail($_POST['email'], 'email');
        $user->validPassType($_POST['password'], 'password');

        if(empty($user->err_msg)){

            $user->validPassLenShot($_POST['password'], 'password');
            $user->validPassLenLarg($_POST['password'], 'password');
        }

        if(empty($user->err_msg)){

            $user->validPassRetype($_POST['password'], $_POST['password_retype'], 'password');

            if(empty($user->err_msg)){

                $user->validDuplicateEmail($_POST['email'], 'email');
                $user->validDuplicateName($_POST['name'], 'name');

                if(empty($user->err_msg)){

                     $user->insertUser($_POST['name'], $_POST['email'], $_POST['password']);
                     header('location: login.php');
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <form action="" method="post">
            <span><?php if(!empty($user->err_msg['name'])) echo h($user->err_msg['name']); ?></span>
            <input type="text" name="name" value="<?php if(!empty($_POST['name'])) echo h($_POST['name']); ?>">
            <span><?php if(!empty($user->err_msg['email'])) echo h($user->err_msg['email']); ?></span>
            <input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo h($_POST['email']); ?>">
            <span><?php if(!empty($user->err_msg['password'])) echo h($user->err_msg['password']); ?></span>
            <input type="password" name="password" value="<?php if(!empty($_POST['password'])) echo h($_POST['password']); ?>">
            <span><?php if(!empty($user->err_msg['password_retype'])) echo h($user->err_msg['password_retype']); ?></span>
            <input type="password" name="password_retype" value="<?php if(!empty($_POST['password_retype'])) echo h($_POST['password_retype']); ?>">
            <input type="submit" value="会員登録">
        </form>
    </body>
</html>
