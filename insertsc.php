<?php
ob_start();
session_start();
require_once 'class/Schedule.class.php';
require_once 'function.php';
require 'vendor/autoload.php';

// line api インスタンス生成
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('w9AHFGgDfuiXizJ+nbUgospTqb7uTy5hr+viE+KAo66P5SZf2wP7x0yEtUceun+7RGhZ7HyAmF0yS+kMA8P5EQ3DZKweK/wuMPuALf7PWo85JjVAgZ9IrMKDtirjfeVe6Yxyz/FAXgMN/sNK1HqDeQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '
35cfb80864e3be2e8c3377689e7dd3a7']);

$schedule = new Schedule();
if(!empty($_POST)){
    $schedule->validRequired($_POST['sc_date'], 'sc_date');
    $schedule->validRequired($_POST['place'], 'place');
    $schedule->validRequired($_POST['start_time'], 'start_time');
    $schedule->validRequired($_POST['finish_time'], 'finish_time');

    if(empty($schedule->err_msg)){
        $row = $schedule->insertSchedule($_POST['sc_type'], $_POST['description'], $_POST['place'], $_POST['sc_date'], $_POST['start_time'], $_POST['finish_time']);

        $list = $schedule->getMessagingList();
        foreach ($list as $value) {
            if(empty($value['line_id'])){
                $from = new SendGrid\Email(null, "localhost.ko@gmail.com");
                $subject = "Hello World from the SendGrid PHP Library!";
                $to = new SendGrid\Email(null, $value['email']);
                $content = new SendGrid\Content("text/plain", "Hello, Email!");
                $mail = new SendGrid\Mail($from, $subject, $to, $content);

                $apiKey = getenv(SENDGRID_API_KEY);
                $sg = new \SendGrid($apiKey);

                $response = $sg->client->mail()->send()->post($mail);

            }else{
                $text = 'hello line';
                $yes_post = new LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('YES', 'sc_y:'.$row[0]['id']);
                $no_post = new LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('NO', 'sc_n:'.$row[0]['id']);
                // Confirmテンプレート
                $confirm = new LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder('上記のスケジュールに参加できますか？', [$yes_post, $no_post]);
                // メッセージを作る
                $confirm_message = new LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('WC Schedule', $confirm);
                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                // push
                $message = new LINE\LINEBot\MessageBuilder\MultiMessageBuilder();
                $message->add($textMessageBuilder);
                $message->add($confirm_message);
                $response = $bot->pushMessage($value['line_id'], $message);

            }
        }
    }
}


print_r($schedules->err_msg);

 ?>
 <!DOCTYPE html>
 <html>
     <head>
         <meta charset="utf-8">
         <title></title>
     </head>
     <body>
         <form action="" method="post">
             <p><select class="" name="sc_type">
                 <option value="1">練習</option>
                 <option value="2">試合・大会</option>
             </select></p>
             <p><input type="text" name="description" value=""></p>
             <p><input type="text" name="place" value=""></p>
             <p><input type="date" name="sc_date" value=""></p>
             <p><input type="time" name="start_time" value=""></p>
             <p><input type="time" name="finish_time" value=""></p>
             <p><input type="submit" value="submit"></p>
         </form>
     </body>
 </html>
