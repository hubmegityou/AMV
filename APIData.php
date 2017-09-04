<?php


class APIData{

    //baza danych z lotniskami
    public $AirportsUrl = "https://v4p4sz5ijk.execute-api.us-east-1.amazonaws.com/anbdata/airports/locations/international-list?api_key=1d2a8cd0-83d5-11e7-a40a-b35c55abe8b5&format=json";
        //baza danych z regionami
    public $AirspacesUrl = "https://v4p4sz5ijk.execute-api.us-east-1.amazonaws.com/anbdata/airspaces/zones/fir-name-list?api_key=1d2a8cd0-83d5-11e7-a40a-b35c55abe8b5&format=json" ;
        //baza danych z liniami lotniczymi
    public $AirlinesUrl = "https://v4p4sz5ijk.execute-api.us-east-1.amazonaws.com/anbdata/airlines/designators/iosa-registry-list?api_key=1d2a8cd0-83d5-11e7-a40a-b35c55abe8b5&format=json";


    //pobieranie danych z API

    function curl($url){
        
        $cSession = curl_init();  
        curl_setopt_array($cSession, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_VERBOSE => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_URL => $url)
        );
        $curlResult=curl_exec($cSession); 
        curl_close($cSession); 
        $curlResult = json_decode($curlResult, true);
        //funckja zwraca tablice z danymi
        return $curlResult;
    }

    function findAirport($text){
        $table = $this -> curl($this -> AirportsUrl);
        $result = array();
        foreach ($table as $object){ 
            if (stripos($object['airportName'], $text) !== false || stripos($object['countryName'], $text)  !== false || stripos($object['airportCode'], $text) !== false || stripos($object['cityName'], $text) !== false){
                array_push($result, array("label" => ($object['cityName']." ".$object['airportName']." ".$object['countryName']), "value" => $object['airportCode']) );
            } 
        }
        return $result;   
    }

    // funkcja zwraca rekord z danymi lotniska bądź lini lotniczych wybranych przez uzytkownika 
    function FindData($country, $name, $city, $curlResult){

        foreach ($curlResult as $key => $object)
    { 
        if ( array_search($country, $object) )
        {
            if ( array_search($city, $object) )
            {  
                if ( array_search($name, $object) )
                {
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



    function dataForAutocomplete ($curlAirportResult, $input){

        foreach ($curlAirportResult as $key =>$value){
            if ($input=='flight'){
                $result[]= $value['airportName'].',  '. $value['cityName'].',  '. $value['countryName'];
            }else{
                $result[]= $value['operatorName'].',  '. $value['countryName'];
            }
        }   
    echo json_encode($result); 
    }

}

?>