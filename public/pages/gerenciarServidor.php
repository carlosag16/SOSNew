<?php include_once('menu-contato.php') ?>


<a style="text-decoration:none; cursor:pointer;" href="<?php //echo CAM_RAIZ?>?page=contato">
<img id="normaliza_img" style="max-width: 20%;float: right;margin: 0px!important" src="<?php echo CAM_RAIZ_2?>sos normaliza.png"/></a>
<br><br><br>

<?php
//require_once("../../app/functions/custom.php");
session_start();
if($_SESSION['id'] == NULL){return redirect("login","danger","unset_login");}
if($_SESSION['email'] != 'adm.bc.agendamento@gmail.com'){ return redirect("login","danger","unset_adm");}
?>

<h2><div style="font-size:28px!important;clear: both;" class="info-aux">Cadastrar servidor</div></h2>


<form action="pages/forms/cadastrarServidor.php" method="POST" role="form">

    <div>

        <label for="">Nome</label>
        <input type="text" class="form-control" name="name" placeholder="Diego Barros" required/>

    </div>
    <br>
    <div>

        <label for="">Email</label>

        <input type="text" class="form-control" name="email" placeholder="sedepti@ufpa.br" required/>

    </div>
    <br>
    <div>

        <label for="">Telefone</label>

        <input type="text" class="form-control" name="phone" placeholder="91982146347"/>

    </div>

    <br>

    <div>

        <label for="">Horários de atuação:</label>

    <?php
        //require_once("../../app/functions/bdq.php");
        $horarios = DBRead("hor_horarios","hor_valor");
        $id = DBRead("hor_horarios","hor_id");
        echo "<br>";
        for($i = 0; $i < Count($id);$i++){
            echo "
                <div style=\"display:inline-block;margin-right:10px;margin-top:10px;\">
                    <label class=\"checkbox-inline\" ><input type=\"checkbox\" name=\"horarios_ser[]\" value=\"$id[$i]\" checked>$horarios[$i]</label>
                </div>
            ";
        }
    ?>
    </div>
    <br>
    <div>
        <center><div class="g-recaptcha" data-sitekey="6LeeUVYUAAAAAIHHqk_bg6qXdnYbRMmx6OMSeYiV"></div></center>
    </div>
    <br>

    <div style="max-width:450px;margin:0px auto;">

        <button type="submit" class="btn btn-primary">Cadastrar</button>
        <button type="button" style="margin-left:5%;" class="btn btn-primary" onclick="window.location.href='<?php echo CAM_ADMIN?>'">Voltar ao Painel Principal</button>
    </div>

</form>
