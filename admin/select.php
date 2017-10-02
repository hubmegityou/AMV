<?php

  require_once "../database/dbinfo.php";
  require_once "../database/connect.php";
    
    $connection = db_connection();
    if ($connection != false){
        $text = $_POST['text'];
        $sql = "UPDATE $db_trip_tab SET $db_trip_status='$text' WHERE $db_trip_id =".$_POST['id'];
        $connection->query($sql);}
        
        echo $sql;