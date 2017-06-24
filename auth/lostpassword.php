<?php
ob_start();
session_start();
require_once('../class/User.class.php');
require_once('../function.php');
require_once('../vendor/autoload.php');


if(!empty($_POST)){

    //user class インスタンス生成
    $user = new User();

    //入力チャック
    $user->validRequired($_POST['email'], 'email');

    if(empty($user->err_msg)){

        //login チェック
        $user->forgetPassword($_POST['email'], 'email');

        if(empty($user->err_msg)){
            $mail_message = "\n\n\n Password 変更URL\nhttps://waldorf-classics.herokuapp.com/auth/resetpassword.php?code=".$user->code;

            $from = new SendGrid\Email(null, "localhost.ko@gmail.com");
            $subject = "Waldorf Classics パスワード変更";
            $to = new SendGrid\Email(null, $_POST['email']);
            $content = new SendGrid\Content("text/plain", $mail_message);
            $mail = new SendGrid\Mail($from, $subject, $to, $content);

            $apiKey = getenv(SENDGRID_API_KEY);
            $sg = new \SendGrid($apiKey);

            $response = $sg->client->mail()->send()->post($mail);


            echo "<script>alert('パスワード変更画面への URL を記載したメール送信しましたのでご確認ください(メールの送信には数分かかります)');</script>";
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
                <p class="submit"><input type="submit" value="Submit"></p>
            </form>
         </div>
     <?php require '../_include/footer.php'; ?>
