﻿<?php 
	session_start();
	if( $_SESSION["logado"] == true ):

	date_default_timezone_set('America/Sao_Paulo');
	require"../conexao.php";
	require"cabecalho.php";
	
	//Definindo variavel para executar consulta
	$sql = '';
	//Definindo variavel para executar consulta
	
	//Recebendo valores do post
	$usuario_fk = utf8_decode($_POST['usuario_fk']);
	$nome = utf8_decode($_POST['nome']);
	$tipo = utf8_decode($_POST['tipo_lancamento']);
	$valor = utf8_decode($_POST['valor']);
	$funcionario = utf8_decode($_POST['funcionario']);
	//Fim Recebendo valores do post
	
	//Preparar consulta para inserir
	$sql = "INSERT INTO `caixa`(`usuario_fk`, `nome_usuario`, `tipo`, `data_recebimento`, `funcionario`,`valor_recebido`) VALUES ($usuario_fk,'$nome','$tipo',now(),'$funcionario','$valor');";
	//Fim Preparar consulta para inserir
	
	// Inserir na tabela mensalidade a primeira mensalidade
	if($tipo=='Mensalidade'){
		$usu = mysql_fetch_array(mysql_query("select * from usuarios where id_usuario = $usuario_fk",$db));
		//Verificar desconto
		if($valor == '37.50'){
			$desc = '25.00';
		}else{
			$desc = '0.00';
		}
		//Fim Verificar desconto
		$categoria = $usu['categoria_fk'];
		$horario = $usu['horario'];
		$insert_mens = "INSERT INTO `mensalidade`(`usuario_fk`, `nome_usuario_fk`, `data_vencimento`, `categoria_fk`, `horario_usuario`, `valor_a_receber`, `desconto_a_receber`, `valor_recebido`, `data_pagamento`, `funcionario`, `status_pagamento`) VALUES ($usuario_fk,'$nome', now(),$categoria,$horario,'$valor','$desc','$valor',now(),'$funcionario','pago')";
		
		$mens = mysql_query($insert_mens,$db);
		
		if($mens == 1){
			$confirmar = mysql_query($sql, $db);
		}else{
			$confirmar = 0;
		}
	}else{
		$confirmar = mysql_query($sql, $db);
	}
	// Fim Inserir na tabela mensalidade a primeira mensalidade
	
	
	
	//Mensagem de sucesso ou erro
	if($confirmar == 1){
		echo '<div class="box-content alerts">
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Lançamento realizado com sucesso!
				</div>
			  </div>';
		echo '<a href="principal.php"><button class="btn btn-success">Ok!</button></a>';
	}else{
		echo '<div class="box-content alerts">
			<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Erro ao realizar lançamento!<br/>Consulte o administrador do sistema.
				</div>
		  </div>';
		  echo '<a href="principal.php"><button class="btn btn-success">Ok!</button></a>';
	}
	
endif;
require ('rodape.php');
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}	
?>