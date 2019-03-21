

<?php
require_once('../../app/functions/bdq.php');
require_once('../../app/functions/efetuar_cancelamento.php');
require_once('../../bootstrap.php');

session_start();
if($_SESSION['id'] == NULL){redirect("login","danger","unset_login");}
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
	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<!-- o bootstrap 3 não tem badge coloridos, então tive que implementar; Teo Quaresma -->
	<style media="screen">
		.warning{background-color: #FFC107}
		.danger{background-color: #DC3545}
		.secondary{background-color: #6C757D}
		.success{background-color: #28A745}
	</style>

</head>

<body class="hold-transition skin-red sidebar-mini">
  <!-- =================== MEU LATERAL FICA AQUI =============== -->
  <?php include_once('menu-lateral.php') ?>
  <!-- ================================================================ -->
	<div class="wrapper">
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<?php
			if(isset($_POST['agd_id'])){   //Para rodar apenas quando o botão submit for acionado.

			    $agd_id = $_POST['agd_id'];
			    $acao = $_POST['input'];
					$session_cancelado = $acao;
					$session_idServ = $_SESSION['id'];

				  if ($acao=="1") {
						// executará background-color:#BC3F30está query quando apertarem em "compareceu"
			      DBExecute("UPDATE agd_agendamentos SET agd_nao_compareceu = 0, agd_concluido = 1 WHERE agd_id = $agd_id");
						// func_des_cancelamento($agd_id, $session_cancelado, $caminho);
			    }
					elseif ($acao=="0") {
						// executará está query quando apertarem em "não compareceu"
			      DBExecute("UPDATE agd_agendamentos SET agd_nao_compareceu = 1, agd_concluido = 1 WHERE agd_id = $agd_id");
						// Loop to store and display values of individual checked checkbox.
						func_cancelamento($agd_id,"Administrador",$session_idServ,$session_cancelado,null,CAM_ADMIN);
			    }
			}

			?>
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Agendamentos
					<small>Ver seus agendamentos</small>
				</h1>
				<ol class="breadcrumb">
					<li><a><i class="fa fa-dashboard"></i> Painel de controle</a></li>
					<li class="active">Agendamentos efetivos</li>
				</ol>
			</section>
			<!-- Main content -->
			<section class="content">
				<form action="efetivos.php" method="post">
					<div class="box ">
						<div class="box-header">
							<h3 class="box-title">Tabela de agendamentos</h3>
              <br><br><br>
              <ul class="nav nav-tabs nav-justified">

                <li role="presentation" class="active box box-danger"><a href="efetivos.php">  <i class="fa fa-calendar-plus-o"> Efetivos </i></a></li>
                <li role="presentation" ><a href="concluidos.php"> <i class="fa fa-calendar-check-o"> Concluídos </i></a></li>
              </ul>
							<br>
						</div>

						<!-- aqui fiz uma gambiarra kkk, mas vou explicar -->

						<!-- este input:hidden será preenchida com um valor que será a escolha da ação do usuário deste admin -->
						<!-- se ele pertar no submit "compareceu" então o valor deste input será compareceu -->
						<!-- se ele pertar no submit "noa_compareceu" então o valor deste input será nao_compareceu -->
						<!-- o scrpit que realiza esta ação está logo no final deste arquivo -->
						<!-- by: Teo -->
						<input id="input" type="hidden" name="input" value="">
						<a id="compareceu" class="btn btn-primary" style="float:right; margin-right:1%; margin-top:1%;" title="Concluir agendamento">
							<i class="fa fa-check"></i> Compareceu
						</a >

						<a id="nao_compareceu" class="btn btn-danger" style="float:right; margin-right:1%; margin-top:1%;" title="Concluir agendamento, porém com ausência do usuário">
							<i class="fa fa-close"></i> Não compareceu
						</a >

						<button id="enviar" type="submit" class="btn btn-danger" style="display:none;float:right; margin-right:1%; margin-top:1%;">
							Enviar
						</button >
						<!-- /.box-header -->
						<!-- tabela de agendamentos -->
            <div class="box-body">
								<table id="example1" class="table table-bordered table-striped">
                  <thead>
	                  <tr>
	                    <th> </th>
											<th>Matrícula</th>
	                    <th>Nome</th>
											<th>Email</th>
	                    <th>Telefone</th>
	                    <th>Dia</th>
	                    <th>Horário</th>
											<th>Curso/Programa</th>
											<th>Criada em</th>
	                    <th>Estado</th>
	                  </tr>
									</thead>
										<tbody>
											<?php
											date_default_timezone_set('America/Sao_Paulo');

											/* ======= LEITURA DO BANCO DE DADOS ======== */

											// pega o dia presente
											$hoje = Date('Y-m-d');
											//pegar id do agendamento
											$id = DBRead("agd_agendamentos","agd_id","WHERE agd_concluido = 0 AND agd_cancelado = 0 AND ser_id = ".$_SESSION['id']);
											//pega número de matrícula do usuário
											$matricula = DBRead("agd_agendamentos","agd_matricula","WHERE agd_concluido = 0 AND agd_cancelado = 0 AND ser_id = ".$_SESSION['id']);
											// pega o nome do usuário
											$nome = DBRead("agd_agendamentos","agd_nome","WHERE agd_concluido = 0 AND agd_cancelado = 0 AND ser_id = ".$_SESSION['id']);
											// pega o email do usuário
											$email = DBRead("agd_agendamentos","agd_email","WHERE agd_concluido = 0 AND agd_cancelado = 0 AND ser_id = ".$_SESSION['id']);
											// pega o telefone do usuário
											$telefone = DBRead("agd_agendamentos","agd_telefone","WHERE agd_concluido = 0 AND agd_cancelado = 0 AND ser_id = ".$_SESSION['id']);
											// pega a data marcada do agendamento
											$datas = DBRead("agd_agendamentos","agd_data","WHERE agd_concluido = 0 AND agd_cancelado = 0 AND ser_id = ".$_SESSION['id']);
											// pega a hora marcada do agendamento
											$horas = DBRead("agd_agendamentos","hor_id","WHERE agd_concluido = 0 AND agd_cancelado = 0 AND ser_id = ".$_SESSION['id']);
											// pega o curos do usuário
											$curso = DBRead("agd_agendamentos","agd_curso_programa","WHERE agd_concluido = 0 AND agd_cancelado = 0 AND ser_id = ".$_SESSION['id']);
											// pega a data em que foi aberta a solicitação de agendamento
											$criadas = DBRead("agd_agendamentos","agd_criada","WHERE agd_concluido = 0 AND agd_cancelado = 0 AND ser_id = ".$_SESSION['id']);

											/*Esse for irá gerar as linha da tabela onde cada coluna terá as informações recuperadas do banco de dados acima.*/
											for ($i=0; $i < count($nome); $i++) {
												$hora = DBReadOne("hor_horarios","hor_valor","where hor_id = ".$horas[$i]);
												$data = new DateTime($datas[$i]);
												$criada = new DateTime($criadas[$i]);
												echo '<tr>';
												echo '<td><input type="checkbox" name="agd_id" value="'.$id[$i].'"></td>';
												echo '<td>'.$matricula[$i].'</td>';
												echo '<td>'.$nome[$i].'</td>';
												echo '<td> '.$email[$i].' </td>';
												echo '<td> '.$telefone	[$i].' </td>';
												echo '<td>'.$data->format("d/m/Y").'</td>';
												echo '<td>'.$hora.'</td>';
												echo '<td>'.$curso[$i].'</td>';
												echo '<td>'.$criada->format("d/m/Y").'</td>';
												/* Essa condição é necessária para que seja possível analisar o estado do agendamento:
													Se a data do agendamento for menor que o dia atual então mostrar que o agendamento está expirado, se for igual mostrar que
													é hoje, se for maior mostrará que está aguardando.
													Isso significa que o servidor terá que escolher entre marcar como concluido escolhendo as opções entre "compareceu" ou "não compareceu".
												*/
												if (strtotime($datas[$i]) < strtotime($hoje)){
													echo '<td><center><span class="badge danger">Expirado!</span><center></td>';
												}elseif(strtotime($datas[$i]) > strtotime($hoje)){
													echo '<td><center><span class="badge secondary">Aguardando</span><center><pan></td>';
												}elseif(strtotime($datas[$i]) == strtotime($hoje)){
													echo '<td><center><span class="badge warning">Hoje!</span><center></td>';
												}
												echo '</tr>';
											}
											// header("location:".CAM_ADMIN."?cancelado={$_SESSION['cancelado']}&message=Você selecionou nada!");
											?>
										</tbody>
                </table>
              </div>
				</div>
				</form>
			</section>
    </div>
    <!-- /.content-wrapper -->
    <?php include_once('rodape.php') ?>
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
      });

			$(function(){
				$("#compareceu").click(function(){
					$("#input").val("1");
					$("#enviar").trigger('click');
				});
				$("#nao_compareceu").click(function(){
					$("#input").val("0");
					$("#enviar").trigger('click');
				})
			})
    })
  </script>
</body>
</html>
