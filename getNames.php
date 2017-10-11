<?php

require_once "database/dbinfo.php";
require_once "database/connect.php";

$connection = db_connection();
$sql = "SELECT $db_connect_passenger_id FROM $db_connect_tab WHERE $db_connect_trip_id =1";
$stmt = $connection->prepare($sql);    
$stmt->execute();
$dataSet = $stmt->get_result();
$data = $dataSet->fetch_all(MYSQLI_ASSOC);

$i=1;
$array = array();

foreach ($data as $object){ 
			$sql= "SELECT $db_passengers_firstname, $db_passengers_lastname, $db_passengers_id FROM $db_passengers_tab WHERE $db_passengers_id= $object[$db_connect_passenger_id]";
			$stmt = $connection->prepare($sql);    
			$stmt->execute();
			$dataSet = $stmt->get_result();
			$data_name = $dataSet->fetch_all(MYSQLI_ASSOC);
			$name= $data_name[0][$db_passengers_firstname].' '.$data_name[0][$db_passengers_lastname];
            $array[$i]= array("name" => ($name),"id" => ($data_name[0][$db_passengers_id]) );
			$i++;
    }
	

echo json_encode($array);


?>