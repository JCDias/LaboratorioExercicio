<?php 
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
	$tipo = utf8_decode($_POST['tipo']);
	$valor = utf8_decode($_POST['valor']);
	$funcionario = utf8_decode($_POST['funcionario']);
	//Fim Recebendo valores do post
	
	//Preparar consulta para inserir
	$sql = "INSERT INTO `caixa`(`usuario_fk`, `nome_usuario`, `tipo`, `data_recebimento`, `funcionario`,`valor_recebido`) VALUES ($usuario_fk,'$nome','$tipo',now(),'$funcionario','$valor');";
	//Fim Preparar consulta para inserir
	
	$confirmar = mysql_query($sql, $db);
	
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