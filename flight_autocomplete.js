$(document).ready(function(){   


    //$("#flightForm").on("keyup", "input", autocomplete);
    var airport = {
        source: "getData.php?type=airport"
    };
    var airlines = {
        source: "getData.php?type=airline"
    };    
    $("[name=departure]").autocomplete(airport);
    $("[name=waypoint]").autocomplete(airport);
    $("[name=destination]").autocomplete(airport);
    $("[name=airlines]").autocomplete(airlines);
    

    $("#waypoints").on("focusout", "input", addWaypoint);

    function addWaypoint(){
        if( !$(this).hasClass("last") && $(this).val() == ''){ $(".last").remove(); return;}
        if( !$(this).hasClass("last")) return; 
        if( $(this).val() == '' ) return;
        $(this).removeClass("last");
        $(this).clone().val('').addClass("last").appendTo("#waypoints");       
    }


});