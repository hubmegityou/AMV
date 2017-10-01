jQuery(document).ready(function(){   
    addHandlers();
    //$('#step1 > div').slice(-3).hide();
    //hide all unnecessary elements
    $("#buttons").nextAll().hide();
    $('#Y').on('click', Ybutton);
    $('#N').on('click', Nbutton);
    $('form > .answer > div > label > img').click(function(element){
        show_variant(element.target);
    });
    $('form').find("img").not("img[name]").on('click', show_next);
    $(".btn_next").click(submit_forms);

    function submit_forms(){
        $("form").each(function(){
            if(!$(this).find("[name=departure-code]").val()){
                return true;
            }
            $.post("submit_form.php", $(this).serialize(), function(data){console.log(data);});
            
            //$(this).ajaxSubmit({url: 'submit_form.php', type: 'post', success: function(data){console.log(data);}});
            /*
            $.ajax({
                url: "submit_form.php",
                dataType: "html",
                cache: true,
                success: function(data){
                    console.log(data);
                }
            });
            */
        });
    }

    var time = 300;
    
    function Ybutton(){
        $("form:first").find("[name=departure-code]").val("");
        $("form:first").find("[name=destination-code]").val("");
        $('#transfer').show(time);
        $('form').hide();
        $('form').next().hide();
        secondPart($(this));
        $(this).parent().siblings().slice(8,10).hide(time);
        $('html,body').animate({scrollTop: $('#transfer').offset().top}, time);
    }
    
    function Nbutton(){
        //fix it
        $("form:not(:first)").remove();
        $("#trips").hide();
        var dep_code = $("[name=departure]").attr("data-code");
        var dest_code = $("[name=destination]").attr("data-code");
        var dep_name = $("[name=departure]").attr("data-name");
        var dest_name = $("[name=destination]").attr("data-name");
        // For some browsers, `attr` is undefined; for others,
        // `attr` is false.  Check for both
        
        $('#transfer').hide().delay(time);
        if (!((typeof dep_code !== typeof undefined && dep_code !== false) && (typeof dest_code !== typeof undefined && dest_code !== false))){
            return;
        }
        
        //fillRoute([dep_name, dep_code, dest_name, dest_code]);
        $("form > div.question").children().html(dep_name + " ("+ dep_code+") - "+ dest_name + " ("+ dest_code+") </br>");        
        $('form').show(time);
        $("form").find("[name=departure-code]").val(dep_code);
        $("form").find("[name=destination-code]").val(dest_code);
        secondPart($(this));
        $('html,body').animate({scrollTop: $('form').first().offset().top}, time);
    }
    
    function fillRoute(array){
        //array.length
        $("form > div.question").children().html(dep_name + " ("+ dep_code+") - "+ dest_name + " ("+ dest_code+") </br>");
        
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
    
    function show_variant(element){
        $("form > .variants").nextAll().hide(time);
        var object = $(element);
        object.parents(".variants").find(".active").removeClass("active");
        object.addClass("active");
        var variant = object.parents("form").find("[name="+object.attr("name")+"]");
        variant.find(".question:not(:first), .answer:not(:first)").hide();
        variant.show(time);
        $('html,body').animate({scrollTop: variant.offset().top}, time);    
    }
    
    function show_next(){
        $(this).closest(".answer").find(".active").removeClass("active");
        $(this).addClass("active");
        next = $(this).closest(".answer").nextAll().slice(0, 2);
        if(!next.length){
            $(".navigation").show();
            next = $(this).parents("form").find(".flights").last();
        }
        next.show();
        $('html,body').animate({scrollTop: next.offset().top}, time);
    }
    
    $("#transfer > .answer > div > label > img").click(function(){
        if (!check_waypoints()){return;}
        clean_waypoints();
        
        $('#trips').show();
        fill_trips();
//        check_entitlement(1);
//        fill_data("trips");
        
        //add buttons
       // clean_trips();
        
        /*
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
            };
        }); */
        
    });

    function fill_trips(){
       
        $("#trips > div > input:visible").remove();
        var waypoints = $('#waypoints > input:visible');
        var length = waypoints.length;

        waypoints.each(function(index){
            if(index === 0){
                fill_flight_buttons($("[name=departure]"), $(this), index);
            } else {
                fill_flight_buttons($(waypoints[index-1]), $(this), index);
            }
            if (index === (length - 1)){
                fill_flight_buttons($(this), $("[name=destination]"), index + 1 );
            }
        });
    };

    function fill_flight_buttons(departure, destination, index){
        var dep_code = departure.attr("data-code");
        var dep_name = departure.attr("data-name");
        var dest_code = destination.attr("data-code");
        var dest_name = destination.attr("data-name");
        var name = String(index + 1)+". "+ dep_name + " (" + dep_code + ") - "+ dest_name + " (" + dest_code + ")";
        var button = $("#trips > div > input:hidden").clone().appendTo("#trips > .answer").show().val(name).attr('data-dep-code', dep_code).attr('data-dest-code', dest_code).attr('data-index', index);
        button.click(function(element){
            $(this).toggleClass('active_btn');
            render_form(element.target);
        });
    };

    function render_form(button){
        var dep_code = $(button).attr('data-dep-code');
        var dest_code = $(button).attr('data-dest-code');
        var form_index = parseInt($(button).attr('data-index'));
        var flag = false;
        var forms = $("form"); 
        forms.each(function(){
            if($(this).find("[name=departure-code]").val() == dep_code){
                $(this).remove();
                flag = true;
                return false;
            }
        });
        if (flag){return;};
        var newform = forms.first().clone();
        newform.attr('data-index', form_index);
        newform.find("[name=departure-code]").val(dep_code);
        newform.find("[name=destination-code]").val(dest_code);
        
        var inserted = false;
        var length = forms.length;
        forms.each(function(index){
            if(form_index > parseInt($(this).attr('data-index')) && index+1 < length && form_index < parseInt($(forms[index+1]).attr('data-index'))){
                inserted = true;
                newform.insertAfter(this);
                return;
            }
        });
        if(!inserted){
            newform.insertAfter($("form").last());
        }
        newform[0].reset(); //just to be sure, shouldn't be filled
        newform.find(".question > p").html($(button).val());
        newform.find('.answer > div > img').click(function(element){
            show_variant(element.target);
        });
        newform.find("img").not("img[name]").on('click', show_next);
        newform.show();
    }

    function clean_trips(){
        $('#trips > .answer').children().slice(1).remove();
    }
    
    function addButtons(dpn, dpc, dsn, dsc, id){
        $('#trips > .answer > btn').first().clone().show().appendTo('#trips > .answer').attr('value', dpn + '(' + dpc + ')' + ' ' + dsn + '(' + dsc + ')').attr('data-departure-name',dpn).attr('data-departure-code',dpc).attr('data-destination-name',dsn).attr('data-destination-code',dsc).attr('id', 'button'+id);
    }
    
    function addForms(){
//        $('#trips > .answer > *').slice(1).
    }
    
    function check_waypoints(){
        var flag = false;
        $("#waypoints > input:visible").each(function(){
            if($(this).val() && $(this).attr('data-code')){
                flag = true;
                return false;
            }
        });
        return flag;
    }
    function clean_waypoints(){
        $("#waypoints > input:visible").each(function(){
            if(!$(this).attr('data-code')){
                $(this).remove();
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
