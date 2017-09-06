<?php

$email = $_POST['email'];
$tel = $_POST['tel'];
$fname = $_POST['first_name'];
$lname = $_POST['last_name'];

require_once "database/dbinfo.php";
require_once "database/connect.php";
    

$connection = db_connection();
$sql = "INSERT INTO $db_passengers_tab($db_passengers_firstname, $db_passengers_lastname, $db_passengers_telnumber, $db_passengers_email)
VALUES ('$fname', '$lname', '$tel', '$email')";
$connection->query($sql);

session_start();
$_SESSION['id'] = $connection->insert_id;

header('Location: compensation_form.html');