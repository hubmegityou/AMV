<?php 
    session_start();
    require_once "database/dbinfo.php";
    require_once "database/connect.php";

    $sql = "SELECT * FROM $db_trip_tab WHERE $db_trip_string_id = ? ";
    $stmt = $connection->prepare($sql);
    $term = $_GET['id'];
    $stmt->bind_param("s", $term); //check for sql injection
    $stmt->execute();
    $dataSet = $stmt->get_result();
    //pull one row as an associative array
    $data = $dataSet->fetch_array(MYSQLI_ASSOC);
    $stmt->close();

    //FIX THIS
    //if(!$data){raise error};
    
    //SET SESSION VARIABLES
    $_SESSION['trip_id'] = $data[$db_trip_id];

    if(!isset($data[$db_trip_first_flight_info_id])){
        header('Location: flight_form.html');
        exit;
    }

    $sql = "SELECT * FROM $db_flight_info_tab WHERE $db_flight_info_id = ? ";
    $stmt = $connection->prepare($sql);
    $term = $data[$db_trip_first_flight_info_id];
    $stmt->bind_param("s", $term); //check for sql injection
    $stmt->execute();
    $dataSet = $stmt->get_result();
    //pull one row as an associative array
    $data = $dataSet->fetch_array(MYSQLI_ASSOC);


    ?>