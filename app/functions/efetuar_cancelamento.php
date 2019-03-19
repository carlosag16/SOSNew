<?php

    function func_cancelamento($selected,$tipo,$session_idServ,$session_cancelado,$session_concluidos,$caminho) {

        $criada = date("d/m/Y H:i:s");
        $hoje = date("Y-m-d");

        $idServ = DBReadOne('agd_agendamentos','ser_id',"WHERE agd_id = $selected"); //Recebe ID do servidor.
        if(($tipo == 'Administrador') or ($session_idServ == $idServ) or ($session_idServ == -1)) { //Teste para verificar se o agendamento escolhido é da pessoa, se não falha. Ou o ADM que pode desativar de qualquer um. Ou é um cancelamento feito pelo usuário, no caso -1.

            //Se apenas for a troca para dizer se compareceu ou não, não precisa enviar e-mail.
            if($session_concluidos == 1){
               return header("location:".$caminho."?status=success&cancelado={$session_cancelado}&type_message=anymessage&message=O processo foi feito com sucesso.");
            }

            if($session_cancelado==0){//Se estiver descancelado, cancela. Caso contrário, descancela.
                 DBExecute("UPDATE agd_agendamentos SET agd_cancelado= 1, agd_concluido = 1 WHERE agd_id = ".$selected);
            } else {
                 DBExecute("UPDATE agd_agendamentos SET agd_cancelado=0 WHERE agd_id = $selected");
            }

            //Coloca no Banco de dados. Esse IF não está correto, pois a falha vai ocorrer em bdq.php e este erro aparecerá na tela. Deve-se corrigir.
            // if(!DBExecute($result_msg_contato)){
            //        return header("location:".$caminho."?status=danger&cancelado={$session_cancelado}&type_message=anymessage&message=O processo foi feito com falha.");
            // }

            //Recebe e-mail da pessoa que fez agendamento. Para ser avisada.
            $para = DBReadOne('agd_agendamentos','agd_email',"WHERE agd_id = $selected");

            //Recebe a data do agendamento, para que o servidor saiba qual dia foi cancelado.
            $agd_data = DBReadOne('agd_agendamentos','agd_data',"WHERE agd_id = $selected");

            $agd_data = new DateTime($agd_data);
            //Além do dia, o horário também.
            $horaID = DBReadOne('agd_agendamentos','hor_id',"WHERE agd_id = $selected");
            $horaValor = DBReadOne('hor_horarios','hor_valor',"WHERE hor_id = $horaID");

            //Aqui recebe o ID e o e-mail, respectivamente. Para avisá-lo, caso tenha sido o ADM que tenha cancelado.
            $servidorID = DBReadOne('agd_agendamentos','ser_id',"WHERE agd_id = $selected");
            $servidorEmail = DBReadOne('ser_servidores','ser_email',"WHERE ser_id = $servidorID");

            $hora_final = date("H:i", strtotime($horaValor) + 90*60);

            $mensagem = "
                        Dia do agendamento: {$agd_data->format('d/m/Y')} <br>
                        Hora do agendamento: $horaValor até $hora_final <br>
                        Data do Cancelamento: $criada <br>
                        <br>
                        <br>
                        <i>Att <br><br>
                        Equipe SEDEPTI </i>
                        <br>
                        <img src=\"http://bc.ufpa.br/sosnormaliza/app/sos%20normaliza.png\" alt=\"SOS Normaliza\" style=\"height:200px;width:200px;\">";

            //Prepara vetor de dados para enviar e-mail.
            $data = ['para'=>[$para,$servidorEmail]];

            //Caso tenha sido para cancelar, envia esse email. Se não, outro tipo de email.
            if($session_cancelado==0){
                if(($agd_data->format('Y-m-d') == $hoje) and (date("H:i")>$horaValor)){

                    $data['mensagem'] = "Informamos que seu agendamento foi cancelado, porque você não apareceu no horário determinado. Por favor, seja mais atencioso e pontual com seus compromissos. <br> <br>".$mensagem;

                    $data['assunto'] = "Aviso de Falta: Agendamento BC.";

                    if(!send($data)){
                       return header("location:".$caminho."?status=danger&cancelado={$session_cancelado}&type_message=anymessage&message=O apenas o envio do email de cancelamento foi feito com falha.");
                    }
                } else {

                    $data['mensagem'] = "Informamos que seu agendamento foi cancelado. Para mais informações, contate o servidor responsável. <br> <br>".$mensagem;

                    $data['assunto'] = "Aviso de Cancelamento de seu Agendamento BC.";

                    if(!send($data)){
                       return header("location:".$caminho."?status=danger&cancelado={$session_cancelado}&type_message=anymessage&message=O apenas o envio do email de cancelamento foi feito com falha.");
                    }
                }

            } else {

                $data['mensagem'] = "Informamos que seu agendamento foi reativado. Para mais informações, contate o servidor responsável. <br> <br>".$mensagem;

                $data['assunto'] = "Aviso de reativação de seu Agendamento BC.";

                if(!send($data)){
                   return header("location:".$caminho."?status=danger&cancelado={$session_cancelado}&type_message=anymessage&message=O apenas o envio do email de descancelamento foi feito com falha.");
                }
            }
        } else { //Se a pessoa tentou cancelar um agendamento que não é dela.
            return header("location:".$caminho."?status=danger&cancelado={$session_cancelado}&type_message=anymessage&message=Apenas o Administrador pode cancelar/descancelar qualquer agendamento. Você pode apenas os quais você é responsável.");
        }
    }
