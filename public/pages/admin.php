<?php
require_once('../../app/functions/checkUserDevice.php'); //Só funcionou desse, se conseguir resolver avise-me. By Jairo
require_once('../../app/functions/bdq.php'); //Só funcionou desse, se conseguir resolver avise-me.By Jairo
require_once('../../bootstrap.php'); //Só funcionou desse, se conseguir resolver avise-me.By Jairo
session_start();
if($_SESSION['id'] == NULL){redirect("login","danger","unset_login");}


ini_set('default_charset','UTF-8');

$mostrar_concluido = " WHERE agd_cancelado = {$_SESSION['cancelado']}";

if($_SESSION['concluidos'] == 1){
	$mostrar_concluido = "_concluidos WHERE 1";
}

$mostrar_serv_agd = '';

if($_SESSION['mostrar_serv_agd'] == 1){
	$mostrar_serv_agd =" AND ser_id = {$_SESSION['id']}";
}

$sql = "SELECT * FROM agd_agendamentos".$mostrar_concluido.$mostrar_serv_agd;

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
	<!-- Theme style -->
	<link rel="stylesheet" href="../AdminLTE-master/dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="../AdminLTE-master/dist/css/skins/_all-skins.min.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="../AdminLTE-master/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">



	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="../..<?php echo CAM_RAIZ_2?>functions/scriptAgendamento.js"></script>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition skin-red sidebar-mini">
	<div class="wrapper">
		<!-- =================== MEU LATERAL FICA AQUI =============== -->
		<?php include_once('menu-lateral.php') ?>
		<!-- ================================================================ -->
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Agendamentos
					<small>Painel de Controle</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-calendar"></i>Agendamentos</a></li>
					<li class="active"></li>
				</ol>
			</section>
			<!-- ============= IMPORTANDO O DASHBOARD ============= -->
			<?php
			if($_SESSION['email'] == 'adm.bc.agendamento@gmail.com'){
				include_once('dashboard.php');
			}
			?>
			<!-- Main content -->
			<section class="content">
				<!-- Small boxes (Stat box) -->
				<div class="row">

					<!-- /.row -->
					<!-- Main row -->
					<div class="row">
						<!-- Left col -->
						<?php
						/*
						<section class="col-lg-7 connectedSortable">

						<!-- Calendario -->
						<div class="box box-solid bg-green-gradient">
						<div class="box-header">
						<i class="fa fa-calendar"></i>

						<h3 class="box-title">Calendário</h3>
						<!-- tools box -->
						<div class="pull-right box-tools">
						<!-- button with a dropdown -->

						<button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
						<button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
						</button>
						</div>
						<!-- /. tools -->
						</div>
						<!-- /.box-header -->
						<div class="box-body no-padding">
						<!--The calendar -->
						<input type="text" id="calendario">


						<!-- /.box-body -->
						<div class="box-footer text-black">
						<div class="row">

						<!-- /.col -->
						</div>
						<!-- /.row -->
						</div>
						</div>
						<!-- /.box -->
						</section>
						*/
						?>
						<!-- /.Left col -->
						<!-- right col (We are only adding the ID to make the widgets sortable)-->
						<section>

							<!-- Custom tabs (Charts with tabs)-->
							<div class="nav-tabs-custom">
								<!-- tabela de clientes -->
								<div class="box">
									<?php
									//                        echo "<p style=\"float:left;margin-top:15px; margin-left:0%; padding:15%; font-size:23px; background-color:$complete; border-radius:5px;padding:0\"><strong>$message</strong></p>";
									if($_SESSION['concluidos']==1){
										echo '<center><h2 id="tituloInicial">Tabela de Agendamentos Concluídos</h2></center>';
									} else {
										if($_SESSION['cancelado']==1){
											echo '<center><h2 id="tituloInicial">Tabela de Agendamentos Cancelados</h2></center>';
										} else {
											echo '<center><h2 id="tituloInicial">Tabela de Agendamentos Efetivos</h2></center>';
										}
									}

									?>

									<!-- /.box-header -->
									<div class="box-body">
										<div id="buttons-box1" style="display:block;height:50px;">

											<form action="../../app/functions/btn_scripts.php" method="post">
												<?php


												if($_SESSION['cancelado']==1){
													$show_canc_efe = 'Cancelados';
												} else {
													$show_canc_efe = 'Efetivos';
												}
												if($_SESSION['concluidos']==0){
													if($_SESSION['cancelado']==0){
														$show_canc_efe = 'Cancelados';
													} else {
														$show_canc_efe = 'Efetivos';
													}
													echo "
													<button name=\"cancelado\" class=\"btn btn-primary\" style=\"margin-left:3%;float:right;\" type=\"submit\" >Mostrar $show_canc_efe</button>
													";
												}

												if($_SESSION['concluidos']==0){
													$show_canc_conc = 'Concluídos';
												} else {
													$show_canc_conc = $show_canc_efe;
												}
												echo "
												<button name=\"concluidos\" class=\"btn btn-primary\" style=\"margin-left:3%;float:right;\" type=\"submit\" >Mostrar $show_canc_conc</button>
												";

												/*echo "
												<button name=\"giro_tabela\" class=\"btn btn-primary\" style=\"margin-left:3%;float:right;\" type=\"submit\" >Girar Tabela</button>
												";*/

												if($_SESSION['mostrar_serv_agd']==1){
													$show_canc_shw = 'Todos';
												} else {
													$show_canc_shw = 'Meus';
												}

												echo "
												<button name=\"mostrar_serv_agd\" class=\"btn btn-primary\" style=\"margin-left:3%;float:right;\" type=\"submit\" >Ver $show_canc_shw AGDs</button>
												";
												?>
											</form>
										</div>

										<form action="../../app/functions/deleta_linha.php" method="post">
											<div id="buttons-box2" style="display:block;height:50px;">
												<?php
												if($_SESSION['concluidos'] == 1){
													$show_canc_descanc = 'arrows-alt-h';
												} else {
													if($_SESSION['cancelado']==0){
														$show_canc_descanc = 'trash-alt';
													} else {
														$show_canc_descanc = 'recycle';
													}
												}
												echo "
												<button class=\"btn btn-primary\" style=\"margin-left:3%;font-size:120%;float:right;z-index:999;\" type=\"submit\" id=\"btn_cancelar\" name=\"submit\"><i class=\"fas fa-$show_canc_descanc\"></i></button>
												";

												?>
											</div>
											<!--<input style="margin: 0 0 1% 3%" class="btn btn-primary" type="submit" id="btn_cancelar" name="submit" value="Cancelar">-->

											<!--Girar tabela automaticamente com o seguinte script: -->
											<?php
											if (checkUserDevice()==true) {
												$_SESSION['giro_tabela'] = 'vertical';
											}
											else{
												$_SESSION['giro_tabela'] = 'horizontal';
											}
											?>
											<div id="main-table">

												<?php if($_SESSION['giro_tabela'] == 'vertical') {echo '<input type="text" id="myInput" onkeyup="searcher()" placeholder="Procurar">';}?>

												<table id="example1" class="table table-bordered table-striped" style="margin-top: 1%;">
													<?php include_once("girar_tabela_{$_SESSION['giro_tabela']}.php");
													gerar_tabela(['    ','Matrícula','Nome','E-mail','Telefone','Data','Horário','Servidor','Curso/Programa','Criado','Compareceu'],
													['agd_id','agd_matricula','agd_nome','agd_email','agd_telefone','agd_data','hor_id','ser_id','agd_curso_programa','agd_criada','agd_nao_compareceu'],
													$result); ?>
												</table>
											</div>


										</form>

									</div>
									<!-- /.box-body -->
								</div>
								<!-- /.box -->

							</div>
							<!-- /.nav-tabs-custom -->

						</section>
						<!-- right col -->

					</div>
					<!-- /.row (main row) -->

				</section>
				<!-- /.content -->
			</div>

			<!-- /.content-wrapper -->
			<footer class="main-footer">
				<div class="pull-right hidden-xs">
					<!--<b>Version</b> 2.4.0--></div>
					<!--<strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
					reserved.-->
				</footer>

				<!-- Control Sidebar -->
				<aside class="control-sidebar control-sidebar-dark">
					<!-- Create the tabs -->
					<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
						<li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
						<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<!-- Home tab content -->
						<div class="tab-pane" id="control-sidebar-home-tab">
							<h3 class="control-sidebar-heading">Recent Activity</h3>
							<ul class="control-sidebar-menu">
								<li>
									<a href="javascript:void(0)">
										<i class="menu-icon fa fa-birthday-cake bg-red"></i>

										<div class="menu-info">
											<h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

											<p>Will be 23 on April 24th</p>
										</div>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)">
										<i class="menu-icon fa fa-user bg-yellow"></i>

										<div class="menu-info">
											<h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

											<p>New phone +1(800)555-1234</p>
										</div>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)">
										<i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

										<div class="menu-info">
											<h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

											<p>nora@example.com</p>
										</div>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)">
										<i class="menu-icon fa fa-file-code-o bg-green"></i>

										<div class="menu-info">
											<h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

											<p>Execution time 5 seconds</p>
										</div>
									</a>
								</li>
							</ul>
							<!-- /.control-sidebar-menu -->

							<h3 class="control-sidebar-heading">Tasks Progress</h3>
							<ul class="control-sidebar-menu">
								<li>
									<a href="javascript:void(0)">
										<h4 class="control-sidebar-subheading">
											Custom Template Design
											<span class="label label-danger pull-right">70%</span>
										</h4>

										<div class="progress progress-xxs">
											<div class="progress-bar progress-bar-danger" style="width: 70%"></div>
										</div>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)">
										<h4 class="control-sidebar-subheading">
											Update Resume
											<span class="label label-success pull-right">95%</span>
										</h4>

										<div class="progress progress-xxs">
											<div class="progress-bar progress-bar-success" style="width: 95%"></div>
										</div>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)">
										<h4 class="control-sidebar-subheading">
											Laravel Integration
											<span class="label label-warning pull-right">50%</span>
										</h4>

										<div class="progress progress-xxs">
											<div class="progress-bar progress-bar-warning" style="width: 50%"></div>
										</div>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)">
										<h4 class="control-sidebar-subheading">
											Back End Framework
											<span class="label label-primary pull-right">68%</span>
										</h4>

										<div class="progress progress-xxs">
											<div class="progress-bar progress-bar-primary" style="width: 68%"></div>
										</div>
									</a>
								</li>
							</ul>
							<!-- /.control-sidebar-menu -->

						</div>
						<!-- /.tab-pane -->
						<!-- Stats tab content -->
						<div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
						<!-- /.tab-pane -->
						<!-- Settings tab content -->
						<div class="tab-pane" id="control-sidebar-settings-tab">
							<form method="post">
								<h3 class="control-sidebar-heading">General Settings</h3>

								<div class="form-group">
									<label class="control-sidebar-subheading">
										Report panel usage
										<input type="checkbox" class="pull-right" checked>
									</label>

									<p>
										Some information about this general settings option
									</p>
								</div>
								<!-- /.form-group -->

								<div class="form-group">
									<label class="control-sidebar-subheading">
										Allow mail redirect
										<input type="checkbox" class="pull-right" checked>
									</label>

									<p>
										Other sets of options are available
									</p>
								</div>
								<!-- /.form-group -->

								<div class="form-group">
									<label class="control-sidebar-subheading">
										Expose author name in posts
										<input type="checkbox" class="pull-right" checked>
									</label>

									<p>
										Allow the user to show his name in blog posts
									</p>
								</div>
								<!-- /.form-group -->

								<h3 class="control-sidebar-heading">Chat Settings</h3>

								<div class="form-group">
									<label class="control-sidebar-subheading">
										Show me as online
										<input type="checkbox" class="pull-right" checked>
									</label>
								</div>
								<!-- /.form-group -->

								<div class="form-group">
									<label class="control-sidebar-subheading">
										Turn off notifications
										<input type="checkbox" class="pull-right">
									</label>
								</div>
								<!-- /.form-group -->

								<div class="form-group">
									<label class="control-sidebar-subheading">
										Delete chat history
										<a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
									</label>
								</div>
								<!-- /.form-group -->
							</form>
						</div>
						<!-- /.tab-pane -->
					</div>
				</aside>
				<!-- /.control-sidebar -->
				<!-- Add the sidebar's background. This div must be placed
				immediately after the control sidebar -->
				<div class="control-sidebar-bg"></div>
			</div>
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
		<!-- Morris.js charts -->
		<!--<script src="../AdminLTE-master/bower_components/raphael/raphael.min.js"></script>-->
		<!--<script src="../AdminLTE-master/bower_components/morris.js/morris.min.js"></script>-->
		<!-- Sparkline -->
		<!--<script src="../AdminLTE-master/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>-->
		<!-- jvectormap -->
		<!--<script src="../AdminLTE-master/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
		<script src="../AdminLTE-master/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>-->
		<!-- jQuery Knob Chart -->
		<!--<script src="../AdminLTE-master/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>-->
		<!-- daterangepicker -->
		<!--<script src="../AdminLTE-master/bower_components/moment/min/moment.min.js"></script>
		<script src="../AdminLTE-master/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>-->
		<!-- datepicker -->
		<!--<script src="../AdminLTE-master/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>-->

		<!-- Bootstrap WYSIHTML5 -->
		<script src="../AdminLTE-master/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
		<!-- Slimscroll -->
		<!--<script src="../AdminLTE-master/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>-->
		<!-- FastClick -->
		<!--<script src="../AdminLTE-master/bower_components/fastclick/lib/fastclick.js"></script>-->
		<!-- AdminLTE App -->
		<script src="../AdminLTE-master/dist/js/adminlte.min.js"></script>
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<script src="../AdminLTE-master/dist/js/pages/dashboard.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="../AdminLTE-master/dist/js/demo.js"></script>
		<!-- DataTables -->
		<script src="../AdminLTE-master/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="../AdminLTE-master/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

		<script>
		$(function () {
			$('#example1').DataTable()
			$('#example2').DataTable({
				'paging'      : true,
				'lengthChange': false,
				'searching'   : false,
				'ordering'    : true,
				'info'        : true,
				'autoWidth'   : false
			})
		})

		$('#calendario').datepicker({
			inline: true,
			altField: '#d'
		});


	</script>

	<?php
	$message = filter_input(INPUT_GET, 'message', FILTER_SANITIZE_STRING);
	if($message!=''){
		echo "<script> alert('$message')</script>";
		echo "<script> window.location.href = window.location.pathname</script>";
	}
	?>




</body>
</html>
