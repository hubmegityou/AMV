<?php

if (!empty($incident)){
switch($incident){
       case 1:  $incident='lot opóźniony';
                break;
       case 2:  $incident='lot odwołany';
                break;
       case 3:  $incident='nie wpuszczono mnie na poład';
                
}}
       
    
if (!empty($cause)){
    
  switch($cause){
        case 1:  $cause='problemy techniczne';
                 break;
        case 2:  $cause='złe warunki atmosferyczne';
                 break;
        case 3:  $cause='wpływ innych lotów';
                 break;
        case 4:  $cause='kłopoty portu lotniczego';
                 break;
        case 5:  $cause='strajk';
                 break;
        case 6:  $cause='nie podano';
                 break;
        case 7:  $cause='nie wiem';
                 break;
}  }      
                   

If (!empty($delay))	{			   

if (!empty($incident) && $incident==1){
      
   switch($delay){
       case 1:      $delay= "mniej niż 3 godziny";
                    break;
       case 2:      $delay= "ponad 3 godziny";
                    break;
       case 3:      $delay= "nie dotarłem na miejsce";
                    break;
  
    }  
   } else{
   
      switch($delay){
       case 1:      $delay= "mniej niż 2 godziny";
                    break;
       case 2:      $delay="2-3 godziny";
                    break;
       case 3:      $delay= "3-4 godziny";
                    break;
       case 4:     $delay= "powyżej 4 godzin";
                    break;
       case 5:     $delay= "nie wiem";
                    break;
   }
}  
}
   
    
   If (!empty($cancel)){
   
   switch($cancel){
      case 1:  $cancel='mniej niż 14 dni przed wylotem';   
               break;
      case 2:  $cancel='wiecej niż 14 dni przed wylotem';
               break;      
   }}
   
   
   if (!empty($resignation)){
   
   switch ($resignation){
      case 1:    $resignation='tak';
                 break;
      case 2:    $resignation='nie';
                 break;
   }}
