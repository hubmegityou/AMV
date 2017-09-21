jQuery(document).ready(function(){   
    addHandlers();
    check();
    payOption();

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

$('#click1').on('click', showQuestion);
$('#click2').on('click', showQuestion);
$('#click3').on('click', showQuestion);

function showQuestion(){
    var id = parseInt($(this).attr('id').slice(-1));
//    var id2 = (id + 1) % 3 + 1; //1>3 (2), 2>1 (3), 3>2 (1)
//    var id3 = 
    switch(id){
        case 1: var id2 = 2;
                var id3 = 3;
                break;
        case 2: var id2 = 3;
                var id3 = 1;
                break;
        case 3: var id2 = 2;
                var id3 = 1;
                break;
    }
    $('#ver'+id2).hide();
    $('#ver'+id3).hide();
    $('#ver'+id).show(1000);
    $('#step1 > div').slice(-2).show();
    $('html,body').animate({scrollTop: $('#ver'+id).offset().top}, time);    
}

// zaznaczanie i odznaczanie wszystkich checkboxów

function check(){
    $("#checkAll").change(function() {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
        checkagreement();
    })}





function payOption(){
    
    $("#paypalOption").hide();
    $("#accountOption").hide();
    
    $('#paypal').click(function(){
        $("#paypalOption").show(1000);
        $("#accountOption").hide(1000);
    });
    
    $('#account').click(function(){
        $("#paypalOption").hide(1000);
        $("#accountOption").show(1000);
    });
}