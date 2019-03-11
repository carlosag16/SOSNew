/*eslint-env jquery*/
/*jslint browser: true*/
/*global $, jQuery*/

//Dá bronca chata se não colocar isso, mas se tirar funciona.
var document = document;
//Futuramente, quando se tiver conhecimento de AJAX (eu creio), a página DesabilitarDia.php deve preencher esse vetor, para que o dia fique desabilitado no Datepicker.
var disabledDays = [""];

    //Serve para setar configurações no DatePicker (calendariozinho que aparece na página contato.php, por exemplo.)
    $( function() {
        $( "#datepicker" ).datepicker(
            {dateFormat: "yy-mm-dd", //garante que seja 2018-05-30 em vez de 30/05/2018, pois a primeira é reconhecida no BD.
             dayNames: [ "Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado" ], //Tira do inglês e põe para Português.
            beforeShowDay: function(date){ //Função para desabilitar dias no Datepicker.
            var day = date.getDay();
            var dia = date.getDate();
            var month = date.getMonth();
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            var isDisabled = ($.inArray(string, disabledDays) != -1);
            //day != 0 disables all Sundays
            return [
                !(dia == 12 && month == 1-1) && //Aniversário de Belém
                !(dia == 21 && month == 4-1) && //Tiradentes
                !(dia == 1 && month == 5-1) && //Dia do Trabalho
                !(dia == 15 && month == 8-1) && //Dia da Adesão do Pará
                !(dia == 7 && month == 9-1) && //Dia da Independência
                !(dia == 12 && month == 10-1) && //Dia da N. S. Aparecida
                !(dia == 2 && month == 11-1) && //Finados
                !(dia == 15 && month == 11-1) && //Dia da Proclamação da República
                !(dia == 25 && month == 12-1) && //Natal
                !(dia == 1 && month == 1-1) && // Dia da Fraternidade Universal
                    day != 0 && day != 6 && !isDisabled];

        },                     
             minDate: 1, //Aqui onde permite que não possa agendar no dia atual.
             dayNamesMin: [ "DOM", "SEG", "TER", "QUA", "QUI", "SEX", "SAB" ],
             monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"]}
        );
        
        $( "#datepicker_dd" ).datepicker(
            {dateFormat: "yy-mm-dd", //garante que seja 2018-05-30 em vez de 30/05/2018, pois a primeira é reconhecida no BD.
             dayNames: [ "Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado" ], //Tira do inglês e põe para Português.
            beforeShowDay: function(date){ //Função para desabilitar dias no Datepicker.
            var day = date.getDay();
            var dia = date.getDate();
            var month = date.getMonth();
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            var isDisabled = ($.inArray(string, disabledDays) != -1);
            //day != 0 disables all Sundays
            return [
                !(dia == 12 && month == 1-1) && //Aniversário de Belém
                !(dia == 21 && month == 4-1) && //Tiradentes
                !(dia == 1 && month == 5-1) && //Dia do Trabalho
                !(dia == 15 && month == 8-1) && //Dia da Adesão do Pará
                !(dia == 7 && month == 9-1) && //Dia da Independência
                !(dia == 12 && month == 10-1) && //Dia da N. S. Aparecida
                !(dia == 2 && month == 11-1) && //Finados
                !(dia == 15 && month == 11-1) && //Dia da Proclamação da República
                !(dia == 25 && month == 12-1) && //Natal
                !(dia == 1 && month == 1-1) && // Dia da Fraternidade Universal
                    day != 0 && day != 6 && !isDisabled];

        },                     
             minDate: 1, //Aqui onde permite que não possa agendar no dia atual.
             dayNamesMin: [ "DOM", "SEG", "TER", "QUA", "QUI", "SEX", "SAB" ],
             monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"]}
        );
    });

//Script para colocar cor ao clicar nas caixinhas de horários.
var check = function (num) {
    var radiobtn = document.getElementById("hora"+num);
    radiobtn.checked = true;
    
    $(".timebox").css("background-color","aliceblue");
    $("#timebox"+num).css("background-color","lightgreen");
}
var datapick = function (sufix) {    
    var datas = $("#datepicker"+sufix).val();
    $("#time_box"+sufix).load("../app/functions/vetHorarios"+sufix+".php",{
        calendar: datas
    });    
}

//Função para carregar os horários disponíveis, a qual está no arquivo vetHorarios.php
$(document).ready(function() {
    $("#datepicker").change(function() {
        datapick('');
    });
    //Não permitir que a pessoa cole a senha no confirmar senha
    $(".senha").bind('paste', function(e) {
        e.preventDefault();
    });
});

//Função para carregar os horários disponíveis, a qual está no arquivo vetHorarios.php
$(document).ready(function() {
    $("#datepicker_dd").change(function() {
        datapick('_dd');
    });
});

//Função para mudar a tabela principal do dashboard de horizontal-vertical e vice-versa.
/*$(document).ready(function() {
    $(window).resize(function() {
        alert('oie')
    });
});
*/

//Script para verificar se a senha confere com a confirmar senha (profile.php)
var pode_senha1 = false;
var check_senha = function () {
    var senha1 = $( "#senha1" ).val();
    var senha2 = $( "#senha2" ).val();

    if( senha2.length==0){
        $( "#password_box" ).html("");            
    } else if(senha1.length<6 || senha2.length<6) {
        $( "#password_box" ).html("A senha é muito curta");
        $( "#password_box" ).css("color","#c67373");
        $( "#password_box" ).css("margin-right","0%");
        $( "#password_box" ).css("margin-top","1%");
        //$( "#password_box" ).css("text-shadow","-0.7px 0 black, 0 0.7px black, 0.7px 0 black, 0 -0.7px black");
    } else if(senha1 !== senha2) {
        $( "#password_box" ).html("A senha não confere");
        $( "#password_box" ).css("color","#c67373");
        $( "#password_box" ).css("margin-top","1%");
        $( "#password_box" ).css("margin-right","3%");
        //$( "#password_box" ).css("text-shadow","-0.7px 0 black, 0 0.7px black, 0.7px 0 black, 0 -0.7px black");
    } else {
        $( "#password_box" ).html("A senha confere");
        $( "#password_box" ).css("color","#58b558");
        $( "#password_box" ).css("margin-top","1%");
        $( "#password_box" ).css("margin-right","3%");
        //$( "#password_box" ).css("text-shadow","-0.7px 0 black, 0 0.7px black, 0.7px 0 black, 0 -0.7px black");
    }
}
//Esse script é para o caso da pessoa mudar a senha e depois a confirmar senha, mas depois ela quiser mudar de novo a senha. Os scripts abaixos garantem que isso funcionem perfeitamente.
$( function () {
    $( "#senha2" ).change( function () {
        pode_senha1 = true;
        check_senha();
    });
})
$( function () {
    $( "#senha1" ).change(function () {
        if(pode_senha1 === true){
            check_senha();
        }
    });
})

//Apenas para mostrar a div que guarda a mensagem e o botão de confirmação do agendamento
var btn_agendar = function () {
    $("#confirmar_agendamento").fadeIn();
    $("#btn_agendar").css("display","none");
}

var ativado = false; //Identifica se o DropDown está ativado ou não.
//Script para aparecer e desaparecer o DropDown do menu do SOS Normaliza.
var agenda_dropDown = function () {
    if(ativado == false){
        $("#drop-down").fadeIn();
        ativado = true;
    } else {
        $("#drop-down").fadeOut();
        ativado = false;
    }
}

function searcher() {
    // Declare variables 
    var input, filter, table, tr, td, i, j;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("example1");
    tr = table.getElementsByTagName("tr");
    var classe = table.getElementsByClassName("match1");    

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length/classe.length; i++) {
        for (j = 0; j < classe.length; j++) {
            td = tr[i* classe.length + j].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    for (j = 0; j < classe.length; j++) {
                        tr[i * classe.length + j].style.display = "";
                    }
                    
                } else {
                    tr[i * classe.length + j].style.display = "none";
                }   
            }
        } 
    }
}

