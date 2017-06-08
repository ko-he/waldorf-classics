<?php
// 定義関数の読み込み
require 'function.php';

//line api sdk 読み込み
require_once '../vendor/autoload.php';

// line api インスタンス生成
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('w9AHFGgDfuiXizJ+nbUgospTqb7uTy5hr+viE+KAo66P5SZf2wP7x0yEtUceun+7RGhZ7HyAmF0yS+kMA8P5EQ3DZKweK/wuMPuALf7PWo85JjVAgZ9IrMKDtirjfeVe6Yxyz/FAXgMN/sNK1HqDeQdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '
35cfb80864e3be2e8c3377689e7dd3a7']);

//line user id から profile を取得
$response = $bot->getProfile('U96e7f2d8021abec1642c1cb9002d787b');
if ($response->isSucceeded()) {
    $profile = $response->getJSONDecodedBody();
}
?>
<div class="prof"><img src="<?php echo h($profile['pictureUrl']); ?>" alt="prof"></div>
