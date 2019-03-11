<?php include_once("../../bootstrap.php"); include_once("../../app/functions/scriptAgendamento.js");?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="<?php echo CAM_RAIZ_2?>estilo-menu.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo CAM_RAIZ_2?>fontAwesome/web-fonts-with-css/css/fontawesome-all.min.css">

    <script>
      function abreMenu() {
          document.getElementById("myDropdown").classList.toggle("show");
      }

      window.onclick = function(e) {
        if (!e.target.matches('.dropbtn')) {
          var myDropdown = document.getElementById("myDropdown");
            if (myDropdown.classList.contains('show')) {
              myDropdown.classList.remove('show');
            }
        }
      }
    </script>

</head>

  <body>

    <div class="menu">
      <div class="navbar">
        <a href="<?php echo CAM_BC_1?>" class="home"><img src="<?php echo CAM_RAIZ_2?>BC.png" width="45"/></a>

        <div class="navbar-right">
          <div class="dropdown">

            <button class="dropbtn" onclick="abreMenu()" id="active"><a class="dropbtn" id="active" shref="<?php echo CAM_RAIZ?>?page=contato" style="padding:0;">Agendamento <span class="glyphicon glyphicon-menu-down" id="icon-dropdown"></span></a>
            </button>

            <div class="dropdown-content" id="myDropdown">

              <a href="<?php echo CAM_RAIZ?>?page=cancelar_agendamento_usuario" data-toggle="tooltip" data-placement="right" title="Cancelar agendamento"> <span class="glyphicon glyphicon-remove-sign" id="icon-cancela" ></span>
                Cancelar
              </a>

              <a href="<?php echo CAM_RAIZ?>?page=contato" data-toggle="tooltip" data-placement="right" title="Realizar agendamento"><span class="glyphicon glyphicon-calendar" style="padding-right: 10px"></span>
                Agendar
              </a>


              <?php
                if($_SESSION['id'] == NULL){
                  echo '<a href="'.CAM_RAIZ.'?page=login" data-toggle="tooltip" data-placement="right" title="Entrar como bibliotecário/Administrador"><span class="glyphicon glyphicon-user" style="padding-right: 10px"></span>
                  Administrador
                  </a>';
                }else{
                  echo '<a onclick="window.location.href=\''.CAM_ADMIN.'\'" data-toggle="tooltip" data-placement="right" title="Entrar como bibliotecário/Administrador"><span class="glyphicon glyphicon-user" style="padding-right: 10px"></span>
                  Voltar ao painel
                  </a>';
                }
               ?>

          </div>
        </div>
              <a href="<?php echo CAM_RAIZ?>?page=sobre" ><span class="glyphicon glyphicon-info-sign" id="icon-info"></span> Sobre</a>


        </div>
      </div>
    </div>

  </body>

</html>
