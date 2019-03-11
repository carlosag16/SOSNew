<?php

	require '../../../bootstrap.php';
	require '../../../app/functions/bdq.php';

	session_start();

	$email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_STRING);

	$result_usuario = "SELECT * FROM ser_servidores WHERE ser_email= '$email' LIMIT 1; ";

	$resultado_usuario = DBExecute($result_usuario);
	
	//Econtrado usuario com esse e-mail

	if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
		$row_usuario = mysqli_fetch_assoc($resultado_usuario);
		$userName = filter_input(INPUT_POST, 'userName', FILTER_SANITIZE_STRING);
		$_SESSION['id'] = $row_usuario['id'];
		$_SESSION['nome'] = $row_usuario['nome'];
		return header("location:".CAM_ADMIN);
	}else {
		//Nenhum usuário encontrado
		$resultado = 'erro';
		echo(json_encode($resultado));
	}

?>