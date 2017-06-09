<?php
require 'DB.class.php';

class Joiner
{
    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function joinAnswer($sc_id, $user_id)
    {
        $sql = 'INSERT INTO joiners (sc_id, user_id, created_at, updated_at) VALUES (:sc_id, user_id, NOW(), NOW(), 1)';
        $data = array(
            ':sc_id' => $sc_id,
            ':user_id' => $user_id
        );
        $this->db->queryPost($sql, $data);
    }
    public function noJoinAnswer($sc_id, $user_id,)
    {
        $sql = 'INSERT INTO joiners (sc_id, user_id, created_at, updated_at) VALUES (:sc_id, user_id, NOW(), NOW(), 2)';
        $data = array(
            ':sc_id' => $sc_id,
            ':user_id' => $user_id
        );
        $this->db->queryPost($sql, $data);
    }
    public function lineIdToId($line_id)
    {
        $sql = 'SELECT id from users WHERE line_id=:line_id';
        $data = array(':lina_id' => $lina_id);
        $recode = $this->db->queryPost($sql, $data);
        $row = $this->db->dbFetch($recode);
        return $row[0]['id'];
    }
}
