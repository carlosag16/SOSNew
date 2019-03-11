//esse script se refere a mensagem de alerta da SENHA do servidor
$( function () {
	$( "#senha1" ).keyup(function () {
		$("#password_box1").show();
		var senha1 = $( "#senha1" ).val();
		if(senha1.length<6 && senha1.length>0) {
			$( "#password_box1" ).html("A senha é muito curta");
			$( "#password_box1" ).css("color","#c67373");
			$( "#password_box1" ).css("margin-right","0%");
			$( "#password_box1" ).css("margin-top","1%");
		}else{
			$( "#password_box1" ).hide();
		}
	});
});
$(function () {
	$( "#senha2" ).keyup( function () {
		$("#password_box2").show();
		var senha1 = $( "#senha1" ).val();
		var senha2 = $( "#senha2" ).val();
		if(senha1 !== senha2) {
			$( "#password_box2" ).html("A senha não confere");
			$( "#password_box2" ).css("color","#c67373");
			$( "#password_box2" ).css("margin-top","1%");
			$( "#password_box2" ).css("margin-right","3%");
			$( "#senha2" ).blur(function(){
				$("#password_box2").show();
			});
		}else if (senha1!=''){
			$("#password_box2").show();
			$( "#password_box2" ).html("A senha confere");
			$( "#password_box2" ).css("color","#58b558");
			$( "#password_box2" ).css("margin-top","1%");
			$( "#password_box2" ).css("margin-right","3%");
			$( "#senha2" ).blur(function(){
				$("#password_box2").hide();
			});
		}
		else{
			$( "#senha2" ).blur(function(){
				$("#password_box2").hide();
			});
		}
	});
});
$(document).ready(function(){
	//esse script se refe as opções de foto do servidor
	$(function(){
		//deixar as opções escondidas
		$("#file").css("display","none");
		$("#load-pic").css("display","none");
		$("#opt-pic").css("display","none");
	})
	$(function() {
		//mostrar opções ao clicar na imagem de perfil
		$("#profile-pic").click(function() {
			$("#opt-pic").slideToggle();
		});
	});
	$(function(){
		//oculta o form de enviar arquivo do HTML
		// e transfere sua função para a classe send-pic
		function executar(){
			$('#file').trigger('click');
			$("#load-pic").css("display","");
		}
		$(".send-pic").click(function(){
			executar();
			// var pic = $("#file").val();
		});
		$("#file").change(function(){
			// para mostrar o nome do arquivo selecionado
			var pic = $("#file").val();
			if(pic!=''){
				$("#trocar-imagem").text(pic);
			}else{
				$("#trocar-imagem").text("Nenhuma imagem selecionada");
			}
		});
	});
});
