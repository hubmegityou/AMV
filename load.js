var current_step = 0;
function get_page(page){
    $.ajax({
            url: "step" + String(page) + ".html",
            dataType: "html",
            cache: true,
            success: function(data){
                //write content 
                $("#content").html(data);
                //copy text to header
                $(".topbar").html($(".flights > h1").html());
            },
            complete: function(){
                // get scripts
                $.getScript("step" + String(page) +".js");
                $.getScript("step" + String(page) +"_load.js");
                //and set variable to current page
                current_step = page;
                
                //set appropriate step on the stepline
                $(".stepline > ul").children().each(function(index){
                    if(index + 1 < current_step) {
                        $(this).removeClass("active");
                        $(this).html("✔");
                    }
                    if(index + 1 == current_step){
                        $(this).addClass("active");
                        $(this).html(current_step);
                    }
                });
                //add handler to button
              //  $(".btn_next").click(function(){ get_page(current_step + 1);});
                $(".btn_prev").click(function(){ get_page(current_step - 1);});
            }
        });
    };
    function get_inital_step(){
        $.ajax({
            url: "get_step.html",
            dataType: "html",
            cache: true,
            success: function(data){
                //current_step = data; redundant IWSS
                get_page(data);    
            }
        });
    }
        
$(document).ready(function(){   
        //remove in final version
        get_page(1);       
        //get_initial_step();
});    