

<?php
//Só funcionou desse, se conseguir resolver avise-me. By Jairo
require_once('../../app/functions/bdq.php');
require_once('../../bootstrap.php');
require_once('../../app/functions/percentual.php');

session_start();
if($_SESSION['id'] == NULL){redirect("login","danger","unset_login");}
ini_set('default_charset','UTF-8');
$conn = DBConnect();
$result = mysqli_query($conn,$sql);
DBClose($conn);
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
	<script src="../..<?php echo CAM_RAIZ_2?>functions/senha-profile.js"></script>
	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-red sidebar-mini">
	<!-- =================== MEU LATERAL FICA AQUI =============== -->
	<?php include_once('menu-lateral.php') ?>
	<!-- ================================================================ -->
	<div class="wrapper">
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
						<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Agendamentos
					<small>Monitorar e controlar seus agendamentos</small>
				</h1>
				<ol class="breadcrumb">
					<li><a onclick="javascript: location.href='admin.php';"><i class="fa fa-calendar"></i> Agendamentos</a></li>
				</ol>
			</section>
			<!-- ============= IMPORTANDO O DASHBOARD ============= -->
			<?php

			if($_SESSION['email'] == 'adm.bc.agendamento@gmail.com'){
				include_once('dashboard.php');
			}
			?>
			<!-- ================================================= -->
			<!-- Main content -->
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Painel de controle</h3>
					</div>
					<div class="box-body">

						<div class="col-lg-3 col-xs-6">
			        <!-- small box -->
							<div class="info-box">
								<a href="efetivos.php">
								<span class="info-box-icon bg-aqua"><i class="fa  fa-calendar"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Agendamentos</span>
									<!-- <span class="info-box-number">1,410</span> -->
								</div>
								<!-- /.info-box-content -->
								</a>
							</div>

			      </div>

						<div class="col-lg-3 col-xs-6">
							<div class="info-box">
								<a href="estatistica.php">
									<span class="info-box-icon bg-green"><i class="fa fa-pie-chart"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Estatísticas</span>
										<!-- <span class="info-box-number">1,410</span> -->
									</div>
									<!-- /.info-box-content -->
								</a>
							</div>
						</div>

						<div class="col-lg-3 col-xs-6">
							<div class="info-box">
								<a href="profile.php">
									<span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
									<div class="info-box-content">
										<span class="info-box-text">Estatísticas</span>
										<!-- <span class="info-box-number">1,410</span> -->
									</div>
									<!-- /.info-box-content -->
								</a>
							</div>
						</div>

					</div>
				</div>
					<!-- /.box-body -->
				</div>
			</section>
			</div>
			<!-- /.content-wrapper -->
			<?php include_once('rodape.php') ?>
			<!-- ./wrapper -->

			<!-- jQuery 3 -->
			<script src="../AdminLTE-master/bower_components/jquery/dist/jquery.min.js"></script>
			<!-- jQuery UI 1.11.4 -->
			<!--<script src="../AdminLTE-master/bower_components/jquery-ui/jquery-ui.min.js"></script>-->
			<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
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
