<?php

require_once('../../../bootstrap.php');
require_once('../../../app/functions/bdq.php');

$captcha = $_POST['g-recaptcha-response'];

$validate = validate([            
    'email' => 'e',
]);

$_SESSION['var_email_in'] = $validate->email;

if($captcha){
    $secreto = '6LeeUVYUAAAAANLUiZedycN-FK4Z--MNNCEKm40u';
    $ip = $_SERVER['REMOTE_ADDR'];
    $var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secreto&response=$captcha&remoteip=$ip");
    $resposta = json_decode($var,true);
    
    if($resposta['success'] == true){       
        
        $servidorEmail = DBReadOne("ser_servidores","ser_email","WHERE ser_email = \"$validate->email\" AND ser_ativo = 1");
        
        if($servidorEmail==NULL){
            return redirect('remember_login_in','danger','login_failed_email_unknown');
        }
        
        $servidorId = DBReadOne("ser_servidores","ser_id","WHERE ser_email = \"$validate->email\" AND ser_ativo = 1");
        
        $data = [
            'para'     => [$servidorEmail],
            'assunto'  => '[SOS NORMALIZA] Redefinição de Senha.',
            'mensagem' => 'Clique no link abaixo para acessar a plataforma. E não se esqueça de trocar sua senha! :) <br> <br> <a href="http://bc.ufpa.br/sosnormaliza/public/pages/forms/remember_login_ask.php?code='.base64_encode($servidorId).'"> Link para redefinição </a>'
        ];
        //href="http://bc.ufpa.br/sosnormaliza/public/pages/forms/remember_login_ask.php?code="'.base64_encode($servidorId).'"> Link para redefinição </a>'
        
        if(send($data)){
            unset($_SESSION['var_email_in']);
            return redirect('remember_login_in','success','any_message','O link foi enviado ao seu e-mail!');
        }
        return redirect('remember_login_in','danger','any_message','Falha na operação. Por favor, contate o suporte.');
    }
} else {
    return redirect('remember_login_in','danger','empty_recaptcha');
}