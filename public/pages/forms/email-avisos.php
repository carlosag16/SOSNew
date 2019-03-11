<?php

    require '../../../bootstrap.php';
    require '../../../app/functions/bdq.php';

    session_start();

    $validate = validate([
        'title'   => 's',
        'comment' => 's'
    ]);
    
    $validate->comment = nl2br($validate->comment);
    $criada = date("Y-m-d");

    $result_msg_contato = "INSERT INTO avi_avisos (ser_id,avi_assunto,avi_mensagem,avi_criada) VALUES ('{$_SESSION['id']}','$validate->title','$validate->comment','$criada')";

    DBExecute($result_msg_contato);

    $ser_emails = DBRead("ser_servidores","ser_email");

    $data = [
            'assunto'  =>$validate->title,
            'mensagem' =>$validate->comment,
            'para'     =>$ser_emails,
            'arquivo'  =>$_FILES['agd_files']
        ];


    send($data);

    return redirect('email-avisos','success','proc_successed');