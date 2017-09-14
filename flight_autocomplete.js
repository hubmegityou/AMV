$(document).ready(function(){   
    addHandlers();
    

    //$("#flightForm").on("keyup", "input", autocomplete);
    function addHandlers(){
        $("[name=departure], [name=waypoint0], [name=destination]").autocomplete({
            source: "getData.php?type=airport",
           /* close: function(event, ui) {
                if (!$("ul.ui-autocomplete").is(":visible")) {
                    $("ul.ui-autocomplete").show();
                    return false;
                }
            },*/
            select: function(event, ui) {
                event.preventDefault();
                $(this).val(ui.item['label']);
                $(this).attr('data-code', ui.item['value']);
                return;
            }
        });
            
            //source: function(request,response){search(request, response);}});
        $("[name=airlines]").autocomplete({
            source: "getData.php?type=airline",
            select: function(event, ui) {
                event.preventDefault();
                $(this).val(ui.item['label']);
                $(this).attr('data-code', ui.item['value']);
                return;
            }
        });
    };

    
    
    $("#waypoints").on("keyup", "input", addWaypoint);

    function addWaypoint(){
        if( !$(this).hasClass("last") && $(this).val() == ''){ $(".last").remove(); return;}
        if( !$(this).hasClass("last")) return; 
        if( $(this).val() == '' ) return;
        $(this).removeClass("last");
        $(this).clone().val('').addClass("last").attr("id", parseInt($(this).attr("id"))+1).attr("name", $(this).attr("name").substr(0,8)+(parseInt($(this).attr("id"))+1)).appendTo("#waypoints").autocomplete({
            source: "getData.php?type=airport",
            select: function(event, ui) {
                event.preventDefault();
                $(this).val(ui.item['label']);
                $(this).attr('data-code', ui.item['value']);
                return;
            }
        });       
    }


});