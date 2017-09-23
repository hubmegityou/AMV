$(document).ready(function(){   
        var current_step = 0;
        function get_page(page){
            $.ajax({
                url: "step" + String(page) + ".html",
                dataType: "html",
                cache: true,
                success: function(data){
                    $("#container").html(data);
                    $(".btn_next").click(function(){ get_page(current_step + 1);});
                },
                complete: function(){
                    $.getScript("step" + String(page) +".js");
                    current_step += 1;
                }
            });
        };
        get_page(1);       
    
});    