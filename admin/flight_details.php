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
					echo ' <li>
                      <a class="" href="import.php">
                          <span>Importuj pliki</span>
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
  
    require_once "../database/dbinfo.php";
    require_once "../database/connect.php";
    
    $connection = db_connection();
    $arrid = $_GET['arrid'];
    $depid = $_GET['depid'];
	$fname='';
	$lname='';
	$campaign= $_GET['campaign'];
	if ($campaign=='undefined'){
		$campaign='';
	}
	
	
    
    $sql_trip= "SELECT $db_flight_info_flightid, $db_flight_info_tripid FROM $db_flight_info_tab WHERE $db_flight_info_departureid = $depid";
    $result_trip = $connection->query($sql_trip);
    while ($row_trip = $result_trip->fetch_assoc()){
		$sql_tripcheck=" SELECT $db_trip_campaign FROM $db_trip_tab  WHERE $db_trip_id=$row_trip[$db_flight_info_tripid]";
		$result_tripcheck = $connection->query($sql_tripcheck);
		$row_tripcheck = $result_tripcheck->fetch_assoc();
		if ($campaign==$row_tripcheck[$db_trip_campaign]){
		
		
        //sprawdzamy, czy zgodne miejsce przylotu
        $sql_arrival_check = "SELECT $db_flight_info_arrivalid FROM $db_flight_info_tab WHERE $db_flight_info_tripid = $row_trip[$db_flight_info_tripid] ORDER BY `$db_flight_info_tab`.`$db_flight_info_order` DESC LIMIT 1";
		$result_arrival_check = $connection->query($sql_arrival_check);
		$row_arrival_check = $result_arrival_check->fetch_assoc();
        if($row_arrival_check[$db_flight_info_arrivalid] == $arrid){ 
            $tripid = $row_trip[$db_flight_info_tripid];
            $sql_person = "SELECT $db_connect_passenger_id FROM $db_connect_tab WHERE $db_connect_trip_id = $tripid";
            $result_person = $connection->query($sql_person);
            while ($row_person = $result_person->fetch_assoc()){
                $sql_passengers="SELECT $db_passengers_firstname, $db_passengers_lastname FROM $db_passengers_tab WHERE $db_passengers_email IS NOT NULL && $db_passengers_id= $row_person[$db_connect_passenger_id]";
				$result_passengers = $connection->query($sql_passengers);
                if ($row_passengers = $result_passengers->fetch_assoc()){
                    $fname= $row_passengers[$db_passengers_firstname];
                    $lname= $row_passengers[$db_passengers_lastname];
                }
            }
            $sql_date = "SELECT $db_flight_date FROM $db_flight_tab WHERE $db_flight_id = $row_trip[$db_flight_info_flightid]";
            $result_date = $connection->query($sql_date);
            $row_date = $result_date->fetch_assoc();
            $date = $row_date[$db_flight_date];
			
			$sql_status= "SELECT $db_trip_status FROM $db_trip_tab WHERE $db_trip_id= $tripid";
			$result_status = $connection->query($sql_status);
			$row_status = $result_status->fetch_assoc();
			$tripstatus= $row_status[$db_trip_status];
			

		if (!empty($lname)&& !empty($fname)){
        echo '<tr onMouseover=this.bgColor="#D9E4E6" onMouseout=this.bgColor="white"'." onclick='tr2($tripid)'>";
        echo "<td>$date </td>".    
        "<td>$fname </td>".
        "<td>$lname</td>".
        "<td>$tripstatus</td>".    
        "</tr>";   
        }}
    }}

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
