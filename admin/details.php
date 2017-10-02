<?php

session_start();

If (!isset($_SESSION['id'])){
   header('Location: login.html');  
}

$id=$_GET['id'];
?>



<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Admin</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />    
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="table/css/style.css">

  </head>

  <body>

  <section id="container" class="">
     
      <?php  require_once('header.php');?>           

      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <ul class="sidebar-menu">                
                  <li >
                      <a class="" href="index.php">
                          <i class="icon_house_alt"></i>
                          <span>Strona główna</span>
                      </a>
                  </li>
				 
                  
                  <?php
                If ($_SESSION['function']==1){
                
                    echo '<li >
                        <a href="usermanagement.php">
                        <span>Zarządzaj użytkownikami</span>
                        </a></li>';
                } else{
                    
                   echo ' <li class="active">
                      <a class="" href="flights.php">
                          <span>Zgłoszenia</span>
                      </a>
                  </li>';  
                }  ?>
                  
                  
              </ul>
          </div>
      </aside>

      <section id="main-content">
          <section class="wrapper">            

			  <div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="fa fa-laptop"></i>szczegóły zgłoszenia</h3>
					


STATUS: 

 <select id='select'>
  <option value="<?php echo $id?>"> przyznano odszkodowanie</option>
  <option value="<?php echo $id?>"> nie przyznano odszkodowania</option>
  <option value="<?php echo $id?>"> w trakcie</option>
</select>   
  <br>
  <br>
  <br>
  <br>
  

<?php

require_once "../database/dbinfo.php";
require_once "../database/connect.php";

$connection = db_connection();  


$sql_connect="SELECT $db_connect_passenger_id,  $db_connect_boarding, $db_connect_reservation FROM $db_connect_tab WHERE $db_connect_trip_id=$id ";
$result_connect = $connection->query($sql_connect);
echo "DANE PASAŻERÓW: ";


?>
  
 <table class="responstable" id='table'>
        <thead>                          
            <tr>
                <th>imię</th>
                <th>nazwisko</th>
                <th>adres</th>
                <th>kod pocztowy</th>
                <th>miasto</th>
                <th>kraj</th>
                <th>email</th>
                <th>numer telefonu</th>
                <th>paszport</th>
                <th>przód dowodu</th>
                <th>tył dowodu</th>
            </tr>
        </thead>
        <tbody>
            
</tbody>

<?php


$i=1;
while ($row_connect = $result_connect->fetch_assoc()){
$boarding=$row_connect[$db_connect_boarding];  
$reservation=$row_connect[$db_connect_reservation];
   


$sql_passengers= "SELECT * FROM $db_passengers_tab WHERE $db_passengers_id =".$row_connect[$db_connect_passenger_id];
$result_passengers = $connection->query($sql_passengers);
while ($row_passengers = $result_passengers->fetch_assoc()){
    
    
        echo "<tr>
        <td>$row_passengers[$db_passengers_firstname] </td>     
        <td>$row_passengers[$db_passengers_lastname] </td>
        <td>$row_passengers[$db_passengers_address]</td>
        <td>$row_passengers[$db_passengers_zipcode]</td> 
        <td>$row_passengers[$db_passengers_city] </td>     
        <td>$row_passengers[$db_passengers_country] </td>
        <td>$row_passengers[$db_passengers_email] <br>";
         
          if ($row_passengers[$db_passengers_email]){   
            echo "<a href=''>  wyslij ponownie e-mail z linkiem do formularza</a> ";}
      
        echo " </td> 
        <td>$row_passengers[$db_passengers_telnumber]</td> 
        <td><a href='download.php?name='$row_passengers[$db_passengers_passport]'> pobierz</a> </td>     
        <td><a href='download.php?name='$row_passengers[$db_passengers_idcard1]'> pobierz</a> </td>
        <td><a href='download.php?name='$row_passengers[$db_passengers_idcard2]'> pobierz</a></td>
        </tr>";  
        
 
  $i++;

}}
  ?>
       </tbody> 
    </table>  
       
    <?php
echo "<br>"; 

 
$sql_trip="SELECT $db_trip_first_flight_info_id, $db_trip_delay, $db_trip_sum FROM $db_trip_tab WHERE $db_trip_id=$id ";
$result_trip = $connection->query($sql_trip);
$row_trip = $result_trip->fetch_assoc();
$flightid = $row_trip[$db_trip_first_flight_info_id];

echo "<br><br>INFORMACJE O LOCIE: <br><br>";

 ?> 
 <table class="responstable" id='table'>
        <thead>                          
            <tr>
                <th>opóźnienie w porcie docelowym</th>
                <th>wartość odszkdowania</th>
                <th>rezerwacja</th>
                <th>karta pokładowa</th>
                
            </tr>
        </thead>
        <tbody>
            
</tbody>


 <?php
 echo "<tr>
         <td>$row_trip[$db_trip_delay] </td>     
        <td>$row_trip[$db_trip_sum] zł </td>
        <td><a href='download.php?name='$reservation'> pobierz</a></td>
        <td><a href='download.php?name='$boarding '> pobierz</a></td> 
        </tr><tbody><table>"; 

echo "<br><br>";
echo "PRZEBIEG TRASY:";



?>
    <table class="responstable" id='table'>
        <thead>                          
            <tr>
                <th>numer lotu</th>
                <th>data lotu</th>
                <th>odległość</th>
                <th>wylot</th>
                <th>przylot</th>
                <th>linie lotnicze</th>
                <th>co sie stało z lotem</th>
            </tr>
        </thead>
   <tbody>
    
    
    
    <?php



