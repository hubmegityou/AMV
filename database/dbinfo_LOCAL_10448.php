<?php

        //informacje o liniach lotniczych
        $db_airlines_tab = 'airlines';
            $db_airlines_id = "id";
            $db_airlines_operator = "operator_name";
            $db_airlines_IATA = "IATA_code";
            $db_airlines_countrycode = "country_code";
            $db_airlines_name = "country_name";
            $db_airlines_region = "region";
         
            
        //informacje o lotniskach    
        $db_airports_tab = "airports";
            $db_airports_id = "ID";
            $db_airports_name = "name"; 
            $db_airports_city = "city";
            $db_airports_country = "country";
            $db_airports_IATA = "IATA";
            $db_airports_ICAO = "ICAO";
            $db_airports_latitude = "latitude";
            $db_airports_longitude = "longitude";
            $db_airports_altitude = "altitude";
            $db_airports_timezone = "timezone";
            $db_airports_dst = "dst";
            $db_airports_countrycode = "country_code";
            $db_airports_region = "region";
            
            
       //informacje o pasa�erach    
        $db_passengers_tab = "passengers_details";
            $db_passengers_id= "id";
            $db_passengers_firstname = "first_name"; //imi�
            $db_passengers_lastname = "last_name";  //nazwisko
            $db_passengers_address = "address"; //adres
            $db_passengers_zipcode = "zip_code"; //kod pocztowy
            $db_passengers_city = "city";   //miasto
            $db_passengers_country = "country";  //pa�stwo
            $db_passengers_email = "email";  //email
            $db_passengers_telnumber = "tel_number"; //numer telefonu
            $db_passengers_passport = "passport"; //paszport
            $db_passengers_idcard1 = "IDcard1"; // dow�d osobisty 1 strona
            $db_passengers_idcard2 = "IDcard2"; // dow�d osobisty 2 strona
            
            
           
        $db_connect_tab= "connect" ;
            $db_connect_id = "id";
            $db_connect_passenger_id = "passenger_ID";
            $db_connect_trip_id = "trip_ID";
            $db_connect_boarding = "boarding_pass"; // karta pok�adowa 
            $db_connect_reservation = "reservation"; //rezerwacja
            
        //informacje o grupie lot�w
        $db_trip_tab = "trip";
            $db_trip_id = "id";
            $db_trip_first_flight_info_id = "flight_info_ID";
            $db_trip_delay = "delay";
            //$db_trip_distance = "distance"; //shoudn't be necessary 
            $db_trip_sum = "sum";
            $db_trip_string_id = "string_id";
            

            
         //grupy lot�w   
        $db_flight_info_tab = "flight_info";
            $db_flight_info_id= "id";
            $db_flight_info_tripid = "trip_id";
            $db_flight_info_applicationid = "application_ID";
            //$db_flight_info_nextflight = "next_flight_info_ID";
            $db_flight_info_flightid = "flight_ID";
            $db_flight_info_departureid = "departure_id";
            $db_flight_info_arrivalid = "arrival_id";
            $db_flight_info_order = "order";

         
            
       //informacje o zg�oszeniu
        $db_application_tab = "application";
            $db_application_id = "id";
            $db_application_incident = "incident"; // co sie sta�o
            $db_application_cause = "cause"; //pow�d
            $db_application_delay = "delay"; // op�nienie
            $db_application_cancel = "cancellation_information"; // kiedy poinformowali o odwo�aniu lotu
            $db_application_resignation = "resignation"; // czy klient zrezygnowa� z lotu w zamian za korzy�ci
            //$db_application_permission = "permission "; // czy by�a zgoda na zmian� planu podr�y  
            $db_application_compensation = "compensation_availability";
            $db_application_compensationid = "compensation_ID";
            
       
        //informacje o zg�oszonych lotach
        $db_flight_tab = "flight";
            $db_flight_id = "id";
            $db_flight_departureid = "departure_ID"; //odlot
            $db_flight_arrivalid = "arrival_ID"; // przylot
            $db_flight_number = "flight_number"; //numer lotu
            $db_flight_date = "flight_date"; // data lotu
            $db_flight_airlineid = "airline_ID"; // linie lotnicze 
            $db_flight_distance = "distance";
            $db_flight_compensation = "compensation_availability"; //czy lot nadaje sie do odszkodowania
            
        //informacje o sposobie wyp�aty odszkodowania
        $db_compensation_tab = "compensation";
            $db_compensation_id = "id";
            $db_compensation_type = "type";  // express czy standard
            $db_compensation_payment = "payment"; // spos�b wyp�aty
            $db_compensation_currency = "currency"; // waluta
            $db_compensation_account = "account"; // numer konta/ PayPal
?>  