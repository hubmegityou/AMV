<?php
		
		
		require_once "../database/dbinfo.php";
		require_once "../database/connect.php";
    
		$connection = db_connection();  
		
		
		if (is_uploaded_file($_FILES['file']['tmp_name'])) {
    
        move_uploaded_file($_FILES['file']['tmp_name'],
                "uploads/".$_FILES['file']['name']);
}
		
		 $filename="uploads/".$_FILES['file']['name'];
		$ext=substr($filename,strrpos($filename,"."),(strlen($filename)-strrpos($filename,".")));

//we check,file must be have csv extention
		if($ext==".csv")
		{
		$file = fopen($filename, "r");
         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
         {
			 $sql_depid= "SELECT $db_airports_id FROM $db_airports_tab WHERE $db_airports_IATA= '$emapData[0]'";
			 $result_depid = $connection->query($sql_depid);
			 $depid = $result_depid->fetch_assoc();
			 
			 $sql_arrid= "SELECT $db_airports_id FROM $db_airports_tab WHERE $db_airports_IATA= '$emapData[1]'";
			 $result_arrid = $connection->query($sql_arrid);
			 $arrid = $result_arrid->fetch_assoc();
			 
			 $sql_alines="SELECT $db_airlines_id FROM $db_airlines_tab  WHERE $db_airlines_IATA= '$emapData[4]'";
			 $result_alines = $connection->query($sql_alines);
			 $alines = $result_alines->fetch_assoc();
			 
			 
			 
            $sql = "INSERT into $db_flight_tab($db_flight_departureid,$db_flight_arrivalid,$db_flight_number, $db_flight_date, $db_flight_airlineid) values('$depid[$db_airports_id]','$arrid[$db_airports_id]','$emapData[2]','$emapData[3]','$alines[$db_airlines_id]')";
			$result = $connection->query($sql);
			$last_id = $connection->insert_id;
			
			$sql_flight= "INSERT into $db_flight_info_tab ($db_flight_info_flightid, $db_flight_info_arrivalid, $db_flight_info_departureid) values ('$last_id', '$arrid[$db_airports_id]', '$depid[$db_airports_id]')";
			$result = $connection->query($sql_flight);
			$last_flight_id = $connection->insert_id;
			;
			
			$num= rand(0,999999999);
			
			
			$sql_trip= "INSERT into  $db_trip_tab ($db_trip_first_flight_info_id, $db_trip_campaign) values ('$last_flight_id','$num')";
			$result = $connection->query($sql_trip);
			$last_trip = $connection->insert_id;
		
			
			$sql= "update $db_flight_info_tab set $db_flight_info_tripid=$last_trip WHERE $db_flight_info_id=$last_flight_id ";
			$result = $connection->query($sql);
			
         }
         fclose($file);
		 // echo "<script type=\"text/javascript\">window.alert('udało się');
                // window.location.href = 'import.php'</script>";

		}
	else {
		echo "<script type=\"text/javascript\">window.alert('Wystąpił błąd');
                window.location.href = 'import.php'</script>";
		
	}


	

?>