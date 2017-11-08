jQuery(document).ready(function($){
 check();
 checkagreement();
  
});


//check or uncheck all checkboxes

function check(){
    $("#checkAll").change(function() {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
		checkagreement();
    });
}



//If all checkboxes are not checked the button 'next' is deactivated
function checkagreement(){

    var c = $("[name='agreement']");
    var num = 0;
    for (i = 0; i < c.length; ++i){
        if (c[i].checked) num++;
    };
	
	$(".btn_next").prop("disabled", (num >= 4) ? false : true);
 
};