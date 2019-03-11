<?php

    require '../../../bootstrap.php';
    require '../../../app/functions/bdq.php';

    session_start();

    $validate = validate([
        'dateday' => 's',
        'comment' => 's'
    ]);

    //Equivalente à lista atualizada
    $horarios_novo = $_POST['horarios_dd'];
    if(!is_array($horarios_novo)){
        $horarios_novo = array($horarios_novo);
    }

    $horarios_id = DBRead("hor_horarios","hor_id");

    $horarios_velho = DBRead("dd_dias_desabilitados","hor_id","WHERE dd_data = \"$validate->dateday\"");
    if(!is_array($horarios_velho)){
        $horarios_velho = array($horarios_velho);
    }

    if($horarios_velho != NULL){
        $arr_inserir = array_diff($horarios_novo,$horarios_velho);
    } else{
        $arr_inserir = $horarios_novo;
    }

    if($horarios_novo != NULL){
        $arr_remover = array_diff($horarios_velho,$horarios_novo);
    } else {
        $arr_remover = $horarios_velho;
    }

    if(Count($arr_inserir)>0){
        $id = $_SESSION['id'];

        $criada        = date("Y-m-d");

        $userCriada = date("d-m-Y H:i:s");

        $comentario = $userCriada."-".$_SESSION['nome']." comentou: ".$validate->comment;
    }

    foreach($arr_inserir as $value){
        $result_msg_contato = "INSERT INTO dd_dias_desabilitados (dd_data, hor_id, dd_comentario, dd_criada, ser_id) VALUES ('$validate->dateday', '$value','$comentario','$criada','$id')";
        DBExecute($result_msg_contato);
    }

    foreach($arr_remover as $value){
        $result_msg_contato = "DELETE FROM dd_dias_desabilitados WHERE dd_data = \"$validate->dateday\" AND hor_id = \"$value\"";            
        DBExecute($result_msg_contato);
    }

    return redirect('desabilitarDia','success','proc_successed');