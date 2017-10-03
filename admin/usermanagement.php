<?php

session_start();


If ($_SESSION['function']!=1){
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
                  <li>
                      <a class="" href="index.php">
                          <i class="icon_house_alt"></i>
                          <span>Strona głwna</span>
                      </a>
                  </li>
				 
                 <?php
                If ($_SESSION['function']==1){
                
                    echo '<li class="active">
                        <a href="usermanagement.php">
                        <span>Zarządaj użytkownikami</span>
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
					<h3 class="page-header"><i class="fa fa-laptop"></i> Zarządzaj użytkownikami</h3>                                                     
                                        
                                        
                       </div>
                     </div>
                 <hr />
                     <div class="subtask-form">
                         
                         Usuń użytkownika <br><br>
                         
                         <div style='margin-left:70%' > wyszukaj <input id='search' type='text'> </div>                     
                                     
                         
                         <table class="responstable" id='table'>
                             <thead>                      
                                    <tr>
                                    <th>Imię</th>
                                    <th>Nazwisko</th>
                                    <th>E-mail</th>
                                    <th>Funkcja</th>
                                    <th>Usuń</th>
                                    </tr>
                             </thead>
                              <tbody>
  
                             
                            <?php  
  
                            require_once "../database/dbinfo.php";
                            require_once "../database/connect.php";
    
                            $connection = db_connection();  
  
                            $sql = "SELECT* FROM $db_users_tab";
                            $result = $connection->query($sql);
                            while( $row = $result->fetch_assoc()){   
                                if ($row[$db_users_function]=='1'){
                                     $function='admin'; 
                                }else {
                                    $function='pracownik'; 
                                }
                                 echo "<tr>
                                <td>$row[$db_users_fname]</td>
                                <td>$row[$db_users_lname]</td>
                                <td>$row[$db_users_email]</td>
                                <td>$function</td>    
                                <td>".'<div onClick="'."delete_row($row[$db_users_id])".'"><i style="cursor: pointer" class="fa fa-trash-o" aria-hidden="true"></i></div></td>
                                </tr>';    
                            } 
  ?>                                         
                              </tbody>  
                              </table>

                 
    <br><br><br><br><br><br>                   
    Dodaj użytkownika
    <br><br>                  
                         
   <form action="addu.php" method="post">
        <center>
		
            <div class="stemat"><p class="left">Imię: <br> <input type="text" name="fname" required/></p></div>
            <div class="stemat"><p class="left">Login: <br> <input type="text" name="login" required/></p></div>
            <div class="stemat"><p class="left">Nazwisko: <br> <input type="text" name="lname" required/></p></div>
            <div class="stemat"><p class="left">Hasło: <br> <input type="password" name="pass1" required /></p></div>
            <div class="stemat"><p class="left">Adres email: <br> <input type="email" name="email" required/></p></div>
            <div class="stemat"><p class="left">Powtórz hasło: <br> <input type="password" name="pass2" required /></p><br></div>
            <div class="stemat"><p class="left">Funkcja: <br>
            <select name="function" required>
                <option value="1">admin</option>
		<option value="2">pracownik</option>
				
        <br />
            </select></p></div>
           <div><p class="left"><br><button type="submit">Dodaj</button></p></div>
            <div style="clear:both"></div>
        <br><br><br>
        </center> 
                        
   </form>                                             
        </div>			
          </section>
        
      </section>
  </section>
     	<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/scripts.js"></script>

  </body>
</html>