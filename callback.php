<?php
//データベース接続、データベース関連クラス読み込み
require_once 'class/DB.class.php';
// require_once 'class/Joiner.class.php';

//line api sdk 読み込み
require_once 'vendor/autoload.php';

// line api インスタンス生成
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('w9AHFGgDfuiXizJ+nbUgospTqb7uTy5hr+viE+KAo66P5SZf2wP7x0yEtUceun+7RGhZ7HyAmF0yS+kMA8P5EQ3DZKweK/wuMPuALf7PWo85JjVAgZ9IrMKDtirjfeVe6Yxyz/FAXgMN/sNK1HqDeQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '
35cfb80864e3be2e8c3377689e7dd3a7']);

//line events 取得
$json_string = file_get_contents('php://input');
$json_obj = json_decode($json_string);

$userId = $json_obj->{"events"}[0]->{"source"}->{"userId"};
$type = $json_obj->{'events'}[0]->{'type'};
$reply_token = $json_obj->{"events"}[0]->{"replyToken"};

//データベースクラスインスタンス生成
$db = new DB();

//follow event ならユーザーを生成してデータベースに保存
//メッセージは管理画面 URL と承認code
if($type == 'follow'){

    //repray message の生成
    $message = "登録ありがとうございます。\n承認コードをメッセージ入力画面より送信してください。";

}elseif($type == 'message'){
    // 送信されたメッセージを取得
    $get_message = $json_obj->{"events"}[0]->{"message"}->{'text'};

    // password 変更キーワード
    if($get_message == 'password change'){

        $reset_code = sha1(uniqid(mt_rand(1000, 9999)));
        $sql = 'UPDATE users SET reset_code=:code WHERE line_id=:id';
        $data = array(
            ':code' => $reset_code,
            ':id' => $userId
        );
        $db->queryPost($sql, $data);
            $message = "Password 変更画面 URL：https://waldorf-classics.herokuapp.com/auth/resetpassword.php?code=".$reset_code;
    }elseif(strlen($get_message) == 6){
        $sql = 'SELECT * FROM users WHERE line_code=:code';
        $data = array(':code' => $get_message);
        $recode = $db->queryPost($sql, $data);
        $row = $db->dbFetch($recode);
        if(empty($row)){
            $message = '承認コードが一致しませんでした';
        }else {
            $sql = 'UPDATE users SET line_code=null, line_id=:line_id WHERE id=:id';
            $data = array(
                ':line_id' => $userId,
                ':id' => $row[0]['id']
            );
            $db->queryPost($sql, $data);

            $message = "コードの承認が完了しました。";
        }
    }
}elseif($type == 'postback') {
    $get_message = $json_obj->{"events"}[0]->{"postback"}->{'data'};
    if(substr($get_message, 0, 5) == 'sc_y:'){
        $message = 'Y';
    }
    $sc_id = substr($get_message, 0, 5);

}


$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
$response = $bot->replyMessage($reply_token, $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
