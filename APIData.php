<?php


class APIData{

    //baza danych z lotniskami
public $AirportsUrl= "https://v4p4sz5ijk.execute-api.us-east-1.amazonaws.com/anbdata/airports/locations/international-list?api_key=1d2a8cd0-83d5-11e7-a40a-b35c55abe8b5&format=json";
    //baza danych z regionami
public $AirspacesUrl= "https://v4p4sz5ijk.execute-api.us-east-1.amazonaws.com/anbdata/airspaces/zones/fir-name-list?api_key=1d2a8cd0-83d5-11e7-a40a-b35c55abe8b5&format=json" ;
    //baza danych z liniami lotniczymi
public $AirlinesUrl= "https://v4p4sz5ijk.execute-api.us-east-1.amazonaws.com/anbdata/airlines/designators/iosa-registry-list?api_key=1d2a8cd0-83d5-11e7-a40a-b35c55abe8b5&format=json";




//pobieranie danych z API

function curl($url){
    
    $cSession = curl_init();  
    curl_setopt($cSession,CURLOPT_URL,$url); 
    curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true); 
    curl_setopt($cSession,CURLOPT_HEADER, false); 
    $curlResult=curl_exec($cSession); 
    curl_close($cSession); 
    $curlResult = json_decode($curlResult, true);

    //funckja zwraca tablice z danymi
    return $curlResult;
}


// funkcja zwraca rekord z danymi lotniska bądź lini lotniczych wybranych przez uzytkownika 
function FindData($country, $name, $city, $curlResult){

    foreach ($curlResult as $key => $object){ 
        if ( array_search($country, $object) ){
            if ( array_search($city, $object) ){  
                if ( array_search($name, $object) ){
                  return $curlResult[$key];
                }
            }
        }
    }
}

//funkcja zwraca region wybranego lotniska odlotu, przylotu oraz przewoznika
function FindRegion($data,$curlAirspacesResult){
    
    $key = array_search($data['countryCode'], array_column($curlAirspacesResult, 'countryCode'));
    return  $curlAirspacesResult[$key]['region'];  
}


// funkcja nadaje format danym wyświetlanym w podpowiedzi wpisywanych lotnisk
function dataForAutocomplete ($curlAirportResult){

    foreach ($curlAirportResult as $key =>$value){
    $result[]= $value['airportName'].',  '. $value['cityName'].',  '. $value['countryName']; 
    }   
    echo json_encode($result); 
}


//funkcja nadaje format danym wyświetlanym w podpowiedzi wpisywanych przewoznikow

function dataForAirlinesAutocomplete ($curlAirlinesResult){

    foreach ($curlAirlinesResult as $key =>$value){
    $result[]= $value['operatorName'].',  '. $value['countryName']; 
    }   
    echo json_encode($result); 
}

}

?>