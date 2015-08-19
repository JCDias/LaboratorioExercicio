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
	$acao = utf8_decode($_POST['acao']);
	$valor = utf8_decode($_POST['valor']);
	//Fim Recebendo valores do post
	
	if($acao=="cadastrar"){
		//Preparar consulta para inserir
		$sql = "INSERT INTO `preco_diaria`(`valor`) VALUES ('$valor');";
		//Fim Preparar consulta para inserir
	}else{
		//Preparar consulta para Atualizar
		$id = $_POST['id'];
		$sql = "UPDATE `preco_diaria` SET `valor`='$valor' WHERE `id_preco_diaria` = $id";
		//Fim Preparar consulta para Atualizar
	}
	
	$confirmar = mysql_query($sql, $db);
	
	//Mensagem de sucesso ou erro
	if($confirmar == 1){
		echo '<div class="box-content alerts">
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Cadastro realizado com sucesso!
				</div>
			  </div>';
		echo '<a href="precos.php"><button class="btn btn-success">Ok!</button></a>';
	}else{
		echo '<div class="box-content alerts">
			<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					Erro ao realizar cadastro!<br/>Consulte o administrador do sistema.
				</div>
		  </div>';
		  echo '<a href="precos.php"><button class="btn btn-success">Ok!</button></a>';
	}
	
endif;
require ('rodape.php');
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}	
?>