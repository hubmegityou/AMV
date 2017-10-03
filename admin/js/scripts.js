
function select_onchange() {
    $('#select').change(function() {
		alert('jestem');
        var id= $(this).find(":selected").val();
        var text=$(this).find(":selected").text();
        $.ajax( // wywołanie ajaxa
      { 
         type: "POST", 
         url: "select.php",
         data: { text:text, id:id}, // Dane przesyłane $_POST
          cache: false,
         success: function(m) 
         {       
        }
    })   
        
        
        
    });
}

function tr(depid, arrid, campaign){       
    location.href = "flight_details.php?depid="+depid+"&arrid="+arrid+"&campaign="+campaign;   
}


function tr2(id){       
    location.href = "details.php?id="+id;   
}


function delete_row(num){
 $.ajax( // wywołanie ajaxa
      { 
         type: "POST", 
         url: "delete.php",
         data: { val:num}, // Dane przesyłane $_POST
          cache: false,
         success: function() 
         {       
             
            location.reload();
        }        
      })  ; 
    
}



function initializeJS() {

    //sidebar dropdown menu
    jQuery('#sidebar .sub-menu > a').click(function () {
        var last = jQuery('.sub-menu.open', jQuery('#sidebar'));        
        jQuery('.menu-arrow').removeClass('arrow_carrot-right');
        jQuery('.sub', last).slideUp(200);
        var sub = jQuery(this).next();
        if (sub.is(":visible")) {
            jQuery('.menu-arrow').addClass('arrow_carrot-right');            
            sub.slideUp(200);
        } else {
            jQuery('.menu-arrow').addClass('arrow_carrot-down');            
            sub.slideDown(200);
        }
       
    });

}



function removeDuplicateRows($table){
    function getVisibleRowText($row){
        return $row.find('td:visible').text().toLowerCase();
    }
    
    $table.find('tr').each(function(index, row){
        var $row = $(row);
    
        $row.nextAll('tr').each(function(index, next){
            var $next = $(next);
            console.log(getVisibleRowText($row), getVisibleRowText($next))
            if(getVisibleRowText($next) == getVisibleRowText($row))
                $next.remove();
        })
    });
}



jQuery(document).ready(function(){
	

removeDuplicateRows($('table'));
    
    
                                                                           
var $rows = $('#table tbody tr');
$('#search').keyup(function() {
	    
	    var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
	        reg = RegExp(val, 'i'),
	        text;
	    
	    $rows.show().filter(function() {
	        text = $(this).text().replace(/\s+/g, ' ');
	        return !reg.test(text);
	    }).hide();
	});
          
  
    
    initializeJS();
    select_onchange();
});