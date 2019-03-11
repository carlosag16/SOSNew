<?php session_start()?>
<a style="text-decoration:none; cursor:pointer;" href="<?php //echo CAM_RAIZ?>?page=contato">
<img id="normaliza_img" src="<?php echo CAM_RAIZ_2?>sos normaliza.png"/></a>

<div class="info-box" style="text-align: center!important">
    Esqueceu sua senha? Insira seu e-mail para recupera-la!
</div>


<form action="pages/forms/remember_login_in.php" method="POST" role="form">
    
    <div>
    
        <label for="">Insira seu e-mail</label>
        <input type="text" class="form-control" name="email" placeholder="sedepti@ufpa.br" value="<?php echo $_SESSION['var_email_in']?>" required/>
    
    </div>
        <br>    
    <div>
        <div class="g-recaptcha" data-sitekey="6LeeUVYUAAAAAIHHqk_bg6qXdnYbRMmx6OMSeYiV"></div>
    </div>
    <br/>
    <div style="margin: 0 25%">
        <button type="submit" class="btn btn-primary">Recuperar senha</button>
        <button type="button" style="margin-left:5%;" class="btn btn-primary" onclick="window.location.href='<?php echo CAM_RAIZ?>?page=login'">Voltar à tela de login</button>
    </div>
    
    <?php 
    session_start();
    if(isset($_SESSION['id'])){
        echo "
            <button type=\"button\" style=\"margin-left:5%;\" class=\"btn btn-primary\" onclick=\"window.location.href='".CAM_ADMIN."'\">Voltar ao Painel Principal</button>
        ";
    }
    ?>

</form>