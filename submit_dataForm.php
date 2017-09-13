<?php

session_start();

$email = $_POST['email'];
$tel = $_POST['tel'];
$fname = $_POST['first_name'];
$lname = $_POST['last_name'];

require_once "database/dbinfo.php";
require_once "database/connect.php";
    

$connection = db_connection();
$sql = "INSERT INTO $db_passengers_tab($db_passengers_firstname, $db_passengers_lastname, $db_passengers_telnumber, $db_passengers_email)
VALUES ('$fname', '$lname', '$tel', '$email')";
$connection->query($sql);

$_SESSION['id'] = $connection->insert_id; ///id passenger
$id=$_SESSION['id'];



$sql = "INSERT INTO $db_trip_tab()
VALUES ()";
$connection->query($sql);

$_SESSION['trip'] = $connection->insert_id; ///id trip
$trip=$_SESSION['trip'];




$sql = "INSERT INTO $db_connect_tab(   $db_connect_passenger_id, $db_connect_trip_id)
VALUES ($id, $trip)";
$connection->query($sql);

$_SESSION['connect'] = $connection->insert_id; ///id connect



$sql = "INSERT INTO $db_compensation_tab( )
VALUES ()";
$connection->query($sql);

$_SESSION['compensation'] = $connection->insert_id; ///id connect




header('Location: compensation_form.html');