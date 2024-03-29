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
<?php $file_path = '../'; ?>
<?php require '../_include/header.php'; ?>
        <h1>Waldorf Classics</h1>
    </header>
    <div class="content">
        <form action="" method="post">
            <p><span class="error"><?php if(!empty($user->err_msg['name'])) echo h($user->err_msg['name']); ?></span><input type="text" name="name" value="<?php if(!empty($_POST['name'])) echo h($_POST['name']); ?>" placeholder="Name"></p>
            <p><span class="error"><?php if(!empty($user->err_msg['email'])) echo h($user->err_msg['email']); ?></span><input type="text" name="email" value="<?php if(!empty($_POST['email'])) echo h($_POST['email']); ?>" placeholder="E-mail"></p>
            <p><span class="error"><?php if(!empty($user->err_msg['password'])) echo h($user->err_msg['password']); ?></span><input type="password" name="password" value="<?php if(!empty($_POST['password'])) echo h($_POST['password']); ?>" placeholder="Password"></p>
            <p><span class="error"><?php if(!empty($user->err_msg['password_retype'])) echo h($user->err_msg['password_retype']); ?></span><input type="password" name="password_retype" value="<?php if(!empty($_POST['password_retype'])) echo h($_POST['password_retype']); ?>" placeholder="Password Again"></p>
            <p class="submit"><input type="submit" value="Sign Up"></p>
        </form>
     </div>
 <?php require '../_include/footer.php'; ?>
