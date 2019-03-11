

<?php
//Só funcionou desse, se conseguir resolver avise-me. By Jairo
require_once('../../app/functions/bdq.php');
require_once('../../bootstrap.php');

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
					Mensagens
					<small>Enviar avisos para servidores do sistema</small>
				</h1>
				<ol class="breadcrumb">
					<li><a onclick="javascript: location.href='admin.php';"><i class="fa fa-calendar"></i> Agendamentos</a></li>
					<li class="active">Mensagens</li>
				</ol>
			</section>
			<!-- Main content -->
      <section class="content">
        <div class="row">

          <!-- /.col -->
          <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Escrever aviso geral</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <form action="forms/email-avisos.php" method="POST" role="form" enctype="multipart/form-data">

                    <div class="form-group">

                      <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa  fa-header"></i>
                        </div>
                        <input type="text" name="title" class="form-control" placeholder="Digite um título para o aviso..." >
                      </div>
                      <!-- /.input group -->
                    </div>


                    <div class="form-group">
                          <textarea id="compose-textarea" name="comment" class="form-control" style="height: 300px" placeholder="Digite a mensagem..."></textarea>
                    </div>
                    <div class="form-group">
                      <div class="btn btn-danger btn-file">
                        <i class="fa fa-paperclip"></i> Adicionar anexo
                        <input type="file" name="agd_files" style="" />
                      </div>
                      <p class="help-block">Max. 32MB</p>
                 </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="pull-right">
                  <button type="submit" class="btn btn-danger"><i class="fa fa-send-o"></i> <span style="padding-left: 5px">Enviar mensagem</span></button>
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
            </div>
            <!-- /. box -->
          </div>
        <!-- /.col -->
      </div>
    </div>
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
