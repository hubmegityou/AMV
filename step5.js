
jQuery(document).ready(function(){
$(".btn_next").prop("disabled", true);
checkagreement();
button_active();
payOption();
submitForm();
  
})
 
 
 
 function checkagreement(){
	$(document).change(function() {
  
	var type= $(".active_comp").attr("id");
	var payment= $("input[type='radio'][name='radio']:checked").attr("id");
	var account= $("input[name='num']").val();
	
	if (!type || !payment || account=='' ){
		$(".btn_next").prop("disabled", true);
	}else {
		$(".btn_next").prop("disabled", false);	
	}
})
}
 
 
 
 function submitForm(){
	 
$(".btn_next").click(function(){
	$.post( "submitForm5.php", {
		 type: $(".active_comp").attr("id"), 
		 payment: $("input[type='radio'][name='radio']:checked").attr("id"),
		 currency: $( "#select" ).val(),
		 account: $("input[name='num']").val()
		 
		 } )
 })}
 
 
 function button_active(){
	 
	 
$( "#e,#s" ).click(function(){
  $(this).addClass('active_comp');
  if ($(this).attr('id')=='e'){
	var id='s';
  }else{
	  var id='e';
  }
   $('#'+id).removeClass('active_comp');
})
	 
 }
 
 
 
 
 function payOption(){
	 
  $( "#paypal,#account" ).click(function(){
  if ($(this).attr('id')=='paypal'){
	
	var id_show='p';
	var id_hide='a';
  }else{
	var id_show='a';
	var id_hide='p';	  
  }	
   $("#pa").show();
   $('#'+id_show).show();
   $('#'+id_hide).hide();
})
 }
 