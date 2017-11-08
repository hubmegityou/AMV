
jQuery(document).ready(function(){
//$(".btn_next").prop("disabled", true);
$( "#paypal,#account" ).change();
//checkagreement();
button_active();
payOption();
submitForm();
fill_form();
  
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
 
 
 function fill_form(){
	 
	 $.ajax({
            url: "step5_load.php",
            dataType: "json",
            cache: true,
            success: function(data){
                 
				if (data['type']==1){
					$("#e").addClass("active_comp"); 
				}else if(data['type']==2){
					 $("#s").addClass("active_comp");
				}
				 
				if (data['payment']==1){
					$("#paypal" ).attr( 'checked', true ); 
					$("#pa").show();
					$('#p').show();
				}else if(data['payment']==2){
					$("#account" ).attr( 'checked', true );
					$("#pa").show();
					$('#a').show();
				}
				 	
				$("#select").val(data['currency']).change();
				document.getElementById("account_num").value=data['account'];
            }
        });
 }
 
 
 
 
 function submitForm(){
	 
$(".btn_next").click(function(){
	$.post( "submit_step5.php", {
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
	 
  $( "#paypal,#account" ).change(function(){
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
 