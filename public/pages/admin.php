

<?php
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
//Só funcionou desse, se conseguir resolver avise-me. By Jairo
require_once('../../app/functions/bdq.php');
require_once('../../bootstrap.php');
require_once('../../app/functions/percentual.php');
require_once('../../app/functions/array_to_json_canvasJS.php');
require_once('../../app/functions/adminQueries.php');

session_start();
if($_SESSION['id'] == NULL){redirect("login","danger","unset_login");}
ini_set('default_charset','UTF-8');
header('Content-Type: text/html; charset=utf-8');

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link rel="shortcut icon" href="<?php echo CAM_RAIZ_2?>SistCA.ico">

	<title>Sist. de Controle de Agendamentos</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="../AdminLTE-master/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../AdminLTE-master/bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../AdminLTE-master/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="../AdminLTE-master/dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="../AdminLTE-master/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="../..<?php echo CAM_RAIZ_2?>functions/scriptAgendamento.js"></script>
	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</head>

<body class="hold-transition skin-red fixed sidebar-mini sidebar-collapse">


	<!-- ====================================
					Para consultar as variáveis usadas nesta página vá em ../../app/functions/adminQueries.php, lá também estão as configurações dos charts
  ===================================-->


	<!-- =================== MEU LATERAL FICA AQUI =============== -->
	<?php include_once('menu-lateral.php') ?>
	<!-- ================================================================ -->
	<div class="wrapper">
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
						<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Painel de controle
					<small>Monitorar e controlar seus agendamentos</small>
				</h1>
				<ol class="breadcrumb">
					<li><a onclick="javascript: location.href='admin.php';"><i class="fa fa-dashboard"></i> Painel de controle</a></li>
				</ol>
			</section>
			<!-- ============= IMPORTANDO O DASHBOARD ============= -->
			<?php

			// if($_SESSION['email'] == 'adm.bc.agendamento@gmail.com'){
			// 	include_once('dashboard.php');
			// }
			?>
			<!-- ================================================= -->
			<!-- Main content -->
			<section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Dashboard (dados gerais do sistema)</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">

          <div class="box box-solid bg-red-gradient">
            <div class="box-header">
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- <button type="button" class="btn btn-danger btn-sm daterange pull-right" data-toggle="tooltip" title="" data-original-title="Date range">
                  <i class="fa fa-calendar"></i></button> -->
                <button type="button" class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
                  <i class="fa fa-minus"></i></button>
              </div>
              <!-- /. tools -->

              <i class="fa fa-bar-chart-o"></i>
              <h3 class="box-title">
                Referente ao mês de <?php echo $mes[$mes_atual]; ?> de <?php echo $ano_atual; ?>
              </h3>
            </div>
            <div class="box-body">

              <div class="container">
                <div class="row">
                    <!-- coluna da esquerda -->
                    <div class="col-md-3" >
                      <!-- quantidade de agendamentos neste mês -->
                      <div class="row" >
                        <div class="col-sm-2">
                          <h1 > <i class="fa  fa-user-plus"></i></h1>
                        </div>
                        <div class="col-sm-9" >
                          <h1> <?php echo $total_agendamentos; ?> </h1>
                          <h6 style="margin-top:-10px">AGENDAMENTOS </h6>
                        </div>
                      </div>
                      <!-- fim do quantidade de agendamentos neste mês -->

                      <!-- agendamentos cancelados neste mes -->
                      <div class="row" >
                        <div class="col-sm-2">
                          <h1 > <i class="fa fa-user-times"></i></h1>
                        </div>
                        <div class="col-sm-9" >
                          <h1> <?php echo $total_agendamentos_cancelados; ?> </h1>
                          <h6 style="margin-top:-10px">AGENDAMENTOS CANCELADOS </h6>
                        </div>
                      </div>
                      <!-- fim do agendamentos cancelados neste mes -->

                      <div class="row" >
                        <div class="col-sm-2">
                          <h1 > <i class="fa fa-check-square-o"></i></h1>
                        </div>
                        <div class="col-sm-9" >
                          <h1> <?php echo $total_agendamentos_realizados; ?> </h1>
                          <h6 style="margin-top:-10px">AGENDAMENTOS REALIZADOS </h6>
                        </div>
                      </div>
                    </div>
                    <!-- coulna do meio -->
                    <div class="col-md-6">
                      <div id="agd_mensal" style="height: 200px; width: 80%;"></div>
                    </div>
                    <!-- coluna da direita -->
                    <div class="col-md-3">
                      <div id="compareceu_vs_naocompareceu" style="height: 300px; width: 100%;">
                    </div>
                </div>
              </div>

            </div>
            <!-- /.box-body-->
          </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
					<div class="box box-danger">
						<div class="box-body">
							<div class="row">
								<!-- coulna de crecimento dos agendamentos e media  -->
								<div class="col-sm-4 col-md-2">
									<div class="row">
										<center>
											<h6>CRESCIMENTO MENSAL DOS AGENDAMENTOS</h6>
											<a class="btn btn-danger disabled" style="width:70%;"> <?php echo $percentual_crescimento; ?>% </a>
										</center>
									</div>
									<div class="row">
										<center>
											<h6>MÉDIA DOS AGEDAMENTOS DE <?php echo $ano_atual; ?></h6>
											<a class="btn btn-danger disabled" style="width:70%;"> <?php echo $media_agd_meses; ?> por mês </a>
										</center>
									</div>
								</div>
								<!-- coluna de principais dúvidas -->
								<div class="col-sm-4 col-md-3">
									<div class="row">
										<!-- grafico chart pie aqui -->
										<div id="prin_duvidas" style="height: 150px; width: 70%;"></div>
									</div>
									<div class="row">
										<!-- aqui era pra ficar a legenda -->
									</div>
								</div>
								<!-- coluna de agedamentos por cursos -->
								<div class="col-sm-4 col-md-4">
									<div class="row">
										<div id="cursos_mais_agd" style="height: 150px; width: 70%;"></div>
									</div>
									<div class="row">
										<!-- aqui era pra ficar a legenda -->

									</div>
								</div>
								<!-- coluna de  atendimentos por servidor -->
								<div class="col-sm-4 col-md-3">
									<div class="row">
										<div id="servidores_mais_agd" style="height: 150px; width: 70%;"></div>

									</div>
									<div class="row">
										<!-- aqui era pra ficar a legenda -->

									</div>
								</div>
							</div>
						</div>
					</div>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
			</section>
		</div>
    <!-- rodapé -->
    <?php include_once('rodape.php') ?>
    <!-- fim do rodapé -->

			<!-- jQuery 3 -->
			<script src="../AdminLTE-master/bower_components/jquery/dist/jquery.min.js"></script>
			<script>
			$.widget.bridge('uibutton', $.ui.button);
			</script>
			<!-- Bootstrap 3.3.7 -->
			<script src="../AdminLTE-master/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
			<!-- Bootstrap WYSIHTML5 -->
			<script src="../AdminLTE-master/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
			<!--<script src="../AdminLTE-master/bower_components/fastclick/lib/fastclick.js"></script>-->
			<script src="../AdminLTE-master/dist/js/adminlte.min.js"></script>
			<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
			<script src="../AdminLTE-master/dist/js/pages/dashboard.js"></script>
			<!-- AdminLTE for demo purposes -->
			<script src="../AdminLTE-master/dist/js/demo.js"></script>
			<!-- DataTables -->
			<script src="../AdminLTE-master/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
			<script src="../AdminLTE-master/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
		</body>
		</html>
