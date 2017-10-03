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
    <th>ID kampanii</th>
    <th>Wylot</th>
    <th>Przylot</th>
  </tr>
   </thead>
   <tbody>
                             
  <?php  
  
  require_once "../database/dbinfo.php";
  require_once "../database/connect.php";
    
    $connection = db_connection();  
  
   $sql= "SELECT $db_trip_first_flight_info_id, $db_trip_id,  $db_trip_campaign FROM  $db_trip_tab";
   $result = $connection->query($sql);
   while($row = $result->fetch_assoc()){  
       $sql2="SELECT * FROM $db_flight_info_tab WHERE $db_flight_info_id=".$row[$db_trip_first_flight_info_id];  
       $result2 = $connection->query($sql2);
       $row2 = $result2->fetch_assoc();
   
	   $departure= $row2[$db_flight_info_departureid];
   
		$sql_ar= "SELECT $db_flight_info_arrivalid FROM $db_flight_info_tab WHERE $db_flight_info_tripid = $row2[$db_flight_info_tripid] ORDER BY `$db_flight_info_tab`.`$db_flight_info_order` DESC LIMIT 1";
		$result_ar = $connection->query($sql_ar); 
		$row_ar = $result_ar->fetch_assoc();
		$arrival= $row_ar[$db_flight_info_arrivalid];
		 
			
       
        $sql4="SELECT $db_airports_name, $db_airports_city, $db_airports_country FROM  $db_airports_tab WHERE $db_airports_id=$departure";
        $result4 = $connection->query($sql4);
        $row4 = $result4->fetch_assoc();
       
        $sql5="SELECT $db_airports_name,$db_airports_city, $db_airports_country  FROM  $db_airports_tab WHERE $db_airports_id=$arrival";
        $result5 = $connection->query($sql5);
        $row5 = $result5->fetch_assoc();
        
        
        
        
        $departuree= "$row4[$db_airports_name], $row4[$db_airports_city], $row4[$db_airports_country]";
        $arrivall= "$row5[$db_airports_name], $row5[$db_airports_city], $row5[$db_airports_country]";
       
       
             echo '<tr onMouseover=this.bgColor="#D9E4E6" onMouseout=this.bgColor="white"'." onclick='tr($departure, $arrival, $row[$db_trip_campaign])'>";
             echo "<td>$row[$db_trip_campaign]</td>     
             <td>$departuree </td>
             <td>$arrivall</td>   
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