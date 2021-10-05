<?php

require '../../../bootstrap.php';
require '../../../app/functions/bdq.php';

$captcha = $_POST['g-recaptcha-response'];


        $validate = validate([            
            'email' => 'e',
            'senha' => 's'
        ]);
session_start();
$_SESSION['var_email'] = $validate->email;
$_SESSION['var_senha'] = $validate->senha;

if($captcha){
    $secreto = '6LeeUVYUAAAAANLUiZedycN-FK4Z--MNNCEKm40u';
    $ip = $_SERVER['REMOTE_ADDR'];
    $var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secreto&response=$captcha&remoteip=$ip");
    $resposta = json_decode($var,true);
    if($resposta['success'] == true){
        $validate->senha = md5($validate->senha);
    
        $servidorEmail = DBReadOne("ser_servidores","ser_id","WHERE ser_email = \"$validate->email\"");
        $servidorSenha = DBReadOne("ser_servidores","ser_senha","WHERE ser_email = \"$validate->email\"");
        
        if($servidorEmail==NULL){
           return redirect('login','danger','login_failed_email_unknown');
        } else
            if($validate->senha!==$servidorSenha){
               return redirect('login','danger','login_failed');
            }
        
        $_SESSION['id'] = $servidorEmail;
        $_SESSION['email'] = $validate->email;
        $id = $servidorEmail;
        $_SESSION['nome'] = DBReadOne("ser_servidores","ser_nome","WHERE ser_id = $id");
        $_SESSION['criada'] = DBReadOne("ser_servidores","ser_criada","WHERE ser_id = $id");
        $_SESSION['telefone'] = DBReadOne("ser_servidores","ser_telefone","WHERE ser_id = $id");
        $_SESSION['cancelado'] = 0;
        $_SESSION['concluidos'] = 0;
        $_SESSION['giro_tabela'] = 'horizontal';

        if($validate->email == 'suporte.sedepti@gmail.com'){
            $_SESSION['tipo'] = 'Administrador';
        } else {
            $_SESSION['tipo'] = 'Servidor';
        }
        unset($_SESSION['var_email']);
        unset($_SESSION['var_senha']);
        return header("location:".CAM_ADMIN);
    }
} else {
    return redirect('login','danger','empty_recaptcha');
}