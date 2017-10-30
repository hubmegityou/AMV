<?php
    require_once "Table.class.php";
    
    class Trip extends Table {
        public $final_delay;
        function __construct($id = null){
            require __DIR__."/../database/dbinfo.php";
            $this->table_name = $db_trip_tab;
            $this->table_id = $db_trip_id;
            
            parent::__construct($id);
            
            $this->final_delay = $this->data[$db_trip_delay];
            $this->data = "";
            
        }

    }
 
?>