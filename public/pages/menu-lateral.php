<meta name="theme-color" content="#DD4B39">
<meta name="apple-mobile-web-app-status-bar-style" content="#DD4B39">
<header class="main-header">

	<!-- Logo -->
	<a href="#" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>S</b>CA</span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>SistCA</b></span>
	</a>

	<!-- Header Navbar: estilo pode ser encontrado no cabeçalho.less -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">

				<!-- User Account: estilo pode ser encontrado no menu suspenso.less -->

				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<!--<img src="../AdminLTE-master/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
						<span><?php
						$print_nome = substr( $_SESSION['nome'] ,0, strpos($_SESSION['nome'], ' '));
						if($print_nome==''){
							echo $_SESSION['nome'];
						} else {
							echo $print_nome;
						}?></span>
					</a>

					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<img src="<?php echo CAM_RAIZ?>AdminLTE-master/dist/img/default-avatar.gif" class="img-circle" alt="User Image">

							<p>
								<?php echo $_SESSION['nome'] ?>
								<small>Membro desde <?php echo date("d/m/Y",strtotime($_SESSION['criada'])) ?></small>
							</p>
						</li>
						<!-- Menu Footer-->
						<li class="user-footer" style="display:flex; justify-content: space-between;">
							<div class="pull-left">
								<!-- <a href="<?php echo CAM_RAIZ?>?page=profile" class="btn btn-default btn-flat">Perfil</a> -->
								<a href="profile.php" class="btn btn-default btn-flat">Perfil</a>
							</div>
							<div class="pull-left">
								<a href="https://docs.google.com/presentation/d/17Huq49eHXC4f7llAxJo8bQCnsVGMXroTDAk9j1zSzLw/edit#slide=id.p" class="btn btn-default btn-flat" target="_blank">Ajuda</a>
							</div>
							<div class="pull-right">
								<a href="<?php echo CAM_RAIZ_2?>functions/signOut.php" class="btn btn-default btn-flat">Sair</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<!-- User's profile picture  -->
			<div class="pull-left image">
				<img src="<?php echo CAM_RAIZ?>AdminLTE-master/dist/img/default-avatar.gif" class="img-circle" alt="User Image">
			</div>
			<!-- User's type -->
			<div class="pull-left info">
				<p><?php echo $_SESSION['tipo']; ?></p>
				<!-- <a href="echo CAM_RAIZ?>?page=profile">Meu perfil</a> -->
				<a href="profile.php">Meu perfil</a>
			</div>
		</div>
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">

			<li><a href="admin.php"><i class="fa  fa-dashboard"></i> <span>Painel de controle</span></a></li>
			<!-- <li class="active treeview menu-open"> -->
			<li class="treeview">

				<a href="#"> <!-- se der bug ver aqui -->
					<i class="fa fa-calendar"></i> <span>Agendamentos</span>
						<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="treeview">
						<li><a href="efetivos.php">  <i class="fa fa-calendar-plus-o"></i> Efetivos </a></li>
						<li><a href="concluidos.php"> <i class="fa fa-calendar-check-o"></i> Concluídos </a></li>
					</li>
				</ul>
			</li>

			<li><a href="<?php echo CAM_RAIZ?>?page=contato"><i class="fa fa-edit"></i> Realizar agendamento</a></li>
			<li><a href="http://bc.ufpa.br/sosnormaliza-teste/public/?page=cancelar_agendamento_usuario"><i class="fa  fa-calendar-times-o"></i> Cancelar agendamento</a></li>

			<?php
			//somente o adm do sistema pode ter acesso a estas opções
			if($_SESSION['email'] == 'adm.bc.agendamento@gmail.com') {

				echo '<li class="treeview">
				<a href="#">
				<i class="fa fa-laptop"></i>
				<span>Gerenciar</span>
				<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
				</span>
				</a>
				<ul class="treeview-menu">
				<li><a href="servidores_disponives.php"><i class="fa fa-users"></i> Servidores</a></li>
				<li><a href="servidores_horarios.php"><i class="fa fa-clock-o"></i> Horários</a></li>
				<li><a href="email-avisos.php"><i class="fa fa-envelope"></i> <span> Mensagens</span></a></li>
				</ul>
				</li> ';
			}
			// './*<li><a href="'.CAM_RAIZ.'?page=gerenciarHorarios"><i class="fa fa-clock-o"></i> Horários</a></li>*/.'

			?>

			<!-- <li><a href="<?php echo CAM_RAIZ;?>?page=estatistica"><i class="fa fa-line-chart"></i> <span>Estatísticas</span></a></li> -->
			<li><a href="estatistica.php"><i class="fa fa-line-chart"></i> <span>Estatísticas</span></a></li>

			<li class="header">OUTROS</li>

			<li><a href="https://docs.google.com/presentation/d/17Huq49eHXC4f7llAxJo8bQCnsVGMXroTDAk9j1zSzLw/edit#slide=id.p" title="Em breve"><i class="fa fa-book"></i> <span>Manual do usuário</span></a></li>
			<li><a href="<?php echo CAM_BC_1;?>"><i class="fa fa-institution"></i> <span>Voltar para SIBI/UFPA</span></a></li>
			<li><a href="<?php echo CAM_RAIZ_2;?>functions/signOut.php"><i class="fa fa-power-off"></i> <span>Sair</span></a></li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>
