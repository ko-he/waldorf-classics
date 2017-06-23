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

    public function updateJoin($status, $sc_id, $id)
    {
        $sql = 'SELECT * FROM joiners WHERE sc_id=:sc_id AND user_id=:id';
        $data = array(
            ':sc_id' => $sc_id,
            ':id' => $id
        );
        $recode = $this->db->queryPost($sql, $data);
        $row = $this->db->dbFetch($recode);
        if(!empty($row)){
            $sql = 'UPDATE joiners SET can_join=:status WHERE sc_id=:sc_id AND user_id=:id';
        }else{
            $sql = 'INSERT INTO joiners (can_join, sc_id, user_id, created_at, updated_at) VALUES (:status, :sc_id, :id, NOW(), NOW())';
        }
        $data = array(
            ':status' => $status,
            ':sc_id' => $sc_id,
            ':id' => $id
        );
        $this->db->queryPost($sql, $data);
    }
    public function mailjoin($id, $sc_id)
    {
        $sql = 'INSERT INTO joiners (can_join, sc_id, user_id, created_at, updated_at) VALUES (1, :sc_id, :id, NOW(), NOW())';
        $data = array(
            ':sc_id' => $sc_id,
            ':id' => $id
        );
        $this->db->queryPost($sql, $data);
    }
    public function mailunjoin($id, $sc_id)
    {
        $sql = 'INSERT INTO joiners (can_join, sc_id, user_id, created_at, updated_at) VALUES (2, :sc_id, :id, NOW(), NOW())';
        $data = array(
            ':sc_id' => $sc_id,
            ':id' => $id
        );
        $this->db->queryPost($sql, $data);
    }

    public function getProfImg($line_id)
    {
        //line user id から profile を取得
        if(!empty($line_id)){
            $response = $this->bot->getProfile($line_id);
            if ($response->isSucceeded()) {
                $profile = $response->getJSONDecodedBody();
                $img_url = $profile['pictureUrl'];
            }
        }else{
            $img_url = 'images/prof.png';
        }
        return $img_url;
    }
    public function getJoiner($sc_id)
    {
        $sql = 'SELECT u.name, u.line_id, j.user_id FROM users u, joiners j WHERE j.sc_id=:sc_id AND j.can_join=1 AND j.user_id=u.id';
        $data = array(':sc_id' => $sc_id);

        $recode = $this->db->queryPost($sql, $data);
        $row = $this->db->dbFetch($recode);
        return $row;
    }
    public function getUnJoiner($sc_id)
    {
        $sql = 'SELECT u.name, u.line_id, j.id FROM users u, joiners j WHERE j.sc_id=:sc_id AND j.can_join=2 AND j.user_id=u.id';
        $data = array(':sc_id' => $sc_id);

        $recode = $this->db->queryPost($sql, $data);
        $row = $this->db->dbFetch($recode);
        return $row;
    }
}
