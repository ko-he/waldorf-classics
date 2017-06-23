<?php

//detabase class 読み込み
require_once('DB.class.php');
require_once('Validate.class.php');

class Schedule extends Validate
{

    private $db;

    public function __construct(){
        parent::__construct();
        $this->db = new DB();
    }

    public function insertSchedule($sc_type, $description, $place, $sc_date, $start_time, $finish_time)
    {
        $sql = 'INSERT INTO schedules (sc_type, description, place, sc_date, start_time, finish_time, created_at, updated_at) VALUES (:sc_type, :description, :place, :sc_date, :start_time, :finish_time, NOW(), NOW())';
        $data = array(
            ':sc_type' => $sc_type,
            ':description' => $description,
            ':place' => $place,
            ':sc_date' => $sc_date,
            ':start_time' => $start_time,
            ':finish_time' => $finish_time
        );
        $this->db->queryPost($sql, $data);
        $sql2 = 'SELECT * FROM schedules ORDER BY id DESC LIMIT 1';
        $recode = $this->db->queryPost($sql2, array());
        $row = $this->db->dbFetch($recode);
        return $row[0];
    }
    public function getMessagingList()
    {
        $sql = 'SELECT * from users';
        $recode = $this->db->queryPost($sql, array());
        $row = $this->db->dbFetch($recode);
        return $row;
    }
    public function getSchedules()
    {
        $sql = 'SELECT * FROM schedules WHERE sc_date>=NOW() ORDER BY sc_date ASC LIMIT 10';
        $recode = $this->db->queryPost($sql, array());
        $row = $this->db->dbFetch($recode);
        return $row;
    }
    public function getNextMatch()
    {
        $sql = 'SELECT * FROM schedules WHERE sc_date>=NOW() AND sc_type=2 ORDER BY sc_date ASC LIMIT 1';
        $recode = $this->db->queryPost($sql, array());
        $row = $this->db->dbFetch($recode);
        return $row[0];
    }
    public function getNextPractice()
    {
        $sql = 'SELECT * FROM schedules WHERE sc_date>=NOW() AND sc_type=1 ORDER BY sc_date ASC LIMIT 1';
        $recode = $this->db->queryPost($sql, array());
        $row = $this->db->dbFetch($recode);
        return $row[0];
    }
    public function deleteSc($id)
    {
        $sql = 'DELETE FROM schedules WHERE id=:id';
        $data = array(':id' => $id);
        $this->db->queryPost($sql, $data);
    }
    public function getEditSchedule($id)
    {
        $sql = 'SELECT * FROM Schedules WHERE id=:id';
        $data = array(':id' => $id);
        $recode = $this->db->queryPost($sql, $data);
        $row = $this->db->dbFetch($recode);
        return $row[0];
    }
    public function updateSchedule($sc_type, $description, $place, $sc_date, $start_time, $finish_time, $id)
    {
        $sql = 'UPDATE schedules SET sc_type=:sc_type, description=:description, place=:place, sc_date=:sc_date, start_time=:starttime, finish_time=:finish_time WHERE id=:id';
        $data = array(
            ':sc_type' => $sc_type,
            ':description' => $description,
            ':place' => $place,
            ':sc_date' => $sc_date,
            ':start_time' => $start_time,
            ':finish_time' => $finish_time,
            ':id' => $id
        );
        $this->db->queryPost($sql, $data);
    }
}
