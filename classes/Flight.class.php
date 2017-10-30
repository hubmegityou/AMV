<?php
    require_once "Table.class.php";
//$this->column_aliases['departure-code'] = $db_flight_info_departureid
    class Flight extends Table {
        public $departure_id;
        public $arrival_id;
        public $flight_number;
        public $flight_date;
        public $airline_id;
        public $distance;
        public $compensation_availability;
        
        function __construct($id = null){
            require __DIR__."/../database/dbinfo.php";
            
            $this->table_name = $db_flight_tab;
            $this->table_id = $db_flight_id;
            
            parent::__construct($id);
            
            $this->departure_id = $this->data[$db_flight_departureid];
            $this->arrival_id = $this->data[$db_flight_arrivalid];
            $this->flight_number = $this->data[$db_flight_number];
            $this->flight_date = $this->data[$db_flight_date];
            $this->airline_id = $this->data[$db_flight_airlineid];
            $this->distance = $this->data[$db_flight_distance];
            $this->compensation_availability = $this->data[$db_flight_compensation];
            
            $this->data = "";
            
        }
        public static function find($flight_number, $airline_id, $date){
            require __DIR__."/../database/dbinfo.php";
            //require "database/connect.php";
            global $connection;

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
            return $data['id'];
        }

    }
 
?>