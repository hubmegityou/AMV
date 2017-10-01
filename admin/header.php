<header class="header dark-bg">
            <a href="index.php" class="logo"><span class="lite">Admin</span></a>
           
   

            <div class="top-nav notification-row">                

                <ul class="nav pull-right top-menu">
                    

                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="profile-ava">
                            </span>
                            <span class="username"><?php echo $_SESSION['fname'].' '.$_SESSION['lname']?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
            
                            <li class="eborder-top">
                                <a href="editprofile.php"><i class="icon_profile"></i> Mój profil</a>
                            </li>
                          
                            <li>
                                <a href="logout.php"><i class="icon_key_alt"></i> Wyloguj</a>
                            </li>
                            
                        </ul>
                    </li>
           
                </ul>
      
            </div>
      </header>