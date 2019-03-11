<?php

require '../../../app/functions/efetuar_des_cancelamento.php';
require '../../../app/functions/bdq.php';
require '../../../bootstrap.php';

$captcha = $_POST['g-recaptcha-response'];

$validate = validate([
    'codigo' => 's',
    'email' => 'e',
]);

session_start();
$_SESSION['var_code_cancelamento'] = $validate->codigo;

if($captcha){
    $secreto = '6LeeUVYUAAAAANLUiZedycN-FK4Z--MNNCEKm40u';
    $ip = $_SERVER['REMOTE_ADDR'];
    $var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secreto&response=$captcha&remoteip=$ip");
    $resposta = json_decode($var,true);

    if($resposta['success'] == true){
        $agd_id = base64_decode($validate->codigo);
        $agd_email = DBReadOne("agd_agendamentos","agd_email","WHERE agd_id = $agd_id AND agd_cancelado = 0");
        
        if(agd_email == NULL){
            return header("location:".$caminho."&status=danger&cancelado={$session_cancelado}&type_message=anymessage&message=O agendamento não consta em nossa base de dados.");
        }
        
        if($agd_email == $validate->email){
            $tipo = NULL;
            $session_idServ = -1;
            $session_cancelado = 0;
            $session_concluidos = NULL;
            $caminho = CAM_RAIZ."?page=cancelar_agendamento_usuario";

            func_des_cancelamento($agd_id,$tipo,$session_idServ,$session_cancelado,$session_concluidos,$caminho);
            

                unset($_SESSION['var_code_cancelamento']);
 
                unset($_SESSION['var_email_id_cancelamento']);

            return header("location:".$caminho."&status=success&cancelado={$session_cancelado}&type_message=anymessage&message=O processo foi feito com sucesso.");
        } else {
            return header("location:".$caminho."&status=danger&cancelado={$session_cancelado}&type_message=anymessage&message=O email informado não está correto.");
        }
    }
    
} else {
    return redirect('cancelar_agendamento_usuario','danger','empty_recaptcha');
}