<?php
    require_once "Table.class.php";
    
    class Airport extends Table {
        public $lat;
        public $long;
        public $region;
        function __construct($id = null){
            require "database/dbinfo.php";
            $this->table_name = $db_airports_tab;
            $this->table_id = $db_airports_id;
            
            parent::__construct($id);
            
            $this->lat = $this->data[$db_airports_latitude];
            $this->long = $this->data[$db_airports_longitude];
            $this->region = $this->data[$db_airports_region];

            $this->data = "";
            
        }

    }
 
?>