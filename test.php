<?php
    $url = "https://v4p4sz5ijk.execute-api.us-east-1.amazonaws.com/anbdata/airports/locations/international-list?api_key=1d2a8cd0-83d5-11e7-a40a-b35c55abe8b5&format=json";
    
    $ch = curl_init();
    
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_VERBOSE => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_URL => $url));

    $data = curl_exec($ch);
    var_dump($data);
    curl_close($ch);

    
    //$curlResult = json_decode($curlResult, true);
    //funckja zwraca tablice z danymi
    //echo $curlResult;
    
?>