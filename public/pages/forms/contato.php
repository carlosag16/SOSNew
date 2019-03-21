<?php

require '../../../bootstrap.php';
require '../../../app/functions/bdq.php';

$captcha = $_POST['g-recaptcha-response'];

$validate = validate([
            'matricula' => 'i',
            'name' => 's',
            'phone' => 'i',
            'email' => 'e',
            'course' => 's',
            'dateday' => 's',
            'hour' => 's'
        ]);

$_SESSION['var_matricula'] = $validate->matricula;
$_SESSION['var_name'] = $validate->name;
$_SESSION['var_phone'] = $validate->phone;
$_SESSION['var_email'] = $validate->email;
$_SESSION['var_course'] = $validate->course;
$_SESSION['var_question'] = $_POST['question'];
$_SESSION['var_dateday'] = $validate->dateday;
$_SESSION['var_hour'] = $validate->hour;

if(!$_SESSION['var_question']){
    return redirect('contato','danger','any_message');
}

if($captcha){
    $secreto = '6LeeUVYUAAAAANLUiZedycN-FK4Z--MNNCEKm40u';
    $ip = $_SERVER['REMOTE_ADDR'];
    $var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secreto&response=$captcha&remoteip=$ip");
    $resposta = json_decode($var,true);

    if($resposta['success'] == true){
        $criada        = date("Y-m-d");

        $horario_valor = DBReadOne("hor_horarios","hor_valor","WHERE hor_id = \"$validate->hour\"");
        $horario_ser_id = DBRead("ser_servidores__hor_horarios","ser_id","WHERE hor_id = \"$validate->hour\"");

        if(Count($horario_ser_id)>1){
            $frequencias = array();
            foreach($horario_ser_id as $key){

                $freq_servidor = DBReadOne("ser_servidores","ser_contador","WHERE ser_id = \"$key\"");
                array_push($frequencias,$freq_servidor);
            }
            $frequencia_efetivo = array();
            foreach($horario_ser_id as $key=>$value){
                $frequencia_efetivo[$frequencias[$key]] = $horario_ser_id[$key];
            }
            ksort($frequencia_efetivo);

            foreach($frequencia_efetivo as $key=>$value){
                $horario_ser_id = $value;
                $key++;
                $result_msg_contato = "UPDATE ser_servidores SET ser_contador = $key WHERE ser_id = $value";

                if(!DBExecute($result_msg_contato)){
                    return redirect('contato','danger','proc_failed');
                }

                break 1;
            }
        } else {
            $horario_ser_id = $horario_ser_id[0];

            $freq = DBReadOne("ser_servidores","ser_contador","WHERE ser_id = \"$horario_ser_id\"");
            $freq++;
            $result_msg_contato = "UPDATE ser_servidores SET ser_contador = $freq WHERE ser_id = $horario_ser_id";


            if(!DBExecute($result_msg_contato)){
                return redirect('contato','danger','proc_failed');
            }
        }

        $servidorNome = DBReadOne("ser_servidores","ser_nome","WHERE ser_id = \"$horario_ser_id\"");
        $servidorEmail = DBReadOne("ser_servidores","ser_email","WHERE ser_id = \"$horario_ser_id\"");

        $result_msg_contato = "INSERT INTO agd_agendamentos (agd_matricula, agd_nome, agd_email, agd_telefone, agd_curso_programa, agd_data, hor_id, ser_id, agd_criada) VALUES ('$validate->matricula','$validate->name', '$validate->email', '$validate->phone', '$validate->course', '$validate->dateday', '$validate->hour','{$horario_ser_id}', '$criada')";


        if(!DBExecute($result_msg_contato)){
            return redirect('contato','danger','proc_failed');
        }

        $agd_id = mysqli_fetch_array(DBExecute("SELECT agd_id FROM agd_agendamentos WHERE agd_data = \"$validate->dateday\" AND hor_id = \"{$validate->hour}\" AND agd_cancelado = 0"));

        $agd_id = $agd_id[0];

        $str_questions = "";

        foreach($_POST['question'] as $value){
            DBExecute("INSERT INTO prin_principais_duvidas__agd_agendamentos (agd_id, prin_id) VALUES ('$agd_id','$value')");
            $duvida = DBReadOne("prin_principais_duvidas","prin_duvida","WHERE prin_id = \"$value\"");
            $str_questions .=" ".$duvida.";";
        }

        $newDate = new DateTime($validate->dateday);
        $criada = date("d/m/Y H:i:s");

        $hora_final = date("H:i", strtotime($horario_valor) + 90*60);

        $mensagem = "<strong>Nome:</strong> {$validate->name} <br>
                        <strong>E-mail:</strong> {$validate->email} <br>
                        <strong>Curso/Programa:</strong> {$validate->course} <br>
                        <strong>Principais Dúvidas:</strong> {$str_questions} <br>
                        <strong>Dia do Agendamento:</strong> {$newDate->format('d/m/Y')} <br>
                        <strong>Horario:</strong> {$horario_valor} até {$hora_final}<br>
                        <strong>Instrutor(a):</strong> {$servidorNome} <br>
                        <strong>E-mail do Instrutor(a):</strong> {$servidorEmail} <br>
                        <strong>Data de Marcação:</strong> {$criada} <br>
                        <strong>Local:</strong> Biblioteca Central -  Campus Belém.<br>
                        <br>
                        <strong>Código de Cancelamento:</strong> ".base64_encode($agd_id)."<br>

                        <br>
                        <i>No caso de cancelamento, acesse a página do SOS Normaliza. No menu superior, clique em Agenda > Cancelar. Insira seu e-mail e seu Código de Cancelamento. Você também pode clicar no link abaixo para agilizar o processo.</i><br>
                        <br>

                        <a href=\"http://bc.ufpa.br/sosnormaliza/public/?page=cancelar_agendamento_usuario&code=".base64_encode($agd_id)."&id=".base64_encode($validate->email)."\">link para Cancelamento</a><br>

                        <br><br>
                        <strong>IMPORTANTE:</strong> No dia {$newDate->format('d/m/Y')}, dirija-se ao balcão de Referência na BC preferencialmente com 5 minutos de antecedência.
                        <br><br>

                        <br>
                        <br>
                        <br>
                        <i>Att <br><br>
                        <br>
                        <i>Att <br><br>
                        Equipe Biblioteca Central </i>";
                        <br>
                        <img src=\"http://bc.ufpa.br/sosnormaliza/app/sos%20normaliza.png\" alt=\"SOS Normaliza\" style=\"height:200px;width:200px;\">";

        $data = [
            'para'         =>[$servidorEmail,$validate->email],
            'assunto'      =>"SOS Normaliza: Comprovante de agendamento sobre: ".$validate->course,
            'mensagem'     =>$mensagem
        ];


        if(send($data)){
            unset($_SESSION['var_matricula']);
            unset($_SESSION['var_name']);
            unset($_SESSION['var_phone']);
            unset($_SESSION['var_email']);
            unset($_SESSION['var_course']);
            unset($_SESSION['var_question']);
            unset($_SESSION['var_dateday']);
            unset($_SESSION['var_hour']);

            return redirect('contato','success','proc_successed');
        } else {
            return redirect('contato','danger','proc_failed');
        }
    }
} else {
    return redirect('contato','danger','empty_recaptcha');
}
