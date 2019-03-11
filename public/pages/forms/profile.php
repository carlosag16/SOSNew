<?php

require '../../../bootstrap.php';
require '../../../app/functions/bdq.php';
session_start();
$captcha = $_POST['g-recaptcha-response'];

$validate = validate([
            'nome' => 's',
            'telefone' => 'i',
            'email' => 'e',
            'senha' => 's',
            'resposta_seguranca' => 's',
            'pergunta_seguranca' => 's'
        ]);
$_SESSION['var_nome'] = $validate->nome;
$_SESSION['var_telefone'] = $validate->telefone;
$_SESSION['var_email'] = $validate->email;
$_SESSION['var_senha'] = $validate->senha;
$_SESSION['var_resposta_seguranca'] = $validate->resposta_seguranca;
$_SESSION['var_pergunta_seguranca'] = $validate->pergunta_seguranca;

if(true){

    $secreto = '6LeeUVYUAAAAANLUiZedycN-FK4Z--MNNCEKm40u';
    $ip = $_SERVER['REMOTE_ADDR'];
    $var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secreto&response=$captcha&remoteip=$ip");
    $resposta = json_decode($var,true);

    if(true){

        $validate_arr = (array) $validate;

        if($validate_arr['senha'] != ''){
            $validate_arr['senha'] = md5($validate_arr['senha']);
        }
        if($validate_arr['resposta_seguranca'] != ''){
            $validate_arr['resposta_seguranca'] = md5(strtolower($validate_arr['resposta_seguranca']));
        }

        foreach ($validate_arr as $key=>$value){
            if($value!=''){
                $result_msg_contato = "UPDATE ser_servidores
                SET ser_$key = '$value'
                WHERE ser_id = {$_SESSION['id']}
                ";
                if(!DBExecute($result_msg_contato)){
                   return redirect('profile','danger','any_message',"Falha ao Mudar $key!");
                }
                $_SESSION[$key] = "$value";
            }
        }
        $id = $_SESSION['id'];

        //Equivalente à lista atualizada
        $horarios_novo = $_POST['horarios_ser'];
        //Dados do banco de dados
        $horarios_velho = DBRead("ser_servidores__hor_horarios","hor_id","WHERE ser_id = $id");

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

        //ChromePhp::log($horarios_novo);

        foreach($arr_inserir as $value){
            $result_msg_contato = "INSERT INTO ser_servidores__hor_horarios (ser_id, hor_id) VALUES ('$id','$value')";
            DBExecute($result_msg_contato);
        }

        foreach($arr_remover as $value){
            $result_msg_contato = "DELETE FROM ser_servidores__hor_horarios
            WHERE ser_id = $id AND hor_id = $value";
            DBExecute($result_msg_contato);
        }

        $_SESSION['nome'] = DBReadOne("ser_servidores","ser_nome","WHERE ser_id = $id");
        $_SESSION['criada'] = DBReadOne("ser_servidores","ser_criada","WHERE ser_id = $id");
        $_SESSION['telefone'] = DBReadOne("ser_servidores","ser_telefone","WHERE ser_id = $id");
        // $_SESSION['pergunta'] = DBReadOne("ser_servidores","ser_pergunta_seguranca","WHERE ser_id = $id");
        // $_SESSION['resposta'] = DBReadOne("ser_servidores","ser_resposta_seguranca","WHERE ser_id = $id");
        $_SESSION['email'] = DBReadOne("ser_servidores","ser_email","WHERE ser_id = $id");

        unset($_SESSION['var_nome']);
        unset($_SESSION['var_telefone']);
        unset($_SESSION['var_email']);
        unset($_SESSION['var_senha']);
        // unset($_SESSION['var_resposta_seguranca']);
        // unset($_SESSION['var_pergunta_seguranca']);

        return redirect('profile','success','profile_success');
    }
} else {
    return redirect('profile','danger','empty_recaptcha');
}
