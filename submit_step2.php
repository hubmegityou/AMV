<?php
session_start();

require_once "database/dbinfo.php";
require_once "database/connect.php";


$connection = db_connection();

$id =$_POST['pass_id'];
$firstname= $_POST['fname'];
$lastname= $_POST['lname'];
$address= $_POST['address'];
$zipcode= $_POST['code'];
$city= $_POST['city'];
$country= $_POST['country'];
$email= $_POST['email'];
$number=$_POST['tnumber'];


if(!empty($id)){

$sql_update="UPDATE $db_passengers_tab SET $db_passengers_firstname='$firstname', $db_passengers_lastname='$lastname', $db_passengers_address='$address', $db_passengers_zipcode='$zipcode',
	  $db_passengers_city='$city', $db_passengers_country='$country', $db_passengers_email='$email', $db_passengers_telnumber='$number' WHERE $db_passengers_id= $id";
$stmt = $connection->prepare($sql_update);    
$stmt->execute();

}else{

$sql="INSERT INTO $db_passengers_tab ($db_passengers_firstname,$db_passengers_lastname, $db_passengers_address, $db_passengers_zipcode, $db_passengers_city, $db_passengers_country ) 
		VAlUES ('$firstname', '$lastname', '$address', '$zipcode', '$city', '$country')";

$stmt = $connection->prepare($sql);    
$stmt->execute();
$pass_id = $connection->insert_id;;
$trip_id = $_SESSION['trip_id'];


$sql_insert="INSERT INTO $db_connect_tab ($db_connect_passenger_id, $db_connect_trip_id) VALUES ('$pass_id', '$trip_id')";
$stmt = $connection->prepare($sql_insert);    
$stmt->execute();

echo $pass_id;

}


?>