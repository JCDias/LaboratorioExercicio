<?php 
	session_start();
	if( $_SESSION["logado"] == true ):

	date_default_timezone_set('America/Sao_Paulo');
	require"../conexao.php";
	require"cabecalho.php";
	
	//Recebendo valores do post
	$nome = utf8_decode($_POST['nome']);
	$valor = utf8_decode($_POST['valor']);
	$id = utf8_decode($_POST['id_usuario']);
	$tipo = utf8_decode($_POST['tipo']);
	$funcionario = utf8_decode($_POST['funcionario']);
	//Fim Recebendo valores do post

	//Preparar consulta para inserir
	$sql_inserir = "INSERT INTO `caixa`(`usuario_fk`, `nome_usuario`, `tipo`, `data_recebimento`, `funcionario`,`valor_recebido`) VALUES ($id,'$nome','$tipo',now(),'$funcionario','$valor');";
	//Fim Preparar consulta para inserir
	

	//Inserir na tabela caixa
	$confirmar = mysql_query($sql_inserir, $db);
	
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