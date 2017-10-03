<?php

require_once "database/dbinfo.php";
require_once "database/connect.php";
header('Content-Type: application/json');
    

$connection = db_connection();
//mysqli_report(MYSQLI_REPORT_ALL);
$sql = "SET @term = ? ";
$stmt = $connection->prepare($sql);
$term = '%'.$_GET['term'].'%';
$stmt->bind_param("s", $term);
$stmt->execute();
$stmt->close();


//$APIData= new APIData();
if (!isset($_GET['step'])){
    echo "Error";
}

switch($_GET["step"]){
    case 1:

        break;
    
    case 2:
        break;
    
    case 3:
        break;
    
    case 5:
        break;

}

echo json_encode($table);


$sql = "SELECT f.$db_flight_id AS 'id' FROM $db_flight_tab f WHERE f.$db_flight_number = ? AND f.$db_flight_airlineid = ? AND f.$db_flight_date = ? LIMIT 1";
$stmt = $connection->prepare($sql);
$stmt->bind_param("iii", $flight_number, $airline_id, $date);
$stmt->execute();
$dataSet = $stmt->get_result();
if ($dataSet->num_rows < 1){
    $stmt->close();
    return false;
}
$data = $dataSet->fetch_array(MYSQLI_ASSOC);
$stmt->close();

function getAirports($connection, $term){
    require "database/dbinfo.php"; 

    $sql = "SELECT * FROM $db_airports_tab WHERE
                $db_airports_ICAO LIKE @term
                OR $db_airports_IATA LIKE @term
                OR $db_airports_name LIKE @term
                OR $db_airports_city LIKE @term
                OR $db_airports_country LIKE @term
                OR $db_airports_region LIKE @term GROUP BY $db_airports_name LIMIT 10 ";

    $stmt = $connection->prepare($sql);    
    $stmt->execute();
    $dataSet = $stmt->get_result();
    //pull all results as an associative array
    $data = $dataSet->fetch_all(MYSQLI_ASSOC);

    $result = array();
    foreach ($data as $object){ 
            array_push($result, array("label" => ($object[$db_airports_city].", ".$object[$db_airports_name].", ".$object[$db_airports_IATA].", ".$object[$db_airports_country]), "value" => $object[$db_airports_IATA]? $object[$db_airports_IATA] : $object[$db_airports_ICAO] ) );
    }
    return $result;
}
?>