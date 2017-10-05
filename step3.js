
jQuery(document).ready(function(){
	getNames(); 
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
				$( "#a"+i).prepend(names[j]);
			}else{
				$( "#a"+i).append(names[j]);
				$("#"+i).clone().appendTo( "#a"+i);
			}}
			 j++;
			 }
		}
})
	
}