jQuery.fn.extend({
    airport: function() {
        this.each(function(){
            $(this).autocomplete({
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
                    $(this).removeClass("error");
                    $(this).addClass("correct");
                    return;
                },
                change: function (event, ui) {
                    if (!ui.item) {
                        $(this).removeClass("correct");
                        $(this).val("");
                        $(this).attr("data-code", "");
                        $(this).attr("data-name", "");
                    } 
                }
            });
        });
    },
    airline: function() {
        this.each(function(){
            $(this).autocomplete({
                source: "getData.php?type=airline",
                select: function(event, ui) {
                    event.preventDefault();
                    $(this).val(ui.item['label']);
                    $(this).attr('data-code', ui.item['value']);
                    $(".flights > [name=airline-code]").val(ui.item['value']);
                    $(this).removeClass("error");
                    $(this).addClass("correct");
                },
                change: function (event, ui) {
                    if (!ui.item) {
                        $(this).removeClass("correct");
                        $(this).val("");
                        // Handle the error
                    } 
                }
            });
        });
    }
});

function validate(objects, event){ // only 2 objects 
    if(objects.first().attr("data-code") == objects.last().attr("data-code")){
        objects.each(function(){
            $(this).addClass("error");
        });       
        event.stopImmediatePropagation();
        return false;
    }
    $.when(
        $.ajax({
            url: "getData.php",
            dataType: "json",
            data: {
                type: "region",
                term: objects.first().attr("data-code")
            },
            cache: false,
        }),
        $.ajax({
            url: "getData.php",
            dataType: "json",
            data: {
                type: "region",
                term: objects.last().attr("data-code")
            },
            cache: false,
        })
    )
    .then(function(response1, response2) {
        if(response1[0] != "EUR" && response2[0] != "EUR"){
            gtfo();
        } 
    })
    .fail(function(err) {
        console.log('Something went wrong', err);
    });
}
function gtfo(){
    $(location).attr('href', '/nope.html');        
}
function next_submits(){
    var flag = false;
    $("form:not([name=all], :last)").each(function(){
        if(!$(this).find("[name=departure-code]").val()){
            return true;
        }
        $.post("submit_form.php", $(this).serialize(), function(data){
            console.log(data);
            if(data == "false"){
                alert("Lot " + $(this).find("[name=departure-code]").val() + " - " + $(this).find("[name=destination-code]").val() + " został odrzucony");
            }else{
                flag = true;
            }
        });
    });
    $.post("submit_form.php", $("form:last").serialize(), function(data){
        console.log(data);
        if(data == "false"){
            alert("Lot " + $("form:last").find("[name=departure-code]").val() + " - " + $("form:last").find("[name=destination-code]").val() + " został odrzucony");
            if(!flag){
                gtfo();
            }
        }else{
            get_page(current_step + 1);
        }
    });
}

function submit_forms(){
    check_entitlement();
    $.post("submit_form.php?type=flights", $("form[name=all]").serialize(), function(data){console.log(data)}).success(next_submits);
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
    $("form:not([name=default], [name=all])").remove();
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
    $("form[name=all] > input:not(:first)").remove();
    $("form[name=all] > input").first().clone().val(dep_code+"-"+dest_code).appendTo("form[name=all]");
    //fillRoute([dep_name, dep_code, dest_name, dest_code]);
    $("form[name=default] > div.question").children().html(dep_name + " ("+ dep_code+") - "+ dest_name + " ("+ dest_code+") </br>");        
    $("form[name=default]").show(time);
    $("form[name=default]").find("[name=departure-code]").val(dep_code);
    $("form[name=default]").find("[name=destination-code]").val(dest_code);
    secondPart($(this));
    $('html,body').animate({scrollTop: $('form[name=default]').offset().top}, time);
}

function fillRoute(array){
    //array.length
    $("form > div.question").children().html(dep_name + " ("+ dep_code+") - "+ dest_name + " ("+ dest_code+") </br>");
    
}

function secondPart(e){
    e.addClass('active');
    var id = e.attr('id');
    if (id == 'N'){
        id = 'Y';
    }
    else{
        id = 'N';
    }
    $('#'+id).removeClass('active');
}

