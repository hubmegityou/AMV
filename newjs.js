jQuery(document).ready(function($){
    Y.addEventListener('click', function(){
        $('#airports').show(time);
        $(this).parent().siblings().slice(8,10).hide(time);
        $('html,body').animate({scrollTop: $(this).parent().prev().offset().top}, time);
    });
    N.addEventListener('click', function (){
        //fix it
        $('#airports').hide().delay(1000);
        $(this).parent().siblings().slice(8,10).show(time);
        $('html,body').animate({scrollTop: $(this).parent().siblings().slice(8,9).offset().top}, time);
    });
    var elem = $('#step1 > div').slice(0,5);
    $('#step1 > div').not(elem).hide();
    $('#airports').hide();
    $('#step2').hide();
    $('#step3').hide();
    $('#step4').hide();
    $('#step5').hide();
    $('#step5 > div').slice(-3).hide();
    $('airports').show();
    
    //move to next question
    $('img').not("img[id^='click']").on('click', function(){
        var elem = $(this).parent().parent();
        if (!elem.next().length){
            var elem = $('#ver3');
        }
        $('html,body').animate({scrollTop: elem.next().offset().top}, time);
    });
    
    //move to next step
    $('.btn_next').on('click', function(){
        var elem = $(this).parent().parent();
        elem.hide(1000);
        elem.next().show();
        $('html,body').animate({scrollTop: elem.offset().top}, time);
    });
    
    //move to previous step
    $('.btn_prev').on('click', function(){
        var elem = $(this).parent().parent();
        elem.hide(500);
        elem.prev().show(1000);
        $('html,body').animate({scrollTop: elem.prev().offset().top}, time);        
    })
});

var time = 1000;