<?php

session_start();

If (!isset($_SESSION['id'])){
   header('Location: login.html');  
}
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
					<h3 class="page-header"><i class="fa fa-laptop"></i>Zgłoszenia</h3>
					
                                   
         <div style='margin-left:70%' > wyszukaj <input id='search' type='text'> </div>                                    
                                        
    <table class="responstable" id='table'>
        <thead>                          
            <tr>
                <th>Data lotu</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Status</th>
            </tr>
        </thead>
   <tbody>
              
       <?php  
  
    require_once "database/dbinfo.php";
    require_once "database/connect.php";
    
    $connection = db_connection();  
    $id=$_GET['id'];
    
    
    $sql_trip= "SELECT $db_trip_id, $db_trip_first_flight_info_id , $db_trip_status FROM $db_trip_tab WHERE $db_trip_campaign= $id";
    $result_trip = $connection->query($sql_trip);
    while ($row_trip = $result_trip->fetch_assoc()){
        $sql_connect="SELECT $db_connect_passenger_id FROM $db_connect_tab WHERE $db_connect_trip_id= $row_trip[$db_trip_id]";
        $result_connect = $connection->query($sql_connect);

        while ($row_connect = $result_connect->fetch_assoc()){
            $sql_passengers="SELECT $db_passengers_firstname, $db_passengers_lastname FROM $db_passengers_tab WHERE $db_passengers_email IS NOT NULL && $db_passengers_id= $row_connect[$db_connect_passenger_id]";
            $result_passengers = $connection->query($sql_passengers);
            $row_passengers = $result_passengers->fetch_assoc();
            
            $fname= $row_passengers[$db_passengers_firstname];
            $lname= $row_passengers[$db_passengers_lastname];  
        }
       
        $sql_flightinfo= "SELECT $db_flight_info_flightid FROM $db_flight_info_tab WHERE $db_flight_info_id=$row_trip[$db_trip_first_flight_info_id]";
        $result_flightinfo = $connection->query($sql_flightinfo);
        $row_flightinfo = $result_flightinfo->fetch_assoc();

        $sql_flight= "SELECT $db_flight_date FROM $db_flight_tab WHERE $db_flight_id= $row_flightinfo[$db_flight_info_flightid]";
        $result_flight = $connection->query($sql_flight);
        $row_flight = $result_flight->fetch_assoc();
            
        $date= $row_flight[$db_flight_date];
        

        echo '<tr onMouseover=this.bgColor="#D9E4E6" onMouseout=this.bgColor="white"'." onclick='tr2($row_trip[$db_trip_id])'>";
        echo "<td>$date </td>     
        <td>$fname </td>
        <td>$lname</td>
        <td>$row_trip[$db_trip_status]</td>    
        </tr>";   
       
    }         
  ?>                        
                             
 </tbody> 
</table>                                              
                                        
                                
                                        
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
