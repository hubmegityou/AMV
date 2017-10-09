<?php

require "database/dbinfo.php";

$value_to_number = array(
    //incident
    "delayed" => 1,
    "cancelled" => 2,
    "overbooked" => 3,

    //delay and cancellation reason
    "technical" => 1,
    "weather" => 2,
    "other_flights" => 3,
    "airport" => 4,
    "strike" => 5,
    "not_known" => 6,
    "i_dont_know" => 7,

    //delay time
    "lt3" => 1,
    "mt3" => 2,
    "havent_arrived" => 3,

    //cancellation info
    "lt14" => 1,
    "mt14" => 2,

    //cancellation time
    "lt2" => 1,
    "2_3" => 2,
    "3_4" => 3,
    "mt4" => 4,

    //overbooking voluntary resignation
    "yes" => 1,
    "no" => 2
);

$name_to_tab_and_column = array(
    "finaldelay" => array($db_trip_tab, $db_trip_delay),  
    "reason" => array($db_application_tab, $db_application_incident),
    "delayreason" => array($db_application_tab, $db_application_cause),
    "delaytime" => array($db_application_tab, $db_application_delay),

    "cancellationinfo" => array($db_application_tab, $db_application_cancel),
    "cancellationtime" => array($db_application_tab, $db_application_delay),
    "overbookingresignation" => array($db_application_tab, $db_application_resignation), 

    //"airlines" => array($db_flight_tab, $db_flight_ ?? ,
    "fnumber" => array($db_flight_tab, $db_flight_number),
    "date" => array($db_flight_tab, $db_flight_date)
);

?>