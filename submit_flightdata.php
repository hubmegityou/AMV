<?php

session_start();

$fnumber = $_POST['fnumber'];
$date = $_POST['date'];


require_once "database/dbinfo.php";
require_once "database/connect.php";
    

$connection = db_connection();

$sql = "UPDATE $db_flight_tab SET $db_flight_number='$fnumber', $db_flight_date='$date' WHERE $db_flight_id=". $_SESSION['flightid'];
$connection->query($sql);

