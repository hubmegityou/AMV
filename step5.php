<?php

require_once "database/dbinfo.php";
require_once "database/connect.php";



IF ($_POST['type'] == "e"){
	$type=1;
}else{
	$type=2;
}

IF($_POST['payment']=='paypal'){
	$payment=1	
}else{
	$payment=2;
}


$currency = $_POST['currency'];
$account = $_POST['account'];



$connection = db_connection();


$sql= "INSERT INTO  $db_compensation_tab ($db_compensation_type, $db_compensation_payment, $db_compensation_currency, $db_compensation_account) VALUES ('$type', '$payment', '$currency', '$account')";
$stmt = $connection->prepare($sql);    
$stmt->execute();

$id = $connection->insert_id; 

$sql_application= "UPDATE  $db_application_tab SET $db_application_compensationid = '$id' WHERE $db_application_id = ";
$stmt = $connection->prepare($sql_application);    
$stmt->execute();


//OR

$sql= "UPDATE  $db_compensation_tab SET $db_compensation_type = '$type', $db_compensation_payment = '$payment',  $db_compensation_currency = '$currency', $db_compensation_account = '$account' WHERE $db_compensation_id = ";
$stmt = $connection->prepare($sql);    
$stmt->execute();


?>