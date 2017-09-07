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
        $db_airports_tab = "airports";
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
            $db_passengers_firstname = "first_name"; //imiê
            $db_passengers_lastname = "last_name";  //nazwisko
            $db_passengers_address = "address"; //adres
            $db_passengers_zipcode = "zip_code"; //kod pocztowy
            $db_passengers_city = "city";   //miasto
            $db_passengers_country = "country";  //pañstwo
            $db_passengers_email = "email";  //email
            $db_passengers_telnumber = "tel_number"; //numer telefonu
            $db_passengers_passport = "passport"; //paszport
            $db_passengers_idcard = "IDcard"; // dowód osobisty
            
           
        $db_connect_tab= "connect" ;
            $db_connect_id = "connect_ID";
            $db_connect_passenger_id = "passenger_ID";
            $db_connect_trip_id = "trip_ID";
            
        //informacje o grupie aplikacji
        $db_trip_tab = "trip";
            $db_trip_id = "trip_ID";
            $db_flight_info_id= "flight_info_ID";
            $db_flight_info_delay = "delay";
            $db_flight_info_distance = "distance";

            
            
        $db_flight_info_tab = "flight_info";
            $db_flight_info_id= "flight_info_ID";
            $db_flight_info_applicationid = "application_ID";
            $db_flight_info_flightid = "flight_ID";
            $db_flight_info_nextflight = "next_flight_info_ID";
            
            
         
            
       //informacje o zg³oszeniu
        $db_application_tab = "application";
            $db_application_id = "application_ID";
            $db_application_incident = "incident"; // co sie sta³o
            $db_application_cause = "cause"; //powód
            $db_application_delay = "delay"; // opóŸnienie
            $db_application_cancel = "cancellation_information"; // kiedy poinformowali o odwo³aniu lotu
            $db_application_resignation = "resignation"; // czy klient zrezygnowa³ z lotu w zamian za korzyœci
            $db_application_permission = "permission "; // czy by³a zgoda na zmianê planu podró¿y  
            $db_application_compensation_amout = "compensation_amount";
            $db_application_boarding = "boarding_pass/res"; // karta pok³adowa lub rezerwacja
            $db_application_compensationid = "compensation_ID";
            
       
        //informacje o zg³oszonych lotach
        $db_flight_tab = "flight";
            $db_flight_id = "flight_ID";
            $db_flight_departureid = "departure_ID"; //odlot
            $db_flight_arrivalid = "arrival_ID"; // przylot
            $db_flight_number = "flight_number"; //numer lotu
            $db_flight_date = "flight_date"; // data lotu
            $db_flight_airlineid = "airline_ID"; // linie lotnicze 
        
            
            
        //informacje o sposobie wyp³aty odszkodowania
        $db_compensation_tab = "compensation";
            $db_compensation_id = "compensation_ID";
            $db_compensation_type = "type";  // express czy standard
            $db_compensation_payment = "payment"; // sposób wyp³aty
            $db_compensation_currency = "currency"; // waluta
            $db_compensation_account = "account"; // numer konta/ PayPal
?>  