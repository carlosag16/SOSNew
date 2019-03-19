<a style="text-decoration:none; cursor:pointer;" href="<?php //echo CAM_RAIZ?>?page=contato">

	<img id="normaliza_img" style="padding-top: 5vh" src="<?php echo CAM_RAIZ_2?>sos normaliza.png"/></a>
	<?php
	session_start();
	/*
	if(!isset($_SESSION['id'])){
	echo "
	<button type=\"button\" id=\"login\"  title=\"Login do Bibliotecário: gerenciar meus agendamentos\" style=\"float:right; margin: 16% 5% 0 0;\" class=\"btn btn-primary\" onclick=\"window.location.href='".CAM_RAIZ."?page=login'\"> Login</button>
	";
}*/
?>

<!--<div style="float: right!important;margin-bottom:0!important;margin-left:70%;position:fixed;">
<a href="http://bc.ufpa.br/guia-de-trabalhos-academicos" target="_blank" title="Consultar o Guia de Trabalhos Acadêmicos"/>
<img src="../app/gta-icon.png" width="150px" />
</a>
</div>-->

<div class="info-box">
	Tem trabalho para entregar e as dúvidas sobre a formatação não param de aparecer? Calma! O SOS Normaliza BC te ajuda! Agende um horário conosco e esclareça suas dúvidas presencialmente!

</div>


<form action="pages/forms/contato.php" method="POST" role="form">

	<!-- Definição do Passo 1: Dados pessoais -->
	<br/><div class="identificadorPasso">1</div> <div class="info-aux">Preencha os dados abaixo:</div><br/>

	<!-- Campo de matrícula -->
	<div class="form-separate">
		<label for="">Matrícula</label>

		<input type="text" class="form-control" name="matricula" placeholder="201504940015" value="<?php echo $_SESSION['var_matricula']?>" required/>

	</div>

	<!-- Campo de nome -->
	<div class="form-separate">
		<label for="">Nome</label>

		<input type="text" class="form-control" name="name" placeholder="João Pedro de Albuquerque" value="<?php echo $_SESSION['var_name']?>" required/>

	</div>

	<!-- Campo de e-mail -->
	<div class="form-separate">
		<label for="">E-mail</label>

		<input type="email" class="form-control" name="email" placeholder="joaopedro@mail.br" value="<?php echo $_SESSION['var_email']?>" required/>
	</div>

	<!-- Campo de telefone -->
	<div class="form-separate">
		<label for="">Telefone</label>

		<input type="text" class="form-control" name="phone" placeholder="91982146347" value="<?php echo $_SESSION['var_phone']?>"/>

	</div>

	<!-- Campo de curso ou programa -->
	<div class="form-separate">
		<label for="">Curso/Programa</label>

		<input type="text" class="form-control" name="course" placeholder="Insira o curso ou programa" value="<?php echo $_SESSION['var_course']?>" required/>
	</div>
<!-- <div class="form-separate">
	<label for="">Curso/Programa</label> -->
	<!-- <input type="text" class="form-control" name="course" placeholder="Insira o curso ou programa" value="<?php echo $_SESSION['var_course']?>" required/> -->
	<!-- <select class="form-control" id="cursos" name="course" value="<?php //echo $_SESSION['var_course']?>" y>
		<?php
		// $cursos = DBRead("tb_cursos","nome_curso");
		// sort($cursos, SORT_STRING);
		// foreach($cursos as $curso){
		// 	echo "<option".$_SESSION['var_course'].">$curso</option>";
		// }
		?>
	</select>
</div> -->

<br/><br/>

<!-- Definição do Passo 2: As dúvidas -->
<div class="identificadorPasso">2</div> <div class="info-aux">Quais são suas principais dúvidas?</div><br/>

<div id="box_prin_duvidas">
	<?php

	$duvidas_id = DBRead("prin_principais_duvidas","prin_id");
	$duvidas = DBRead("prin_principais_duvidas","prin_duvida");

	for($i=0; $i<Count($duvidas_id);$i++){
		echo "<label class=\"control control--checkbox\">";
		echo "<input type=\"checkbox\" name=\"question[]\" value =\"".($duvidas_id[$i])."\">$duvidas[$i]<br>";
		echo "<div class=\"control__indicator\"></div>";
		echo "</label>";
	}
	?>
</div>

<br/><br/>

<!-- Definição do Passo 3: O agendamento -->
<div class="identificadorPasso">3</div><div class="info-aux">Escolha uma data e horário:</div><br/>

<!-- Escolha de horários -->
<div class="form-separate">
	<label for="">Agendamento</label>
	<input type="text" class="form-control" id="datepicker" name="dateday" placeholder="Clique para escolher" value="<?php echo $_SESSION['var_dateday']?>" autocomplete="off" required>

	<div id="time_box" style="margin-bottom:30px;"></div>
</div>

<br><br>

<!-- Definição do Passo 4 -->
<div class="identificadorPasso">4</div> <div class="info-aux">Valide o re-CAPTCHA</div><br/>
<div class="form-separate">
	<!-- Gerador do re-CAPTCHA -->
	<div class="g-recaptcha" data-sitekey="6LeeUVYUAAAAAIHHqk_bg6qXdnYbRMmx6OMSeYiV"></div>
</div>
<br/>
<br/>
<br/>

<center>
	<div style="display: inline;">
		<!-- Botão para chamar confirmação de envio -->
		<div id="btn_agendar" onclick="btn_agendar()" style="display: inline; margin-bottom:5%" class="btn btn-primary">Confirmar agendamento</div>

		<div id="confirmar_agendamento">
			<div class="info-box">
				Ao confirmar, você certifica que está de acordo com o serviço que será prestado. É uma orientação com base nas normas da ABNT e está voltada para tirar suas principais dúvidas.
			</div>
			<br> <br>
			<!-- Botão de envio do formulário -->
			<button type="submit" style="display: inline" class="btn btn-primary">Confirmar agendamento</button>
		</div>

		<!-- Botão para adiministradores: Voltar ao painel de administração -->
		<?php
		if(isset($_SESSION['id'])){
			echo "
			<button type=\"button\" style=\"display:inline;margin-left:20px;\" class=\"btn btn-primary\" onclick=\"window.location.href='".CAM_ADMIN."'\">Voltar ao Painel Principal</button>
			";
		}
		?></div></center>


	</form>
