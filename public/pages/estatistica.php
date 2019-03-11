<?php
//Só funcionou desse, se conseguir resolver avise-me. By Jairo
require_once('../../app/functions/checkUserDevice.php');
require_once('../../app/functions/bdq.php');
require_once('../../bootstrap.php');
require_once('../../app/functions/percentual.php');
require_once('../../app/functions/array_to_json_canvasJS.php');

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
					Dados estatísticos
					<small>Relatório estatísticos dos agendamentos</small>
				</h1>
				<ol class="breadcrumb">
					<li><a onclick="javascript: location.href='admin.php';"><i class="fa fa-calendar"></i> Agendamentos</a></li>
					<li class="active">Dados estatísticos</li>
				</ol>
			</section>
			<!-- ============= IMPORTANDO O DASHBOARD ============= -->
			<?php /* Somente o adm verá o dashboard*/
			if($_SESSION['email'] == 'adm.bc.agendamento@gmail.com'){
				include_once('dashboard.php');
			}
			?>
			<!-- ================================================= -->
			<!-- Main content -->
			<section class="content">
				<!-- ==================================================================== -->
				<!-- ============================ linha 0 =============================== -->
				<!-- ==================================================================== -->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Dados gerais</h3>
					</div>
					<div class="box-body">
						Nesta sessão são apresentados dados estatísticos gerais, com dados obtidos desde a data da implantação do site SOS Normaliza.
					</div>
					<!-- /.box-body -->
				</div>
				<!-- ==================================================================== -->
				<!-- ============================ linha 1 =============================== -->
				<!-- ==================================================================== -->
				<!-- linha 1 -->
				<div class="row">
					<!-- coluna direita -->
					<div class="col-md-6">
						<!-- aqui irão ficar os textos  -->

						<!-- =========== LISTA DE Atendimentos por servidor =============== -->
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Atendimentos por servidor</h3>
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="height: 340px; max-width: 920px; margin: 0px auto;">
								<table class="table table-bordered">
									<tr>
										<th style="width: 10px">#</th>
										<th>Nome do servidor</th>
										<th>Quantidade</th>
										<!-- <th style="width: 40px">Percent. de atendimento</th> -->
									</tr>
									<?php
									$nomes = DBRead('ser_servidores','ser_nome');
									// leitura do banco de dados:
									$quantidades = DBRead('ser_servidores','ser_contador');
									$servidores = array_combine($nomes, $quantidades); // combina os dois vetores colocando o nome como key e a quantidade como value
									arsort($servidores);
									$count=1;
									foreach ($servidores as $nome => $quantidade){
										if($count>7)
										break;
										echo '
										<tr>
										<td>'.$count.'º</td>
										<td>'.$nome.'</td>
										<td>'.$quantidade.' usuário(s)</td>
										<td>
										</td>
										<td><span class="badge bg-black" title="Atendeu '.percent($quantidade,$servidores).'% dos usuários">'.number_format(percent($quantidade,$servidores),1).'%</span></td>
										</tr>

										';
										$count++;
									}
									?>
								</table>
							</div>
							<!-- /.box-body -->
							<div class="box-footer clearfix">
								<button type="button" class="btn pull-right btn-danger" data-toggle="modal" data-target="#servidores-ativos">
									Ver tudo
								</button>

								<div class="modal fade" id="servidores-ativos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h1 class="modal-title" id="exampleModalLongTitle">Lista de Atendimentos por servidor</h1>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<!-- <span aria-hidden="true">&times;</span> -->
												</button>
											</div>
											<div class="modal-body">
												<table class="table table-bordered">
													<tr>
														<th style="width: 10px">#</th>
														<th>Nome do servidor</th>
														<th>Quantidade</th>
														<!-- <th style="width: 40px">Percent. de atendimento</th> -->
													</tr>
													<?php
													$count=1;
													foreach ($servidores as $nome => $quantidade){
														// if($count>7)
														// 	break;
														echo '
														<tr>
														<td>'.$count.'º</td>
														<td>'.$nome.'</td>
														<td>'.$quantidade.' usuário(s)</td>
														<td>
														</td>
														<td><span class="badge bg-black" title="Atendeu '.percent($quantidade,$servidores).'% dos usuários">'.number_format(percent($quantidade,$servidores),1).'%</span></td>
														</tr>

														';
														$count++;
													}
													?>
												</table>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
												<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- =========== FIM DA LISTA DE Atendimentos por servidor =============== -->

						<!-- ====================== LISTA DE DUVIDAS MAIS FREQUENTES ============================= -->
						<div class="box box-default">
			              <div class="box-header with-border">
			                <h3 class="box-title">Dúvidas mais frequentes</h3>
			              </div>
			              <!-- /.box-header -->
			              <div class="box-body" style="height: 340px; max-width: 920px; margin: 0px auto;">
			                <table class="table table-bordered">
			                  <tr>
			                    <th style="width: 10px">#</th>
								<th>Tipos de dúvidas</th>
			                    <!-- <th>Quantidade</th> -->
			                    <!-- <th style="width: 40px">Percent.</th> -->
			                  </tr>
							  <?php
								  $prin_duvidas = DBRead("prin_principais_duvidas__agd_agendamentos","prin_id");
								  $nome_duvida = DBRead("prin_principais_duvidas","prin_duvida");
								  $id_duvida = DBRead("prin_principais_duvidas","prin_id");
								  $duvidas = array_combine($id_duvida,$nome_duvida);
								  $countDuv = array_fill_keys($duvidas, 0); // countDuv[["duvida1"]=>0, ["duvida2"]=>0, ["duvida3"]=>0 ....] inicializando o contador com valor zero, os indices são os ids das duvidas armazenadas no banco de dados

								  // percorre o $prin_duvidas[] e se o id for igual ao  id do $duvidas, então essa respectiva duvida é incrementada em $countDuv:
								  // countDuv[["duvida1"]=>3, ["duvida2"]=>2, ["duvida3"]=>4 ....]
								  for ($i=0; $i < count($prin_duvidas); $i++) {
									if(array_key_exists($prin_duvidas[$i], $duvidas)){
									  $countDuv[$duvidas[$prin_duvidas[$i]]] += 1;
									}
								  }
								  arsort($countDuv); // ordena em ordem decrescente
								  $count=1;
								  foreach ($countDuv as $nomeDuv => $quantidade) {
									  if($count>7)
										  break;
										echo '
											<tr>
											<td>'.$count.'º</td>
											<td>'.$nomeDuv.'</td>
											<!-- <td>'.$quantidade.'</td> -->
											<td>
											</td>
											<td><span class="badge bg-black" title="'.percent($quantidade,$countDuv).'% do total de dúvidas">'.number_format(percent($quantidade,$countDuv),1).'%</span></td>
											</tr>
										';
									$count++;
								  }
							   ?>
			                </table>
			              </div>
			              <!-- /.box-body -->
			              <div class="box-footer clearfix">
							  <button type="button" class="btn pull-right btn-danger" data-toggle="modal" data-target="#duvida-frequente">
							    Ver tudo
							  </button>

							  <div class="modal fade" id="duvida-frequente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h1 class="modal-title" id="exampleModalLongTitle">Lista de dúvidas mais frequentes</h1>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <!-- <span aria-hidden="true">&times;</span> -->
								        </button>
								      </div>
								      <div class="modal-body">
										  <table class="table table-bordered">
											<tr>
											  <th style="width: 10px">#</th>
											  <th>Tipos de dúvidas</th>
											  <!-- <th>Quantidade</th> -->
											  <!-- <th style="width: 40px">Percent.</th> -->
											</tr>
											<?php
												$count=1;
												foreach ($countDuv as $nomeDuv => $quantidade) {
													// if($count>7)
													// 	break;
													  echo '
														  <tr>
														  <td>'.$count.'º</td>
														  <td>'.$nomeDuv.'</td>
														  <!-- <td>'.$quantidade.'</td> -->
														  <td>
														  </td>
														  <td><span class="badge bg-black" title="'.percent($quantidade,$countDuv).'% do total de dúvidas">'.number_format(percent($quantidade,$countDuv),1).'%</span></td>
														  </tr>
													  ';
												  $count++;
												}
											 ?>
										  </table>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
								        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
								      </div>
								    </div>
								  </div>
							  </div>
			              </div>
			            </div>
						<!-- ====================== FIM DA LISTA DE DUVIDAS MAIS FREQUENTES ============================= -->

						<!-- ====================== LISTA DE CURSOS COM MAIS DÚVIDAS ============================= -->
						<div class="box box-default">
			              <div class="box-header with-border">
			                <h3 class="box-title">Agendamentos por cursos</h3>
			              </div>
			              <!-- /.box-header -->
			              <div class="box-body" style="height: 340px; max-width: 920px; margin: 0px auto;">
			                <table class="table table-bordered">
			                  <tr>
			                    <th style="width: 10px">#</th>
			                    <th>Curso</th>
								<!-- <th>Quantidade</th> -->
			                    <!-- <th style="width: 40px">Percent. de dúvidas</th> -->
			                  </tr>
							  <?php
								  $cursos = Array();
								  $agd_id_fk = DBRead("prin_principais_duvidas__agd_agendamentos","agd_id"); // ids que tiveram duvidas, um id pode aparecer mais de uma vez aqui
								  $agd_id_pk = DBRead("agd_agendamentos","agd_id"); // ids dos agendamentos
								  for ($i=0; $i < count($agd_id_fk); $i++) {
									if(in_array($agd_id_fk[$i],$agd_id_pk)){
									  $curso = DBReadOne("agd_agendamentos","agd_curso_programa"," WHERE agd_id = $agd_id_fk[$i]"); // pega o nome do curso na tabela de agendamentos de aacordo com o dado ID
									  $cursos[$i]=$curso;
									}
								  }
								  $num_duvidas_por_curso = array_count_values($cursos);
								  function cmp($a, $b){ // criterio de comparação para ser utilizado no usort()
									  if ($a == $b) {
									  return 0;
									  }
									  return ($a > $b) ? -1 : 1;
								  }
								  uasort($num_duvidas_por_curso, "cmp"); // o asort() não estava oredenando em ordem decrescente então tive que usar o uasort()
									// leitura do banco de dados.
									$count=1;
									$i=0;
									foreach ($num_duvidas_por_curso as $curso => $numDeDuv) {
										if($count>7)
											break;
										echo '
										<tr>
										<td>'.$count.'º</td>
										<td>'.$curso.'</td>
										<!-- <td>'.$numDeDuv.'</td>-->
										<td>
										</td>
										<td><span class="badge bg-black" title="'.percent($numDeDuv,$num_duvidas_por_curso).'% do total de dúvidas">'.number_format(percent($numDeDuv,$num_duvidas_por_curso),1).'%</span></td>
										</tr>
										';
										$count++;
									}
							?>
			                </table>
			              </div>
			              <div class="box-footer clearfix">
							  <button type="button" class="btn pull-right btn-danger" data-toggle="modal" data-target="#duvida-curso-modal">Ver tudo</button>
			              </div>

						  <div class="modal fade" id="duvida-curso-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h1 class="modal-title" id="exampleModalLongTitle">Lista de cursos com mais dúvidas</h1>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <!-- <span aria-hidden="true">&times;</span> -->
							        </button>
							      </div>
							      <div class="modal-body">
									  <table class="table table-bordered">
										<tr>
										  <th style="width: 10px">#</th>
										  <th>Curso</th>
										  <!-- <th>Quantidade</th> -->
										  <!-- <th style="width: 40px">Percent. de dúvidas</th> -->
										</tr>
										<?php
											  $count=1;
											  $i=0;
											  foreach ($num_duvidas_por_curso as $curso => $numDeDuv) {
												  // if($count>7)
												  // 	break;
												  echo '
												  <tr>
												  <td>'.$count.'º</td>
												  <td>'.$curso.'</td>
												  <!-- <td>'.$numDeDuv.'</td>-->
												  <td>
												  </td>
												  <td><span class="badge bg-black" title="'.percent($numDeDuv,$num_duvidas_por_curso).'% do total de dúvidas">'.number_format(percent($numDeDuv,$num_duvidas_por_curso),1).'%</span></td>
												  </tr>
												  ';
												  $count++;
											  }
									  ?>
									  </table>
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
							        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
							      </div>
							    </div>
							  </div>
							</div>
			            </div>
						<!-- ====================== FIM DA LISTA DE CURSOS COM MAIS DÚVIDAS ============================= -->
					</div>
					<!-- coluna esquerda -->
					<div class="col-md-6">
						<!-- aqui irão ficar os gráficos  -->

						<!-- =========== chart DE Atendimentos por servidor =============== -->
						<!-- /.box-header -->
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Gráfico atendimentos por servidor</h3>
							</div>
							<!-- end/.box-header -->
							<!-- /.box-body -->
							<div class="box-body" style="height: 340px; max-width: 920px; margin: 0px auto;">
								<div id="chartServidor" style="height: 375px; width: 100%;"></div>
							</div>
							<!-- end/.box-body -->
							<!-- /.box-footer -->
							<div class="box-footer clearfix">
								<div style="height: 34px"></div>
							</div>
							<!-- end/.box-footer -->
						</div>
						<!-- =========== FIM DO chart DE Atendimentos por servidor =============== -->

						<!-- =========== chart DE duvidas frequentes =============== -->
						<!-- /.box-header -->
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Gráfico dúvidas mais frequentes</h3>
							</div>
							<!-- end/.box-header -->
							<!-- /.box-body -->
							<div class="box-body" style="height: 340px; max-width: 920px; margin: 0px auto;">
								<div id="chartDuvida" style="height: 375px; width: 100%;"></div>
							</div>
							<!-- end/.box-body -->
							<!-- /.box-footer -->
							<div class="box-footer clearfix">
								<div style="height: 34px"></div>
							</div>
							<!-- end/.box-footer -->
						</div>
						<!-- =========== FIM DO chart DE duvidas frequentes =============== -->

						<!-- =========== chart DE duvidas curso =============== -->
						<!-- /.box-header -->
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Gráfico agendamentos por curso</h3>
							</div>
							<!-- end/.box-header -->
							<!-- /.box-body -->
							<div class="box-body" style="height: 340px; max-width: 920px; margin: 0px auto;">
								<div id="chartCurso" style="height: 375px; width: 100%;"></div>
							</div>
							<!-- end/.box-body -->
							<!-- /.box-footer -->
							<div class="box-footer clearfix">
								<div style="height: 34px"></div>
							</div>
							<!-- end/.box-footer -->
						</div>
						<!-- =========== FIM DO chart DE duvidas curso =============== -->
					</div>
				</div>
			</section>
		</div>
		<!-- /.content-wrapper -->
		<?php include_once('rodape.php') ?>

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
		<!-- <script src="../AdminLTE-master/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="../AdminLTE-master/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> -->
		<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>


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

		<!-- script de coinfigurações dos charts -->
		<script>
			// ============================= chart dos atentimentos por sevidor ============================
			<?php
			$nomes = DBRead('ser_servidores','ser_nome');
			// leitura do banco de dados:
			$quantidades = DBRead('ser_servidores','ser_contador');
			$servidores = array_combine($nomes, $quantidades); // combina os dois vetores colocando o nome como key e a quantidade como value
			arsort($servidores); // ordena em ordem decrescente
			$dataPoints = array_to_json_canvasJS($servidores); // convert array associativo para o formato json própio para o CanvasJS
			// leitura do banco de dados.
			?>
			//configuração do chart do CanvasJS:
			$(document).ready(function () {
				var chart = new CanvasJS.Chart("chartServidor",
				{
					title:{
						text: "De ago de 2018 a <?php echo date("M Y") ?>",
						fontSize: 12
					},
					legend: {
						maxWidth: 120,
						itemWidth: 60
					},
					data: [
					{
						type: "pie",
						showInLegend: true,
						legendText: "{indexLabel}",
						dataPoints: <?php  echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
					}
					]
				});
				chart.render();
			});
			// ============================= fim do chart dos atentimentos por sevidor ============================

			// ============================= chart das duvidas frequentes ============================
			<?php
				$prin_duvidas = DBRead("prin_principais_duvidas__agd_agendamentos","prin_id");
				$nome_duvida = DBRead("prin_principais_duvidas","prin_duvida");
				$id_duvida = DBRead("prin_principais_duvidas","prin_id");
				$duvidas = array_combine($id_duvida,$nome_duvida);
				$countDuv = array_fill_keys($duvidas, 0); // countDuv[["duvida1"]=>0, ["duvida2"]=>0, ["duvida3"]=>0 ....] inicializando o contador com valor zero, os indices são os ids das duvidas armazenadas no banco de dados

				// percorre o $prin_duvidas[] e se o id for igual ao  id do $duvidas, então essa respectiva duvida é incrementada em $countDuv:
				// countDuv[["duvida1"]=>3, ["duvida2"]=>2, ["duvida3"]=>4 ....]
				for ($i=0; $i < count($prin_duvidas); $i++) {
					if(array_key_exists($prin_duvidas[$i], $duvidas)){
						$countDuv[$duvidas[$prin_duvidas[$i]]] += 1;
					}
				}
				arsort($countDuv); // ordena em ordem decrescente
				$dataPoints = array_to_json_canvasJS($countDuv); // convert array associativo para o formato json própio para o CanvasJS
				// leitura do banco de dados.
			?>
			//configuração do chart do CanvasJS:
			$(document).ready(function () {
				var chart2 = new CanvasJS.Chart("chartDuvida",
				{
					title:{
						text: "De ago de 2018 a <?php echo date("M Y") ?>",
						fontSize: 12
					},
					legend: {
						maxWidth: 120,
						itemWidth: 60
					},
					data: [
					{
						type: "pie",
						showInLegend: true,
						legendText: "{indexLabel}",
						dataPoints: <?php  echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
					}
					]
				});
				chart2.render();
			});
			// ============================= fim do chart das duvidas frequentes ============================


			// ============================= chart das duvidas cursos ============================
			<?php
				$cursos = Array();
				$agd_id_fk = DBRead("prin_principais_duvidas__agd_agendamentos","agd_id"); // ids que tiveram duvidas, um id pode aparecer mais de uma vez aqui
				$agd_id_pk = DBRead("agd_agendamentos","agd_id"); // ids dos agendamentos
				for ($i=0; $i < count($agd_id_fk); $i++) {
					if(in_array($agd_id_fk[$i],$agd_id_pk)){
						$curso = DBReadOne("agd_agendamentos","agd_curso_programa"," WHERE agd_id = $agd_id_fk[$i]"); // pega o nome do curso na tabela de agendamentos de aacordo com o dado ID
						$cursos[$i]=$curso;
					}
				}
				$num_duvidas_por_curso = array_count_values($cursos);
				uasort($num_duvidas_por_curso, "cmp");
				$dataPoints = array_to_json_canvasJS($num_duvidas_por_curso); // convert array associativo para o formato json própio para o CanvasJS
				// leitura do banco de dados.
			?>
			//configuração do chart do CanvasJS:
			$(document).ready(function () {
				var chart3 = new CanvasJS.Chart("chartCurso",
				{
					title:{
						text: "De ago de 2018 a <?php echo date("M Y") ?>",
						fontSize: 12
					},
					legend: {
						maxWidth: 120,
						itemWidth: 60
					},
					data: [
					{
						type: "pie",
						showInLegend: true,
						legendText: "{indexLabel}",
						dataPoints: <?php  echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
					}
					]
				});
				chart3.render();
			});
			// ============================= fim do chart das duvidas cursos ============================

		</script>
		<!-- fim do script de coinfigurações dos charts -->

		<?php
		$message = filter_input(INPUT_GET, 'message', FILTER_SANITIZE_STRING);
		if($message!=''){
			echo "<script> alert('$message')</script>";
			echo "<script> window.location.href = window.location.pathname</script>";
		}
		?>
	</body>
	</html>
