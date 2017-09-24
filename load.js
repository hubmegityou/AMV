$(document).ready(function(){   
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
                    //set appropriate step on the stepline
                    $(".stepline > ul").children().each(function(index){
                        if(index < current_step){
                            $(this).removeClass("active");
                            $(this).html("✔");
                        }
                        if(index == current_step){
                            $(this).addClass("active");
                        }
                    });
                    //add handler to button
                    $(".btn_next").click(function(){ get_page(current_step + 1);});
                },
                complete: function(){
                    //finally, get scripts
                    $.getScript("step" + String(page) +".js");
                    //and set variable to current page
                    current_step = page;
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

        //remove in final version
        get_page(1);       
    
});    