<?php
session_start();

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$address = $_POST['address'];
$code = $_POST['code'];        
$city = $_POST['city'];
$country = $_POST['country'];
$val=  $_POST['val'];

echo $val; 
require_once "database/dbinfo.php";
require_once "database/connect.php";
    

$connection = db_connection();

if ($val=='1'){
    $sql = "UPDATE $db_passengers_tab SET $db_passengers_firstname= '$fname', $db_passengers_lastname='$lname',  $db_passengers_address='$address',  $db_passengers_zipcode='$code',
        $db_passengers_city ='$city', $db_passengers_country='$country' WHERE $db_passengers_id=".$_SESSION['id'];
     $connection->query($sql);

}else{
    
    $sql= "INSERT INTO $db_passengers_tab ($db_passengers_firstname,$db_passengers_lastname, $db_passengers_address, $db_passengers_zipcode, $db_passengers_city, $db_passengers_country )
           VALUES ('$fname','$lname','$address', '$code', '$city','$country' )";
  
    $connection->query($sql);
    $id = $connection->insert_id; 
    
    $trip=$_SESSION['trip'];
    $sql= "INSERT INTO  $db_connect_tab ($db_connect_passenger_id, $db_connect_trip_id) VAlUES ($id,$trip )";
    $connection->query($sql);
    $sessionid= 'id'.$val;
    $_SESSION["$sessionid"] = $connection->insert_id;  
}
                     
    
            












