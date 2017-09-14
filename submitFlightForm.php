<?php

session_start();
//require 'APIData.php';
require 'GreatCircle.php';
require_once "database/dbinfo.php";
require_once "database/connect.php";

// pobranie danych wpisanych przez uzytkownika-> miejsce wylotu 
$departure=explode(', ', $_POST['departure']);
$departureName=$departure[1];
$departureIATA=$departure[2];

//pobranie danych wpisanych przez uzytkownika-> miejsce przylotu
$arrival= explode(', ', $_POST['destination']);
$arrivalName=$arrival[1];
$arrivalIATA=$arrival[2];

//pobranie danych wpisanych przez uzytkownika-> przewoznik
$airlines= explode(', ',$_POST['airlines']);
$airlinesName=$airlines[0];

/*
//pobranie danych lotnisk, regionów oraz linii lotniczych z API
$APIData= new APIData();
$curlAirportResult= $APIData->curl($APIData->AirportsUrl);
$curlAirspacesResult= $APIData->curl($APIData->AirspacesUrl);
$curlAirlinesResult= $APIData->curl($APIData->AirlinesUrl);
*/

//pobranie danych wpisanych przez uzytkownika-> miejsce przesiadki

$i = 0;
$prev_flightinfo_id = 0;
$prev_airport_name = $departureName;
$prev_airport_IATA = $departureIATA;
$connection = db_connection();
//sprawdzenie regionu przewoźnika
$sql = "SELECT $db_airlines_id, $db_airlines_region FROM $db_airlines_tab WHERE $db_airlines_operator = '$airlinesName'";
if($result = $connection->query($sql))
        echo "ok1";
$row = $result->fetch_assoc();
$airlinesRegion = $row[$db_airlines_region];
$airlinesId = $row[$db_airlines_id];
//wyszukiwanie id lotniska startowego
                $sql = "SELECT $db_airports_id, $db_airports_region, $db_airports_latitude, $db_airports_longitude FROM $db_airports_tab WHERE $db_airports_name = '$prev_airport_name' AND $db_airports_IATA = '$prev_airport_IATA'";
                if($result = $connection->query($sql))
                        echo "ok2";
                echo $sql;
                $row = $result->fetch_assoc();
                $prev_airport = $row;
                $prev_airport_id = $row[$db_airports_id];
                $prev_airport_reg = $row[$db_airports_region];
$distanceSum = 0;
/*
while (!empty($_POST['waypoint'.$i])){
    //odczytywanie miejsc kolejnych przesiadek
    $airport = explode(', ', $_POST['waypoint'.$i]);
    $airportName = $airport[0];
    $airportIATA = $airport[2];
    //wyszukiwanie id lotniska przesiadkowego
                $sql = "SELECT $db_airports_id, $db_airports_region, $db_airports_latitude, $db_airports_longitude FROM $db_airports_tab WHERE $db_airports_name = '$airportName' AND $db_airports_IATA = '$airportIATA'";
                $result = $connection->query($sql);
                $row = $result->fetch_assoc();
                $arrival = $row;
                $arrivalid = $row[$db_airports_id];
                $arrivalreg = $row[$db_airports_region];
    //weryfikacja czy lot nadaje sie do objecia odszkodowania
    if (($prev_airport_reg != 'EUR' && $arrivalreg != 'EUR') || ($arrivalreg != 'EUR' && $airlinesRegion != 'EUR')){
        $sql = "INSERT INTO $db_flight_tab ($db_flight_departureid, $db_flight_arrivalid, $db_flight_airlineid, $db_flight_compensation) VALUES ('$prev_airport_id','$arrivalid', '$airlinesId', false)";
    }
    else{
        $distance = GreatCircle::distance($prev_airport[$db_airports_latitude], $prev_airport[$db_airports_longitude],$arrival[$db_airports_latitude],$arrival[$db_airports_longitude]);   
        $distanceSum += $distance;
        $sql = "INSERT INTO $db_application_tab ($db_application_id) VALUES (NULL)";
        $connection->query($sql);
        $applicationID = $connection->insert_id;
        $sql = "INSERT INTO $db_flight_tab ($db_flight_departureid, $db_flight_arrivalid, $db_flight_airlineid, $db_flight_compensation, $db_flight_distance) VALUES ('$prev_airport_id','$arrivalid', '$airlinesId', true, '$distance')";
    }
    $connection->query($sql);
    $flightID = $connection->insert_id;
    //dodanie rekordu do flight_info tab
    $sql = "INSERT INTO $db_flight_info_tab (";
    
    //id poprzedniego lotniska = id aktualnego lotniska przylotu
    $prev_airport_id = $arrivalid;
    $prev_airport_reg = $arrivalreg;
    $prev_airport_name = $airportName;
    $prev_airport_IATA = $airportIATA;
    $i++;
}
*/

