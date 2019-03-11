<a style="text-decoration:none; cursor:pointer;" href="<?php //echo CAM_RAIZ?>?page=contato">
<img id="normaliza_img" style="max-width: 20%;float: right;margin: 0px!important" src="<?php echo CAM_RAIZ_2?>sos normaliza.png"/></a>
<br><br><br>

<?php 
    session_start();
    if($_SESSION['id'] == NULL){return redirect("login","danger","unset_login");}
    if($_SESSION['email'] != 'adm.bc.agendamento@gmail.com'){ return redirect("login","danger","unset_adm");}
?>
<h2><div style="font-size:28px!important;clear: both;" class="info-aux">Desabilitar dia</div></h2>

<form action="pages/forms/desabilitarDia.php" method="POST" role="form">
    
    <div>
    
        <label for="">Escolha o dia que deseja desabilitar/habilitar:</label>
        
        <input type="text" class="form-control" autocomplete="off" id="datepicker_dd" name="dateday" placeholder="Clique para escolher" required>
        
        <div id="time_box_dd" style="margin-bottom:30px;"></div>
        
        
    </div>
    
    
    <div>
    
        <label for="">Deseja adicionar algum comentário sobre a desabilitação/habilitação?</label>
        
        <textarea type="text" class="form-control" name="comment" placeholder="Escreva aqui"></textarea>

    </div>
    
    <br/>
    <div style="max-width:450px;margin:0px auto;">
        <button type="submit" class="btn btn-primary">Confirmar</button>
        <button type="button" style="margin-left:5%;" class="btn btn-primary" onclick="window.location.href='<?php echo CAM_ADMIN?>'">Voltar ao Painel Principal</button>
    </div>

</form>