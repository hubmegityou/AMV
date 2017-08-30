     
var id=2; 
     
     
  // wyświetlanie podpowiedzi przy wpisywaniu danych lotu    
function autocomplete_input ( url, input){
    
    $(document).ready(function(){  
    $.post(url, { /**/ }, showResult, "text");  
});

function showResult(res){
    var obj = JSON.parse(res);
    $("input[id="+input+"]").autocomplete({
    source: obj
  });
}}


//funckja dodająca kolejne pola z przesiadkami

function addInput(){
    
    var new_label=$("<label>");
    var new_dep = $("<input>");
    var new_label_airlines=$("<label>");
    var new_dep_airlines = $("<input>");
    
    
    new_label.attr("for", "change");
    new_label.html(" lotnisko: ");
    new_dep.attr("type", "text");
    new_dep.attr("name", "change"+id);
    new_dep.attr("id", "flight");
    $("#ui-widget").append(new_label);
    $("#ui-widget").append(new_dep);
    
    new_label_airlines.attr("for", "airlines");
    new_label_airlines.html(" nazwa przewoźnika: ");
    new_dep_airlines.attr("type", "text");
    new_dep_airlines.attr("name", "airlines"+id);
    new_dep_airlines.attr("id", "airlines");
    $("#ui-widget").append(new_label_airlines);
    $("#ui-widget").append(new_dep_airlines);
    
    id=id+1;
    
   reloadAutocomplete()
    
}

// ponowne wywołanie funkcji odpowiadającej za wyświetlanie podpowiedzi
function reloadAutocomplete(){
    autocomplete_input("getAPIAirports.php", "flight");
    autocomplete_input("getAPIAirlines.php", "airlines");
}

// lot z przesiadką-> umozliwienie dodawania przesiadek

function change(){
    $('#change').hide();
    addInput();
    $('#addinputbutton').show(); 
    $('#nextbutton').show();
}

// lot bez przesiadki-> przejście do dalszej cześci formularza
function nochange(){
   window.location.replace("submitFlightForm.php") ;
}




window.onload=reloadAutocomplete();