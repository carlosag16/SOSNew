<?php
//Só funcionou desse, se conseguir resolver avise-me. By Jairo
// require_once('../../app/functions/checkUserDevice.php');
require_once('../../app/functions/bdq.php');
require_once('../../bootstrap.php');
require_once('../../app/functions/percentual.php');

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
	<div class="wrapper">
		<!-- =================== MEU LATERAL FICA AQUI =============== -->
		<?php include_once('menu-lateral.php') ?>
		<!-- ================================================================ -->
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Perfil
					<small>Seus dados pessoais</small>
				</h1>
				<ol class="breadcrumb">
					<li><a onclick="javascript: location.href='admin.php';"><i class="fa fa-calendar"></i> Agendamentos</a></li>
					<li class="active">Perfil</li>
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

				<div class="row">
					<div class="col-md-3">
						<!-- Profile Image -->
						<div class="box box-default ">
							<div class="box-body box-profile">
								<!-- <img src="<?php echo CAM_RAIZ?>AdminLTE-master/dist/img/default-avatar.gif" class="img-circle" alt="User Image" style="height: 70px; float: center;"> -->
								<!-- <img id="profile-pic" class="profile-user-img img-responsive img-circle" src="<?php echo $_SESSION['default_profile_pic'] ?>" alt="Perfil do servidor" draggable="false"> -->
								<h3 class="profile-username text-center">
									<?php echo $_SESSION['nome']; ?>
								</h3>
								<!-- nome do servidor -->
								<p class="text-muted text-center">Servidor(a)</p>
								<?php $num = DBRead("ser_servidores","ser_contador","WHERE ser_id = {$_SESSION['id']};"); ?>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
					<!-- /.col -->
					<!-- Dados do servidor -->
					<div class="col-md-9">
						<div class="box box-default ">
							<div class="box-header with-border">
								<!-- ========= configurações de dados do servidor servidor ========== -->
								<form id="formulario" class="form-horizontal" action="forms/profile.php" method="POST" role="form">
									<!-- ========= nome do servidor ========== -->
									<div class="form-group">
										<label for="inputNome" class="col-sm-2 control-label">Nome</label>
										<div class="col-sm-10">
											<input name="nome" type="text" class="form-control" id="inputName" placeholder="Antonio Da Silva Costa" value="<?php echo $_SESSION['nome']?>">
										</div>
									</div>
									<!-- ========= email do servidor ========== -->
									<div class="form-group">
										<label for="inputEmail" class="col-sm-2 control-label">Email</label>
										<div class="col-sm-10">
											<input name="email" type="email" class="form-control" id="inputEmail" placeholder="<?php echo $_SESSION['email']?>" value="<?php echo $_SESSION['email']?>">
										</div>
									</div>
									<!-- ========= telefone do servidor ========== -->
									<div class="form-group">
										<label for="inputTelefone" class="col-sm-2 control-label">Telefone</label>
										<div class="col-sm-10">
											<input name="telefone" type="tel" class="form-control" id="inputName" placeholder="(91)987654321" value="<?php echo $_SESSION['telefone']?>">
										</div>
									</div>
									<!-- ========= senha do servidor ========== -->
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Alterar Senha </label>
										<div class="col-sm-10">
											<input data-toggle="tooltip" data-placement="top" title="mais que 6 caracteres! " type="password" class="form-control" id="senha1" placeholder="Digite uma nova senha"/>
											<div id="password_box1"></div>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Confirmar Senha</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" id="senha2" name="senha" placeholder="Confirmar nova senha" />
											<div id="password_box2"></div>
										</div>
									</div>
									<!-- ========= horários de atuação do servidor ========== -->
									<?php
										if ($_SESSION['email'] != 'adm.bc.agendamento@gmail.com'){
												echo '<div class="form-group">
													<label for="" class="col-sm-2 control-label">Seus horários de atuação:</label>
													<div class="col-sm-10">';
														$horarios = DBRead("hor_horarios","hor_valor");
														$id = DBRead("hor_horarios","hor_id");
														$meusHorarios = DBRead("ser_servidores__hor_horarios","hor_id","WHERE ser_id = {$_SESSION['id']}");
														$trocou;
														if($meusHorarios == NULL) {$meusHorarios = 0;}
														for($i = 0; $i < Count($id);$i++){
															for($j = 0; $j<Count($meusHorarios);$j++){
																if($id[$i] == $meusHorarios[$j]) {
																	$trocou = 1; //verifica se é para marcar ou não.
																	echo "
																	<label class=\"checkbox-inline\"><input type=\"checkbox\" name=\"horarios_ser[]\" value=\"$id[$i]\" checked>$horarios[$i]</label>
																	";

																} else if($j == Count($meusHorarios)-1 && $trocou == 0) {
																	echo "
																	<label class=\"checkbox-inline\"><input type=\"checkbox\" name=\"horarios_ser[]\" value=\"$id[$i]\">$horarios[$i]</label>
																	";
																}

															}
															$trocou = 0;
														}
													echo '</div>';
												echo '</div>';
										}
									 ?>

									<br>
									<!-- ========= recaptcha ========== -->
									<!-- <div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<div class="g-recaptcha" data-sitekey="6LeeUVYUAAAAAIHHqk_bg6qXdnYbRMmx6OMSeYiV"></div>
										</div>
									</div> -->
									<!-- ========= botão de enviar ========== -->
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-10">
											<button type="submit" class="btn btn-danger">Enviar</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
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
