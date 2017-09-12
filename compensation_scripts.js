/***************************************************************************/
jQuery(document).ready(function($){
  op = function(obj) {
    $(obj).stop().slideToggle();
    };
});



window.onload = function(){
    check();
    ('#')
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
        var reg = new RegExp('^[0-9a-zA-Z]+@[0-9a-zA-Z.-]+\.[a-zA-Z]{2,3}$', 'gi');
        return check(input, reg);
    };
    //sprawdzanie numeru domu/mieszkania
    function testInputNumber(input) {
        var reg = new RegExp('^[1-9]+[0-9]*[a-zA-Z]{0,1}$', 'gi');
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
                if (name == 'fname' || name == 'lname' || name == 'city' || name == 'street') {
                    element.addEventListener('keyup', function() {testInputText(element);});
                    element.addEventListener('blur', function() {testInputText(element);});
                }
                if (name == 'email') {
                    element.addEventListener('keyup', function() {testInputEmail(element);});
                    element.addEventListener('blur', function() {testInputEmail(element);});
                } 
                if (name == 'code') {
                    element.addEventListener('keyup', function() {testInputCode(element);});
                    element.addEventListener('blur', function() {testInputCode(element);});
                }            
                if (name == 'number1' || name == 'number2') {
                    element.addEventListener('keyup', function() {testInputNumber(element);});
                    element.addEventListener('blur', function() {testInputNumber(element);});                
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
});




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




function add_passenger(){
    
    $("#personal_data").clone().appendTo("#2");
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




// zaznaczanie i odznaczanie wszystkich checkbox�w
function check(){
    $("#checkAll").change(function() {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
}



//dodanie funkcji walidacji formularza do p�l zapyta� o dane osobowe po nazwie klasy
document.addEventListener("DOMContentLoaded", function() {
    var form = document.querySelector('.form');
    validateForm.init({form : form}); 
    });