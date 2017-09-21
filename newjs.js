jQuery(document).ready(function($){
    //show only departure and arrival places + first question
    var elem = $('#step1 > div').slice(0,5);
    $('#step1 > div').not(elem).hide();
    $('#airports').hide();
    
    //hide all unnecessary elements
    $('#step2').hide();
    $('#step3').hide();
    $('#step4').hide();
    $('#step5').hide();
    $('#step5 > div').slice(-3).hide();
    $('airports').show();
    $('#paypalOption').hide();
    $('#accountOption').hide();
    
    //show the next part of the form after 1st question
    $('#Y').on('click', Ybutton);
    $('#N').on('click', Nbutton);
    
    //show variant of the accident (delay, cancellation, overbooking)
    $('#click1').on('click', showQuestion);
    $('#click2').on('click', showQuestion);
    $('#click3').on('click', showQuestion);
    
    //check all checkboxes
    $('#checkAll').on('change', check);
    
    //show payment options
    $('#paypal').on('click', PayPal);
    $('#account').on('click', bankAccount);
    
    //move to next question
    $('img').not("img[id^='click']").on('click', imgMove);
    
    //move to payment options
    $('.btn_comp').on('click', compMove);
    
    //move to next step
    $('.btn_next').on('click', buttonNext);
    
    //move to previous step
    $('.btn_prev').on('click', buttonPrev);
});


var time = 1000;

function Ybutton(){
    $('#airports').show(time);
    $(this).parent().siblings().slice(8,10).hide(time);
    $('html,body').animate({scrollTop: $(this).parent().prev().offset().top}, time);
}

function Nbutton(){
    //fix it
    $('#airports').hide().delay(1000);
    $(this).parent().siblings().slice(8,10).show(time);
    $('html,body').animate({scrollTop: $(this).parent().siblings().slice(8,9).offset().top}, time);
}

function check() {
    $('input:checkbox').prop('checked', $(this).prop('checked'));
    checkagreement();
}

function PayPal(){
    $('#paypalOption').show(1000);
    $('#accountOption').hide(1000);
    $('#step5 > div').slice(-1).show();
    $('html,body').animate({scrollTop: $('#paypalOption').offset().top}, time);
}

function bankAccount(){
    $('#paypalOption').hide(1000);
    $('#accountOption').show(1000);
    $('#step5 > div').slice(-1).show();
    $('html,body').animate({scrollTop: $(this).parent().offset().top}, time);
}

function imgMove(){
    var elem = $(this).parent().parent();
    if (!elem.next().length){
        var elem = $('#ver3');
    }
    $(this).addClass('active_img');
    $('html,body').animate({scrollTop: elem.next().offset().top}, time);
}

function compMove(){
    var elem = $('#step5 > .flights').slice(-2,-1);
    elem.show();
    $(this).addClass('active_comp');
    var id = $(this).attr('id');
    if (id == 'express'){
        id = 'standard';
    }
    else{
        id = 'express';
    }
    console.log(id);
    $('#'+id).removeClass('active_comp');
    //fix
    $('html,body').animate({scrollTop: elem.offset().top()}, time);
}

function buttonNext(){
    var elem = $(this).parent().parent();
    elem.hide(450);
    elem.next().show(time);
    $('html,body').animate({scrollTop: elem.offset().top()}, time);
}

function buttonPrev(){
    var elem = $(this).parent().parent();
    elem.hide(500);
    elem.prev().show(time);
    $('html,body').animate({scrollTop: elem.prev().offset().top}, time);        
}

function showQuestion(){
    var id = parseInt($(this).attr('id').slice(-1));
//    var id2 = (id + 1) % 3 + 1; //1>3 (2), 2>1 (3), 3>2 (1)
//    var id3 = 
    switch(id){
        case 1: var id2 = 2;
                var id3 = 3;
                break;
        case 2: var id2 = 3;
                var id3 = 1;
                break;
        case 3: var id2 = 2;
                var id3 = 1;
                break;
    }
    $('#ver'+id2).hide();
    $('#ver'+id3).hide();
    $('#ver'+id).show(1000);
    $('#step1 > div').slice(-2).show();
    $('html,body').animate({scrollTop: $('#ver'+id).offset().top}, time);    
}