function test(request, response){

    $.ajax({
        url: "https://v4p4sz5ijk.execute-api.us-east-1.amazonaws.com/anbdata/airports/locations/international-list?api_key=1d2a8cd0-83d5-11e7-a40a-b35c55abe8b5&format=json",
        dataType: "jsonp",
        cache: true,
        data: {
        q: request.term
        },
        success: function( data ) {
        var re = new RegExp(request.term, 'i');
        
        if (data.match(re)) {
            // do something
        }  
        alert( data );
        }
        });
};

