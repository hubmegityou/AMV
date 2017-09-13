<?php

session_start();


require_once "database/dbinfo.php";
require_once "database/connect.php";
$connection = db_connection();

$num=$_POST['num'];

$sql = "UPDATE $db_compensation_tab SET $db_compensation_type ='$num' WHERE $db_compensation_id=".$_SESSION['compensation'];
$connection->query($sql);
