<?php
//edycja profilu - wpis do bazy
session_start();
if (!empty($_POST)){
    require_once "database/dbinfo.php";
require_once "database/connect.php";
    
    $connection = db_connection();
    if ($connection != false){
        $sql = "UPDATE $db_users_tab SET $db_users_fname = '".$_POST['fname']."', $db_users_lname = '".$_POST['lname']."', $db_users_email='".$_POST['email']."', $db_users_login='".$_POST['login']."' WHERE $db_users_id='".$_SESSION['id']."'";
        if ($connection->query($sql)){
            $_SESSION['fname'] = $_POST['fname'];
            $_SESSION['lname'] = $_POST['lname'];
            $_SESSION['alert'] = 'Edytowano twoje dane pomyślnie';
        }
        if ($_POST['pass1']!='' || $_POST['pass2']!=''){
            if ($_POST['pass1'] != $_POST['pass2']){
                $_SESSION['alert'] = "Błąd: hasła nie są jednakowe";        
            }
            else{
                $sql = "UPDATE $db_users_tab SET $db_users_pass = '".md5($_POST['pass1'])."' WHERE $db_users_id='".$_SESSION['id']."'";
                if ($connection->query($sql) != true){
                    $_SESSION['alert'] = 'Wystąpił błąd podczas aktualizacji danych';
                }
            }
        }
    }
}
header("Location: editprofile.php");
?>