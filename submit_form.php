<?php

//print_r($_POST);
//return;
session_start();
require_once "database/dbinfo.php";
require_once "database/connect.php";
require_once "Flight_info.class.php";
require_once "Flight.class.php";
require_once "Application.class.php";
require_once "Airport.class.php";
require_once "GreatCircle.php";
require_once "Money.class.php";
require_once "Validate.class.php";
$_SESSION["trip_id"] = 2; // just for testing !!!!!!!!!!!!!!!!!!!!
//if(!isset($_SESSION['trip_id'])){wywal gdzies}
$connection = db_connection();


//check if flight exists, if so then link it to application, otherwise create it and link it to application
//if exists you can also check for compensation availability

if(isset($_GET["type"]) && $_GET["type"] == "flights"){ 
    echo(create_or_update_flight_infos()); //if we got list of flights then set them for trip 
}else{
    echo(create_or_update_application());   //if we got one flight then add an application to it 
}

function purge_trip_flight_infos(){
    require "database/dbinfo.php";
    global $connection;
    $sql = "DELETE FROM $db_flight_info_tab WHERE $db_flight_info_tripid = ? ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $_SESSION["trip_id"]);
    $stmt->execute();
    $stmt->close();
}

function create_or_update_flight_infos(){
    //$sql = "SELECT EXISTS(SELECT application.* FROM application INNER JOIN flight_info ON application.id = flight_info.application_id INNER JOIN flight on flight.id = flight_info.flight_ID INNER JOIN trip on trip.id = flight_info.trip_id WHERE flight.departure_ID = ? and trip.id = ? LIMIT 1) AS exists";
    $flag = true;
    array_shift($_POST["flights"]);
    if(count($_POST["flights"]) > 1){
        $_SESSION["multiple"] = true;
        $_SESSION["flights_list"] = $_POST["flights"];
        $i = 0;
        foreach($_POST["flights"] as $flight_data){
            $flight = explode('-', $flight_data); 
            if($flight && !create_or_update_flight_info($flight, $i)){
                $flag = false;
            }
            $i++;
        }
        
    }else{
        $_SESSION["multiple"] = false;
        $flight = explode('-', $_POST["flights"][0]); 
        $flag = create_or_update_flight_info($flight, 0);
    }
        
    /*$i = 0;
    $flag = true;
    foreach($_POST["flights"] as $flight_data){
        $flight = explode('-', $flight_data); 
        if($flight && !create_or_update_flight_info($flight, $i)){
            $flag = false;
        }
        $i++;
    }*/
    return $flag;
}





/* This function selects appropriate flight_info row and then updates it's order or calls create function */ 
function create_or_update_flight_info($flight, $i){
    require "database/dbinfo.php";
    global $connection;
    $sql = "SELECT fi.$db_flight_info_id AS 'id' FROM $db_flight_info_tab fi INNER JOIN $db_airports_tab aa ON fi.$db_flight_info_arrivalid = aa.$db_airports_id INNER JOIN $db_airports_tab ad ON fi.$db_flight_info_departureid = ad.$db_airports_id  WHERE ad.$db_airports_IATA  = ? AND aa.$db_airports_IATA  = ? AND fi.$db_flight_info_tripid = ? LIMIT 1  ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssi", $flight[0], $flight[1], $_SESSION["trip_id"]);
    $stmt->execute();
    $dataSet = $stmt->get_result();
    if ($dataSet->num_rows > 0){
        $data = $dataSet->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        $flight_info_object = new Flight_info($data["id"]);
        $flight_info_object->update($db_flight_info_order, $i);
    }else{
        $stmt->close();
        insert_flight_info($flight, $i);
    }
   

    return true;
    
}
/* This function creates new flight_info row and links it with airports from airports table */
function insert_flight_info($flight, $order){
    require "database/dbinfo.php";
    global $connection;
    $airports_ids = [];
    for($i = 0; $i < 2; $i++){
        $sql = "SELECT $db_airports_id AS 'id' FROM $db_airports_tab WHERE $db_airports_IATA = ? ";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $flight[$i]); //flight[$i] contains something like "KTW"
        $stmt->execute();
        $dataSet = $stmt->get_result();
        if ($dataSet->num_rows < 1){
            $stmt->close();
            return false;
        }   
        
        $data = $dataSet->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        $airports_ids[$i] = $data['id']; 
    }
    
    $flight_info_object = new Flight_info();
    $flight_info_object->update($db_flight_info_tripid, $_SESSION['trip_id']);
    $flight_info_object->update($db_flight_info_departureid, $airports_ids[0]);
    $flight_info_object->update($db_flight_info_arrivalid, $airports_ids[1]);
    $flight_info_object->update($db_flight_info_order, $order);
    
 
}
/* This function selects and updates appropriate application and creates flight - if we have an application then we got a bunch of info about flight, such as date and flight number, so we can create it and link this flight to application. We cannot update the flight, as it is shared by many */
function create_or_update_application(){
    
    if(!empty($_SESSION["multiple"]) && !$_SESSION["multiple"] && !Validate::one_flight()){

        echo "false";
        return false;
    }
    if($_SESSION["multiple"]){
        $from = explode('-', $_SESSION["flights_list"][0]);
        $to = explode('-', end($_SESSION["flights_list"]));
        reset($_SESSION["flights_list"]);
        $problem = $_POST["departure-code"];
        $airline = $_POST["airline-code"];
        
        if(!Validate::many_flights($from[0], $to[1], $problem, $airline)){
            echo "false";
            return false;  
        }
    }
    
    //$_POST["date"] = date('Y-m-d', strtotime($_POST["date"]));
    
    require "database/dbinfo.php";
    global $connection;
    $sql = "SELECT fi.$db_flight_info_id AS 'fi_id', fi.$db_flight_info_applicationid AS 'ap_id' FROM $db_flight_info_tab fi INNER JOIN $db_trip_tab t on t.$db_trip_id = fi.$db_flight_info_tripid  INNER JOIN $db_airports_tab aa ON fi.$db_flight_info_arrivalid = aa.$db_airports_id INNER JOIN $db_airports_tab ad ON fi.$db_flight_info_departureid = ad.$db_airports_id  WHERE ad.$db_airports_IATA  = ? AND aa.$db_airports_IATA  = ? AND t.$db_trip_id = ? LIMIT 1";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssi", $_POST["departure-code"], $_POST["destination-code"], $_SESSION["trip_id"]);
    $stmt->execute();
    $dataSet = $stmt->get_result();
    if ($dataSet->num_rows < 1){
       // echo("Lessthanone");
        $stmt->close();
        return false;
    }
    //$dataSet = $stmt->get_result();
    $data = $dataSet->fetch_array(MYSQLI_ASSOC);
    $stmt->close();
    $flight_info_id = $data["fi_id"];
    $application_id = $data["ap_id"];
    if(isset($application_id)){
        update_application($application_id);
    }else{
        $application_id = insert_application($flight_info_id);
    }

    create_flight($flight_info_id);
    fill_compensation($application_id, $flight_info_id);
    return true;
    }

    function fill_compensation($application_id, $flight_info_id){
        require "database/dbinfo.php";
        
        $application_object = new Application($application_id);
        $flight_info_object = new Flight_info($flight_info_id);
        $amount = intval(Money::compensation($flight_info_object->flight_id, $flight_info_object->departure_id, $flight_info_object->arrival_id, $application_object->id)); 
        
        $application_object->update($db_application_compensation, $amount);

    }


    function update_application($application_id){
        $application_object = new Application($application_id);
        $application_object->update_assoc($_POST);

    }

    function insert_application($flight_info_id){
        require "database/dbinfo.php";
        $application_object = new Application();
        $application_object->update_assoc($_POST);

        $flight_info_object = new Flight_info($flight_info_id);
        $flight_info_object->update($db_flight_info_applicationid, $application_object->id);
        return $application_object->id;
    }
    /* WORK TO BE DONE HERE */
    function create_flight($flight_info_id){
        $flight_info_object = new Flight_info($flight_info_id); //select our flight_info
        
        if($flight_info_object->flight_id){ //if it has flight linked then 
            if(look_for_changes($flight_info_object->flight_id)){ //check if flight information has changed  
                link_or_insert_flight($flight_info_id); //if so, search for flight or create a new flight and link if with our flight_info
            }

        }else{
            link_or_insert_flight($flight_info_id);// if it doesn't have flight linked, create flight and link it. Simple, isn't it?
        }

        
    
   
}

