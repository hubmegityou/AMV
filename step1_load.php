<?php
    require_once "classes/Trip.class.php";
    require_once "classes/Application.class.php";
    require_once "classes/Airport.class.php";
    require_once "classes/Flight_info.class.php";
    require_once "classes/Flight.class.php";
    require "database/dbinfo.php";
    $_SESSION["trip_id"] = 2; //#########################################################
/*    if(!isset($_SESSION["trip_id"])){
        header(); 
    }*/
    $trip_object = new Trip($_SESSION["trip_id"]);
    $final_delay = $trip_object->final_delay;

    global $connection;
    //$object[$db_airports_city].", ".$object[$db_airports_name].", ".$object[$db_airports_IATA].", ".$object[$db_airports_country]),
    $sql = "SELECT a1.$db_airports_IATA AS 'dep_IATA', a1.$db_airports_city AS 'dep_city', a1.$db_airports_name AS 'dep_name', a1.$db_airports_country AS 'dep_country',
    a2.$db_airports_IATA AS 'dest_IATA', a2.$db_airports_city AS 'dest_city', a2.$db_airports_name AS 'dest_name', a2.$db_airports_country AS 'dest_country', 
    f.$db_flight_number AS 'flight_number', f.$db_flight_date AS 'flight_date', 
    al.$db_airlines_IATA AS 'airline_IATA', al.$db_airlines_operator AS 'airline_name', al.$db_airlines_name AS 'airline_country', 
    ap.* 
    FROM $db_flight_info_tab fi 
    LEFT JOIN $db_application_tab ap ON fi.$db_flight_info_applicationid = ap.$db_application_id 
    INNER JOIN $db_airports_tab a1 ON fi.$db_flight_departureid = a1.$db_airports_id 
    INNER JOIN $db_airports_tab a2 ON fi.$db_flight_arrivalid = a2.$db_airports_id 
    LEFT JOIN $db_flight_tab f ON fi.$db_flight_info_flightid = f.$db_flight_id 
    LEFT JOIN $db_airlines_tab al ON f.$db_flight_airlineid = al.$db_airlines_id 
    WHERE fi.$db_flight_info_tripid = ?
    ORDER BY fi.$db_flight_info_order ASC";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $_SESSION["trip_id"]);
    $stmt->execute();
    $dataSet = $stmt->get_result();
    $rows = $dataSet->num_rows;
    $data = $dataSet->fetch_all(MYSQLI_ASSOC); 
    $stmt->close();

    if ($rows > 1){
        $departure_name = $data[0]["dep_city"].", ".$data[0]["dep_name"].", ".$data[0]["dep_IATA"].", ".$data[0]["dep_country"];
        $departure_data_code = $data[0]["dep_IATA"];
        $departure_data_name = $data[0]["dep_city"];
        
        $destination_name = $data[$rows-1]["dest_city"].", ".$data[$rows-1]["dest_name"].", ".$data[$rows-1]["dest_IATA"].", ".$data[$rows-1]["dest_country"];
        $destination_data_code = $data[$rows-1]["dest_IATA"];
        $destination_data_name = $data[$rows-1]["dest_city"];
        
        $waypoints = [];
        for($i = 1; $i < $rows; $i++){
            $waypoints[$i]["name"] = $data[$i]["dep_city"].", ".$data[$i]["dep_name"].", ".$data[$i]["dep_IATA"].", ".$data[$i]["dep_country"];
            $waypoints[$i]["data_code"] = $data[$i]["dep_IATA"];
            $waypoints[$i]["data_name"] = $data[$i]["dep_city"];
        }
        
    }elseif($rows == 1){
        $departure_name = $data["dep_city"].", ".$data["dep_name"].", ".$data["dep_IATA"].", ".$data["dep_country"];
        $departure_data_code = $data["dep_IATA"];
        $departure_data_name = $data["dep_city"];
        
        $destination_name = $data["dest_city"].", ".$data["dest_name"].", ".$data["dest_IATA"].", ".$data["dest_country"];
        $destination_data_code = $data["dest_IATA"];
        $destination_data_name = $data["dest_city"];
    }else{
        $departure_name = "";
        $departure_data_code = "";
        $departure_data_name = "";
    }
    

?>