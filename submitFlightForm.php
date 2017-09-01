<?php

require 'APIData.php';
require'GreatCircle.php';

// pobranie danych wpisanych przez uzytkownika-> miejsce wylotu 
$departure=explode(',  ', $_POST['departure']);
$departureName=$departure[0];
$departureCity=$departure[1];
$departureCountry=$departure[2];

//pobranie danych wpisanych przez uzytkownika-> miejsce przylotu
$arrival= explode(',  ', $_POST['arrival']);
$arrivalName=$arrival[0];
$arrivalCity=$arrival[1];
$arrivalCountry=$arrival[2];

//pobranie danych wpisanych przez uzytkownika-> przewoznik
$airlines= explode(',  ',$_POST['airlines']);
$airlinesName=$airlines[0];
$airlinesCountry= $airlines[1];

<<<<<<< HEAD
=======
//pobranie danych lotnisk, regionów oraz linii lotniczych z API

>>>>>>> 426b9d497015eb78eb0f1d84e53f110a1a3fba41
$APIData= new APIData();
//pobranie danych lotnisk, regionów oraz linii lotniczych z API
$curlAirportResult= $APIData->curl($APIData->AirportsUrl);
$curlAirspacesResult= $APIData->curl($APIData->AirspacesUrl);
$curlAirlinesResult= $APIData->curl($APIData->AirlinesUrl);

//pobranie danych wpisanych przez uzytkownika-> miejsce przesiadki
if (isset($_POST['change'])){
    $airport = expole(', ', $_POST['change2']);
    $airportName = $airport[0];
    $airportCity = $airport[1];
    $airportCountry = $airport[2];
    $airportData = $APIData->FindData($airportCountry, $airportName, $airportCity, $curlAirportResult);
    $airportRegion = $APIData->FindRegion($airportData, $curlAirportResult);
    var_dump($airportData);
    var_dump($airportRegion);
}
//pobranie rekordów z danymi wylotu, przylotu oraz linii lotniczych podanych prze uzytkownika
$departureData= $APIData->FindData($departureCountry, $departureName,$departureCity,$curlAirportResult);
$arrivalData=$APIData->FindData($arrivalCountry, $arrivalName,$arrivalCity,$curlAirportResult);
$airlinesData=$APIData->FindData( $airlinesCountry, $airlinesName,0, $curlAirlinesResult);

// sprawdzenie regionów lotniska wylotu, przylotu oraz linii lotniczych podanych przez uzytkownika
$departureRegion=$APIData->FindRegion($departureData, $curlAirspacesResult);
$arrivalRegion= $APIData->FindRegion($arrivalData, $curlAirspacesResult);
$airlinesRegion= $APIData->FindRegion($airlinesData, $curlAirspacesResult);

//weryfikacja czy lot nadaje się do objęcia zgłoszeniem roszczenia
if ($departureRegion!='EUR' && $arrivalRegion!='EUR'){
    echo "lot nie nadaje sie do objecia zgloszeniem roszczenia-  lecisz z poza europy poza europe";
} elseif( $departureRegion!='EUR' && $arrivalRegion=='EUR' && $airlinesRegion!='EUR'){
    echo "lot nie nadaje sie do objecia zgloszeniem roszczenia- przewoznik spoza europy";
    
}else{
    //weryfikacja pozytywna- obliczanie odleglosci miedzy lotniskami
   $distance= GreatCircle::distance($departureData['latitude'], $departureData['longitude'],$arrivalData['latitude'],$arrivalData['longitude']);   
   
      
}