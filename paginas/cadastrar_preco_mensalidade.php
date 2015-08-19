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
	$horario = utf8_decode($_POST['horario']);
	$valor = utf8_decode($_POST['valor']);
	$desconto = utf8_decode($_POST['desconto']);
	$categoria = utf8_decode($_POST['categoria']);
	$funcionario = utf8_decode($_POST['funcionario']);
	//Fim Recebendo valores do post
	
	if($acao=="cadastrar"){
		//Preparar consulta para inserir
		$sql = "INSERT INTO `preco_mensalidade`(`horario`, `valor`, `desconto`, `categoria_fk`, `funcionario`, `data_cadastro`) VALUES ($horario,'$valor','$desconto',$categoria,'$funcionario',now());";
		//Fim Preparar consulta para inserir
	}else{
		//Preparar consulta para Atualizar
		$id = $_POST['id'];
		$sql = "UPDATE `preco_mensalidade` SET `horario`=$horario,`valor`='$valor',`desconto`='$desconto',`categoria_fk`=$categoria,`funcionario`='$funcionario',`data_cadastro`=now() WHERE `id_preco_mensalidade` = $id";
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