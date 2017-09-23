/***************************************************************************/
jQuery(document).ready(function($){
  op = function(obj) {
    $(obj).stop().slideToggle();
    };
});

function end(reason){
    switch(reason){
        case 1: alert("Twój lot był opóźniony z powodu złych warunków atmosferycznych, co wyłącza odpowiedzialność przewoźnika a tym samym możliwość uzyskania odszkodowania.");
            break;
        case 2: alert("Twój lot był opóźniony z powodu strajku, co wyłącza odpowiedzialność przewoźnika a tym samym możliwość uzyskania odszkodowania.");
            break;
        case 3: alert("Twój lot był opóźniony mniej niż 3 godziny, co wyłącza odpowiedzialność przewoźnika a tym samym możliwość uzyskania odszkodowania.");
            break;
        case 4: alert("Zostałeś poinformowany o odwołaniu lotu wcześniej niż 14 dni przed wylotem, co wyłącza odpowiedzialność przewoźnika a tym samym możliwość uzyskania odszkodowania.");
            break;
        case 5: alert("Zgodziłeś się na alternatywną formę rekompensaty, co wyłącza odpowiedzialność przewoźnika a tym samym możliwość uzyskania odszkodowania.");
            break;    
    }
}

window.onload = function(){
    check();
};

//weryfikacja formularza drugiego (dane klienta)
var validateForm = (function(){
    var options = {};
    var classError = 'error';
    
    //funckja dodaje odpowiedni� klas� w zale�no�ci czy dane wej�ciowe s� w poprawnej formie
    function showFieldValidation(input, inputIsValid) {
        if (!inputIsValid) {
            if (!input.parentNode.className || input.parentNode.className.indexOf(options.classError)==-1) {
                input.parentNode.className += ' ' + options.classError
            }
        } else {
            var regError = new RegExp('(\\s|^)'+options.classError+'(\\s|$)');
            input.parentNode.className = input.parentNode.className.replace(regError, '');
        }
    };
    
    //funkcja sprawdza czy dane wej�ciowe (input) s� zgodne ze wzorcem (reg)
    function check (input, reg){
        var inputIsValid = true;
        if (!reg.test(input.value)) {
            inputIsValid = false;
        }else{
            if (input.value==''){            
                inputIsValid = false;
            }
        }
        if (inputIsValid) {
            showFieldValidation(input, true);
            return true;
        } else {
            showFieldValidation(input, false);
            return false;
        }
    }
    //sprawdzanie kodu pocztowego
    function testInputCode(input) {
        var reg = new RegExp('^[0-9]{2}-[0-9]{3}$', 'gi');
        return check(input, reg);
    };
    //sprawdzanie imienia, nazwiska, miasta, ulicy
    function testInputText(input) {
        var reg = new RegExp('^[a-zA-z-]*$', 'gi');
        return check(input, reg);
    };
    //sprawdzanie e-maila
    function testInputEmail(input) {
        var reg = new RegExp('^[0-9a-zA-Z]+@[0-9a-zA-Z-]+\.[a-zA-Z]{2,3}$', 'gi');
        return check(input, reg);
    };
    //sprawdzanie numeru domu/mieszkania
    function testInputNumber(input) {
        var reg = new RegExp('^[1-9]+[0-9]*[a-zA-Z]{0,1}$', 'gi');
        return check(input, reg);
    };
    //sprawdzanie adresu (ulica + numer domu/mieszkania)
    function testInputAddress(input) {
        var reg = new RegExp('^[a-zA-Z]+[1-9]+[0-9]*[a-zA-Z]{0,1}\/{0,1}[1-9]+[0-9]*$', 'gi');
        return check(input, reg);
    };
    //sprawdzanie numeru telefonu (z numerem kierunkowym)
    function testInputPhone(input) {
        var reg = new RegExp('^/+{0,1}[0-9]{7,11}$');
        return check(input, reg);
    };
    function prepareElements() {
        var elements = options.form.querySelectorAll('input[required], textarea[required], select[required]');
    
        [].forEach.call(elements, function(element) {
            //usuwamy atrybut required aby przy wysy�aniu wyskakiwa�y by domy�lne b��dy
            element.removeAttribute('required');
            //klasa, po kt�rej p�niej b�dziemy sprawdza� pola
            element.className += ' required';

            //sprawdzamy typ pola
            if (element.nodeName.toUpperCase() == 'INPUT') {
                var type = element.type.toUpperCase();
                var name = element.name.toLowerCase();
                //do r�nych typ�w p�l (kolejno: zwyk�y tekst, email, kod pocztowy, numer domu/mieszkania dodajemy funkcje sprawdzaj�ce poprawno��
                if (name == 'fname' || name == 'lname' || name == 'city' || name == 'country') {
                    element.addEventListener('keyup', function() {testInputText(element);});
                    element.addEventListener('blur', function() {testInputText(element);});
                }
                else if (name == 'email') {
                    element.addEventListener('keyup', function() {testInputEmail(element);});
                    element.addEventListener('blur', function() {testInputEmail(element);});
                } 
                else if (name == 'code') {
                    element.addEventListener('keyup', function() {testInputCode(element);});
                    element.addEventListener('blur', function() {testInputCode(element);});
                }            
                else if (name == 'number1' || name == 'number2') {
                    element.addEventListener('keyup', function() {testInputNumber(element);});
                    element.addEventListener('blur', function() {testInputNumber(element);});                
                }
                else if (name == 'address'){
                    element.addEventListener('keyup', function() {testInputAddress(element);});
                    element.addEventListener('blur', function() {testInputAddress(element);});                
                }
                else if (name == 'tnumber'){
                    element.addEventListener('keyup', function() {testInputPhone(element);});
                    element.addEventListener('blur', function() {testInputPhone(element);});                
                }
            }
        });
    };
    
    function init(_options) {
        //do modu�u b�dziemy przekazywa� opcje
        //przekazane ustawimy w zmiennej options naszego modu�u, lub ustawimy domy�lne
        options = {
            form : _options.form || null,
            classError : _options.classError || 'error'
        };
        if (options.form == null || options.form == undefined || options.form.length==0) {
            console.warn('validateForm: �le przekazany formularz');
            return false;
        }
        prepareElements();
    };
    return {
        init : init
    }
})();

function click_b(x,y){
   if (x=='1a'){
       $('#1').hide();
       $('#a').show(); 
       $('#2').show(); 
   }else
       $('#'+x).hide();
       $('#'+y).show();
}

function option(x, y, z){
    $('#option'+x).show();
    $('#option'+y).hide();
    $('#option'+z).hide();    
}


function payOption(id){
    if (id==1){
        $("#paypalOption").show();
        $("#accountOption").hide();
    }else{
        $("#paypalOption").hide();
        $("#accountOption").show();
    }
}

// sprawdzanie czy wszystkie checkboxy zaznczone
function checkagreement(){
    var c = $("[name='agreement']");
    var num = 0;
    for (i = 0; i < c.length; ++i){
        if (c[i].checked) num++;
    };
    $("#next0").attr("disabled", (num >= 4) ? false : true);
};

// zaznaczanie i odznaczanie wszystkich checkbox�w
function check(){
    $("#checkAll").change(function() {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
        checkagreement();
    });
}

//dodanie funkcji walidacji formularza do p�l zapyta� o dane osobowe po nazwie klasy
document.addEventListener("DOMContentLoaded", function() {
    var form = document.querySelector('.form');
    validateForm.init({form : form}); 
});