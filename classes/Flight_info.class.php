<?php
    require_once "Table.class.php";

    class Flight_info extends Table {
        public $trip_id;
        public $application_id;
        public $flight_id;
        public $departure_id;
        public $arrival_id;
        
        function __construct($id = null){
            require __DIR__."/../database/dbinfo.php";
            $this->table_name = $db_flight_info_tab;
            $this->table_id = $db_flight_info_id;
            parent::__construct($id);
            
            $this->trip_id = $this->data[$db_flight_info_tripid];
            $this->application_id = $this->data[$db_flight_info_applicationid];
            $this->flight_id = $this->data[$db_flight_info_flightid];
            $this->departure_id = $this->data[$db_flight_info_departureid];
            $this->arrival_id = $this->data[$db_flight_info_arrivalid];
            
            $this->data = "";
            
        }

    }
?>