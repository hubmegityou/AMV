jQuery(document).ready(function(){   
    addHandlers();
    //$('#step1 > div').slice(-3).hide();
    //hide all unnecessary elements
    $("#buttons").nextAll().hide();
    $('#Y').on('click', Ybutton);
    $('#N').on('click', Nbutton);

    var time = 300;
    
    function Ybutton(){
        $('#transfer').show(time);
        $('#form').hide();
        $('#form').next().hide();
        secondPart($(this));
        $(this).parent().siblings().slice(8,10).hide(time);
        $('html,body').animate({scrollTop: $('#transfer').offset().top}, time);
    }
    
    function Nbutton(){
        //fix it
        var dep_code = $("[name=departure]").attr("data-code");
        var dest_code = $("[name=destination]").attr("data-code");
        var dep_name = $("[name=departure]").attr("data-name");
        var dest_name = $("[name=destination]").attr("data-name");
        // For some browsers, `attr` is undefined; for others,
        // `attr` is false.  Check for both
        
        $('#transfer').hide().delay(time);
        if (!((typeof dep_code !== typeof undefined && dep_code !== false) || (typeof dest_code !== typeof undefined && dest_code !== false))){
            return
        }
        //fillRoute([dep_name, dep_code, dest_name, dest_code]);
        $("#form > div.question").children().html(dep_name + " ("+ dep_code+") - "+ dest_name + " ("+ dest_code+") </br>");        
        $('#form').show(time);
        secondPart($(this));
        $('html,body').animate({scrollTop: $('#form').offset().top}, time);
    }
    function fillRoute(array){
        //array.length
        $("#form > div.question").children().html(dep_name + " ("+ dep_code+") - "+ dest_name + " ("+ dest_code+") </br>");
        
    }
    function secondPart(e){
        e.addClass('active_btn_yn');
        var id = e.attr('id');
        if (id == 'N'){
            id = 'Y';
        }
        else{
            id = 'N';
        }
        $('#'+id).removeClass('active_btn_yn');
    }
    
    $("#transfer > .answer > div > img ").click(function(){
        if (!check_waypoints()){return;} 
        clean_waypoints();
        check_entitlement(1);
        fill_data("trips");
        
    });
    
    function check_waypoints(){
        var flag = false;
        $("#waypoints > input:visible").each(function(){
            if($(this).val() && $(this).attr('data-code')){
               flag = true; 
            }
        });
        if(!flag){return false;}
        return true;
    }
    function clean_waypoints(){
        $("#waypoints > input:visible").each(function(){
            if(!$(this).val()){
                $(this).remove()
            }
        });
    };

    function check_entitlement(index){

    }



    //$("#flightForm").on("keyup", "input", autocomplete);
    function addHandlers(){
        $("[name=departure], [name=waypoint], [name=destination]").autocomplete({
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
                $(this).attr('data-name', ui.item['label'].split(',', 1)[0]);
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

    
    
   $("#add_waypoint").click(addWaypoint);

    function addWaypoint(){
            $("#waypoints > input:hidden").first().clone().show().appendTo("#waypoints").autocomplete({
            source: "getData.php?type=airport",
            select: function(event, ui) {
                event.preventDefault();
                $(this).val(ui.item['label']);
                $(this).attr('data-code', ui.item['value']);
                $(this).attr('data-name', ui.item['label'].split(',', 1)[0]);
                return;
            }
        });       
    };

});
