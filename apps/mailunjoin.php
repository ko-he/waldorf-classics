<?php
session_start();
require '../Joiner.class.php';

$joiner = new Joiner();

if(!empty($_GET['id'])){
    $joiner->mailJoin($_GET['id'], $_GET['sc_id']);
}
header('location: https://waldorf-classics.herokuapp.com');
