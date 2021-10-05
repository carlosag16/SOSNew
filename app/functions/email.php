<?php
//Função para enviar e-email, via classe PHPMailer. Na atual configuração, verificar se há formas de otimizar, isto é, enxugar código.
function send(array $data) {
        
    $email = new PHPMailer\PHPMailer\PHPMailer;  
    $email->Charset = 'UTF-8';
    $email->SMTPSecure = 'ssl';
    $email->isSMTP();
    $email->Host = 'smtp.gmail.com';
    $email->Port = 465;
    $email->SMTPAuth = true;
    $email->Username = 'sosnormalizabc@gmail.com'; //para fazer login no email.
    $email->Password = '@gend@2018ADM'; //senha do email.
    $email->isHTML(true);
    $email->setFrom('sosnormalizabc@gmail.com'); //Quem envia o e-mail.
    $email->FromName = utf8_decode('Administração de Agendamentos da BC-UFPA'); //nome de quem envia o email.
    
    foreach($data['para'] as $value){$email->addAddress($value);}; //Destinatários dos e-mails
    
    $email->Subject = utf8_decode($data['assunto']); //Assunto do e-email. Importante deixar o utf8_decode para e-mails que tem problemas com acentuações (como o outlook (Valeu, Shimada!)) E também o Assunto no GMAIL sempre dá problema.
    
    $email->AltBody = strip_tags(stripslashes(utf8_decode($data['mensagem'])));//Texto alternativo.
    //Texto principal, que vai no corpo do e-mail.
    
    $email->MsgHTML( utf8_decode($data['mensagem']) ); //Mensagem em HTML
    
    if($data['arquivo'] != NULL){
        $email->AddAttachment($data['arquivo']['tmp_name'], $data['arquivo']['name']); //Anexo de arquivos
    }

    if($email->send()){
        return 'ok';
    } else {
        return $email->ErrorInfo;
    }
    
}