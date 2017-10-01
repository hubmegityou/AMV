<?php

print_r($_POST);
return;
session_start();
require_once "database/dbinfo.php";
require_once "database/connect.php";

//if(!isset($_SESSION['trip_id'])){wywal gdzies}
$connection = db_connection();


//check if flight exists, if so then link it to application, otherwise create it and link it to application
//if exists you can also check for compensation availability

if($_GET["type"] == "flights"){ 
   echo(create_or_update_flight_infos()); 
}else{
    echo(create_or_update_application());
}

function create_or_update_flight_infos(){
    //$sql = "SELECT EXISTS(SELECT application.* FROM application INNER JOIN flight_info ON application.id = flight_info.application_id INNER JOIN flight on flight.id = flight_info.flight_ID INNER JOIN trip on trip.id = flight_info.trip_id WHERE flight.departure_ID = ? and trip.id = ? LIMIT 1) AS exists";
    $i = 0;
    $flag = true;
    foreach($_POST["flights[]"] as $flight_data){
        $flight = explode('-', $flight_data); 
        if(!create_or_update_flight_info($flight, $i)){
            $flag = false;
        }
        $i++;
    }
    return $flag;
}

function create_or_update_flight_info($flight, $i){
    $sql = "SELECT fi.$db_flight_info_id FROM $db_flight_info_tab fi INNER JOIN $db_trip_tab t on t.$db_trip_id = fi.$db_flight_info_tripid  INNER JOIN $db_airports_tab aa ON f.$db_flight_info_arrivalid = aa.$db_airports_id INNER JOIN $db_airports_tab ad ON f.$db_flight_info_departureid = ad.$db_airports_id  WHERE ad.$db_airports_IATA  = ? AND aa.$db_airports_IATA  = ? AND t.$db_trip_id = ? LIMIT 1 AS 'id' ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssi", $flight[0], $flight[1], $_SESSION["trip_id"]);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0){
        $dataSet = $stmt->get_result();
        $data = $dataSet->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        $flight_info_object = new Flight_info($data["id"]);
        $flight_info_object->update($db_flight_info_order, $i);
    }else{
        $stmt->close();
        insert_flight_info($flight, $i);
    }
    /*
    function update_flight_info_order($id, $order){
        $sql = "UPDATE $db_flight_info_tab SET $db_flight_info_order = ? WHERE $db_flight_info_tab.$db_flight_info_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ii", $order, $id);
        $flag = $stmt->execute();   
        $stmt->close(); 
        return $flag;
    }*/
    function insert_flight_info($flight, $order){
        $airports_ids = [];
        for($i = 0; $i < 2; $i++){
            $sql = "SELECT $db_airports_id FROM $db_airports_tab WHERE $db_airports_IATA = ? AS 'id' ";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("s", $flight[$i]); //flight[$i] contains something like "KTW"
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows < 1){
                $stmt->close();
                return false;
            }   
            $dataSet = $stmt->get_result();
            $data = $dataSet->fetch_array(MYSQLI_ASSOC);
            $stmt->close();
            $airports_ids[$i] = $data['id']; 
        }
        
        $flight_info_object = new Flight_info();
        $flight_info_object->update($db_flight_info_tripid, $_SESSION['trip_id']);
        $flight_info_object->update($db_flight_info_departureid, $airports_ids[0]);
        $flight_info_object->update($db_flight_info_arrivalid, $airports_ids[1]);
        $flight_info_object->update($db_flight_info_order, $order);
        //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!REWORK
        /*
        $sql = "INSERT INTO $db_flight_info_tab ($db_flight_info_tripid, $db_flight_info_departureid, $db_flight_info_arrivalid, $db_flight_info_order) VALUES (?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("iiii", $_SESSION['trip_id'], $airports_ids[0], $airports_ids[1], $order);
        $flag = $stmt->execute();   
        $stmt->close();
        return $flag; */
    }
    
}

