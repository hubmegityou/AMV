<?php

require 'APIData.php';


$APIData= new APIData();
if ($_POST['input']=="flight"){

    $curlResult= $APIData->curl($APIData->AirportsUrl);

}else{

    $curlResult= $APIData->curl($APIData->AirlinesUrl);
}
    
$data= $APIData-> dataForAutocomplete($curlResult, $_POST['input']);
echo $data;
