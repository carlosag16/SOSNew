

<?php
//Só funcionou desse, se conseguir resolver avise-me. By Jairo
require_once('../../app/functions/checkUserDevice.php');
require_once('../../app/functions/bdq.php');
require_once('../../bootstrap.php');
require_once('../../app/functions/percentual.php');

session_start();
if($_SESSION['id'] == NULL || $_SESSION['email'] != 'adm.bc.agendamento@gmail.com'){redirect("login","danger","unset_login");}
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
	<div class="wrapper">
		<!-- =================== MEU LATERAL FICA AQUI =============== -->
		<?php include_once('menu-lateral.php') ?>
		<!-- ================================================================ -->
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<?php
				//query que altera o estado do servidro de ativo para desativado ao clicar no botão
				if($_POST['estado_servidor']!=null){
					$id = $_POST['estado_servidor'];
					$estado = DBReadOne("ser_servidores","ser_ativo"," WHERE ser_id = {$id}");
					if ($estado=='0'){
						DBExecute("UPDATE ser_servidores SET ser_ativo = 1 WHERE ser_id = {$id};");
						DBExecute("DELETE from ser_servidores__hor_horarios WHERE ser_id = {$id};");
					}
					else{
						DBExecute("UPDATE ser_servidores SET ser_ativo = 0 WHERE ser_id = {$id};");
					}
				}
			?>

			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Editar
					<small>Ativar ou desativar bibliotecários do sistema</small>
				</h1>
				<ol class="breadcrumb">
					<li><a onclick="javascript: location.href='admin.php';"><i class="fa fa-calendar"></i> Agendamentos</a></li>
					<li class="active">Editar servidor</li>
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
						<h3 class="box-title">Bibliotecários disponíveis</h3>
						<a class="btn btn-primary" style="float:right; margin-right:1%; margin-top:1%;" href="<?php echo ''.CAM_RAIZ.'?page=gerenciarServidor'; ?>"><i class="fa fa-user-plus"></i> Cadastrar novo</a>
					</div>
					<div class="box-body">
						<div class="row">
						<table class="table table-hover thead-light">
	          <thead>
	            <tr>
	              <!-- <th scope="col">checkbox</th> -->
								<th scope="col"></th>
	              <th scope="col">Nome</th>
	              <th scope="col">Email</th>
	              <th scope="col">Estado</th>
	            </tr>
	          </thead>
	          <tbody>

	            <?php
	              /**
	              *Esta query pega o nome, email e estatus dos servidores
	              */
	              $servidores_ativos = DBRead("ser_servidores","ser_id","where ser_id <> 4 ORDER BY ser_nome"); // ser_id <> 4 # para não pegar o adm do sistema
	              foreach ($servidores_ativos as $id) {
	                $nome = DBRead("ser_servidores","ser_nome","WHERE ser_id=".$id.";");
	                $email = DBRead("ser_servidores","ser_email","WHERE ser_id=".$id.";");
	                $ativo = DBRead("ser_servidores","ser_ativo","WHERE ser_id=".$id.";");
									echo '
									<tr>
									<!-- <th scope="row">[]</th>-->
									<td> <center> <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSoQrCJR3WvVUX-8ZVYO2KPcv7f-nFnnd3lKdGl9zkzbI3CyYi3Bw" class="img-circle" alt="Receitas de Código" width="25" height="25"> </center></td>
									<td>'.$nome[0].'</td>
									<td>'.$email[0].'</td>';
									// se o resultado for 0 botão será de cor verde indicando que o sevidor está ativo
									// se o resultado pfor 1 o botão será de vermelha indicando que o servdor está desativado do sistema
									if($ativo[0]==0){
										// $name = array('id'=>$id);
										echo '
										<td>
											<form class="" action="servidores_disponives.php" method="post">
												<input type="hidden" name="estado_servidor" value="'.$id.'">
												<button type="submit" class="btn btn-success" style="width: 100px;"> Ativo </button>
											</form>
										</td>
										';
									}
									else{
										echo '
										<td>
											<form class="" action="servidores_disponives.php" method="post">
												<input type="hidden" name="estado_servidor" value="'.$id.'">
												<button type="submit" class="btn btn-danger" style="width: 100px;"> Desativado </button>
											</form>
										</td>
										';
									}
									echo '</tr>';
	              }
								header("location:".CAM_ADMIN."/servidores_disponives.php"); // isso é necessário para limpar o $id do $_POST
								// e assim evitar que o navegador altere o status dos servidores sozinho
								// porém ainda encontra-se com um bug: assim que clicamos no botão para desativar ou ativar determionado servidores
								// ao atualizar o broser ele altera o status do servidor sozinho [ainda buscando uma solução para isso, by: Teo]
	             ?>

	             </tbody>
	        </table>
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
