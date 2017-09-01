<?php
require 'APIData.php';

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

//pobranie danych lotnisk, regionów oraz linii lotniczych z API

$APIData= new APIData();
$curlAirportResult= $APIData->curl($APIData->AirportsUrl);
$curlAirspacesResult= $APIData->curl($APIData->AirspacesUrl);
$curlAirlinesResult= $APIData->curl($APIData->AirlinesUrl);


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
    echo "lot nie nadaje sie do objecia zgloszeniem roszczenia -  lecisz spoza europy poza europe";
} 
elseif( $departureRegion!='EUR' && $arrivalRegion=='EUR' && $airlinesRegion!='EUR'){
    echo "lot nie nadaje sie do objecia zgloszeniem roszczenia - przewoznik spoza europy";
}
else{
    //sprawdzenie czy lot by� w obr�bie UE
    $UE = ($departureRegion=='EUR' && $arrivalRegion=='EUR') ? true : false;
    //weryfikacja pozytywna- obliczanie odleglosci miedzy lotniskami
    require 'GreatCircle.php';
    $distance= GreatCircle::distance($departureData['latitude'], $departureData['longitude'],$arrivalData['latitude'],$arrivalData['longitude']);
    //sprawdzanie do kt�rej kategorii zaliczamy pokonany dystans (potrzebne do odczytywania wysoko�ci odszkodowania z tabeli)
    if ($distance <= 1500)
            $type = 0;
        elseif (($distance > 1500 && $UE) || ($distance <= 3500 && !$UE))
            $type = 1;
        else
            $type = 2;
    header("Location: compensation_form.html");
}
?>