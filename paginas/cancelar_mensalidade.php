<?php 
	session_start();
	if( $_SESSION["logado"] == true ):

	date_default_timezone_set('America/Sao_Paulo');
	require"../conexao.php";
	require"cabecalho.php";
	
	$id = $_GET['id'];
	$funcionario = $_SESSION['usuario'];
	
	$sql = "UPDATE `mensalidade` SET `funcionario`='$funcionario',`status_pagamento`='cancelada', `data_pagamento`=now() WHERE id_mensalidade = $id";
	
	$confirmar = mysql_query($sql,$db);
	
	//Mensagem de sucesso ou erro
	if($confirmar == 1){
		echo '<div class="box-content alerts">
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Cancelamento realizado com sucesso!
				</div>
			  </div>';
		echo '<a href="mensalidades_em_aberto.php"><button class="btn btn-success">Ok!</button></a>';
	}else{
		echo '<div class="box-content alerts">
			<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Erro ao realizar cancelamento!<br/>Consulte o administrador do sistema.
				</div>
		  </div>';
		  echo '<a href="mensalidades_em_aberto.php"><button class="btn btn-success">Ok!</button></a>';
	}
	
endif;
require ('rodape.php');
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}	
?>