jQuery(document).ready(function(){   
    addHandlers();
    //$('#step1 > div').slice(-3).hide();
    //hide all unnecessary elements
    $("#buttons").nextAll().hide();
    $('#Y').on('click', Ybutton);
    $('#N').on('click', Nbutton);
    $('#click1').on('click', showQuestion);
    $('#click2').on('click', showQuestion);
    $('#click3').on('click', showQuestion);
    $('img').not("img[id^='click']").on('click', imgMove);
    
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
    
    function showQuestion(){
        var id = parseInt($(this).attr('id').slice(-1));
        var id2 = id % 3 + 1;
        var id3 = (id + 1) % 3 + 1;
        $('#ver'+id2).hide();
        $('#ver'+id3).hide();
        $('#ver'+id).show(1000);
        $('#step1 > div').slice(-2).show();
        $('#ver3').next().show();
        $('html,body').animate({scrollTop: $('#ver'+id).offset().top}, time);    
    }
    
    function imgMove(){
        var elem = $(this).parent().parent().parent().parent();
        if (!elem.next().length){
            var elem = $('#ver3');
        }
        $(this).addClass('active_img');
        elem.next().show();
        $('html,body').animate({scrollTop: elem.next().offset().top}, time);
    }
    
    $("#transfer > .answer > div > label > img ").click(function(){
//        if (!check_waypoints()){return;}
        $('#trips').show();
//        clean_waypoints();
//        check_entitlement(1);
//        fill_data("trips");
        
        //add buttons
        clean_trips();
        var id = 1;
        var dep_code = $("[name=departure]").attr("data-code");
        var dep_name = $("[name=departure]").attr("data-name");
        $('#waypoints > input').slice(1).each(function(){
            var dest_code = $(this).attr("data-code");
            var dest_name = $(this).attr("data-name");
            addButtons(dep_name, dep_code, dest_name, dest_code, id);
            dep_name = dest_name;
            dep_code = dest_code;
            id++;
        });
        var dest_code = $("[name=destination]").attr("data-code");
        var dest_name = $("[name=destination]").attr("data-name");
        addButtons(dep_name, dep_code, dest_name, dest_code, id);
        
        //add onclick function
        console.log($('#trips > .answer > input').slice(1).length);
        //FIX IT!!!!
        //to nie działa
        $('#trips > .answer > input').slice(1).on('click', function(){
            var id = $(this).attr('id').val().slice(-1);
            if ($(this).hasClass('active_btn')){
                $(this).removeClass('active_btn');
                //usunięcie formularza
                $('#form' + id).remove();
            }
            else{
                $(this).addClass('active_btn');
                $('#form').clone().attr('id', 'form' + id).appendTo('#step1');
                //coś w tym stylu ale nie wiem jak to zaklepać
                "<input type='hidden' name='departure-name' value='"+$(this).attr('data-departure-name').val()+"'/>".appendTo('#form'+id);
                "<input type='hidden' name='departure-code' value='"+$(this).attr('data-departure-code').val()+"'/>".appendTo('#form'+id);
                "<input type='hidden' name='destination-name' value='"+$(this).attr('data-destination-name').val()+"'/>".appendTo('#form'+id);
                "<input type='hidden' name='destination-code' value='"+$(this).attr('data-destination-code').val()+"'/>".appendTo('#form'+id);
            }
        });
    });
    
    function clean_trips(){
        $('#trips > .answer').children().slice(1).remove();
    }
    
    function addButtons(dpn, dpc, dsn, dsc, id){
        $('#trips > .answer > input:hidden').first().clone().show().appendTo('#trips > .answer').attr('value', dpn + '(' + dpc + ')' + ' ' + dsn + '(' + dsc + ')').attr('data-departure-name',dpn).attr('data-departure-code',dpc).attr('data-destination-name',dsn).attr('data-destination-code',dsc).attr('id', 'button'+id);
    }
    
    function addForms(){
//        $('#trips > .answer > *').slice(1).
    }
    
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
