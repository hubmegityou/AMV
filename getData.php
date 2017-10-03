<?php

//require_once 'APIData.php';
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
if (!isset($_GET['type'])){
    echo "Error";
}
if ($_GET['type'] == "airport"){
    //$table = $APIData -> findAirport($_GET['term']);
    $table = getAirports($connection, $term);
}elseif($_GET['type'] == "airline"){
    //$table = $APIData -> findAirline($_GET['term']);
    $table = getAirlines($connection, $term);
}elseif($_GET['type'] == "region"){
    $table = getRegion($connection, $term);
}
echo json_encode($table);




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

function getAirlines($connection, $term){
    require "database/dbinfo.php"; 

    $sql = "SELECT * FROM $db_airlines_tab WHERE $db_airlines_operator LIKE @term GROUP BY $db_airlines_name LIMIT 10 ";
    
    $stmt = $connection->prepare($sql);    
    $stmt->execute();
    $dataSet = $stmt->get_result();
    //pull all results as an associative array
    $data = $dataSet->fetch_all(MYSQLI_ASSOC);

    $result = array();
    foreach ($data as $object){ 
            array_push($result, array("label" => ($object[$db_airlines_operator].", ".$object[$db_airlines_name]), "value" => $object[$db_airlines_IATA]));
    }
    return $result;
}
function getRegion($connection, $term){
    require "database/dbinfo.php"; 

    $sql = "SELECT $db_airports_region FROM $db_airports_tab WHERE $db_airports_IATA LIKE @term LIMIT 1 ";
    
    $stmt = $connection->prepare($sql);    
    $stmt->execute();
    $dataSet = $stmt->get_result();
    //pull all results as an associative array
    $data = $dataSet->fetch_all(MYSQLI_ASSOC);

    $result= ""; 
    $result = $data[0][$db_airlines_region];
    
    return $result;
}

?>