<?php

require '../../../bootstrap.php';
require '../../../app/functions/bdq.php';

    $id = base64_decode(filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING));
        
    session_start();

    $servidorResposta = DBReadOne("ser_servidores","ser_id","WHERE ser_id = '$id'");

    if($servidorResposta==NULL){
        return redirect('remember_login_in','danger','login_failed_wrong_answer');
    } 

    $_SESSION['id'] = $id;
    $_SESSION['email'] = DBReadOne("ser_servidores","ser_email","WHERE ser_id = $id AND ser_ativo = 1");        
    $_SESSION['nome'] = DBReadOne("ser_servidores","ser_nome","WHERE ser_id = $id AND ser_ativo = 1");
    $_SESSION['criada'] = DBReadOne("ser_servidores","ser_criada","WHERE ser_id = $id AND ser_ativo = 1");
    $_SESSION['telefone'] = DBReadOne("ser_servidores","ser_telefone","WHERE ser_id = $id AND ser_ativo = 1");
    $_SESSION['cancelado'] = 0;
    $_SESSION['concluidos'] = 0;
    $_SESSION['mostrar_serv_agd'] = 0;

    if($_SESSION['email'] == 'adm.bc.agendamento@gmail.com'){
        $_SESSION['tipo'] = 'Administrador';
    } else {
        $_SESSION['tipo'] = 'Servidor';
    }
    return header("location:".CAM_RAIZ."?page=profile");