<?php

session_start();

If (!isset($_SESSION['id'])){
   header('Location: login.html');  
}
?>



<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  

    <title>Admin</title>

  
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
                  <li class="active">
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
                    
                   echo ' <li>
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
					<h3 class="page-header"><i class="fa fa-laptop"></i>Strona główna</h3>
					
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
