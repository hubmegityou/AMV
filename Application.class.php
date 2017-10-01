<?php
    require_once "database/dbinfo.php";
    require_once "database/connect.php";
    require_once "Table.class.php";
    
    class Application extends Table {

        function __construct($id = null){
            $this->table_name = $db_application_tab;
            $this->table_id = $db_application_id;
            
            parent::__construct($id);
            
            $this->data = "";
            
        }

    }
 
?>