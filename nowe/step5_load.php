<?php


require_once "database/dbinfo.php";
require_once "database/connect.php";
$connection = db_connection();


$sql= "SELECT $db_compensation_type,$db_compensation_payment,$db_compensation_currency, $db_compensation_account 
FROM $db_compensation_tab WHERE $db_compensation_id = (SELECT $db_application_compensationid FROM $db_application_tab WHERE $db_application_id = 
(SELECT $db_flight_info_applicationid FROM $db_flight_info_tab WHERE $db_flight_info_id =(SELECT $db_trip_first_flight_info_id FROM $db_trip_tab WHERE $db_trip_id=2)))";


$stmt = $connection->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->num_rows;
$data = $result->fetch_all(MYSQLI_ASSOC); ;
$stmt->close();
	
	
if ($rows > 0){
	$array['type']= $data[0][$db_compensation_type];
	$array['payment']= $data[0][$db_compensation_payment];
	$array['currency']= strtoupper ($data[0][$db_compensation_currency]);
	$array['account'] = $data[0][$db_compensation_account];
}else{
	$array['type']='';
	$array['payment']='';
	$array['currency']='';
	$array['account'] ='';
}
	
	echo json_encode($array)
	
	
	
?>