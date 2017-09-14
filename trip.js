$(document).ready(function(){   

    $.ajax({
        url: "trip.php",
        dataType: "jsonp",
        cache: true,
        success: function(data){
            data.forEach(populatePage(item, index));
        }
    });

    function populatePage(item, index){
        $(".flight").last().clone().appendTo(".flights");    
        $(".flight").last().html("<a href = 'compensation_form.html' data-flight = '"+ item['flight_info']['id']+"'>" + item['flight_info']['flight_date'] +"</a>");
    };
});