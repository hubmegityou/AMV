<?php
//session_start();


class Validate{

    public static function one_flight(){
        $dep_reg = Validate::get_airport_region($_POST["departure-code"]);
        $dest_reg = Validate::get_airport_region($_POST["destination-code"]);
        if($dep_reg != "EUR" && $dest_reg != "EUR"){
            echo "false";
            return false;
        }
        $airline_region = Validate::get_airline_region($_POST["airline-code"]);
        if($dep_reg != "EUR" && $dest_region == "EUR" && $airline_region != "EUR"){
            echo "false";
            return false;
        }
        return Validate::second_validation();
    }

    public static function many_flights($from, $to, $problem_location, $airline){
        $dep_reg = Validate::get_airport_region($from);
        $dest_reg = Validate::get_airport_region($to);
        $problem_reg = Validate::get_airport_region($problem_location);
        $airline_region = Validate::get_airline_region($airline);
        if($dep_reg != "EUR" && $problem_reg != "EUR" && $airline_region != "EUR"){
            echo "false";
            return false;
        }
        return Validate::second_validation();
    }


    public static function second_validation(){
        
        if(!isset($_POST["overbooked"]) && isset($_POST["delayreason"]) && ($_POST["delayreason"] == "weather" || $_POST["delayreason"] == "strike")){
            echo "false";
            return false;
        }
        if(isset($_POST["overbooked"]) && isset($_POST["yes"]) && $_POST["overbookingresignation"] == "yes"){
            echo "false";
            return false;
        }
        if(isset($_POST["cancelled"]) && isset($_POST["cancellationtime"]) && $_POST["cancellationtime"] == "mt14"){
            echo "false";
            return false;
        }
        if(!isset($_POST["airline-code"]) || !isset($_POST["date"]) || !isset($_POST["fnumber"])){
            echo "false";
            return false;
        }
        echo "true";
        return true;
    }

    
    public static function get_airport_region($code){
        require "database/dbinfo.php";
        global $connection;

        $sql = "SELECT $db_airports_region AS 'region' FROM $db_airports_tab WHERE $db_airports_IATA LIKE ? LIMIT 1 ";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $dataSet = $stmt->get_result();
        if ($dataSet->num_rows < 1){
            $stmt->close();
            return false;
        }
        $data = $dataSet->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        return $data['region'];
    }

    public static function get_airline_region($code){
        require "database/dbinfo.php";
        global $connection;

        $sql = "SELECT $db_airlines_region AS 'region' FROM $db_airlines_tab WHERE $db_airlines_IATA LIKE ? LIMIT 1 ";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $dataSet = $stmt->get_result();
        if ($dataSet->num_rows < 1){
            $stmt->close();
            return false;
        }
        $data = $dataSet->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        return $data['region'];
    }
}

?>