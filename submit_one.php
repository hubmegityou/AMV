<?php

session_start();

$val = $_POST['val'];


require_once "database/dbinfo.php";
require_once "database/connect.php";
$connection = db_connection();

$sql = "UPDATE  $db_application_tab SET $db_application_incident = '$val' WHERE $db_application_id=".$_SESSION['application'];
$connection->query($sql);
//INSERT INTO table (id, name, age) VALUES(1, "A", 19) ON DUPLICATE KEY UPDATE name="A", age=19