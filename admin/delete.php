<?php

  require_once "../database/dbinfo.php";
  require_once "../database/connect.php";
    
    $connection = db_connection();
    if ($connection != false){
        $id = $_POST['val'];
        $sql = "DELETE FROM $db_users_tab WHERE $db_users_id= $id";
        $connection->query($sql);}