<?php
require_once "database/dbinfo.php";
require_once "database/connect.php";

$type=$_POST['name'];
$id=$_POST['id'];



switch($type){
	case "r":	
				$field= $db_connect_passenger_id;
				$table= $db_connect_tab;
				$file= $db_connect_reservation;
				break;
				
	case "k":	
				$field= $db_connect_passenger_id;
				$table= $db_connect_tab;
				$file= $db_connect_boarding;
				break;
				
	case "p":	
				$field= $db_passengers_id;
				$table= $db_passengers_tab;
				$file= $db_passengers_passport;
				break;
				
	case "dp":	
				$field= $db_passengers_id;
				$table= $db_passengers_tab;
				$file= $db_passengers_idcard1;
				break;
				
	case "dt":  
				$field= $db_passengers_id;
				$table= $db_passengers_tab;
				$file= $db_passengers_idcard2;
				break;
}

$connection = db_connection();
	
$sql= "SELECT $file FROM $table WHERE $field= $id"; 
$stmt = $connection->prepare($sql);    
$stmt->execute();
$dataSet = $stmt->get_result();
$data = $dataSet->fetch_all(MYSQLI_ASSOC); 
$stmt->close();

if (!empty($data[0][$file])){
	echo 'ok';
}

?>