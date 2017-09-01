
     
  // wyświetlanie podpowiedzi przy wpisywaniu danych lotu    
function autocomplete_input (input){
    
    $(document).ready(function(){  
    $.post("getData.php", {input:input}, showResult, "text");  
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

    new_label.attr("class", "sr-only");
    new_label.attr("for", "change");
    new_label.html(" lotnisko: ");
    
    new_dep.attr("type", "text");
    new_dep.attr("name", "change2");
    new_dep.attr("class", "contact-subject form-control");
    new_dep.attr("autocomplete", "off");
    new_dep.attr("placeholder", "miejsce przesiadki... ");
    new_dep.attr("id", "flight");
    $("#ui-widget").append(new_label);
    $("#ui-widget").append(new_dep);
    
    
   reloadAutocomplete()
    
}

// ponowne wywołanie funkcji odpowiadającej za wyświetlanie podpowiedzi
function reloadAutocomplete(){
    autocomplete_input("flight");
    autocomplete_input( "airlines");
}

// lot z przesiadką-> umozliwienie dodawania przesiadek

function change(){
    $('#change').hide();
    addInput();
    $('#nextbutton').show();
}

// lot bez przesiadki-> przejście do dalszej cześci formularza
function nochange(){
   window.location.replace("submitFlightForm.php") ;
}




window.onload=reloadAutocomplete();