function show_variant(element){
    var object = $(element);
    object.parents("form").find(".variants").nextAll().hide(time);
    object.parents("form")[0].reset();
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
    var button = $("#trips > div > input:first").clone().appendTo("#trips > .answer").show().val(name).attr('data-dep-code', dep_code).attr('data-dest-code', dest_code).attr('data-index', index);
    $("form[name=all] > input").first().clone().val(dep_code+"-"+dest_code).appendTo("form[name=all]");
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
    var forms = $("form:not([name=all])"); 
    forms.each(function(){
        if($(this).find("[name=departure-code]").val() === dep_code && $(this).find("[name=destination-code]").val() === dest_code){
            $(this).remove();
            flag = true;
            return false;
        }
    });
    if (flag){return;};
    var newform = forms.filter("[name=default]").first().clone();
    newform.attr("name", "");
    newform.attr('data-index', form_index);
    newform.find("[name=departure-code]").val(dep_code);
    newform.find("[name=destination-code]").val(dest_code);
    
    var inserted = false;
    var length = forms.length;
    forms.each(function(index){
        if(form_index > parseInt($(this).attr('data-index')) && index+1 < length && form_index < parseInt($(forms[index+1]).attr('data-index'))){
            inserted = true;
            newform.insertAfter(this);
            return false;
        }
    });
    if(!inserted){
        newform.insertAfter($("form").last());
    }
    newform[0].reset(); //just to be sure, shouldn't be filled
    newform.find(".question > p").html($(button).val());
    newform.find('.answer > div > label > img[name]').click(function(element){
        show_variant(element.target);
    });
    newform.find("img").not("img[name]").on('click', show_next);
    newform.find(".btn_yes, .btn_no").click(show_next);
    newform.find("[name=airlines]").airline();
    newform.show();
}

function clean_trips(){
    $('#trips > .answer').children().slice(1).remove();
}

function check_waypoints(){
    var flag = false;
    $("#waypoints > input:visible").each(function(){
        if($(this).val() && $(this).attr('data-code')){
            flag = true;
            //return false;
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

function check_entitlement(){
    if($("#N").hasClass("active")){
        check_entitlement_one();
    }
}

function check_entitlement_one(){
    $("forms:not([name=all])").first(function(){
        $.when(
            $.ajax({
                url: "getData.php",
                dataType: "json",
                data: {
                    type: "region",
                    term: $(this).find("[name=departure-code]").val()
                },
                cache: false,
            }),
            $.ajax({
                url: "getData.php",
                dataType: "json",
                data: {
                    type: "region",
                    term: $(this).find("[name=destination-code]").val()
                },
                cache: false,
            }),
            $.ajax({
                url: "getData.php",
                dataType: "json",
                data: {
                    type: "airline_region",
                    term: $(this).find("[name=airlines]").attr("data-code")
                },
                cache: false,
            })
        )
        .then(function(response1, response2, response3) {
            if(response1[0] != "EUR" && response2[0] == "EUR" && response3[0] != "EUR"){
                gtfo();
                //$(this).remove();
                //alert("Za lot "+$(this).find("[name=departure-code]")+" - "+$(this).find("[name=departure-code]")+" nie przysługuje odszkodowanie");
            }
        })
        .fail(function(err) {
            console.log('Something went wrong', err);
        });
        
    });

}


function addHandlers(){
    
    $("[name=departure], [name=waypoint], [name=destination]").airport();            
    $("[name=airlines]").airline();
};

function addWaypoint(){
    $("#waypoints > input:hidden").first().clone().show().appendTo("#waypoints").airport();       
};

jQuery(document).ready(function(){   
    addHandlers();
    //$('#step1 > div').slice(-3).hide();
    //hide all unnecessary elements
    $("#buttons").nextAll().hide();
    $('#Y').click(Ybutton);
    $("#N").click(function(event){validate($("[name=departure], [name=destination]"), event)});
    $('#N').click(Nbutton);
    $('form > .answer > div > label > img').click(function(element){
        show_variant(element.target);
    });
    $("form").find("img").not("img[name]").on('click', show_next);
    $(".btn_yes, .btn_no").click(show_next);
    $(".btn_next").click(submit_forms);
    $("#transfer > .answer > div > label > img").click(function(){
        if (!check_waypoints()){
            return;
        }
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
   $("#add_waypoint").click(addWaypoint);
});
