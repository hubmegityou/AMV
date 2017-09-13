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
            
                     
           $('#pas').append(val+'. '+fname+' '+lname+"<br>"+ address +'<br>'+code+' '+city+', '+country+"<br><br>");
            
            
            
        }        
      })
   
}


function add_contact(){
    
    var tnumber = $("#tnumber").val();
    var email = $("#email").val();
    

      $.ajax( // wywołanie ajaxa
      { 
         type: "POST", 
         url: "submit_contactdata.php",
         data: { tnumber:tnumber, email:email}, // Dane przesyłane $_POST
          cache: false,
         success: function(m) 
         {             
           $('#con').append("kontakt: <br>"+tnumber+"<br>"+ email);      
        }        
      }) 
}



function add_compensation(num){
    
     $.ajax( // wywołanie ajaxa
      { 
         type: "POST", 
         url: "submit_compensation.php",
         data: { num: num }, // Dane przesyłane $_POST
          cache: false,
         success: function(m) 
         {     
        }       
      }) 
}




function add_compensation2(){
    
     var val = parseInt(document.querySelector('input[name="radio"]:checked').value);
     var account;
     var select;
      
    if(val==1){
       account = $("#account_num").val(); 
      select = "";
    }else{
       account = $("#account_num2").val();  
       select = document.getElementById("select").value;
    }
    
     $.ajax( // wywołanie ajaxa
      { 
         type: "POST", 
         url: "submit_compensation2.php",
         data: { val: val, account:account, select:select }, // Dane przesyłane $_POST
          cache: false,
         success: function(m) 
         {     
        }       
      })
      
     
}