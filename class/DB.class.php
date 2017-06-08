<?php
/*データベースクラス
2017.04.07*/

class DB {

    const DB_HOST = 'pgsql:dbname=d7uunh1sb58rvn; host=ec2-54-225-68-71.compute-1.amazonaws.com; charset=utf8';
    const DB_USER = 'hmpzvzhlyhlaeb';
    const DB_PASSWORD = 'c6e1b4152cce054e06b5a52dc2b38169cb5fdae834887a40c1751645bb3ba981';
    const DB_OPTIONS = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
    );

    private $dbh;

    public function __construct(){
        try{
            $this->dbh = new PDO(self::DB_HOST, self::DB_USER, self::DB_PASSWORD, self::DB_OPTIONS);
        }catch(PDOException $e){
            exit('missing connect to database'.$e->message());
        }
    }

    public function queryPost($sql, $data){
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($data);
        return $stmt;
    }

    public function dbFetch($recordSet){
        $ret = array();
        while($row = $recordSet->fetch(PDO::FETCH_ASSOC)){
            $ret[] = $row;
        }
        return $ret;
    }
}