// do {
    
    // $sql_flightinfo="SELECT $db_flight_info_flightid, $db_flight_info_applicationid, $db_flight_info_nextflight FROM $db_flight_info_tab WHERE $db_flight_info_id=$flightid ";
    // $result_flightinfo = $connection->query($sql_flightinfo);
    // $row_flightinfo = $result_flightinfo->fetch_assoc();
    
    
   
    // $sql_flight= "SELECT * FROM $db_flight_tab WHERE $db_flight_id=".$row_flightinfo[$db_flight_info_flightid];
    // $result_flight = $connection->query($sql_flight);
    // ($row_flight = $result_flight->fetch_assoc());  
 
    
    // $sql_departure= "SELECT * FROM $db_airports_tab WHERE $db_airports_id=".$row_flight[$db_flight_departureid] ;
    // $result_departure = $connection->query($sql_departure);
    // $row_departure = $result_departure->fetch_assoc();
    
    // $sql_arrival= "SELECT * FROM $db_airports_tab WHERE $db_airports_id=".$row_flight[$db_flight_arrivalid];
    // $result_arrival = $connection->query($sql_arrival);
    // $row_arrival = $result_arrival->fetch_assoc();
    
    
    // $sql_airlines= "SELECT * FROM $db_airlines_tab WHERE $db_airlines_id=".$row_flight[$db_flight_airlineid];
    // $result_airlines = $connection->query($sql_airlines);
    // $row_airlines = $result_airlines->fetch_assoc();
    
    // $sql_application="SELECT * FROM $db_application_tab WHERE $db_application_id=".$row_flightinfo[$db_flight_info_applicationid];
    // $result_application = $connection->query($sql_application);
    // $row_application = $result_application->fetch_assoc();
    
    
    
     // echo "<tr>
        // <td>$row_flight[$db_flight_number]</td>     
        // <td>$row_flight[$db_flight_date] </td>
        // <td>$row_flight[$db_flight_distance] km</td>
        // <td>nazwa: $row_departure[$db_airports_name] <br>miasto: $row_departure[$db_airports_city]<br>kraj: $row_departure[$db_airports_country] <br>kod IATA: $row_departure[$db_airports_IATA] <br>kod ICAO: $row_departure[$db_airports_ICAO] <br>region: $row_departure[$db_airports_region]</td> 
        // <td>nazwa: $row_arrival[$db_airports_name] <br>miasto: $row_arrival[$db_airports_city]<br>kraj: $row_arrival[$db_airports_country] <br>kod IATA: $row_arrival[$db_airports_IATA] <br>kod ICAO: $row_arrival[$db_airports_ICAO] <br>region: $row_arrival[$db_airports_region]</td> 
        // <td>nazwa: $row_airlines[$db_airlines_operator] <br> kraj: $row_airlines[$db_airlines_name] <br>kod IATA: $row_airlines[$db_airlines_IATA] <br>region: $row_airlines[$db_airlines_region]</td>";  

      ?>
   <td> <?php 
   
   // $incident = $row_application[$db_application_incident];
   // $cause = $row_application[$db_application_cause];
   // $delay = $row_application[$db_application_delay];
   // $cancel = $row_application[$db_application_cancel];
   // $resignation = $row_application[$db_application_resignation];
   // require_once('aliasesForFlight.php');
   
   
   // if($incident){
	   // echo 'przyczyna: '. $incident.'<br>';
   // }
   
    // if($cause){
	   // echo 'powód: '. $cause.'<br>';
   // }
   
     // if($delay){
	   // echo 'opóźnienie: '. $delay.'<br>';
   // }
   
     // if($cancel){
	   // echo 'podanie informacji o odwołaniu lotu: '. $cancel.'<br>';
   // }
   
    // if($resignation){
	   // echo 'rezygnacja z lotu: '. $resignation.'<br>';
   // }

   ?>  </td>
       </tr>    
    <?php

    // $flightid = $row_flightinfo[$db_flight_info_nextflight];
    
// }while( $row_flightinfo[$db_flight_info_nextflight]);

?>   
</tbody> 
    </table>

<?php
 echo "<br><br>";
echo "DANE DO PRZELEWU<br><br>";


// $sql_compensation="SELECT * FROM $db_compensation_tab WHERE $db_compensation_id= $row_application[$db_application_compensationid]";
// $result_compensation= $connection->query($sql_compensation);
// $row_compensation = $result_compensation->fetch_assoc();

// $type= $row_compensation[$db_compensation_type];
// $payment=$row_compensation[$db_compensation_payment];

// require_once('aliasesForPayment.php');


 ?> 
 <table class="responstable" id='table'>
        <thead>                          
            <tr>
                <th>typ</th>
                <th>sposob wypłaty</th>
                <th>waluta</th>
                <th>nr konta/paypal</th>
                
            </tr>
        </thead>
        <tbody>
            
</tbody>


 <?php
 echo "<tr>
         <td>$type</td>     
        <td>$payment </td>
        <td>$row_compensation[$db_compensation_currency]</td>
        <td>$row_compensation[$db_compensation_account]</td> 
        </tr><tbody><table>"; 

echo "<br><br>";
?>

    <br>
    <br>
                                             
                                        
				</div>
			</div>
          </section>
         
      </section>

  </section>
	<script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>

  </body>
</html>
