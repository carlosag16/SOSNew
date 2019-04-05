

<?php
//Só funcionou desse, se conseguir resolver avise-me. By Jairo
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

<body class="hold-transition skin-red fixed sidebar-mini">
	<!-- =================== MEU LATERAL FICA AQUI =============== -->
	<?php include_once('menu-lateral.php') ?>
	<!-- ================================================================ -->
	<div class="wrapper">
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
					Horários
					<small>Ver horário de atuação dos servidores ativos no sistema</small>
				</h1>
				<ol class="breadcrumb">
					<li><a onclick="javascript: location.href='admin.php';"><i class="fa fa-dashboard "></i> Painel de controle</a></li>
					<li class="active">Horários</li>
				</ol>
			</section>
			<!-- Main content -->
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Horário de atuação dos bibliotecários</h3>
					</div>
					<div class="box-body">
						<table class="table table-bordered">
              <div class="row">
	          <thead>
	            <tr>
	              <!-- <th scope="col">checkbox</th> -->
								<th scope="col"></th>
	              <th scope="col">Nome</th>
                <th scope="col">9h30</th>
                <th scope="col">11h00</th>
                <th scope="col">12h30</th>
                <th scope="col">16h00</th>
                <th scope="col">17h30</th>
	              <th scope="col">19h00</th>
	            </tr>
	          </thead>
	          <tbody>

	            <?php
	              /**
	              *Esta query pega somente os servidores ativos do sistema
	              */
                $servidores_ativos = DBRead("ser_servidores","ser_id","where ser_id <> 4 AND ser_ativo = 0 ORDER BY ser_nome"); // ser_id <> 4 # para não pegar o adm do sistema
                foreach ($servidores_ativos as $id) {
                  $nome = DBRead("ser_servidores","ser_nome","WHERE ser_id=".$id.";");
									$horario = DBRead("ser_servidores__hor_horarios","hor_id","WHERE ser_id=".$id.";");
                  $h = array_fill(1,6,0); //Array ( [1] => 0 [2] => 0 [3] => 0 [4] => 0 [5] => 0 [6] => 0 )
                  foreach ($horario as $key => $value) {
                    if (array_key_exists($value,$h)) { // pondo cada hor_id de acordo com o indice do $h, ex: Array ( [1] => 1 [2] => 0 [3] => 3 [4] => 0 [5] => 5 [6] => 0 )
                      $h[$value] = $value;
                    }
                  }
									echo '
									<tr>
									<td> <center> <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSoQrCJR3WvVUX-8ZVYO2KPcv7f-nFnnd3lKdGl9zkzbI3CyYi3Bw" class="img-circle" alt="Receitas de Código" width="25" height="25"> </center></td>
									<td>'.$nome[0].'</td>';
                  foreach ($h as $key => $value){
                    if ($value != 0){
                      echo '<td><i class="fa fa-check"></i></td>';
                    }
                    else {
                      echo '<td></td>';
                    }
                  }
                  echo '</tr>';
	              }
	             ?>
	        </table>
        </tbody>
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
