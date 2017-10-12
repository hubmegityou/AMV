
jQuery(document).ready(function(){
	getNames(); 
	submitForm();
})



function getNames(){

$.ajax({
        type: 'POST',
        headers: {
            "cache-control": "no-cache"
        },
        url: "getNames.php",
        async: false,
        cache: false,
        data: {
        },
        success: function (jsonArray) {
            var names = JSON.parse(jsonArray);
			 var j=1;
			 while (names[j]) {
			for (i=1; i<4; i++){	
			if (j==1){
				$( "#a"+i).prepend(names[j]['name']);
				$("#"+i).find('input').attr('name', names[j]['id']);
				
			}else{
				$( "#a"+i).append(names[j]['name']);
				$("#"+i).clone().appendTo( "#a"+i);
				$("#"+i).find('input').attr('name', names[j]['id']);
			}}
			 j++;
			 }
		}
})
	
}

function submitForm(){
	
$("input").change(function(){
	
	
	var file = $(this).prop('files')[0];
	var data = new FormData(file);
	var type= $(this).attr('id');
	var name= $(this).attr('name');
	data.append('file', file);
	data.append("type", type);
	data.append("pass_id", name);
      
       $.ajax( // wywołanie ajaxa
      { 
         type: "POST",
         enctype: 'multipart/form-data',
         processData: false,  // Important!
         contentType: false,
         url: "step3.php",
          data:data,
         cache: false,
         success: function(){}        
      })
	
	
	
		
		
    });    
	
	
}







