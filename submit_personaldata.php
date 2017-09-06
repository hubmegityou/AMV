<?php
session_start();

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$address = $_POST['address'];
$code = $_POST['code'];        
$city = $_POST['city'];
$country = $_POST['country'];
$tel = $_POST['tnumber'];
$email = $_POST['email'];


require_once "database/dbinfo.php";
require_once "database/connect.php";
    

$connection = db_connection();
$sql = "UPDATE $db_passengers_tab SET $db_passengers_firstname= '$fname', $db_passengers_lastname='$lname',  $db_passengers_address='$address',  $db_passengers_zipcode='$code',
        $db_passengers_city ='$city', $db_passengers_country='$country',  $db_passengers_email='$email',  $db_passengers_telnumber='$tel' WHERE $db_passengers_id=".$_SESSION['id'];
$connection->query($sql);