function link_or_insert_flight($flight_info_id){
    require "database/dbinfo.php";
    global $connection;
    $flight_info_object = new Flight_info($flight_info_id);
    
    
    $sql = "SELECT a.$db_airlines_id AS 'id' FROM $db_airlines_tab a WHERE a.$db_airlines_IATA = ? LIMIT 1";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $_POST["airline-code"]);
    $stmt->execute();
    $dataSet = $stmt->get_result();
    if ($dataSet->num_rows < 1){
        $stmt->close();
        return false;
    }
    //$dataSet = $stmt->get_result();
    $data = $dataSet->fetch_array(MYSQLI_ASSOC);
    $stmt->close();
    
    $flight_id = Flight::find($_POST['fnumber'], $data['id'], $_POST['date']);
    if($flight_id){
        $flight_info_object->update($db_flight_info_flightid, $flight_id);
    }else{
        insert_flight($flight_info_id, $data['id']);
    }
    
    
}
function insert_flight($flight_info_id, $airline_id){
    require "database/dbinfo.php";
    
    $flight_info_object = new Flight_info($flight_info_id);

    $flight_object = new Flight();
    $flight_object->update($db_flight_airlineid, $airline_id);  //link airlines
    $flight_object->update($db_flight_number, $_POST['fnumber']); // this should set flight number and date, bo we still need more info
    $flight_object->update($db_flight_date, $_POST["date"]);
    $flight_object->update($db_flight_departureid, $flight_info_object->departure_id); // link airports
    $flight_object->update($db_flight_arrivalid, $flight_info_object->arrival_id); // link airports
    
    $departure_airport_object = new Airport($flight_info_object->departure_id);
    $destination_airport_object = new Airport($flight_info_object->arrival_id);
    
    $distance = GreatCircle::distance($departure_airport_object->lat, $departure_airport_object->long, $destination_airport_object->lat, $destination_airport_object->long);
    $distance = intval($distance);
    $flight_object->update($db_flight_distance, $distance); //calculate distance
    
    //$availability = check_compensation_availability($departure_airport_object, $destination_airport_object, $distance);
   // $flight_object->update($db_flight_compensation, ($availability ? 1 : 0)); //check if it is available for compensation 


    $flight_info_object->update($db_flight_info_flightid, $flight_object->id);
}


function check_compensation_availability($departure_obj, $destination_obj, $distance){


}

function look_for_changes($flight_id){
    $flight_object = new Flight($flight_id);
    if ($_POST['fnumber'] != $flight_object->flight_number || $_POST['date'] != $flight_object->flight_date){
        return true;
    } 
    return false;
}
?>
