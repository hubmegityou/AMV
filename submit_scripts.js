function add_passenger(){    
   
   var fname = $("#fname").val();
    var lname = $("#lname").val();
    var address = $("#address").val();
    var code = $("#code").val();
    var city = $("#city").val();
    var country = $("#country").val();
    var val= $('#hd').val();
    

      $.ajax( // wywołanie ajaxa
      { 
         type: "POST", 
         url: "submit_personaldata.php",
         data: { val:val, fname: fname, lname: lname, address:  address, code: code, city: city, country: country }, // Dane przesyłane $_POST
          cache: false,
         success: function(m) 
         {    
            val++; 
            document.getElementById('hd').value=val;
            $("#fname").val('');
            $("#lname").val('');
            $("#address").val('');
            $("#code").val('');
            $("#city").val('');
            $("#country").val('');
            
        }        
      })
   
}



