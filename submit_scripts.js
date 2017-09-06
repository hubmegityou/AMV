

function submitPersonalData(){
    var fname = $("#fname").val();
    var lname = $("#lname").val();
    var address = $("#address").val();
    var code = $("#code").val();
    var city = $("#city").val();
    var country = $("#country").val();
    var tnumber = $("#tnumber").val();
    var email = $("#email").val();
     
      $.ajax( // wywo³anie ajaxa
      { 
         type: "POST", 
         url: "submit_personaldata.php",
         data: { fname: fname, lname: lname, address:  address, code: code, city: city, country: country, tnumber: tnumber, email: email }, // Dane przesy³ane $_POST
          cache: false,
         success: function(m) 
         {  
         }    
        })
}