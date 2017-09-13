<?php

session_start();

$email = $_POST['email'];
$tel = $_POST['tel'];
$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
//check if variables not null 
//turn this on later 
/*
if(!isset($email) || !isset($tel) || !isset($first_name) || !isset($last_name)){
    header('Location: DataForm.html'); //add error code and render it on page 
    exit;
}*/
require_once "database/dbinfo.php";
require_once "database/connect.php";
    

$connection = db_connection();
$sql = "INSERT INTO $db_passengers_tab($db_passengers_firstname, $db_passengers_lastname, $db_passengers_telnumber, $db_passengers_email)
VALUES ('$fname', '$lname', '$tel', '$email')";
$connection->query($sql);

$_SESSION['passenger_id'] = $connection->insert_id; //passenger id
//$id=$_SESSION['id'];


header('Location: flight_form.html');
exit;
?>