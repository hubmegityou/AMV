
function submit_passenger(){
    verify_passenger();
    $.post("submit_passenger.php", $("#passenger").serialize(), function(data){console.log(data)}).success(load_passengers);
}
function load_passengers(){
    $.ajax({
        url: "getData.php",
        dataType: "json",
        data: {
            type: "passengers"
        },
        cache: false,
        success: function(data){
            fill_passengers(data);
        }        
    });
}
function fill_passengers(data){
    $("#passengers_details").html("");
    data.forEach(function(item, index){
        $(item).append_to("#passengers_details");

    });

}
function add_contact_data(){};

function add_passenger(){
    submit_passenger();
    $("#passenger")[0].reset();
}

function edit_passenger(element){
    var index = $(element).attr("data-index");
    $.ajax({
        url: "getData.php",
        dataType: "json",
        data: {
            type: "passengers"
        },
        cache: false,
        success: function(data){
            fill_form(data[index]);
        }        
    });
}
function fill_form(data){

}

$(document).ready(function(){
    $("#add_passenger").click(add_passenger);
    $(".btn_next").click(add_contact_data);
});
