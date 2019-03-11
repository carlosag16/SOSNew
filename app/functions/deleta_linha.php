<?php
//Está é a página de cancelar e descancelar agendamentos.
    require_once("../../bootstrap.php");
    require_once("efetuar_des_cancelamento.php");
    require_once("bdq.php"); //Não é necessário nessa página, porém, é necessário na página efetuar_des_cancelamento.php. Entretanto, o desenvolvedor teve que retirar de lá, visto que é preciso do bdq.php na página forms/cancelar_agendamento_usuario.php para validar um email. Acontece que estavam ocorrendo 2 require("bdq.php") e isso causa Fatal Error. Portanto, o desenvolvedor teve que retirar de efetuar_des_cancelamento.php e adicionar nas páginas que o antecede.
    session_start();

    if(isset($_POST['submit'])){//PAra rodar apenas quando o botão submit for acionado.
        if(!empty($_POST['list_check'])){ //lista de agendamentos selecionados. Se estiver vazio, não entra.
            // Loop to store and display values of individual checked checkbox.
            foreach($_POST['list_check'] as $selected){
                
                $tipo = $_SESSION['tipo'];
                $session_idServ = $_SESSION['id'];
                $session_cancelado = $_SESSION['cancelado'];
                $session_concluidos = $_SESSION['concluidos'];
                $caminho = CAM_ADMIN;

                func_des_cancelamento($selected,$tipo,$session_idServ,$session_cancelado,$session_concluidos,$caminho);
                
                return header("location:".$caminho."?status=success&cancelado={$session_cancelado}&type_message=anymessage&message=O processo foi feito com sucesso."); 
            }                
        } else {
            return header("location:".CAM_ADMIN."?cancelado={$_SESSION['cancelado']}&message=Você selecionou nada!");
        }
    }
?>