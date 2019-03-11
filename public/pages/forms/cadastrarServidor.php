<?php

require '../../../bootstrap.php';
require '../../../app/functions/bdq.php';

$captcha = $_POST['g-recaptcha-response'];

if($captcha){
    $secreto = '6LeeUVYUAAAAANLUiZedycN-FK4Z--MNNCEKm40u';
    $ip = $_SERVER['REMOTE_ADDR'];
    $var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secreto&response=$captcha&remoteip=$ip");
    $resposta = json_decode($var,true);
    
    if($resposta['success'] == true){
        $validate = validate([
            'name' => 's',
            'phone' => 'i',
            'email' => 'e',
        ]);
        $criada        = date("Y-m-d");
        
        $horarios = $_POST['horarios_ser'];
        $senha = md5('.servidor1');
        $result_msg_contato = "INSERT INTO ser_servidores (ser_nome, ser_email, ser_telefone, ser_senha, ser_criada, ser_ativo) VALUES ('$validate->name', '$validate->email', '$validate->phone', '$senha', '$criada', '1')";

        if(!DBExecute($result_msg_contato)){
            return redirect('cadastrarServidor','danger','proc_failed');
        }
        $id = DBReadOne("ser_servidores","ser_id","WHERE ser_email = '$validate->email'");   
        if($horarios!=NULL){
            for ($i = 0; $i< Count($horarios);$i++){
                $result_msg_contato = "INSERT INTO ser_servidores__hor_horarios (ser_id, hor_id) VALUES ('$id','$horarios[$i]')";

                if(!DBExecute($result_msg_contato)){                    
                    return redirect('cadastrarServidor','danger','proc_failed');
                }
            }
        }
        $newDate = new DateTime($validate->dateday);
        $criada = date("d-m-Y H:i:s");

        $mensagem = "Olá, {$validate->name}. Seja bem-vindo(a). <br>
                        Sua ativação já está concluída. Em breve você receberá agendamentos. <br>
                        Verifique suas configurações na plataforma, pois pode estar faltando alguns dados, além de haver a possibilidade de ter algo errado. <br>
                        Inclusive, você deve trocar sua senha! A senha padrão é: <br> <strong>.servidor1<strong> <br>
                        Caso haja dúvidas sobre a utilização da ferramenta, há o Guia. Você pode acessá-lo pelo botão Ajuda (fica ao lado de Perfil e Sair)  <br>
                        Não se preocupe, avisaremos quando isso ocorrer. <br>
                        Data de Cadastramento: {$criada} <br>
                        <br>
                        <br>
                        <br>
                        <i>Att <br><br>
                        Equipe SEDEPTI </i>";
        
        $data = [
            'para'         =>[$validate->email],
            'assunto'      =>"Comprovante de cadastramento",
            'mensagem'     =>$mensagem,
        ];


        if(send($data)){    
            return redirect('cadastrarServidor','success','proc_successed');
        } else {
            return redirect('cadastrarServidor','danger','proc_failed');
        }
    }
} else {
    return redirect('cadastrarServidor','danger','empty_recaptcha');
}