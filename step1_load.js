
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
        }
    });
});

function load_one(data){
    $("input[name=departure]").attr("data-code", data["dep_IATA"]).attr("data-name", data["dep_city"]).val(data["dep_city"]+", "+data["dep_name"]+", "+data["dep_IATA"]+", "+data["dep_country"]).addClass("correct");
    $("input[name=destination]").attr("data-code", data["dest_IATA"]).attr("data-name", data["dest_city"]).val(data["dest_city"]+", "+data["dest_name"]+", "+data["dest_IATA"]+", "+data["dest_country"]).addClass("correct");
    $("#N").click();
    var incident =  data["incident"] - 1;
    $(".variants > div > label > img").eq(incident).click();
    var div = $("div[name=delayed], div[name=cancelled], div[name=overbooked]").eq(incident);
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
    var flights = $("div.flights:last");
    flights.find("input[name=fnumber]").val(data["flight_number"]);
    flights.find("input[name=date]").val(data["flight_date"]);
    flights.find("input[name=airline-code]").val(data["airline_IATA"]);
    flights.find("input[name=airlines]").attr("data-code", data["airline_IATA"]).val(data["airline_name"]+", "+data["airline_country"]).addClass("correct");
    $("html, body").animate({ scrollTop: $(document).height() + 5000 }, 300);
}
function load_many(data){

}

