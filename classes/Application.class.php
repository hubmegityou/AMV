<?php
    require_once "Table.class.php";
    
    class Application extends Table {

        function __construct($id = null){
            require __DIR__."/../database/dbinfo.php";
            $this->table_name = $db_application_tab;
            $this->table_id = $db_application_id;
            
            parent::__construct($id);
            
            $this->data = "";
            
        }

    }
 
?>