$sql = "SELECT $db_airports_id, $db_airports_region, $db_airports_latitude, $db_airports_longitude FROM $db_airports_tab WHERE $db_airports_name = '$arrivalName' AND $db_airports_IATA = '$arrivalIATA'";
                if($result = $connection->query($sql));
                    echo"ok3";
                $row = $result->fetch_assoc();
                $arrival = $row;
                $arrivalid = $row[$db_airports_id];
                $arrivalreg = $row[$db_airports_region];
var_dump($prev_airport, $arrival, $airlinesRegion);

if (($prev_airport_reg != 'EUR' && $arrivalreg != 'EUR') || ($arrivalreg != 'EUR' && $airlinesRegion != 'EUR')){
    $sql = "INSERT INTO $db_flight_tab ($db_flight_departureid, $db_flight_arrivalid, $db_flight_airlineid, $db_flight_compensation) VALUES ('$prev_airport_id','$arrivalid', '$airlinesId', false)";
    echo "alert('Twoj lot nie może zostać objęty reklamacją')";
    header("location: DataForm.html");
    exit();
}
else{
    //obliczanie odleglosci
    $distance = GreatCircle::distance($prev_airport[$db_airports_latitude], $prev_airport[$db_airports_longitude],$arrival[$db_airports_latitude],$arrival[$db_airports_longitude]);   
    //wstawienie pustego rekordu application
    $sql = "INSERT INTO $db_application_tab ($db_application_id) VALUES (NULL)";
    $connection->query($sql);
    $applicationID = $connection->insert_id;
    $_SESSION['application'] = $applicationID;
    //wstawienie danych lotu
    $sql = "INSERT INTO $db_flight_tab ($db_flight_departureid, $db_flight_arrivalid, $db_flight_airlineid, $db_flight_compensation, $db_flight_distance) VALUES ('$prev_airport_id','$arrivalid', '$airlinesId', true, '$distance')";
    $connection->query($sql);
    $flightID = $connection->insert_id;
    $_SESSION['flightid'] = $flightID;
    $_SESSION['departure'] = $prev_airport_id;
    $_SESSION['arrival'] = $arrivalid;
    $sql = "INSERT INTO $db_flight_info_tab ($db_flight_info_applicationid, $db_flight_info_flightid) VALUES ('$applicationID', '$flightID')";
    $connection->query($sql);
    $flightinfoID = $connection->insert_id;
    $trip_id = $_SESSION['trip_id'];
    $sql = "UPDATE $db_trip_tab SET $db_trip_first_flight_info_id = '$flightinfoID' WHERE $db_trip_id='$trip_id'";
    $connection->query($sql);
    header("location: compensation_form.html");
}
/*
//pobranie rekordów z danymi wylotu, przylotu oraz linii lotniczych podanych prze uzytkownika
$departureData= $APIData->FindData($departureCountry, $departureName,$departureCity,$curlAirportResult);
$arrivalData=$APIData->FindData($arrivalCountry, $arrivalName,$arrivalCity,$curlAirportResult);
$airlinesData=$APIData->FindData( $airlinesCountry, $airlinesName,0, $curlAirlinesResult);

// sprawdzenie regionów lotniska wylotu, przylotu oraz linii lotniczych podanych przez uzytkownika
$departureRegion=$APIData->FindRegion($departureData, $curlAirspacesResult);
$arrivalRegion= $APIData->FindRegion($arrivalData, $curlAirspacesResult);
$airlinesRegion= $APIData->FindRegion($airlinesData, $curlAirspacesResult);
*/
//weryfikacja czy lot nadaje się do objęcia zgłoszeniem roszczenia
/*if ($departureRegion!='EUR' && $arrivalRegion!='EUR'){
    echo "lot nie nadaje sie do objecia zgloszeniem roszczenia-  lecisz z poza europy poza europe";
} elseif( $departureRegion!='EUR' && $arrivalRegion=='EUR' && $airlinesRegion!='EUR'){
    echo "lot nie nadaje sie do objecia zgloszeniem roszczenia- przewoznik spoza europy";
    
}else{
    //weryfikacja pozytywna- obliczanie odleglosci miedzy lotniskami
   $distance = GreatCircle::distance($departureData['latitude'], $departureData['longitude'],$arrivalData['latitude'],$arrivalData['longitude']);      
}*/
?>