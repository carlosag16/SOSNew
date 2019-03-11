<?php
    require_once("../../bootstrap.php");
    require_once("bdq.php");

    function echo_checkbox($value,$horario,$checked) {
        return "
                <div>        
                    <label style=\"font-size:85%;\" class=\"checkbox-inline\"><input type=\"checkbox\" name=\"horarios_dd[]\" value=\"$value\" $checked>$horario</label>
                </div>
            ";
    }
    
    function echo_comment($echo_mensagem) {
        return "<br> <br> ".$echo_mensagem;
    }
    
    $data  = $_POST['calendar']; //Recebe a data que vem da função a qual é ativada pela mudança no datepicker. (scriptAgendamento.js)

    $horarios_valor = DBRead("hor_horarios","hor_valor");
    $horarios_id = DBRead("hor_horarios","hor_id");
    $horariosDesabilitados = DBRead("dd_dias_desabilitados","hor_id", "WHERE dd_data = \"$data\"");
    $comentarioDesabilitacao = array_values(array_unique(DBRead("dd_dias_desabilitados","dd_comentario", "WHERE dd_data = \"$data\"" )));

    //Se a data não possui horários marcados
    if($horariosDesabilitados == NULL or $horariosDesabilitados[0] == "0") {
        for($i = 0; $i < Count($horarios_id);$i++){           
           echo echo_checkbox("$horarios_id[$i]","$horarios_valor[$i]",'');
        }        
        
        if($horariosDesabilitados[0] == "0"){
            echo echo_comment("A data está completamente reabilitada!");            
        } else {
            echo echo_comment("A data está completamente habilitada!");
        }
        
    } else {
        $parcial = false;
        for($i = 0; $i < Count($horarios_id);$i++){

            if(in_array($horarios_id[$i],$horariosDesabilitados)) { echo echo_checkbox("$horarios_id[$i]","$horarios_valor[$i]",'checked'); }

            else { $parcial = true; echo echo_checkbox("$horarios_id[$i]","$horarios_valor[$i]",''); }
        }
        if($parcial) {
            echo echo_comment("A data está parcialmente desabilitada!");        
        } else {
            echo echo_comment("A data está completamente desabilitada!");            
        }
        
        for ($j = 0; $j < Count($comentarioDesabilitacao);$j++){
            echo echo_comment("$comentarioDesabilitacao[$j]");
        }
    }   

?>