$(document).ready(function(){   
    var AirportsList;
    var AirlinesList;
    //cacheData();
    
    function cacheData(){

        $.ajax({
            url: "https://v4p4sz5ijk.execute-api.us-east-1.amazonaws.com/anbdata/airports/locations/international-list?api_key=1d2a8cd0-83d5-11e7-a40a-b35c55abe8b5&format=json",
            dataType: "jsonp",
            cache: true,
            success: function(data){
                AirportsList = data;
                getAirlines();
            }
        });
            function getAirlines(){
                $.ajax({
                    url: "https://v4p4sz5ijk.execute-api.us-east-1.amazonaws.com/anbdata/airlines/designators/iosa-registry-list?api_key=1d2a8cd0-83d5-11e7-a40a-b35c55abe8b5&format=json",
                    dataType: "jsonp",
                    cache: true,
                    success: function(data){
                        AirlinesList = data;  
                        addHandlers();
                    }
                });
            };
    };


    //$("#flightForm").on("keyup", "input", autocomplete);
    var airport = {
        source: "getData.php?type=airport"
    };
    var airlines = {
        source: "getData.php?type=airline"
    };    
    function search(request, response){
        var re = new RegExp(request.term, 'i');
        var tab = new Array();
        AirportsList.forEach(function(item, index){
            if (item['countryName'].match(re) || item["cityName"].match(re) || item["airportName"].match(re) || item["airportCode"].match(re)) {
                tab.push({label: item["cityName"]+" "+item["airportName"]+" "+item["countryName"], value:item["airportCode"]}); // do something
            }  
        });
        response(tab);    
    };
    function addHandlers(){
        $("[name=departure]").autocomplete({
            source: airport});

        $("[name=waypoint]").autocomplete({
            source: airport});
        
        $("[name=destination]").autocomplete({
            source: airport});
            
            
            //source: function(request,response){search(request, response);}});
        $("[name=airlines]").autocomplete(airlines);
    };

    
    
    $("#waypoints").on("keyup", "input", addWaypoint);

    function addWaypoint(){
        if( !$(this).hasClass("last") && $(this).val() == ''){ $(".last").remove(); return;}
        if( !$(this).hasClass("last")) return; 
        if( $(this).val() == '' ) return;
        $(this).removeClass("last");
        $(this).clone().val('').addClass("last").appendTo("#waypoints").autocomplete({
            source: function(request,response){search(request, response);}});       
    }


});