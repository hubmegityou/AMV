<?php

require 'APIData.php';

header('Content-Type: application/json');
$APIData= new APIData();

if ($_GET['type']=="airport"){
    $table = $APIData -> findAirport($_GET['term']);
}else{
    $table = $APIData -> findAirline($_GET['term']);
}
echo json_encode($table);
/*

if ($_POST['input']=="flight"){

    $curlResult= $APIData->curl($APIData->AirportsUrl);

}else{

    $curlResult= $APIData->curl($APIData->AirlinesUrl);
}
    
$data= $APIData-> dataForAutocomplete($curlResult, $_POST['input']);
echo $data;
*/

?>