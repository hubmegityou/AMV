$(document).ready(function(){   


    //$("#flightForm").on("keyup", "input", autocomplete);
    var autocompleteTable = {
        source: "getData.php"
    };
    
    $("[name=departure]").autocomplete(autocompleteTable);
    $("[name=waypoint]").autocomplete(autocompleteTable);
    $("[name=destination]").autocomplete(autocompleteTable);


    $("#waypoints").on("focusout", "input", addWaypoint);

    function addWaypoint(){
        if( !$(this).hasClass("last") && $(this).val() == ''){ $(".last").remove(); return;}
        if( !$(this).hasClass("last")) return; 
        if( $(this).val() == '' ) return;
        $(this).removeClass("last");
        $(this).clone().val('').addClass("last").appendTo("#waypoints");       
    }


});