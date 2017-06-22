<?php
session_start();
require '../class/Schedule.class.php';

$schedule = new Schedule();

if(!empty($_GET['id'])){
    $schedule->deleteSc($_GET['id']);
}
header('location: https://waldorf-classics.herokuapp.com');
