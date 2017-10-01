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
  

    <title>Admin</title>
    <link rel="stylesheet" href="table/css/style.css">  
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />   
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
	<link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">

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
                      <a class="" href="active.php">
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
    <th>ID kampanii</th>
    <th>Wylot</th>
    <th>Przylot</th>
    <th>Linie lotnicze</th>
  </tr>
   </thead>
   <tbody>
                             
  <?php  
  
  require_once "database/dbinfo.php";
    require_once "database/connect.php";
    
    $connection = db_connection();  
  
   $sql= "SELECT $db_trip_first_flight_info_id, $db_trip_id,  $db_trip_campaign FROM  $db_trip_tab GROUP BY $db_trip_campaign ";
   $result = $connection->query($sql);
   while($row = $result->fetch_assoc()){  
       $sql2="SELECT $db_flight_info_flightid, $db_flight_info_nextflight FROM $db_flight_info_tab WHERE $db_flight_info_id=".$row[$db_trip_first_flight_info_id];  
       $result2 = $connection->query($sql2);
       $row2 = $result2->fetch_assoc();
       If($row2[$db_flight_info_nextflight]==0){
            $sql3= "SELECT $db_flight_departureid, $db_flight_arrivalid, $db_flight_airlineid FROM $db_flight_tab WHERE $db_flight_id=".$row2[$db_flight_info_flightid];
            $result3 = $connection->query($sql3); 
            $row3 = $result3->fetch_assoc();
            
            $departure= $row3[$db_flight_departureid];
            $arrival=$row3[$db_flight_arrivalid];
        
            
            
       }else{
            $sql3= "SELECT $db_flight_departureid FROM $db_flight_tab WHERE $db_flight_id=".$row2[$db_flight_info_flightid];
            $result3 = $connection->query($sql3);
            $row3 = $result3->fetch_assoc();
            
            $departure= $row3[$db_flight_departureid];
       }
       
        $sql4="SELECT $db_airports_name, $db_airports_city, $db_airports_country FROM  $db_airports_tab WHERE $db_airports_id=$departure";
        $result4 = $connection->query($sql4);
        $row4 = $result4->fetch_assoc();
       
        $sql5="SELECT $db_airports_name,$db_airports_city, $db_airports_country  FROM  $db_airports_tab WHERE $db_airports_id=$arrival";
        $result5 = $connection->query($sql5);
        $row5 = $result5->fetch_assoc();
        
        $sql6= "SELECT $db_airlines_operator, $db_airlines_name FROM $db_airlines_tab WHERE $db_airlines_id=$row3[$db_flight_airlineid]";
        $result6 = $connection->query($sql6);
        $row6 = $result6->fetch_assoc();
        
        
        
        $airlines= "$row6[$db_airlines_operator], $row6[$db_airlines_name]";
        $departure= "$row4[$db_airports_name], $row4[$db_airports_city], $row4[$db_airports_country]";
        $arrival= "$row5[$db_airports_name], $row5[$db_airports_city], $row5[$db_airports_country]";
       
       
             echo '<tr onMouseover=this.bgColor="#D9E4E6" onMouseout=this.bgColor="white"'." onclick='tr($row[$db_trip_campaign])'>";
             echo "<td>$row[$db_trip_campaign]</td>     
             <td>$departure </td>
             <td>$arrival</td>
             <td>$airlines</td>    
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