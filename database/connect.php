<?php

        
    function db_connection(){
        
    $host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "m1147_mvp";  
        
    $conn = new mysqli($host, $db_user, $db_pass, $db_name);
    if ($conn->connect_errno!=0){
        echo "Error: ".$conn->connect_errno;
        echo "<script type=\"text/javascript\">alert('b³¹d w po³¹czeniu z baz¹…');</script>";
        return false;
    }
    else{
        $conn -> query ('SET NAMES utf8');
        $conn -> query ('SET CHARACTER_SET utf8_unicode_ci');
        return $conn;
    }
}

?>