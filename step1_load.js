
jQuery(document).ready(function(){   
    $.ajax({
        url: "get_filled.php",
        dataType: "json",
        data: {
            step: 1
        },
        cache: false,
        success: function(data){
            if(data instanceof Array){
                load_many(data);
            }else if(data instanceof Object && Object.keys(data).length > 5){
                load_one(data);
            }
            $("html, body").animate({ scrollTop: $(document).height() + 5000 }, 300);
        }
    });
});

function load_one(data){
    $("input[name=departure]").attr("data-code", data["dep_IATA"]).attr("data-name", data["dep_city"]).val(data["dep_city"]+", "+data["dep_name"]+", "+data["dep_IATA"]+", "+data["dep_country"]).addClass("correct");
    $("input[name=destination]").attr("data-code", data["dest_IATA"]).attr("data-name", data["dest_city"]).val(data["dest_city"]+", "+data["dest_name"]+", "+data["dest_IATA"]+", "+data["dest_country"]).addClass("correct");
    $("#N").click();
    fill_form($("form:last"), data);
}

function fill_form(form, data){
    var incident =  data["incident"] - 1;
    form.find(".variants > div > label > img").eq(incident).click();
    var div = form.find("div[name=delayed], div[name=cancelled], div[name=overbooked]").eq(incident);
    switch(incident){
        case 0:
            div.find(".answer:first > div > label > img").eq(data["cause"] - 1).click();
            div.find(".answer").eq(1).find("div > label > img").eq(data["delay"] - 1).click();
            break;
        case 1:
            div.find(".answer:first > div > label > img").eq(data["cancellation_information"] - 1).click();
            div.find(".answer").eq(1).find("div > label > img").eq(data["cause"] - 1).click();
            div.find(".answer").eq(1).find("div > label > img").eq(data["delay"] - 1).click();
            break;
        case 2:
            div.find(".answer:first > label").eq(data["resignation"] - 1).click();
            break;

    }
    var flights = form.find("div.flights:last");
    flights.find("input[name=fnumber]").val(data["flight_number"]);
    flights.find("input[name=date]").val(data["flight_date"]);
    flights.find("input[name=airline-code]").val(data["airline_IATA"]);
    flights.find("input[name=airlines]").attr("data-code", data["airline_IATA"]).val(data["airline_name"]+", "+data["airline_country"]).addClass("correct");
}
function load_many(data){
    $("input[name=departure]").attr("data-code", data[0]["dep_IATA"]).attr("data-name", data[0]["dep_city"]).val(data[0]["dep_city"]+", "+data[0]["dep_name"]+", "+data[0]["dep_IATA"]+", "+data[0]["dep_country"]).addClass("correct");
    $("input[name=destination]").attr("data-code", data[data.length - 1]["dest_IATA"]).attr("data-name", data[data.length - 1]["dest_city"]).val(data[data.length - 1]["dest_city"]+", "+data[data.length - 1]["dest_name"]+", "+data[data.length - 1]["dest_IATA"]+", "+data[data.length - 1]["dest_country"]).addClass("correct");
    $("#Y").click();
    var n_of_flights = data.length;
    for(var i = 1; i < data.length; i++){
        $("#waypoints > input:last").attr("data-code", data[i]["dep_IATA"]).attr("data-name", data[i]["dep_city"]).val(data[i]["dep_city"]+", "+data[i]["dep_name"]+", "+data[i]["dep_IATA"]+", "+data[i]["dep_country"]).addClass("correct");
        $("#add_waypoint").click();
    }
    $.ajax({
        url: "get_filled.php",
        dataType: "json",
        data: {
            step: "final"
        },
        cache: false,
        success: function(finaldelay){
            if(finaldelay instanceof Object){
                load_many_two(data, finaldelay);
            }
        }
    });
}
function load_many_two(data, finaldelay){
    $("#transfer > form > .answer:first").find("div > label > img").eq(finaldelay["final_delay"] - 1).click();
    data.forEach(function(item, index){
        if(item["id"] != null){
            $("#trips > .answer:first").find("input:not(:hidden)").eq(index).click();
            fill_form($("form[data-index="+index+"]"), item);
        }
    });
    $("html, body").animate({ scrollTop: $(document).height() + 5000 }, 300);    
}
