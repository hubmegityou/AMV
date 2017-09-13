<?php

//require_once 'APIData.php';
require_once "database/dbinfo.php";
require_once "database/connect.php";
    

$connection = db_connection();
//mysqli_report(MYSQLI_REPORT_ALL);
$sql = "SET @term = ? ";
$stmt = $connection->prepare($sql);
$term = '%'.$_GET['term'].'%';
$stmt->bind_param("s", $term);
$stmt->execute();
$stmt->close();


header('Content-Type: application/json');
//$APIData= new APIData();

if ($_GET['type'] == "airport"){
    //$table = $APIData -> findAirport($_GET['term']);
    $table = getAirports($connection, $term);
}else{
    //$table = $APIData -> findAirline($_GET['term']);
}
echo json_encode($table);




function getAirports($connection, $term){
    require "database/dbinfo.php"; 

    $sql = "SELECT * FROM $db_airports_tab WHERE
                $db_airports_id LIKE @term 
                OR $db_airports_ICAO LIKE @term
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
            array_push($result, array("label" => ($object['city_name']." ".$object['airport_name']." ".$object['country_name']), "value" => $object['ICAO_code']) );
         
    }
    return $result;
}

?>