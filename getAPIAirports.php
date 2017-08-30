<?php

require 'APIData.php';

$APIData= new APIData();
$curlResult= $APIData->curl($APIData->AirportsUrl);
$data= $APIData-> dataForAutocomplete ($curlResult);
echo $data;

?>