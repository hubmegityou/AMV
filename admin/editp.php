<?php
//edycja profilu - wpis do bazy
session_start();
if (!empty($_POST)){
    require_once "../database/dbinfo.php";
require_once "../database/connect.php";
    
    $connection = db_connection();
    if ($connection != false){
		
		if ($_POST['pass1']!='' || $_POST['pass2']!=''){
			
            if ($_POST['pass1'] != $_POST['pass2']){
               echo "<script type=\"text/javascript\">window.alert('Hasła nie są jednakowe'); window.location.href = 'editprofile.php'</script>";        
            }
            else{
                $sql = "UPDATE $db_users_tab SET $db_users_pass = '".md5($_POST['pass1'])."' WHERE $db_users_id='".$_SESSION['id']."'";
                if ($connection->query($sql) != true){
                    echo "<script type=\"text/javascript\">window.alert('Wystąpił błąd');
                 window.location.href = 'editprofile.php'</script>";
                }
            }
        }
		

        $sql = "UPDATE $db_users_tab SET $db_users_fname = '".$_POST['fname']."', $db_users_lname = '".$_POST['lname']."', $db_users_email='".$_POST['email']."', $db_users_login='".$_POST['login']."' WHERE $db_users_id='".$_SESSION['id']."'";
        if ($connection->query($sql)){
			
            $_SESSION['fname'] = $_POST['fname'];
            $_SESSION['lname'] = $_POST['lname'];
            echo "<script type=\"text/javascript\">window.alert('Twoje dane zostały edytowane');
                 window.location.href = 'editprofile.php';</script>";
        }
        
    }
}
?>