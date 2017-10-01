<?php
    require_once "database/dbinfo.php";
    require_once "database/connect.php";
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
            $this->table_name = $db_flight_tab;
            $this->table_id = $db_flight_id;
            
            parent::__construct($id);
            
            $this->$departure_id = $this->data[$db_flight_departureid];
            $this->$arrival_id = $this->data[$db_flight_arrivalid];
            $this->$flight_number = $this->data[$db_flight_number];
            $this->$flight_date = $this->data[$db_flight_date];
            $this->$airline_id = $this->data[$db_flight_airlineid];
            $this->$distance = $this->data[$db_flight_distance];
            $this->$compensation_availability = $this->data[$db_flight_compensation];
            
            $this->data = "";
            
        }

    }
 
?>