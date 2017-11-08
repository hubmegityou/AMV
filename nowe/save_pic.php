<?php

require_once "database/dbinfo.php";
require_once "database/connect.php";

session_start();


//$_SESSION['trip_id'];


//// pass_id-> passenger id
////type->id   r-> rezerwacja, k-> karta pokładowa, p-> paszport, dp-> dowód osobity przód, dt-> dowód osobity tył


$trip=2;
//$_SESSION['trip_id'];
$type = $_POST['type'];
$pass_id= $_POST['pass_id'];

$name=explode('.',$_FILES["file"]['name']);
$filename=$type.'.'.$name[1];

$path="uploads/$trip/$pass_id/".$filename;

if (!is_dir( "uploads")){
    mkdir ("uploads", 0777);}

if (!is_dir( "uploads/$trip")){
    mkdir ("uploads/$trip", 0777);}

if (!is_dir( "uploads/$trip/$pass_id")){
    mkdir ("uploads/$trip/$pass_id", 0777);}
	
	if (is_uploaded_file($_FILES["file"]['tmp_name'])) {
    
		move_uploaded_file($_FILES["file"]['tmp_name'],
        $path);
	}
	

	
switch($type){
	case "r":	
				$table= $db_connect_tab;
				$file= $db_connect_reservation;
				$field=$db_connect_passenger_id;
				$value=$trip;
				break;
				
	case "k":	
				$table= $db_connect_tab;
				$file= $db_connect_boarding;
				$field=$db_connect_passenger_id;
				$value=$trip;
				break;
				
	case "p":	
				$table= $db_passengers_tab;
				$file= $db_passengers_passport;
				$field= $db_passengers_id;
				$value= $pass_id;
				break;
				
	case "dp":	
				$table= $db_passengers_tab;
				$file= $db_passengers_idcard1;
				$field= $db_passengers_id;
				$value= $pass_id;
				break;
				
	case "dt":  
				$table= $db_passengers_tab;
				$file= $db_passengers_idcard2;
				$field= $db_passengers_id;
				$value= $pass_id;
				break;
}
	
$connection = db_connection();
	
$sql= "UPDATE $table SET $file= '$path' WHERE $field=$value";
$stmt = $connection->prepare($sql);    
$stmt->execute();


?>