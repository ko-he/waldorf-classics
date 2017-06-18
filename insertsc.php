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
$schedules = $schedule->getSchedules();

if(!empty($_POST)){
    $schedule->validRequired($_POST['sc_date'], 'sc_date');
    $schedule->validRequired($_POST['place'], 'place');
    $schedule->validRequired($_POST['start_time'], 'start_time');
    $schedule->validRequired($_POST['finish_time'], 'finish_time');

    if(empty($schedule->err_msg)){
        if($_POST['sc_type'] == 1){
            $type = '練習';
        }else{
            $type = '試合・大会';
        }
        $sen_msg = dateformat($_POST['sc_date'])."\n".substr($_POST['start_time'], 0, 5)."~".substr($_POST['finish_time'], 0, 5)."\n\n上記の日時で".$type."を行います。\n\n参加頂ける方はお願いします。";
        $row = $schedule->insertSchedule($_POST['sc_type'], $_POST['description'], $_POST['place'], $_POST['sc_date'], $_POST['start_time'], $_POST['finish_time']);

        $list = $schedule->getMessagingList();
        foreach ($list as $value) {
            if(empty($value['line_id'])){

                $mail_message = "\n\n\n上記のスケージュールに参加できる場合\nhttps://waldorf-classics.herokuapp.com/apps/mailjoin.php?id=".$value['id']."\n\n参加できない場合\nhttps://waldorf-classics.herokuapp.com/apps/mailunjoin.php?id=".$value['id'];

                $from = new SendGrid\Email(null, "localhost.ko@gmail.com");
                $subject = "Waldorf Classics Schedule のお知らせ";
                $to = new SendGrid\Email(null, $value['email']);
                $content = new SendGrid\Content("text/plain", $sen_msg.$mail_message);
                $mail = new SendGrid\Mail($from, $subject, $to, $content);

                $apiKey = getenv(SENDGRID_API_KEY);
                $sg = new \SendGrid($apiKey);

                $response = $sg->client->mail()->send()->post($mail);

            }else{
                $text = $sen_msg;
                $yes_post = new LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('YES', 'sc_y:'.$row[0]['id']);
                $no_post = new LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('NO', 'sc_n:'.$row[0]['id']);
                // Confirmテンプレート
                $confirm = new LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder('上記のスケジュールに参加できますか？', [$yes_post, $no_post]);
                // メッセージを作る
                $confirm_message = new LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('Waldorf Classics Schedule', $confirm);
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
    <?php require '_include/header.php'; ?>
            <h1>Waldorf Classics</h1>
        </header>
        <div class="content">
            <ul class="schedules">
                <?php foreach($schedules as $value): ?>
                    <?php if($value['sc_type'] == 1): ?>
                        <li class="schedule practise" data-sc-id="<?php echo h($value['id']); ?>">
                            <p class="date"><?php echo h(dateformat($value['sc_date'])); ?></p>
                            <p class="time">時間：<span><?php echo h($value['start_time']); ?></span>~<span ><?php echo h($value['finish_time']); ?></span></p>
                            <p class="place">場所：<?php echo h($value['place']); ?></p>
                            <p class="label">練習</p>
                            <p class="menu"><span>変更</span><a href="">削除</a></p>
                        </li>
                    <?php else: ?>
                        <li class="schedule match" data-sc-id="<?php echo h($value['id']); ?>">
                            <p class="date"><?php echo h(dateformat($value['sc_date'])); ?></p>
                            <p class="time">時間：<span><?php echo h($value['start_time']); ?></span>~</p>
                            <p class="place">場所：<?php echo h($value['place']); ?></p>
                            <p class="label">試合</p>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
             <form action="" method="post">
                 <p><select class="" name="sc_type">
                     <option value="1">練習</option>
                     <option value="2">試合・大会</option>
                 </select></p>
                 <p><input type="text" name="description" value="" placeholder="大会名など"></p>
                 <p><input type="text" name="place" value="" placeholder="場所"></p>
                 <p><input type="date" name="sc_date" value=""></p>
                 <p><input type="time" name="start_time" value=""></p>
                 <p><input type="time" name="finish_time" value=""></p>
                 <p class="submit"><input type="submit" value="submit"></p>
             </form>
         </div>
     <?php require '_include/footer.php'; ?>
