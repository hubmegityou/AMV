<?php
session_start();
require_once "database/dbinfo.php";
require_once "database/connect.php";

//if(!isset($_SESSION['trip_id'])){wywal gdzies}
$connection = db_connection();

$sql = "SELECT $db_trip_first_flight_info_id FROM $db_trip_tab WHERE $db_trip_id = ? ";
    $stmt = $connection->prepare($sql);
    $term = $_SESSION['trip_id'];
    $stmt->bind_param("s", $term); //check for sql injection
    $stmt->execute();
    $dataSet = $stmt->get_result();
    //pull one row as an associative array
    $data = $dataSet->fetch_array(MYSQLI_ASSOC);
    $stmt->close();
    $next_flight_id = $data[$db_trip_first_flight_info_id];

$ids = array();
//foreach ($data as $object){ 
//        array_push($result, array("label" => ($object[$db_airports_city]." ".$object[$db_airports_name]." ".$object[$db_airports_country]), "value" => $object[$db_airports_ICAO]? $object[$db_airports_ICAO] : $object[$db_airports_IATA] ) );
//}
do{
    $sql = "SELECT * FROM $db_flight_info_tab WHERE $db_flight_info_id = ? ";
    $stmt = $connection->prepare($sql);
    $term = $next_flight_id;
    $stmt->bind_param("s", $term); //check for sql injection
    $stmt->execute();
    $dataSet = $stmt->get_result();
    //pull one row as an associative array
    $data = $dataSet->fetch_array(MYSQLI_ASSOC);
    $stmt->close();
    array_push($ids, array("application_id" => ($data[$db_flight_info_applicationid] ? $data[$db_flight_info_applicationid] : "" ), "flight_id" => $data[$db_flight_id]));
    $next_flight_id = $data[$db_flight_info_nextflight];
}while(isset($data[$db_flight_info_nextflight]));

$flights_and_applications = array();
foreach($ids as $object){
    $sql = "SELECT * FROM $db_flight_tab WHERE $db_flight_id = ? ";
    $stmt = $connection->prepare($sql);
    $term = $object['flight_id'];
    $stmt->bind_param("s", $term); //check for sql injection
    $stmt->execute();
    $dataSet = $stmt->get_result();
    //pull one row as an associative array
    $flight_data = $dataSet->fetch_array(MYSQLI_ASSOC);
    $stmt->close();
    if($object['application_id'] != "") {
        $sql = "SELECT * FROM $db_application_tab WHERE $db_application_id = ? ";
        $stmt = $connection->prepare($sql);
        $term = $object['application_id'];
        $stmt->bind_param("s", $term); //check for sql injection
        $stmt->execute();
        $dataSet = $stmt->get_result();
        //pull one row as an associative array
        $application_data = $dataSet->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
    }

    array_push($flights_and_applications, array('flight_info' => $flight_data, 'application_info' => (!empty($application_data) ? $application_data : "") ));
}

header('Content-Type: application/json');
echo json_encode($flights_and_applications);

?>