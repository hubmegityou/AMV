<?php

//require_once 'APIData.php';
require_once "database/dbinfo.php";
require_once "database/connect.php";
    

$connection = db_connection();


$sql = "SET @term = :term";

$stmt = $connection->prepare($sql);
$term = $_GET['term'];
$stmt->bindValue(":term", "%$term%", PDO::PARAM_STR);
$stmt->execute();


header('Content-Type: application/json');
//$APIData= new APIData();

if ($_GET['type'] == "airport"){
    //$table = $APIData -> findAirport($_GET['term']);
    $table = getAirports();
}else{
    //$table = $APIData -> findAirline($_GET['term']);
}
echo json_encode($table);




function getAirports(){ 
    $sql = "SELECT * FROM $db_airports_tab WHERE
                $db_airports_id LIKE @term 
                OR $db_airports_ICAO LIKE @term
                OR $db_airports_IATA LIKE @term
                OR $db_airports_name LIKE @term
                OR $db_airports_city LIKE @term
                OR $db_airports_country LIKE @term
                OR $db_airports_region LIKE @term ";

    $stmt = $connection->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();
    $stmt->close();

    $result = array();
    foreach ($data as $object){ 
        if (stripos($object['airportName'], $text) !== false || stripos($object['countryName'], $text)  !== false || stripos($object['airportCode'], $text) !== false || stripos($object['cityName'], $text) !== false){
            array_push($result, array("label" => ($object['cityName']." ".$object['airportName']." ".$object['countryName']), "value" => $object['airportCode']) );
        } 
    }
    return $result;
}
/*

if ($_POST['input']=="flight"){

    $curlResult= $APIData->curl($APIData->AirportsUrl);

}else{

    $curlResult= $APIData->curl($APIData->AirlinesUrl);
}
    
$data= $APIData-> dataForAutocomplete($curlResult, $_POST['input']);
echo $data;
*/

?>