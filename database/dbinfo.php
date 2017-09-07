<?php

        //informacje o liniach lotniczych
        $db_airlines_tab = 'airlines';
            $db_airlines_id = "airline_ID";
            $db_airlines_operator = "operator_name";
            $db_airlines_IATA = "IATA_code";
            $db_airlines_countrycode = "country_code";
            $db_airlines_name = "country_name";
            $db_airlines_region = "region";
         
            
        //informacje o lotniskach    
        $db_airports_tab = "airporst";
            $db_airports_id = "airport_ID";
            $db_airports_ICAO = "ICAO_code";
            $db_airports_IATA = "IATA_code";
            $db_airports_name = "airport_name";
            $db_airports_city = "city_name";
            $db_airports_country = "country_name";
            $db_airports_region = "region";
            $db_airports_latitude = "latitude";
            $db_airports_longitude = "longitude";
         
            
       //informacje o pasa¿erach    
        $db_passengers_tab = "passengers_details";
            $db_passengers_id= "passenger_ID";
            $db_passengers_firstname = "first_name";
            $db_passengers_lastname = "last_name";
            $db_passengers_address = "address";
            $db_passengers_zipcode = "zip_code";
            $db_passengers_city = "city";
            $db_passengers_country = "country";
            $db_passengers_email = "email";
            $db_passengers_telnumber = "tel_number";
            $db_passengers_passport = "passport";
            $db_passengers_idcard = "IDcard";
            $db_passengers_boarding = "boarding_pass/res";
            $db_passengers_applicationid = "application_ID";
            
            
        //informacje o sposobie wyp³aty odszkodowania
        $db_compensation_tab = "compensation";
            $db_compensation_id = "compensation_ID";
            $db_compensation_type = "type";
            $db_compensation_payment = "payment";
            $db_compensation_currency = "currency";
            $db_compensation_account = "account";
        
            
            
       //informacje o zg³oszeniu
        $db_application_tab = "application";
            $db_application_id = "application_ID";
            $db_application_compensationid = "compensation_ID";
?>  