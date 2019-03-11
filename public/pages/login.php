<?php session_start()?>
<?php include_once('menu-contato.php') ?>
<a style="text-decoration:none; cursor:pointer;" href="<?php echo CAM_RAIZ?>?page=contato">
<img id="normaliza_img" src="<?php echo CAM_RAIZ_2?>sos normaliza.png"/></a>

<div class="info-box" style="text-align: center!important">
    Bem vindo(a)! Para administrar os agendamentos, por favor, realize login.
</div>

<p id='msg'></p>


<form action="pages/forms/login.php" method="POST" role="form">

    <div class="form-separate">

        <label for="">E-mail</label>

        <input type="email" class="form-control" name="email" placeholder="example@example.com" value="<?php echo $_SESSION['var_email']?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="example@example.com" required/>

    </div>

    <div class="form-separate">

        <label for="">Senha</label>

        <input type="password" class="form-control" name="senha" placeholder="Sua senha" value="<?php echo $_SESSION['var_senha']?>" required/>

    </div>
        <br>
    <div class="form-separate">
        <div class="g-recaptcha" data-sitekey="6LeeUVYUAAAAAIHHqk_bg6qXdnYbRMmx6OMSeYiV"></div>
    </div>
    <br/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <div style="margin:0 12%;">
        <button type="submit" class="btn btn-primary">Login</button>

        <button type="button" style="margin-left:5%;" class="btn btn-primary" onclick="window.location.href='<?php echo CAM_RAIZ?>?page=contato'">Voltar à tela de agendamento</button>

        <button type="button" style="margin-left:5%;" class="btn btn-primary" onclick="window.location.href='<?php echo CAM_RAIZ?>?page=remember_login_in' ">Esqueceu sua senha?</button>
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

<!--

<div class="form-separate">

        <div class="g-signin2" data-onsuccess="onSignIn"></div>

    </div>

    <script>

        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            var userID = profile.getId();
            var userName = profile.getName();
            var userPicture = profile.getImageUrl();
            var userEmail = profile.getEmail();
            var userToken = googleUser.getAuthResponse().id_token;

            /*console.log('ID: ' + profile.getId());
            console.log('Name: ' + profile.getName());
            console.log('Image URL: ' + profile.getImageUrl());
            console.log('Email: ' + profile.getEmail()); */

            //document.getElementById('msg').innerHTML = userEmail;
            if(userEmail !== ''){
                var dados = {
                    userID:userID,
                    userName:userName,
                    userPicture:userPicture,
                    userEmail:userEmail
                };
                $.post('../pages/valida.php', dados, function(retorna){
                    if(retorna === '"erro"'){
                        var msg = "<div class='alert alert-danger'>Usuário não encontrado com esse e-mail!</div>";
                        document.getElementById('msg').innerHTML = msg;
                    }else{
                        window.location.href = retorna;
                    }

                });
            }else{
                var msg = "Usuário não encontrado!";
                document.getElementById('msg').innerHTML = msg;
            }
        }

    </script>-->
