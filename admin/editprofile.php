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
                }  else{
                    
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
					<h3 class="page-header"><i class="fa fa-laptop"></i> Edytuj profil</h3>
					
                                   <form action="editp.php" method="post">
<center>
<?php
    require_once "database/dbinfo.php";
require_once "database/connect.php";
    
    $connection = db_connection();
    if ($connection != false){
        $sql = "SELECT $db_users_fname, $db_users_lname, $db_users_login, $db_users_email FROM $db_users_tab WHERE $db_users_id=".$_SESSION['id'];
        if ($result = $connection->query($sql))
        $row = $result->fetch_assoc();
        echo "<div><p class='left'>Imię: <br><input type='text' value='$row[$db_users_fname]' name='fname'  required/></p></div>";
        echo "<div><p class='left'>Login: <br><input type='text' value='$row[$db_users_login]' name='login'  required/></p></div>";
        echo "<div><p class='left'>Nazwisko: <br><input type='text' value='$row[$db_users_lname]' name='lname'  required/></p></div>";
        echo "<div><p class='left'>Nowe hasło: <br><input type='password' name='pass1' ></p></div>";
        echo "<div><p class='left'>Adres email: <br><input type='email' value='$row[$db_users_email]' name='email' required/></p></div>";
        echo "<div><p class='left'>Powtórz hasło: <br><input type='password' name='pass2' ></p></div>";
        }
?>
    <div style="clear:both"></div>
    <br><br>
<div><p class="left" style='margin-left:44%'><br><button type="submit">Zapisz</button></p></div>
<br><br>
</center>
</form>     
                                        
                                
                                        
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
