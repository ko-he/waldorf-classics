<?php
/*データベースクラス
2017.04.07*/

class DB {
    const DB_URL = parse_url(getenv('DATABASE_URL'));
    const DB_HOST = sprintf('pgsql:host=%s;dbname=%s', self::DB_URL['host'], substr(self::DB_URL['path'], 1));
    const DB_USER = self::DB_URL['user'];
    const DB_PASSWORD = self::DB_URL['pass'];
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
