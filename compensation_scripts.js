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
