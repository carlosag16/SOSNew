<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema de Agendamento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" type="text/css" media="screen" href="estilo.css" />
	 
	
	
	
	
</head>
<body>
    <?php
    require 'conexao.php';
    ?>
    

    <form name="ficha" method="post" action="index.php" target="_blank">
        <fildset>

           <fildset class= "campo campo2">
            <legend>Dados Pessoais</legend>
            <label>Matricula<span>*</span>:</label>
            <input type="text" name="matricula" required="required" placeholder="(Ex.: 201506844)">
            <br>
            <label>Nome<span>*</span>:</label>
            <input type="text" name="nome" required="required" placeholder="(Ex.: Diego Barros)">
            <br>
            <label>E-mail<span>*</span>:</label>
            <input type="text" name="email" required="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="(EX.: diegobarrosbc@ufpa.br)">
            <br>
            <label>Telefone:</label>
            <input type ="text" name="telefone" required="required">
            <br>
            <label>Curso/Programa<span>*</span>:</label>
            <select name="curso" id="curso" class="curso">
            <option selected="selected" value="selecione">- Selecione -</option>
					<?php include("selecionar-curso.php"); ?>
            </select>
            <br>
         
          <label>Agendamento<span>*</span>:</label>
            <input type ="date" name="calendario" required="required">
			<span class="validity"></span>
            <br>
<form action="#" class="ws-validate">
           </fildset>
           <input class="botao" type="submit" value="cadastrar" onClick="return validar()">
    </fildset>
    </form>
    
    
    
</body>
</html>