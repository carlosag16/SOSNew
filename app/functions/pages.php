<?php
    //Serve para saber se a página colocada no ?page existe e também para adicionar mensagens nas páginas.
    function load() {
        //Serve para pegar o ?page &status &type_message &message da URI, respectivamente.
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
        $complete = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);
        $type_message = filter_input(INPUT_GET, 'type_message', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_GET, 'message', FILTER_SANITIZE_STRING);
        
        //Salva a página, pois esta será transformada para 'pagina'.php e por causa do $page="pages/contato.php" esse salvamento é necessário.
        $indiceAssunto = $page;
        
        $page = (!$page) ? "pages/contato.php" : "pages/$page.php";        
        
        function texto($tipo,$ind_assunto=0,$t_msn,$msn=''){
            
            $tipos = [
                'success' => 'lightgreen',
                'danger' => 'lightcoral'
            ];
            
            $assunto = [
                'contato'           => 'O agendamento',
                'cadastrarServidor' => 'O cadastro',
                'desabilitarDia'    => 'O processo',
                'login'             => 'O login'
            ];
            
            $mensagem = [
                'page_not_found' => 'A página requerida não foi encontrada. Você foi redirecionado para a Página Inicial.',
                'proc_successed' => "{$assunto[$ind_assunto]} foi feito com sucesso.",
                'proc_failed'  => "{$assunto[$ind_assunto]} foi feito com falha.",
                'empty_recaptcha' => 'O reCaptcha não foi preenchido. Por favor, preencha-o.',
                'login_failed_email_unknown' => 'Esse email não foi cadastrado.',
                'login_failed' => 'O email inserido não confere com esta senha.',
                'unset_login' => 'Você precisa estar logado para acessar esta área.',
                'unset_adm' => 'Você precisa ser administrador para acessar esta área.',
                'profile_success' => 'As alterações foram feitas com sucesso!',
                'unset_remember_login' => 'Você precisar ter inserido seu email!',
                'login_failed_wrong_answer' => 'Você inseriu a resposta errada.',
                'any_message' =>''
            ];
            
            echo "<p style=\"margin-top:15px; font-size:18px; background-color:{$tipos[$tipo]}; border-radius:5px; padding: 7px 13px;\"><strong>{$mensagem[$t_msn]}{$msn}</strong></p>";
        }
        
        if(!file_exists($page)){
            $page = "pages/contato.php";
            texto($complete,'',$type_message,'');
        }
        
        texto($complete,$indiceAssunto,$type_message,$message);
        
        return $page;
    }