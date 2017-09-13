<?php
session_start();

$tnumber = $_POST['tnumber'];
$email = $_POST['email'];


require_once "database/dbinfo.php";
require_once "database/connect.php";
    

$connection = db_connection();

    $sql = "UPDATE $db_passengers_tab SET $db_passengers_telnumber = '$tnumber', $db_passengers_email='$email' WHERE $db_passengers_id=".$_SESSION['id'];
    $connection->query($sql);
