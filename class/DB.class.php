<?php
/*データベースクラス
2017.04.07*/

class DB {

    private $dbh;

    public function __construct(){
        $url = parse_url(getenv('DATABASE_URL'));
        $dsn = sprintf('pgsql:host=%s;dbname=%s', $url['host'], substr($url['path'], 1));
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        );
        try{
            $this->dbh = new PDO($dsn, $url['user'], $url['pass'], $options);
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
