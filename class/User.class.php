<?php

//detabase class 読み込み
require_once('DB.class.php');

//validate class 読み込み
require_once('Validate.class.php');

/* user class
2017.04.18*/
class User extends Validate{

    public $id;
    private $db;

    public function __construct(){
        parent::__construct();
        $this->db = new DB();
    }
    public function setUserId($id){
        $this->id = $id;
    }
    public function login($email, $password, $key){
        $sql = 'SELECT * FROM users WHERE email=:email';
        $data = array(':email' => $email);

        $recode = $this->db->queryPost($sql, $data);
        $row = $this->db->dbFetch($recode);

        if(empty($row) || !password_verify($password, $row[0]['password'])){
            $this->err_msg[$key] = 'emailまたはパスワードが正しくありません';
        }else{
            $this->id = $row[0]['id'];
        }
    }
    public function insertUser($name, $email, $password){
        for($i=0; $i<6; $i++){
            @$code .= mt_rand(0, 9);
        }
        $sql = 'INSERT INTO users (name, email, password, line_code, created_at, updated_at) values (:name, :email, :password, :code, NOW(), NOW())';
        $data = array(
            ':name' => $name,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':code' => $code

        );
        $this->db->queryPost($sql, $data);
    }
    public function logout(){
        $_SESSION = array();
        session_destroy();
    }
    public function getUser($id){
        $sql = 'SELECT * FROM user WHERE id=:id';
        $data = array(':id' => $id);
        $recode = $this->db->queryPost($sql, $data);
        $row = $this->db->dbFetch($recode);
        return $row[0];
    }
    public function forgetPassword($email, $key){
        $sql = 'SELECT * FROM users WHERE email=:email';
        $data = array(':email' => $email);

        $recode = $this->db->queryPost($sql, $data);
        $row = $this->db->dbFetch($recode);

        if(empty($row)){
            $this->err_msg[$key] = 'このメールアドレスは登録されていません';
        }else{
            $code = sha1(uniqid(mt_rand(), true));

            $sql = 'UPDATE users (reset_code) values (:code) WHERE id=:id';
            $data = array(
                ':code' => $code,
                ':id' => $row[0]['id']
            );
            $this->db->queryPost($sql, $data);

            //メール送信処理
        }
    }
    public function checkCode($code){
        $sql = 'SELECT * FROM users WHERE resert_code=:code';
        $data = array(':code' => $code);

        $recode = $this->db->queryPost($sql, $data);
        $row = $this->db->dbFetch($recode);
        if(empty($row)){
            $this->err_msg['code'] = 'リセットコードが不正です';
        }else{
            $this->id = $row[0]['id'];
        }
    }
    public function resetPassword($password){
        $sql = 'UPDATE users SET password=:password WHERE id=:id';
        $data = array(
            ':password' => password_hash($password),
            ':id' => $this->id
        );
        $this->db->queryPost($sql, $data);
    }
}
