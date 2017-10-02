<?php
//zawiera spis nazw tabel i pól z bazy danych
        $db_users_tab = 'users';
            $db_users_id = 'user_ID';
            $db_users_login = 'login';
            $db_users_pass = 'password';
            $db_users_fname = 'first_name';
            $db_users_lname = 'last_name';
            $db_users_email = 'email';
            $db_users_function = 'user_function';
                
                
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
        $db_airlines_tab = 'airlines';
            $db_airlines_id = "id";
            $db_airlines_operator = "operator_name";
            $db_airlines_IATA = "IATA_code";
            $db_airlines_countrycode = "country_code";
            $db_airlines_name = "country_name";
            $db_airlines_region = "region";
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
            
            
       //informacje o pasażerach    
        $db_passengers_tab = "passengers_details";
            $db_passengers_id = "id";
            $db_passengers_firstname = "first_name"; 
            $db_passengers_lastname = "last_name";  
            $db_passengers_address = "address"; 
            $db_passengers_zipcode = "zip_code";
            $db_passengers_city = "city";  
            $db_passengers_country = "country";  
            $db_passengers_email = "email"; 
            $db_passengers_telnumber = "tel_number"; 
            $db_passengers_passport = "passport"; 
            $db_passengers_idcard1 = "IDcard1"; 
            $db_passengers_idcard2 = "IDcard2"; 
            
            
            
           
        $db_connect_tab = "connect" ;
            $db_connect_id = "id";
            $db_connect_passenger_id = "passenger_ID";
            $db_connect_trip_id = "trip_ID";
            $db_connect_boarding = "boarding_pass"; 
            $db_connect_reservation = "reservation"; 
            
        //informacje o grupie lotów
        $db_trip_tab = "trip";
            $db_trip_id = "id";
            $db_trip_first_flight_info_id = "flight_info_ID";
            $db_trip_delay = "delay";
            $db_trip_sum = "sum";
            $db_trip_string_id = "string_id";
            $db_trip_campaign = "campaign_id";
            $db_trip_status = "status";

            
         //grupy lotów   
        $db_flight_info_tab = "flight_info";
            $db_flight_info_id= "id";
            $db_flight_info_tripid = "trip_id";
            $db_flight_info_departureid = "departure_id"; //odlot
            $db_flight_info_arrivalid = "arrival_id"; // przylot
            $db_flight_info_applicationid = "application_ID";
            $db_flight_info_nextflight = "next_flight_info_ID";
            $db_flight_info_flightid = "flight_ID";
            $db_flight_info_order = "order";
            
            
         
            
       //informacje o zgłoszeniu
        $db_application_tab = "application";
            $db_application_id = "id";
            $db_application_incident = "incident"; // co sie stało
            $db_application_cause = "cause"; //powód
            $db_application_delay = "delay"; // opóźnienie
            $db_application_cancel = "cancellation_information"; // kiedy poinformowali o odwołaniu lotu
            $db_application_resignation = "resignation"; // czy klient zrezygnować z lotu w zamian za korzy?ci 
            $db_application_compensationid = "compensation_ID";
            
       
        //informacje o zgłoszonych lotach
        $db_flight_tab = "flight";
            $db_flight_id = "id";
            $db_flight_departureid = "departure_ID"; //odlot
            $db_flight_arrivalid = "arrival_ID"; // przylot
            $db_flight_number = "flight_number"; //numer lotu
            $db_flight_date = "flight_date"; // data lotu
            $db_flight_airlineid = "airline_ID"; // linie lotnicze 
            $db_flight_distance = "distance";
            $db_flight_compensation = "compensation_availability"; //czy lot nadaje sie do odszkodowania
            
        //informacje o sposobie wypłaty odszkodowania
        $db_compensation_tab = "compensation";
            $db_compensation_id = "id";
            $db_compensation_type = "type";  // express czy standard
            $db_compensation_payment = "payment"; // sposób wypłaty
            $db_compensation_currency = "currency"; // waluta
            $db_compensation_account = "account"; // numer konta/ PayPal
                
                           
?>
