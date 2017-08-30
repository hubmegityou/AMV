<?php

require 'APIData.php';

$APIData= new APIData();
$curlResult= $APIData->curl($APIData->AirlinesUrl);
$data= $APIData-> dataForAirlinesAutocomplete($curlResult);
echo $data;
?>