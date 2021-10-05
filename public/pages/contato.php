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
	Tem trabalho para entregar e as dúvidas sobre a formatação não param de aparecer? Calma! O SOS Normaliza BC te ajuda! Agende um horário conosco e esclareça suas dúvidas!

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
<!-- <div class="form-separate">
	<label for="">Curso/Programa</label>
	<input type="text" class="form-control" name="course" placeholder="Insira o curso ou programa" value="<?php echo $_SESSION['var_course']?>" required/>
	<select class="form-control" id="cursos" name="course" value="">
		<option value=""></option>
		<option value=""></option>
	</select>
</div> -->
<div class="form-separate">
<label for="">Curso/Programa</label>

<input id="curso" type="text" class="form-control" name="course" placeholder="Insira o curso ou programa" value="<?php echo $_SESSION['var_course']?>" required/>
</div>

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
<!-- definição do passo 4 -->
<div class="identificadorPasso">4</div>
<div class="info-aux">Escolha se será presencial ou online</div>
<div class="form-separate">
<label>Presencial ou online</label>
<select required class="form-control>
<option value="online">Online</option>
<option value="presencial">Presencial</option>
<option value="online">Online</option>
</select>
</div>
<br><br>

<!-- Definição do Passo 5 -->
<div class="identificadorPasso">5</div> <div class="info-aux">Valide o re-CAPTCHA</div><br/>
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

	<script>
	  // $( function() {
	  //   var availableTags = [
		// 		"ICA Programa de Pós-Graduação em Artes PPGARTES"	,
		// 		"ICB Programa de Pós-Graduação em Biotecnologia PPGBIOTEC"	,
		// 		"ICB Programa de Pós-Graduação em Genética e Biologia Molecular PPGBM"	,
		// 		"ICB Programa de Pós-Graduação em Neurociências e Biologia celular PPGNBC"	,
		// 		"ICB Programa de Pós-Graduação em Biologia de Agentes Infecciosos e Parasitários PPGBAIP"	,
		// 		"ICB Programa de Pós-Graduação em Ecologia Aquática e Pesca PPGEAP"	,
		// 		"ICB Programa de Pós-Graduação em Zoologia PPGZOOL"	,
		// 		"ICB Programa de Pós-Graduação em Ecologia PPGECO"	,
		// 		"ICB Programa de Pós-Graduação em Análises Clínicas MACPRO"	,
		// 		"ICB Programa de Pós-Graduação em Saúde	Sociedade e Ambiente PPGSSEA",
		// 		"ICED Programa de Pós-Graduação em Educação PPGED"	,
		// 		"ICEN Programa de Pós-Graduação em Matemática e Estatística PPGME"	,
		// 		"ICEN Programa de Pós-Graduação em Física PPGF"	,
		// 		"ICEN Programa de Pós-Graduação em Ciência da Computação PPGCC"	,
		// 		"ICEN Programa de Pós-Graduação em Química PPGQ"	,
		// 		"ICJ Programa de Pós-Graduação em Direito PPGD"	,
		// 		"ICS Programa de Pós-Graduação em Ciências Farmacêuticas PPGCF"	,
		// 		"ICS Programa de Pós-Graduação em Enfermagem PPGENF"	,
		// 		"ICS Programa de Pós-Graduação em Odontologia PPGO"	,
		// 		"ICS Programa de Pós-Graduação em Química Medicinal e Modelagem Molecular PPGQM3"	,
		// 		"ICSA Programa de Pós-Graduação em Economia PPGE"	,
		// 		"ICSA Programa de Pós-Graduação em Serviço Social PPGSS"	,
		// 		"ICSA Programa de Pós-Graduação em Ciência da Informação PPGCI"	,
		// 		"IFCH Programa de Pós-Graduação em Antropologia PPGA"	,
		// 		"IFCH Programa de Pós-Graduação em Ciência Política PPGCP"	,
		// 		"IFCH Programa de Pós-Graduação em Segurança Pública PPGSP"	,
		// 		"IFCH Programa de Pós-Graduação em Filosofia PPGF"	,
		// 		"IFCH Programa de Pós-Graduação em Geografia PPGG"	,
		// 		"IFCH Programa de Pós-Graduação em História PPGH"	,
		// 		"IFCH Programa de Pós-Graduação em Psicologia PPGP"	,
		// 		"IFCH Programa de Pós-Graduação em Sociologia e Antropologia PPGSA"	,
		// 		"IG Programa de Pós-Graduação em Ciências Ambientais PPGCA"	,
		// 		"IG Programa de Pós-Graduação em Geologia e Geoquímica PPGG"	,
		// 		"IG Programa de Pós-Graduação Geofísica CPGf"	,
		// 		"IG Programa de Pós-Graduação em Recursos Hídricos PPRH"	,
		// 		"ILC Programa de Pós-Graduação em Letras PPGL"	,
		// 		"ILC Programa de Pós-Graduação em Comunicação PPGCOM"	,
		// 		"ITEC Programa de Pós-Graduação em Arquitetura e Urbanismo PPGAU"	,
		// 		"ITEC Programa de Pós-Graduação em Ciência e Tecnologia de Alimentos PPGCTA"	,
		// 		"ITEC Programa de Pós-Graduação em Engenharia Civil PPGEC"	,
		// 		"ITEC Programa de Pós-Graduação em Engenharia de Processos PPGEP"	,
		// 		"ITEC Programa de Pós-Graduação em Engenharia Elétrica PPGEE"	,
		// 		"ITEC Programa de Pós-Graduação em Engenharia Industrial PPGEI"	,
		// 		"ITEC Programa de Pós-Graduação em Engenharia Mecânica PPGEM"	,
		// 		"ITEC Programa de Pós-Graduação em Engenharia Química PPGEQ"	,
		// 		"ITEC Programa de Pós-Graduação em Processos Construtivos e Saneamento Urbano PPCS"	,
		// 		"NAEA Programa de Pós-Graduação em Desenvolvimento Sustentável do Trópico Úmido PPGDSTU"	,
		// 		"NAEA Programa de Pós-Graduação em Gestão Pública PPGGP"	,
		// 		"NCADR Programa de Pós-Graduação em Ciência Animal PPGCAN"	,
		// 		"NCADR Programa de Pós-Graduação em Agriculturas Amazônicas PPGAA"	,
		// 		"NDAE Programa de Pós-Graduação em Computação Aplicada PPCA"	,
		// 		"NDAE Programa de Pós-Graduação em Engenharia de Barragem e Gestão Ambiental PEBGA"	,
		// 		"NDAE Programa de Pós-Graduação em Engenharia de Infraestrutura e Desenvolvimento Energético PPGINDE"	,
		// 		"NMT Programa de Pós-Graduação em Doenças Tropicais PPGDT"	,
		// 		"NMT Programa de Pós-Graduação em Saúde na Amazônia PPGSA"	,
		// 		"NUMA Programa de Pós-Graduação em Gestão de Recursos Naturais e Desenvolvimento Local na Amazônia PPGEDAM"	,
		// 		"CANAN Mestrado Profissional em Ensino de História PROFHISTORIA"	,
		// 		"CBRAG Programa de Pós-Graduação em Biologia Ambiental PPGBA"	,
		// 		"CUNTI Programa de Pós-Graduação em Educação e Cultura PPGEDUC"	,
		// 		"CCAST Programa de Pós-Graduação em Saúde Animal na Amazônia PPGSAAM"	,
		// 		"CCAST Programa de Pós-Graduação em Ciência Animal PPGCAN"	,
		// 		"IEMCI Programa de Pós-Graduação em Docência em Educação em Ciências e Matemáticas PPGDOC"	,
		// 		"IEMCI Programa de Pós-Graduação em Educação em Ciências e Matemáticas PPGECM"	,
		// 		"ICED Programa de Pós-Graduação em Currículo e Gestão da Escola Básica PPGEB"	,
		// 		"IG Programa de Pós-Graduação em Rede Nacional para o Ensino das Ciências Ambientais PROFCIAMB"	,
		// 		"CBRAG Programa de Mestrado Interdisciplinar em Linguagens e Saberes na Amazônia PPLSA"	,
		// 		"CBRAG Programa de Mestrado Profissional em Ensino da Matemática PROFMAT"	,
		// 		"ILC Mestrado Profissional em Letras em Rede Nacional PROFLETRAS"	,
		// 		"CAMTU Programa de Pós-Graduação em Engenharia de Barragem e Gestão Ambiental PEBGA"	,
		// 		"NDAE Mestrado Profissional em Computação Aplicada PPCA"	,
		// 		"IG Programa de Pós-Graduação em Gestão de Risco e Desastre na Amazônia PPGGRD"	,
		// 		"CALTA Programa de Pós-Graduação em Biodiversidade e Conservação PPGBC"	,
		// 		"ICS Programa de Pós-Graduação em Saúde	Ambiente e Sociedade na Amazônia PPGSAS",
		// 		"ITEC Programa de Pós-Graduação em Engenharia Naval PPGENAV"	,
		// 		"ICEN Programa de Pós-Graduação em Ciências e Meio Ambiente PPGCMA"	,
		// 		"NEB Programa de Pós-Graduação em Currículo e Gestão da Escola Básica PPEB"	,
		// 		"ICEN Programa de Pós-Graduação em Matemática em Rede Nacional PROFMAT"	,
		// 		"CCAST Programa de Pós-Graduação em Matemática em Rede Nacional PROFMAT"	,
		// 		"CCAST Programa de Pós-Graduação em Estudos Antrópicos na Amazônia PPGEAA"	,
		// 		"NTPC Programa de Pós-Graduação em Teoria e Pesquisa do Comportamento PPGTPC"	,
		// 		"NTPC Programa de Pós-Graduação em Neurociências e Comportamento PPGNC"	,
		// 		"NPO Programa de Pós-Graduação em Oncologia e Ciências Médicas PPGOCM"	,
		// 		"INEAF Programa de Pós-Graduação em Agriculturas Amazônicas PPGAA"	,
		// 		"DMT Programa de Demonstração 1",
		// 		"DMT Programa de Demonstração 2",
		// 		"DMT Programa de Demonstração 3",
		// 		"CABAE Programa de Pós-Graduação em Matemática em Rede Nacional PROFMAT"	,
		// 		"CABAE Programa de Pós-Graduação em Cidades	Territórios e Identidades PPGCITI",
		// 		"NITAE Programa de Pós-Graduação Criatividade e Inovação em Metodologias de Ensino Superior PPGCIMES",
		// 		"ICA Programa de Pós-Graduação em Artes PPGARTES",
		// 		"ICB Programa de Pós-Graduação em Biotecnologia PPGBIOTEC",
		// 		"ICB Programa de Pós-Graduação em Genética e Biologia Molecular PPGBM",
		// 		"ICB Programa de Pós-Graduação em Neurociências e Biologia Celular PPGNBC",
		// 		"ICB Programa de Pós-Graduação em Biologia de Agentes Infecciosos e Parasitários PPGBAIP",
		// 		"ICB Programa de Pós-Graduação em Ecologia Aquática e Pesca PPGEAP",
		// 		"ICB Programa de Pós-Graduação em Zoologia PPGZOOL",
		// 		"ICB Programa de Pós-Graduação em Ecologia PPGECO",
		// 		"ICED Programa de Pós-Graduação em Educação PPGED",
		// 		"ICEN Programa de Pós-Graduação em Matemática e Estatística PPGME",
		// 		"ICEN Programa de Pós-Graduação em Física PPGF",
		// 		"ICEN Programa de Pós-Graduação em Ciência da Computação PPGCC",
		// 		"ICJ Programa de Pós-Graduação em Direito PPGD",
		// 		"ICS Programa de Pós-Graduação em Química Medicinal e Modelagem Molecular PPGQM3",
		// 		"ICEN Programa de Pós-Graduação em Química PPGQ",
		// 		"ICSA Programa de Pós-Graduação em Economia PPGE",
		// 		"IFCH Programa de Pós-Graduação em História PPGH",
		// 		"IFCH Programa de Pós-Graduação em Psicologia PPGP",
		// 		"IFCH Programa de Pós-Graduação em Sociologia e Antropologia PPGSA",
		// 		"IFCH Programa de Pós-Graduação em Geografia PPGG",
		// 		"IFCH Programa de Pós-Graduação em Antropologia PPGA",
		// 		"IFCH Doutorado Interinstitucional em Relações Internacionais DINTER",
		// 		"IG Programa de Pós-Graduação em Ciências Ambientais PPGCA",
		// 		"IG Programa de Pós-Graduação em Geologia e Geoquímica PPGG",
		// 		"IG Programa de Pós-Graduação Geofísica CPGF",
		// 		"ILC Programa de Pós-Graduação em Letras PPGL",
		// 		"ITEC Programa de Pós-Graduação em Ciência e Tecnologia de Alimentos PPGCTA",
		// 		"ITEC Programa de Pós-Graduação em Engenharia Civil PPGEC",
		// 		"ITEC Programa de Pós-Graduação em Engenharia de Recursos Naturais na Amazônia PRODERNA",
		// 		"ITEC Programa de Pós-Graduação em Engenharia Elétrica PPGEE",
		// 		"NAEA Programa de Pós-Graduação em Desenvolvimento Sustentável do Trópico Úmido PPGDSTU",
		// 		"NCADR Programa de Pós-Graduação em Ciência Animal PPGCAN",
		// 		"NMT Programa de Pós-Graduação em Doenças Tropicais PPGDT",
		// 		"NTPC Programa de Pós-Graduação em Teoria e Pesquisa do Comportamento PPGTPC",
		// 		"CBRAG Programa de Pós-Graduação em Biologia Ambiental PPGBA",
		// 		"CCAST Programa de Pós-Graduação em Saúde Animal na Amazônia PPGSAAM",
		// 		"CCAST Programa de Pós-Graduação em Ciência Animal PPGCAN",
		// 		"IEMCI Programa de Pós-Graduação em Educação em Ciências e Matemáticas PPGECM",
		// 		"ICB Programa de Pós-Graduação em Biodiversidade e Biotecnologia BIONORTE",
		// 		"ICED Programa de Pós-Graduação em Currículo e Gestão da Escola Básica PPGEB",
		// 		"NPO Programa de Pós-Graduação em Oncologia e Ciências Médicas PPGOCM",
		// 		"DMT Programa de Demonstração 1",
		// 		"DMT Programa de Demonstração 2",
		// 		"DMT Programa de Demonstração 3",
		// 		"ICS Programa de Pós-Graduação em Rede em Inovação Farmacêutica PPGIF",
		// 		"ICSA Faculdade de Biblioteconomia FABIB",
		// 		"ICA Faculdade de Artes Visuais FAV",
		// 		"ICA Faculdade de Cinema FAV",
		// 		"ICA Faculdade de Música EMUFPA",
		// 		"ICA Faculdade de Multimídia FAV",
		// 		"ICA Faculdade de Museologia FAV",
		// 		"ICA Faculdade de Teatro ETDUFPA",
		// 		"ICB Faculdade de Biomedicina FBM",
		// 		"ICB Faculdade de Biotecnologia FBIOTEC",
		// 		"ICB Faculdade de Ciências Biológicas FCB",
		// 		"ICED Faculdade de Educação FAED",
		// 		"ICED Faculdade de Educação Física  FAEF",
		// 		"ICEN Faculdade de Matemática FAMAT",
		// 		"ICEN Faculdade de Física FACFIS",
		// 		"ICEN Faculdade de Química FACQ",
		// 		"ICEN Faculdade de Computação FACOMP",
		// 		"ICEN Faculdade de Estatística FAEST",
		// 		"ICEN Faculdade de Ciências Naturais FACIN",
		// 		"ICJ Faculdade de Direito FADIR",
		// 		"ICS Faculdade de Enfermagem FAENF",
		// 		"ICS Faculdade de Farmácia FFARM",
		// 		"ICS Faculdade de Fisioterapia e Terapia Ocupacional FFTO",
		// 		"ICS Faculdade de Medicina FAMED",
		// 		"ICS Faculdade de Nutrição FANUT",
		// 		"ICS Faculdade de Odontologia FODON",
		// 		"ICSA Faculdade de Administração FAAD",
		// 		"ICSA Faculdade de Arquivologia FARQ",
		// 		"ICSA Faculdade de Ciências Contábeis FACICON",
		// 		"ICSA Faculdade de Ciências Econômicas FACECON",
		// 		"ICSA Faculdade de Serviço Social FASS",
		// 		"ICSA Faculdade de Turismo FACTUR",
		// 		"IFCH Faculdade de Filosofia FAFIL",
		// 		"IFCH Faculdade de Ciências Sociais FACS",
		// 		"IFCH Faculdade de História FHIST",
		// 		"IFCH Faculdade de Psicologia FAPSI",
		// 		"IG Faculdade de Geologia FAGEO",
		// 		"IG Faculdade de Meteorologia FAMET",
		// 		"IG Faculdade de Oceanografia FAOC",
		// 		"IG Faculdade de Geofísica FAGEOF",
		// 		"ILC Faculdade de Comunicação FACOM",
		// 		"ILC Faculdade de Letras FALE",
		// 		"ILC Faculdade de Letras Estrangeiras Modernas FALEM",
		// 		"ITEC Faculdade de Arquitetura e Urbanismo FAU",
		// 		"ITEC Faculdade de Engenharia Civil FEC",
		// 		"ITEC Faculdade de Engenharia da Computação e Telecomunicações FCT",
		// 		"ITEC Faculdade de Engenharia de Alimentos FEA",
		// 		"ITEC Faculdade de Engenharia Elétrica FEE",
		// 		"ITEC Faculdade de Engenharia Mecânica FEM",
		// 		"ITEC Faculdade de Engenharia Naval FENAV",
		// 		"ITEC Faculdade de Engenharia Química FEQ",
		// 		"ITEC Faculdade de Engenharia Sanitária e Ambiental FAESA",
		// 		"ITEC Faculdade de Engenharia Ferroviária e Logística FEFLOG",
		// 		"CABAE Curso de Língua Portuguesa FACL",
		// 		"CABAE Curso de Língua Espanhola FACL",
		// 		"CABAE Curso de Matemática FCET",
		// 		"CABAE Curso de Física FCET",
		// 		"CABAE Curso de Engenharia Industrial FEI",
		// 		"CABAE Curso de Educação do Campo FADECAM",
		// 		"CABAE Curso de Pedagogia FAECS",
		// 		"CABAE Curso de Serviço Social FAECS",
		// 		"CALTA Faculdade de Ciências Biológicas FCBATM",
		// 		"CALTA Faculdade de Educação FAEDATM",
		// 		"CALTA Faculdade de Engenharia Agronômica FEAATM",
		// 		"CALTA Faculdade de Engenharia Florestal FEFATM",
		// 		"CALTA Faculdade de Etnodiversidade ETNO",
		// 		"CALTA Faculdade de Geografia  GEOATM",
		// 		"CALTA Faculdade de Letras - Língua Portuguesa LLPATM",
		// 		"CALTA Faculdade de Letras - Língua Inglesa LLIATM",
		// 		"CANAN Curso de Ciência e Tecnologia FCTANAN",
		// 		"CANAN Curso de Engenharia de Materiais FEMANAN",
		// 		"CANAN Curso de Geoprocessamento FAGEOANAN",
		// 		"CANAN Curso de História FHISTANAN",
		// 		"CANAN Curso de Geografia FGEOANAN",
		// 		"CANAN Curso de Química FQUIMANAN",
		// 		"CANAN Curso de Física FISICANAN",
		// 		"CBRAG Faculdade de Engenharia de Pesca FEPBRAG",
		// 		"CBRAG Faculdade de Ciências Biológicas FCBBRAG",
		// 		"CBRAG Faculdade de Ciências Naturais FCNBRAG",
		// 		"CBREV Faculdade de Educação FAEDBREV",
		// 		"CBREV Faculdade de Letras FALEBREV",
		// 		"CBREV Faculdade de Serviço Social FSSBREV",
		// 		"CBREV Faculdade de Ciências Naturais FCNBREV",
		// 		"CBREV Faculdade de Matemática FAMATBREV",
		// 		"CUNTI Curso de Agronomia FAGCAM",
		// 		"CUNTI Curso de Geografia FGEOCAM",
		// 		"CUNTI Curso de História FHISTCAM",
		// 		"CUNTI Curso de Letras - Língua Inglesa FLICAM",
		// 		"CUNTI Curso de Letras - Língua Portuguesa FLPCAM",
		// 		"CUNTI Curso de Matemática FAMATCAM",
		// 		"CUNTI Curso de Pedagogia FPECAM",
		// 		"CUNTI Curso de Sistemas de Informação FSICAM",
		// 		"CUNCA Curso de Ciências Contábeis FCCCAP",
		// 		"CUNCA Curso de Ciências Naturais FCNCAP",
		// 		"CUNCA Curso de História FHISTCAP",
		// 		"CUNCA Curso de Letras FAEDCAP",
		// 		"CUNCA Curso de Matemática FAMATCAP",
		// 		"CUNCA Curso de Pedagogia FPECAP",
		// 		"CCAST Faculdade de Sistemas de Informação FSICAST",
		// 		"CCAST Faculdade de Engenharia da Computação FECCAST",
		// 		"CCAST Faculdade de Língua Espanhola FLECAST",
		// 		"CCAST Faculdade de Língua Portuguesa FLPCAST",
		// 		"CCAST Faculdade de Medicina Veterinária FMVCAST",
		// 		"CCAST Faculdade de Pedagogia FPECAST",
		// 		"CCAST Faculdade de Matemática FAMATCAST",
		// 		"CCAST Faculdade de Letras FAEDCAST",
		// 		"CCAST Faculdade de Educação Física FEFCAST",
		// 		"CUSAL Curso de Licenciatura em Matemática FLMCAM",
		// 		"CUSAL Curso de Engenharia de Exploração e Produção de Petróleo FEEPPCAM",
		// 		"CSOUR Faculdade de Letras FAEDSOUR",
		// 		"CSOUR Faculdade de Ciências Biológicas FCBSOUR",
		// 		"CAMTU Faculdade de Engenharia Civil FECTUC",
		// 		"CAMTU Faculdade de Engenharia Elétrica FEETUC",
		// 		"CAMTU Faculdade de Engenharia Mecânica FEMTUC",
		// 		"CAMTU Faculdade de Engenharia da Computação FECTUC",
		// 		"CAMTU Faculdade de Engenharia Sanitária e Ambiental FAESATUC",
		// 		"CAMTU Faculdade de Engenharia de Pesca FEPTUC",
		// 		"CAMTU Faculdade de Engenharia Florestal FEFTUC",
		// 		"IEMCI Licenciatura Integrada em Educação em Ciências	Matemáticas e Linguagens LIECM",
		// 		"CBRAG Faculdade de Letras (Graduação em Língua Portuguesa) FLPBRAG",
		// 		"CBRAG Faculdade de Letras (Graduação em Língua Inglesa) FLIBRAG",
		// 		"CBRAG Faculdade de História FHISTBRAG",
		// 		"CBRAG Faculdade de Matemática FAMATBRAG",
		// 		"CBRAG Faculdade de Educação FAEDBRAG",
		// 		"IFCH Faculdade de Geografia e Cartografia FGC",
		// 		"INEAF Faculdade de Desenvolvimento Rural FDR",
		// 		"DMT Faculdade de Demonstração 1",
		// 		"DMT Faculdade de Demonstração 2",
		// 		"DMT Faculdade de Demonstração 3",
		// 		"ICA Programa de Pós-Graduação em Artes PPGARTES"	,
		// 		"ICB Programa de Pós-Graduação em Biotecnologia PPGBIOTEC"	,
		// 		"ICB Programa de Pós-Graduação em Genética e Biologia Molecular PPGBM"	,
		// 		"ICB Programa de Pós-Graduação em Neurociências e Biologia celular PPGNBC"	,
		// 		"ICB Programa de Pós-Graduação em Biologia de Agentes Infecciosos e Parasitários PPGBAIP"	,
		// 		"ICB Programa de Pós-Graduação em Ecologia Aquática e Pesca PPGEAP"	,
		// 		"ICB Programa de Pós-Graduação em Zoologia PPGZOOL"	,
		// 		"ICB Programa de Pós-Graduação em Ecologia PPGECO"	,
		// 		"ICB Programa de Pós-Graduação em Análises Clínicas MACPRO"	,
		// 		"ICB Programa de Pós-Graduação em Saúde	Sociedade e Ambiente PPGSSEA",
		// 		"ICED Programa de Pós-Graduação em Educação PPGED"	,
		// 		"ICEN Programa de Pós-Graduação em Matemática e Estatística PPGME"	,
		// 		"ICEN Programa de Pós-Graduação em Física PPGF"	,
		// 		"ICEN Programa de Pós-Graduação em Ciência da Computação PPGCC"	,
		// 		"ICEN Programa de Pós-Graduação em Química PPGQ"	,
		// 		"ICJ Programa de Pós-Graduação em Direito PPGD"	,
		// 		"ICS Programa de Pós-Graduação em Ciências Farmacêuticas PPGCF"	,
		// 		"ICS Programa de Pós-Graduação em Enfermagem PPGENF"	,
		// 		"ICS Programa de Pós-Graduação em Odontologia PPGO"	,
		// 		"ICS Programa de Pós-Graduação em Química Medicinal e Modelagem Molecular PPGQM3"	,
		// 		"ICSA Programa de Pós-Graduação em Economia PPGE"	,
		// 		"ICSA Programa de Pós-Graduação em Serviço Social PPGSS"	,
		// 		"ICSA Programa de Pós-Graduação em Ciência da Informação PPGCI"	,
		// 		"IFCH Programa de Pós-Graduação em Antropologia PPGA"	,
		// 		"IFCH Programa de Pós-Graduação em Ciência Política PPGCP"	,
		// 		"IFCH Programa de Pós-Graduação em Segurança Pública PPGSP"	,
		// 		"IFCH Programa de Pós-Graduação em Filosofia PPGF"	,
		// 		"IFCH Programa de Pós-Graduação em Geografia PPGG"	,
		// 		"IFCH Programa de Pós-Graduação em História PPGH"	,
		// 		"IFCH Programa de Pós-Graduação em Psicologia PPGP"	,
		// 		"IFCH Programa de Pós-Graduação em Sociologia e Antropologia PPGSA"	,
		// 		"IG Programa de Pós-Graduação em Ciências Ambientais PPGCA"	,
		// 		"IG Programa de Pós-Graduação em Geologia e Geoquímica PPGG"	,
		// 		"IG Programa de Pós-Graduação Geofísica CPGf"	,
		// 		"IG Programa de Pós-Graduação em Recursos Hídricos PPRH"	,
		// 		"ILC Programa de Pós-Graduação em Letras PPGL"	,
		// 		"ILC Programa de Pós-Graduação em Comunicação PPGCOM"	,
		// 		"ITEC Programa de Pós-Graduação em Arquitetura e Urbanismo PPGAU"	,
		// 		"ITEC Programa de Pós-Graduação em Ciência e Tecnologia de Alimentos PPGCTA"	,
		// 		"ITEC Programa de Pós-Graduação em Engenharia Civil PPGEC"	,
		// 		"ITEC Programa de Pós-Graduação em Engenharia de Processos PPGEP"	,
		// 		"ITEC Programa de Pós-Graduação em Engenharia Elétrica PPGEE"	,
		// 		"ITEC Programa de Pós-Graduação em Engenharia Industrial PPGEI"	,
		// 		"ITEC Programa de Pós-Graduação em Engenharia Mecânica PPGEM"	,
		// 		"ITEC Programa de Pós-Graduação em Engenharia Química PPGEQ"	,
		// 		"ITEC Programa de Pós-Graduação em Processos Construtivos e Saneamento Urbano PPCS"	,
		// 		"NAEA Programa de Pós-Graduação em Desenvolvimento Sustentável do Trópico Úmido PPGDSTU"	,
		// 		"NAEA Programa de Pós-Graduação em Gestão Pública PPGGP"	,
		// 		"NCADR Programa de Pós-Graduação em Ciência Animal PPGCAN"	,
		// 		"NCADR Programa de Pós-Graduação em Agriculturas Amazônicas PPGAA"	,
		// 		"NDAE Programa de Pós-Graduação em Computação Aplicada PPCA"	,
		// 		"NDAE Programa de Pós-Graduação em Engenharia de Barragem e Gestão Ambiental PEBGA"	,
		// 		"NDAE Programa de Pós-Graduação em Engenharia de Infraestrutura e Desenvolvimento Energético PPGINDE"	,
		// 		"NMT Programa de Pós-Graduação em Doenças Tropicais PPGDT"	,
		// 		"NMT Programa de Pós-Graduação em Saúde na Amazônia PPGSA"	,
		// 		"NUMA Programa de Pós-Graduação em Gestão de Recursos Naturais e Desenvolvimento Local na Amazônia PPGEDAM"	,
		// 		"CANAN Mestrado Profissional em Ensino de História PROFHISTORIA"	,
		// 		"CBRAG Programa de Pós-Graduação em Biologia Ambiental PPGBA"	,
		// 		"CUNTI Programa de Pós-Graduação em Educação e Cultura PPGEDUC"	,
		// 		"CCAST Programa de Pós-Graduação em Saúde Animal na Amazônia PPGSAAM"	,
		// 		"CCAST Programa de Pós-Graduação em Ciência Animal PPGCAN"	,
		// 		"IEMCI Programa de Pós-Graduação em Docência em Educação em Ciências e Matemáticas PPGDOC"	,
		// 		"IEMCI Programa de Pós-Graduação em Educação em Ciências e Matemáticas PPGECM"	,
		// 		"ICED Programa de Pós-Graduação em Currículo e Gestão da Escola Básica PPGEB"	,
		// 		"IG Programa de Pós-Graduação em Rede Nacional para o Ensino das Ciências Ambientais PROFCIAMB"	,
		// 		"CBRAG Programa de Mestrado Interdisciplinar em Linguagens e Saberes na Amazônia PPLSA"	,
		// 		"CBRAG Programa de Mestrado Profissional em Ensino da Matemática PROFMAT"	,
		// 		"ILC Mestrado Profissional em Letras em Rede Nacional PROFLETRAS"	,
		// 		"CAMTU Programa de Pós-Graduação em Engenharia de Barragem e Gestão Ambiental PEBGA"	,
		// 		"NDAE Mestrado Profissional em Computação Aplicada PPCA"	,
		// 		"IG Programa de Pós-Graduação em Gestão de Risco e Desastre na Amazônia PPGGRD"	,
		// 		"CALTA Programa de Pós-Graduação em Biodiversidade e Conservação PPGBC"	,
		// 		"ICS Programa de Pós-Graduação em Saúde	Ambiente e Sociedade na Amazônia PPGSAS",
		// 		"ITEC Programa de Pós-Graduação em Engenharia Naval PPGENAV"	,
		// 		"ICEN Programa de Pós-Graduação em Ciências e Meio Ambiente PPGCMA"	,
		// 		"NEB Programa de Pós-Graduação em Currículo e Gestão da Escola Básica PPEB"	,
		// 		"ICEN Programa de Pós-Graduação em Matemática em Rede Nacional PROFMAT"	,
		// 		"CCAST Programa de Pós-Graduação em Matemática em Rede Nacional PROFMAT"	,
		// 		"CCAST Programa de Pós-Graduação em Estudos Antrópicos na Amazônia PPGEAA"	,
		// 		"NTPC Programa de Pós-Graduação em Teoria e Pesquisa do Comportamento PPGTPC"	,
		// 		"NTPC Programa de Pós-Graduação em Neurociências e Comportamento PPGNC"	,
		// 		"NPO Programa de Pós-Graduação em Oncologia e Ciências Médicas PPGOCM"	,
		// 		"INEAF Programa de Pós-Graduação em Agriculturas Amazônicas PPGAA"	,
		// 		"DMT Programa de Demonstração 1",
		// 		"DMT Programa de Demonstração 2",
		// 		"DMT Programa de Demonstração 3",
		// 		"CABAE Programa de Pós-Graduação em Matemática em Rede Nacional PROFMAT"	,
		// 		"CABAE Programa de Pós-Graduação em Cidades	Territórios e Identidades PPGCITI",
		// 		"NITAE Programa de Pós-Graduação Criatividade e Inovação em Metodologias de Ensino Superior PPGCIMES"
	  //   ];
	  //   $( "#curso" ).autocomplete({
	  //     source: availableTags
	  //   });
	  // } );
	  </script>
