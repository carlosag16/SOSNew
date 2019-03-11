
<?php
    require "../bootstrap.php";
    require "../app/functions/bdq.php";
    session_start();
    echo "<script> alert(window.location.href == '".CAM_BC.CAM_RAIZ."'); if(window.location.href == '".CAM_BC.CAM_RAIZ."' || location.href == '".CAM_BC_2.CAM_RAIZ."'){ window.location.href = '".CAM_BC.CAM_RAIZ."'?page=contato}</script>";
?>
<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="utf-8"/>
        <!-- Cores no navegador mobile -->
        <meta name="theme-color" content="#1d1d1b">
        <meta name="apple-mobile-web-app-status-bar-style" content="#1d1d1b">
        <meta name="msapplication-navbutton-color" content="#1d1d1b">

        <title>SOS Normaliza</title>
        <?php
            $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
            if($page == 'contato'){
                echo "<link rel=\"shortcut icon\" href=\"".CAM_RAIZ_2."sos.ico\">";
            } else {
               echo "<link rel=\"shortcut icon\" href=\"".CAM_RAIZ_2."SistCA.ico\">";
            }
        ?>

        <link rel="stylesheet" type="text/css" media="screen" href="../app/estilo.css" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!--<link rel="stylesheet" href="//resources/demos/style.css">-->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="../app/functions/scriptAgendamento.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>

        <!-- Script do Login usando Google -->
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <meta name="google-signin-client_id" content="599960979958-ieqqfo66r66uaj1e1aup7trgf5u230p0.apps.googleusercontent.com">


        <link rel='stylesheet' href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/>

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-131277442-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-131277442-1');
		</script>


    </head>

    <body>

        <div class="main-inner">

            <div>
                <?php
                    if(filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING) == 'contato'){ include_once("pages/menu-contato.php"); echo "<br>";} ?>
            </div>
            <?php

            try {
                require load();
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            ?>

        </div>

    </body>


    <footer>

    	<div class="main-footer">
    		<center>

                <a href="http://bc.ufpa.br" target="_blank" title="Ir para a página da Biblioteca Central"><img src="../app/BC.png" class="footer-logo" style="width: 12%;"/></a>
                <br/><br/>
                <a href="http://bc.ufpa.br/guia-de-trabalhos-academicos" target="_blank" title="Consultar o Guia de Trabalhos Acadêmicos" style="color:#e7302a!important;">Consultar Guia de Trabalhos Acadêmicos</a>
                <br/><br/>
                <strong>Universidade Federal do Pará<br/>
                Biblioteca Central Prof. Dr. Clodoaldo Beckmann</strong><br/>
                End.: Rua Augusto Corrêa, n. 1 – CEP 66075-110 Belém – PA<br/>
                Desenvolvido e mantido por <strong>SEDEPTI</strong>.<br/>

            </center>
		</div>

    </footer>


</html>
