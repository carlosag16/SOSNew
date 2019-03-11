<?php

//Caso para não sofrer probelmas caso haja mudanças entre GET e POST. Necessidade dela em validate.php
function request(){
    $request = [
        'POST' => $_POST,
        'GET'  => $_GET
    ];
    
    return $request[$_SERVER['REQUEST_METHOD']];    
}

//redireciona de forma personalizada para outra página. É o atalho responsável para mostrar as mensagens de erros.
function redirect($target,$complete='',$type_message='',$message=''){
    if($target == '/'){
        return header("location:".CAM_RAIZ);
    }
    //page: É a página para onde este será encaminhado.
    //status: success/danger. Serve para indicar a cor da caixinha.
    //type_message: Inidica qual tipo de mensagem vai ser indicada. Ex: proc_sucessed. Indica que aparecerá uma mensagem dizendo que o processo foi feito com sucesso.
    //message: deve ser utilizado somente quando type_message=any_message. Aqui será enviada manualmente a mensagem. Isto é, não será armazenada na sessão de mensagens.
    return header("location:".CAM_RAIZ."?page=$target&status=$complete&type_message=$type_message&message=$message");
}
