<?php
session_start();
require_once "database/dbinfo.php";
require_once "database/connect.php";
header('Content-Type: application/json');
    
$_SESSION["trip_id"] = 2; //REMOVE!!!!!!!!!!!!!!!!!!!!
$connection = db_connection();
//mysqli_report(MYSQLI_REPORT_ALL);


if (!isset($_GET['step'])){
    echo "Error";
}

switch($_GET["step"]){
    case 1:
        $table = getStepOne();
        break;
    
    case 2:
        break;
    
    case 3:
        break;
    
    case 5:
        break;

}

echo json_encode($table);

function getStepOne(){
    require "database/dbinfo.php";
    
    global $connection;
    //$object[$db_airports_city].", ".$object[$db_airports_name].", ".$object[$db_airports_IATA].", ".$object[$db_airports_country]),
$sql = "SELECT a1.$db_airports_IATA AS 'dep_IATA', a1.$db_airports_city AS 'dep_city', a1.$db_airports_name AS 'dep_name', a1.$db_airports_country AS 'dep_country',
 a2.$db_airports_IATA AS 'dest_IATA', a2.$db_airports_city AS 'dest_city', a2.$db_airports_name AS 'dest_name', a2.$db_airports_country AS 'dest_country', 
 f.$db_flight_number AS 'flight_number', f.$db_flight_date AS 'flight_date', 
 al.$db_airlines_IATA AS 'airline_IATA', al.$db_airlines_operator AS 'airline_name', al.$db_airlines_name AS 'airline_country', 
 ap.* 
 FROM $db_flight_info_tab fi 
 INNER JOIN $db_application_tab ap ON fi.$db_flight_info_applicationid = ap.$db_application_id 
 INNER JOIN $db_airports_tab a1 ON fi.$db_flight_departureid = a1.$db_airports_id 
 INNER JOIN $db_airports_tab a2 ON fi.$db_flight_arrivalid = a2.$db_airports_id 
 INNER JOIN $db_flight_tab f ON fi.$db_flight_info_flightid = f.$db_flight_id 
 INNER JOIN $db_airlines_tab al ON f.$db_flight_airlineid = al.$db_airlines_id 
 WHERE fi.$db_flight_info_tripid = ?
 ORDER BY fi.$db_flight_info_order";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $_SESSION["trip_id"]);
    $stmt->execute();
    $dataSet = $stmt->get_result();
    if ($dataSet->num_rows < 1){
        $stmt->close();
        return false;
    }
    $data = $dataSet->fetch_all(MYSQLI_ASSOC); //fetch_all
    $stmt->close();
    return $data;
}
?>