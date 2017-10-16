
jQuery(document).ready(function(){
	cloneForm();
	submitForm();
})


function cloneForm(){
	
$('#add').click(function (){

var input_fname = $('input[name="first_name"]').val();
var input_lname = $('input[name="last_name"]').val();
var input_address = $('input[name="address"]').val();
var input_code = $('input[name="code"]').val();
var input_city = $('input[name="city"]').val();
var input_country = $('input[name="country"]').val();

submitPassenger();

var input_val = input_fname + ' ' + input_lname + '<br>' + input_address + '<br>'+ input_code + ' '+ input_city +', '+ input_country+'<br><br>';

$('#passengers').append(input_val);

$(':input').val('');
})
}



function submitPassenger(){

$.post( "step2.php", {
		 
		 fname: $('input[name="first_name"]').val(),
		 lname: $('input[name="last_name"]').val(),
		 address: $('input[name="address"]').val(),
		 code: $('input[name="code"]').val(),
		 city: $('input[name="city"]').val(),
		 country: $('input[name="country"]').val()
		 } )
}



function submitForm(){

$('#btn_next').click(function (){
	
	
$.post( "step2.php", {
		 email: $('input [name="email"]').val(),
		 tnumber: $('input [name="tnumber"]').val() 
		 })
})
}
