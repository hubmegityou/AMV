<?php

session_start();

require_once "database/dbinfo.php";
require_once "database/connect.php";
$connection = db_connection();



//////////////////////////////////////////////////////////////////////////////////////////////////////////


$sql="Select $db_flight_distance from  $db_flight_tab where $db_flight_id=".$_SESSION['flightid'];
$result=$connection->query($sql);
$row = $result->fetch_assoc();
$distance = $row[$db_flight_distance];

$sql= "SELECT $db_airports_region from $db_airports_tab WHERE $db_airports_id=".$_SESSION['departure'];
$result = $connection->query($sql);
$row = $result->fetch_assoc();
$dep = $row[$db_airports_region];

$sql= "SELECT $db_airports_region from $db_airports_tab WHERE $db_airports_id=".$_SESSION['arrival'];
$result = $connection->query($sql);
$row = $result->fetch_assoc();
$arr=$row[$db_airports_region];

If ($distance<=1500){
    $x=1;
} elseif ( $distance >1500 && $dep='EUR' && $arr= 'EUR'|| $distance <3500 ){
    $x=2;
}else {
    $x=3;
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql= "SELECT $db_application_delay, $db_application_incident  from $db_application_tab WHERE $db_application_id=".$_SESSION['application'];
$result=$connection->query($sql);
$row = $result->fetch_assoc();
$delay=$row[$db_application_delay];
$row= $row[$db_application_incident];




//odszkodowanko
//x= >1500
If ($x==1){
    //y= opóxnienie poniżej 2h - 1 opcja z opóźnien w locie odwołanym
  If($delay==1 &&  $incident==2){
      $sub=125;
  }  else{
      $sub=250;
  }
    
}elseif ($x==2){
    //y= opóźnienie ponżej 3h czyli poniżej opcji 3 w locie opóźnionym
    if ($db_application_delay<3 && $db_application_incident==1){
        $sub=200;
    }else{
        $sub=400;
    }
} elseif ($x==3){
    //y- opóźnienie poniżej 4h czyli poniżej opcji 4 w locie odwołanym
    //z- opóźniony lot opcja 3 - w locie opóźnionym
    If($delay==3 && $incident==1 ||$delay<4 && $incident==2 ){
        $sub=300;
    }else{
        $sub=600;
    }
}
echo $sub;