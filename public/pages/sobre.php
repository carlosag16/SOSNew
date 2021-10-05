<a style="text-decoration:none; cursor:pointer;" href="<?php //echo CAM_RAIZ?>?page=contato">

<img id="normaliza_img" style="padding-top: 5vh" src="<?php echo CAM_RAIZ_2?>sos normaliza.png"/></a>

<?php include_once('menu-contato.php') ?>

<?php
    session_start();
    /*
    if(!isset($_SESSION['id'])){
        echo "
            <button type=\"button\" id=\"login\"  title=\"Login do Bibliotecário: gerenciar meus agendamentos\" style=\"float:right; margin: 16% 5% 0 0;\" class=\"btn btn-primary\" onclick=\"window.location.href='".CAM_RAIZ."?page=login'\"> Login</button>
        ";
    }*/
    ?>

<!--CONTEINER 1-->
<div>
    <!--HEADER 1-->
    <div>

        <h1>
            <div class="identificadorPasso">1</div> <div style="font-size:26px!important;" class="info-aux">O que é o SOS Normaliza?</div><br/>
        </h1>
    </div>
    <!--BODY 1-->
    <div>
        <p style="text-align: justify">
             O SOS Normaliza é um serviço voltado para a orientação sobre normalização acadêmica para os alunos (graduação, especialização, mestrado, doutorado), professores e servidores da Universidade Federal do Pará. O tempo médio de orientação é de 1 (uma) hora, com o objetivo de sanar as principais dúvidas do solicitante com relação às normas acadêmicas, conforme a ABNT. Através do sistema o solicitante marca o dia e horário e um bibliotecário devidamente preparado irá atender conforme solicitação online ou presencial.
        </p>
    </div>
</div>

<!--CONTEINER 2-->

<div>
    <!--HEADER 2-->
    <div>
        <h1>
            <br/><div class="identificadorPasso">2</div> <div style="font-size:26px!important;" class="info-aux">Quem pode usufruir do serviço?</div><br/>
        </h1>
    </div>

    <!--BODY 2-->
    <div>
        <p style="text-align: justify">
            Alunos (graduação, especialização, mestrado, doutorado), professores e servidores da Universidade Federal do Pará.
        </p>
    </div>
</div>

<!--CONTEINER 3-->

<div>
    <!--HEADER 3-->
    <div>
        <h1>
            <br/><div class="identificadorPasso">3</div> <div style="font-size:26px!important;" class="info-aux">Ocorreu um imprevisto, é possível remarcar ou cancelar a orientação?</div><br/>

        </h1>
    </div>

    <!--BODY 3-->

    <div>
        <p style="text-align: justify">
            Sim. Você poderá notificar por e-mail que não será possível comparecer ao dia marcado.
        </p>
    </div>
</div>

<!--CONTEINER 4-->

<div>
    <!--HEADER 4-->
    <div>
        <h1>
            <br/><div class="identificadorPasso">4</div> <div style="font-size:26px!important;" class="info-aux">É cobrada alguma taxa pelo serviço?</div><br/>
        </h1>
    </div>
    <!--BODY 4-->
    <div>
        <p style="text-align: justify">
            Não. Assim como todos os serviços e produtos da Biblioteca Central da UFPA, o SOS Normaliza é gratuito.
        </p>
    </div>
</div>

<!--CONTEINER 5-->

<div>
    <!--HEADER 5-->
    <div>
        <h1>
            <br/><div class="identificadorPasso">5</div> <div style="font-size:26px!important;" class="info-aux">O que é preciso para agendar?</div><br/>
        </h1>
    </div>
    <!--BODY 5-->
    <div>
        <p style="text-align: justify">
            É necessário acessar <a href="<?php echo CAM_RAIZ?>?page=contato">este link</a> e preencher os dados solicitados. Feito isso, você receberá um e-mail, confirmando o dia e o horário escolhido. O sistema também te enviará um lembrete via e-mail no dia de sua orientação.
        </p>
    </div>
</div>
