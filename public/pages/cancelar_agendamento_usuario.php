<?php
    session_start();
    $code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
    $email_id = base64_decode(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING));
    if($code !=''){
        $_SESSION['var_code_cancelamento'] = $code;
    }
    if($email_id !=''){
        $_SESSION['var_email_id_cancelamento'] = $email_id;
    }
?>
<?php include_once('menu-contato.php') ?>

<a style="text-decoration:none; cursor:pointer;" href="<?php //echo CAM_RAIZ?>?page=contato">

<img id="normaliza_img" style="padding-top: 5vh" src="<?php echo CAM_RAIZ_2?>sos normaliza.png"/></a>

<form action="pages/forms/cancelar_agendamento_usuario.php" method="POST" role="form">

    <!-- Definição do Passo 1 -->
    <div class="identificadorPasso">1</div> <div class="info-aux">Insira o Código de Segurança</div><br/>
    <!-- Campo de matrícula -->
    <div class="form-separate">
        <input type="text" class="form-control" name="codigo" placeholder="Seu código..." value="<?php echo $_SESSION['var_code_cancelamento']?>" required/>
    </div>
    <br/>

    <!-- Definição do Passo 1 -->
    <div class="identificadorPasso">2</div> <div class="info-aux">Insira o E-mail</div><br/>
    <!-- Campo de matrícula -->
    <div class="form-separate">
        <input type="text" class="form-control" name="email" placeholder="E-mail cadastrado no ato do agendamento" value="<?php echo $_SESSION['var_email_id_cancelamento']?>" required/>
    </div>
    <br/>

    <!-- Definição do Passo 2 -->
    <div class="identificadorPasso">3</div> <div class="info-aux">Valide o re-CAPTCHA</div><br/>
    <div class="form-separate">
        <!-- Gerador do re-CAPTCHA -->
        <div class="g-recaptcha" data-sitekey="6LeeUVYUAAAAAIHHqk_bg6qXdnYbRMmx6OMSeYiV"></div>
    </div>
    <br/>
    <br/>
    <br/>

    <center>
        <div style="display: inline;">
            <!-- Botão para chamar confirmação de cancelamento -->
            <button type="submit" style="display: inline" class="btn btn-primary">Realizar cancelamento</button>
        </div>
    </center>

</form>
