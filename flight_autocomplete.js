$(document).ready(function(){   
 
 
 // wyświetlanie podpowiedzi przy wpisywaniu danych lotu    
function autocomplete_input (input){
    
        $.post("getData.php", {input:input}, showResult, "text");  
    
    function showResult(res){
        var obj = JSON.parse(res);
        $("input[id="+input+"]").autocomplete({
            source: obj
        });
}}


//funckja dodająca kolejne pola z przesiadkami

function addInput(){
    
    
    reloadAutocomplete()
    
}

// ponowne wywołanie funkcji odpowiadającej za wyświetlanie podpowiedzi
function reloadAutocomplete(){
    autocomplete_input("flight");
    autocomplete_input( "airlines");
}

// lot z przesiadką-> umozliwienie dodawania przesiadek

$("#waypoints").on("keyup", "input", addWaypoint);

function addWaypoint(){
    if( !$(this).hasClass("last") ) return;
    if( $(this).val() == '' ) return;
    $(this).removeClass("last");
    $(this).clone().val('').addClass("last").appendTo("#waypoints");       
}

function cloneInput(){

}

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
//window.onload=reloadAutocomplete();

});