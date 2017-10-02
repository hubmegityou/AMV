<?php

        
    function db_connection(){
        
    $host = "s3.mydevil.net";
    $db_user = "m1147_root";
    $db_pass = "GecsmskqFt16WzpcsE6g";
    $db_name = "m1147_amv";  
        
    $conn = new mysqli($host, $db_user, $db_pass, $db_name);
    if ($conn->connect_errno!=0){
        echo "Error: ".$conn->connect_errno;
        echo "<script type=\"text/javascript\">alert('b��d w po��czeniu z baz��');</script>";
        return false;
    }
    else{
        $conn -> query ('SET NAMES utf8');
        $conn -> query ('SET CHARACTER_SET utf8_unicode_ci');
        return $conn;
    }
}

?>