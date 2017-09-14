<?php
function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}

session_start();

$email = $_POST['email'];
$tel = $_POST['tel'];
$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
//check if variables not null 
//turn this on later 
/*
if(!isset($email) || !isset($tel) || !isset($first_name) || !isset($last_name)){
    header('Location: DataForm.html'); //add error code and render it on page 
    exit;
}*/
require_once "database/dbinfo.php";
require_once "database/connect.php";

$connection = db_connection();
$connection->query(sprintf("INSERT INTO $db_passengers_tab($db_passengers_firstname, $db_passengers_lastname, $db_passengers_telnumber, $db_passengers_email)
VALUES ('%s','%s','%s','%s')", 
mysqli_real_escape_string($connection, $fname), 
mysqli_real_escape_string($connection, $lname), 
mysqli_real_escape_string($connection, $tel), 
mysqli_real_escape_string($connection, $email)));

$passenger_id = $connection->insert_id; //passenger id
$_SESSION['passenger_id']=$passenger_id;

//checking the uniqueness of generated code
do{
    $token = random_str(25);
    $sql = "SELECT $db_trip_id FROM $db_trip_tab WHERE $db_trip_string_id='$token'";
    $result = $connection->query($sql);
}while ($row = $result->fetch_assoc());

$sql = "INSERT INTO $db_trip_tab ($db_trip_id, $db_trip_string_id) VALUES ( NULL, '$token')";
$connection->query($sql);
$trip_id = $connection->insert_id;
$_SESSION['trip_id'] = $trip_id;
$sql = "INSERT INTO $db_connect_tab ($db_connect_id, $db_connect_passenger_id, $db_connect_trip_id) VALUES (NULL, '$passenger_id', '$trip_id')";
$connection->query($sql);

mail(
    "$email", 
    "AMV - zgłoszenie odszkodowania", 
    "Twój link: localhost/AMV/flight_form.html?$token");

//header('Location: flight_form.html');
exit;
?>