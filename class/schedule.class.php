<?php

//detabase class 読み込み
require_once('DB.class.php');

class Schedule
{

    private $db;

    public function __construct(){
        $this->db = new DB();
    }

    public function insertSchedule($sc_type, $description, $place, $sc_date, $start_time, $finish_time)
    {
        $sql = 'INSERT INTO Schedules SET sc_type=:sc_type, description=:description, place=:place, sc_date=:sc_date, start_time=:start_time, finish_time=:finish_time, created_at=NOW(), updated_at=NOW()';
        $data = array(
            ':sc_type' => $sc_type,
            ':description' => $description,
            ':sc_date' => $sc_date,
            ':start_time' => $start_time,
            ':finish_time' => $finish_time
        );
        $this->db->queryPost($sql, $data);
    }
}
