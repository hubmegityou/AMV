window.onload = function(){
    start();
    addEvents();
};

var answers = new Array; //tablica przechowuj¹ca odpowiedzi
//funkcja dodaje do pól radio input w ka¿dym pytaniu aktywacjê przycisku "dalej" (u¿ywa next jako "najbli¿szy" przycisk zaraz pod odpowiedziami)
function addEvents(){ 
    $('fieldset').on('click', 'input', function(e){
	$(this).parent().next('button').removeAttr('disabled');
        });
}

//czyszczenie tablicy z odpowiedziami i pokazanie tylko kroku pierwszego
function start(){
    answers.splice(0, answers.length);
    $('.class').not('#step1').hide();
    $('#step1').show();
}

//powrót do poprzedniego pytania
function prevquestion(s, p){    //s:= bie¿¹ce pytanie, p:= poprzednie pytanie
    answers.splice(answers.length-1, 1); //usuniêcie z tablicy ostatniej dodanej odpowiedzi
    $('#next'+s).attr('disabled',true); //ukrycie przycisku "dalej" w bie¿¹cym pytaniu
    $('#step'+s).hide();    //ukrycie bie¿¹cego pytania
    $('#step'+p).show();    //pokazanie poprzedniego pytania
}

//przejœcie do kolejnego pytania
function nextquestion(s){ //s := kod aktywnego kroku (nie pytanie)
    var q = parseInt(s.substr(0,1)); //q := numer aktywnego pytania
    var val = parseInt(document.querySelector('input[name="question'+q+'"]:checked').value); //wartosc odpowiedzi do aktywnego pytania
    answers.push(val);    //dodanie wartoœci ostatniej odpowiedzi do tablicy
    var id = 'end';
    var step = '';
    if (val){  //wartoœæ 0 w polu odpowiedzi -> nie dostajesz odszkodowania, koniec formularza
        step = 'step';
        switch(q){ //sprawdzenie, z którego pytania funkcja zosta³a uruchomiona
            case 1:
                if(val < 3){
                    id = '2b'; //delayed/cancelled
                }
                else{
                    id = '2a'; //overbooking
                }
                break;
            case 2:
                switch(answers[0]){
                    case 1: //delayed
                        id = '3a';
                        break;
                    case 2: //cancelled
                        id = '3b';
                        break;
                    case 3: //overbooking
                        step = '';
                        id = 'finish';
                        break;
                }
                break;
            case 3:
            case 4:
                if (val == 12){ //12 := akceptacja oferty od przewoŸnika w zwi¹zku z odwo³aniem lotu
                    id = 4;
                }
                else{ //je¿eli q==4 od razu przechodzimy w to miejsce, odpowiedzi z tego pytania nigdy nie maj¹ value==12
                    step = '';
                    id = 'finish';
                }
                break;
        }
    }
    $('#next'+s).prop('disabled', true);    //dezaktywacja bie¿¹cego przycisku "dalej"
    $('#step'+s).hide();    //ukrycie bie¿¹cego pola z pytaniem
    $('#'+step+id).show();  //pokazanie nowego pytania lub koniec formularza
}

function fill(){
    $('#finish').hide();
    $('#form').show();
}

//weryfikacja formularza drugiego (dane klienta)
var validateForm = (function(){
    var options = {};
    var classError = 'error';
    
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
    
    function testInputCode(input) {
        var reg = new RegExp('^[0-9]{2}-[0-9]{3}$', 'gi');
        return check(input, reg);
    };
    
    function testInputText(input) {
        var reg = new RegExp('^[a-zA-z-]*$', 'gi');
        return check(input, reg);
    };
    
    function testInputEmail(input) {
        var reg = new RegExp('^[0-9a-zA-Z]+@[0-9a-zA-Z.-]+\.[a-zA-Z]{2,3}$', 'gi');
        return check(input, reg);
    };
    
    function testInputNumber(input) {
        var reg = new RegExp('^[1-9]+[0-9]*[a-zA-Z]{0,1}$', 'gi');
        return check(input, reg);
    };
    
    function prepareElements() {
        var elements = options.form.querySelectorAll('input[required], textarea[required], select[required]');
    
        //przyjemniejsza forma for
        [].forEach.call(elements, function(element) {
            //usuwamy atrybut required - inaczej przy wysy³aniu wyskakiwa³y by domyœlne b³êdy przegl¹darki
            element.removeAttribute('required');
            //dodajemy klasê - po niej bêdziemy póŸniej sprawdzaæ pola
            element.className += ' required';

            //sprawdzamy typ pola
            if (element.nodeName.toUpperCase() == 'INPUT') {
                var type = element.type.toUpperCase();
                var name = element.name.toLowerCase();
                //dla ka¿dego pola dodajemy obs³ugê funkcji sprawdzaj¹cej
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
    //metoda publiczna
    function init(_options) {
        //do naszego modu³u bêdziemy przekazywaæ opcje
        //przekazane ustawimy w zmiennej options naszego modu³u, lub ustawimy domyœlne
        options = {
            form : _options.form || null,
            classError : _options.classError || 'error'
        };
        if (options.form == null || options.form == undefined || options.form.length==0) {
            console.warn('validateForm: le przekazany formularz');
            return false;
        }
        prepareElements();
    };
    return {
        init : init
    }
})();


document.addEventListener("DOMContentLoaded", function() {
    var form = document.querySelector('.form');
    validateForm.init({form : form});
});