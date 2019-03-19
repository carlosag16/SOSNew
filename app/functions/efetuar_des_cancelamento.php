<?php
    /*By: Jairo Filho
      Edited by: Teo Quaresma;
    */
    function func_des_cancelamento($selected, $session_cancelado, $caminho) {

      $criada = date("d/m/Y H:i:s");
      $hoje = date("Y-m-d");

      //Recebe ID do servidor referente aquele agendamento ($selected)
      $idServ = DBReadOne('agd_agendamentos','ser_id',"WHERE agd_id = $selected");

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

      //Caso tenha sido para cancelar, envia esse email.
      if($session_cancelado==0){
          if(($agd_data->format('Y-m-d') == $hoje) and (date("H:i")>$horaValor)){
            

              $data['mensagem'] = "<h3><b>SOS Normaliza<b></h3>Informamos que seu agendamento foi cancelado, porque você não apareceu no horário determinado. Por favor, seja mais atencioso e pontual com seus compromissos. <br> <br>".$mensagem;
              $data['assunto'] = "Aviso de Falta: Agendamento BC.";

          }
          else {
              $data['assunto'] = "Aviso de Cancelamento: Agendamento BC.";

              $data['mensagem'] = "<h3><b>SOS Normaliza<b></h3>Informamos que seu agendamento foi cancelado. Para mais informações, contate o servidor responsável. <br> <br>".$mensagem;

              // $data['assunto'] = "Aviso de Cancelamento de seu Agendamento BC.";

          }
    }
  ?>