function create_or_update_application(){
    $sql = "SELECT fi.$db_flight_info_id AS 'fi_id', fi.$db_flight_info_applicationid AS 'ap_id' FROM $db_flight_info_tab fi INNER JOIN $db_trip_tab t on t.$db_trip_id = fi.$db_flight_info_tripid  INNER JOIN $db_airports_tab aa ON f.$db_flight_info_arrivalid = aa.$db_airports_id INNER JOIN $db_airports_tab ad ON f.$db_flight_info_departureid = ad.$db_airports_id  WHERE ad.$db_airports_IATA  = ? AND aa.$db_airports_IATA  = ? AND t.$db_trip_id = ? LIMIT 1";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssi", $_POST["departure-code"], $_POST["destination-code"], $_SESSION["trip_id"]);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows < 1){
        $stmt->close();
        return false;
    }
    $dataSet = $stmt->get_result();
    $data = $dataSet->fetch_array(MYSQLI_ASSOC);
    $stmt->close();
    $flight_info_id = $data["fi_id"];
    $application_id = $data["ap_id"];
    if($application_id){
        update_application($application_id);
    }else{
        insert_application($flight_info_id);
    }

    create_or_update_flight($flight_info_id);
 

    function update_application($application_id){
        $application_object = new Application($application_id);
        $application_object->update($_POST);
        /*
        $sql = "UPDATE $db_application_tab SET $db_application_incident = ?, $db_application_cause = ?, $db_application_delay = ?, $db_application_cancel = ?, $db_application_resignation = ? WHERE $db_application_tab.$db_application_id = ?";
        $stmt = $connection->prepare($sql);
        $_POST;
        $stmt->bind_param("iiiiii", $application_id);
        $flag = $stmt->execute();   
        $stmt->close(); 
        return $flag;*/
    }

    function insert_application($flight_info_id){
        $application_object = new Application();
        $application_object->update($_POST);//##############################################

        $flight_info_object = new Flight_info($flight_info_id);
        $flight_info_object->update($db_flight_info_applicationid, $application_object->id);
    }

    function create_or_update_flight($flight_info_id){
        $flight_info_object = new Flight_info($flight_info_id);
        if($flight_info_object->flight_id){
            update_flight($flight_info_object->flight_id);
        }else{
            insert_flight($flight_info_id);
        }
        
        function update_flight($flight_id){
            $flight_object = new Flight($flight_id);
            $flight_object->update($_POST);
        }

        function insert_flight($flight_info_id){
            $flight_object = new Flight();
            $flight_object->update($_POST);

            $flight_info_object = new Flight_info($flight_info_id);
            $flight_info_object->update($db_flight_info_flightid, $flight_object->id);
        }


        /*

        $sql = "SELECT f.$db_flight_id AS 'f_id' FROM $db_flight_tab f INNER JOIN $db_flight_info_tab fi ON fi.$db_flight_info_flightid = f.$db_flight_id INNER JOIN $db_trip_tab t on t.$db_trip_id = fi.$db_flight_info_tripid  INNER JOIN $db_airports_tab aa ON f.$db_flight_info_arrivalid = aa.$db_airports_id INNER JOIN $db_airports_tab ad ON f.$db_flight_info_departureid = ad.$db_airports_id  WHERE ad.$db_airports_IATA  = ? AND aa.$db_airports_IATA  = ? AND t.$db_trip_id = ? LIMIT 1";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssi", $_POST["departure-code"], $_POST["destination-code"], $_SESSION["trip_id"]);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows < 1){
            $stmt->close();
            return false;
        }
        $dataSet = $stmt->get_result();
        $data = $dataSet->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        $flight_info_id = $data["fi_id"];
        $application_id = $data["ap_id"]; */
    }
    /*
    function update_flight_info($flight_info_id, $application_id){
        $sql = "UPDATE $db_flight_info_tab SET $db_flight_info_applicationid = ? WHERE $db_flight_info_tab.$db_flight_info_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ii", $application_id, $flight_info_id);
        $flag = $stmt->execute();   
        $stmt->close(); 
        return $flag;
    } */
    /*
    //$sql = "SELECT application.* FROM application INNER JOIN flight_info ON application.id = flight_info.application_id INNER JOIN flight on flight.id = flight_info.flight_ID INNER JOIN trip on trip.id = flight_info.trip_id WHERE flight.departure_ID = ? and trip.id = ?";
        $stmt = $connection->prepare($sql);
        
    // $term = $_SESSION['trip_id'];
    // $stmt->bind_param("s", $term); //check for sql injection
    $v1 = "KTW";
    $v2 = 1;
    $stmt->bind_param("si", $v1, $v2);
        $stmt->execute();
        $dataSet = $stmt->get_result();
        //pull one row as an associative array
        $data = $dataSet->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        echo($data);
        if ($data["exists"]){
            $sql = "UPDATE ";
            
        }else{
            $sql = "INSERT INTO application.* FROM application INNER JOIN flight_info ON application.id = flight_info.application_id INNER JOIN flight on flight.id = flight_info.flight_ID INNER JOIN trip on trip.id = flight_info.trip_id WHERE flight.departure_ID = ? and trip.id = ?";
        }
        */
}
?>
