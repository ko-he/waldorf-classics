<?php
session_start();
require '../Joiner.class.php';

$joiner = new Joiner();

if(!empty($_GET['status'])){
    $joiner->updateJoin($_GET['status'], $_GET['sc_id'], $_SESSION['id']);
}
header('location: https://waldorf-classics.herokuapp.com');