var uriSearcher = function (url,variavel) {
    var params = url.split("&")
    for(var i=0; i<params.length;i++){
        if(params[i].split("=")[0].indexOf(variavel) != -1) {
            return params[i].split("=")[1];
        }
    }
}

var change_h2_name = function (id) {
    var page = location.href.split("/").slice(-1);
    //alert(typeof page);
    var variavelPage = uriSearcher(JSON.stringify(page),'page');
    //alert(location.href.split("/").slice(-1) == "transacao.php");
    var texto;
    if($('#'+id).is(':checked')) {
        texto = 'Editar ';
        document.getElementsByName("nome")[0].required = false;
        document.getElementsByName("email")[0].required = false;
        //Pegar os horários do servidor e alimentar a div editar_ser_horarios e esconder cadastrar_ser_horarios. Criar função com .load(). Depois terminar os testes e passar para gerenciarHorarios.php
    } else {
        texto = 'Cadastrar '
        document.getElementsByName("nome")[0].required = true;
        document.getElementsByName("email")[0].required = true;
    }
    switch(true) {
        case (variavelPage.indexOf("gerenciarHorarios") != -1 ? true : false):
            texto += 'Horário:'
            break;
        case (variavelPage.indexOf("gerenciarServidor") != -1 ? true : false):
            texto += 'Servidor:'
            break;
        default:
            texto+='Deu merda'
    }
    document.getElementById("trans_h2").textContent = texto;
    
}
