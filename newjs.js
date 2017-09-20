jQuery(document).ready(function($){
    Y.addEventListener('click', function(){
        $('#airports').show();
    });
    N.addEventListener('click', function (){
        $('#airports').hide();
        $('html,body').animate({scrollTop: $(this).parent().next().offset().top}, time);
    });
//    var elem = $('#step1 > div');
//    console.log(elem);
//    for (var i = 0; i <= 2; i++)
        
//    $('#step1 > div').not('.topbar').not('.stepline').not('.flights').hide();
//    $('.topbar').show();
    $('#step2').hide();
    $('#step3').hide();
    $('#step4').hide();
    $('#step5').hide();
    $('airports').show();
    //move to next question
    $('img').on('click', function(){
        var elem = $(this).parent().parent();
        console.log(elem.length);
        if (!elem.next().length){
            var elem = elem.parent();
        }
        $('html,body').animate({scrollTop: elem.next().offset().top}, time);
    })
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