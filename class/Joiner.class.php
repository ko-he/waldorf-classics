<?php
require 'DB.class.php';
//line api sdk 読み込み
require_once '../vendor/autoload.php';


class Joiner
{
    private $db;
    private $bot;

    public function __construct()
    {
        $this->db = new DB();

        // line api インスタンス生成
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('w9AHFGgDfuiXizJ+nbUgospTqb7uTy5hr+viE+KAo66P5SZf2wP7x0yEtUceun+7RGhZ7HyAmF0yS+kMA8P5EQ3DZKweK/wuMPuALf7PWo85JjVAgZ9IrMKDtirjfeVe6Yxyz/FAXgMN/sNK1HqDeQdB04t89/1O/w1cDnyilFU=');
        $this->bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '
        35cfb80864e3be2e8c3377689e7dd3a7']);

    }

    public function getProfImg($line_id)
    {
        //line user id から profile を取得
        if(!empty($line_id)){
            $response = $bot->getProfile($line_id);
            if ($response->isSucceeded()) {
                $profile = $response->getJSONDecodedBody();
                $img_url = $profile['pictureUrl'];
            }
        }else{
            $img_url = 'images/prof.jpg';
        }
        return $img_url;
    }
    public function getJoiner($sc_id)
    {
        $sql = 'SELECT u.name, u.line_id j.id FROM users u joiners j WHERE j.sc_id=:sc_id AND j.can_join=1 AND j.user_id=u.id';
        $data = array(':sc_id' => $sc_id);

        $recode = $this->db->queryPost($sql, $data);
        $row = $this->db->dbFetch($recode);
        return $row;
    }
    public function getUnJoiner($sc_id)
    {
        $sql = 'SELECT u.name, u.line_id j.id FROM users u joiners j WHERE j.sc_id=:sc_id AND j.can_join=2 AND j.user_id=u.id';
        $data = array(':sc_id' => $sc_id);

        $recode = $this->db>queryPost($sql, $data);
        $row = $this->db->dbFetch($recode);
        return $row;
    }
}
