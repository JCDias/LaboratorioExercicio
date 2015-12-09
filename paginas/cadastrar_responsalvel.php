<?php 
	session_start();
	if( $_SESSION["logado"] == true ):

	date_default_timezone_set('America/Sao_Paulo');
	require"../conexao.php";
	require"cabecalho.php";
	
	//Recebendo valores do post
	$nome = utf8_decode($_POST['nome']);
	$cpf = utf8_decode($_POST['cpf']);
	$rg = utf8_decode($_POST['rg']);
	//Recebendo a data de nascimento e invertento para formato mm/dd/yyyy
	$data = utf8_decode($_POST['data_nasc']);
	$d=explode("/",$data);
	$data_nasc=$d[2]."-".$d[1]."-".$d[0];
	//Fim Recebendo a data de nascimento e invertento para formato mm/dd/yyyy
	
	//Tratando telefone vazio
	$telefone = utf8_decode($_POST['telefone']);
	if($telefone==""){
		$telefone='-';
	}
	//Fim Tratando telefone vazio
	
	$celular = utf8_decode($_POST['celular']);
	$usuario = utf8_decode($_POST['usuario']);
	$grau = utf8_decode($_POST['grau']);
	$outro = utf8_decode($_POST['outro']);
	if($grau == 'Outro'){
		$grau = $outro;
	}
	$funcionario = utf8_decode($_POST['funcionario']);
	$data_cad = utf8_decode($_POST['data_cad']);
	//Fim Recebendo valores do post

	//Preparar consulta para inserir
	$sql_inserir = "INSERT INTO `responsavel`(`nome_responsavel`, `cpf`, `rg`, `data_nasc`, `usuario_fk`, `parentesco`, `telefone`, `celular`, `data_cadastro`, `funcionario`) VALUES ('$nome','$cpf','$rg','$data_nasc',$usuario,'$grau','$telefone','$celular','$data_cad','$funcionario');";
	//Fim Preparar consulta para inserir
	
	if($cpf !=''){
		$sql = "select count(cpf) from usuarios where cpf = '$cpf';";
		$consulta = mysql_query($sql,$db);
		$res = mysql_fetch_array($consulta);
	}else{
		$res['count(cpf)'] = 0;
	}
	
	if($res['count(cpf)']<=0){	
		//Inserir usuário
		$confirmar = mysql_query($sql_inserir, $db);
		//Mensagem de sucesso ou erro
		if($confirmar == 1){
			echo '<div class="box-content alerts">
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Cadastro realizado com sucesso!
					</div>
				  </div>';
			echo '<a href="principal.php"><button class="btn btn-success">Ok!</button></a>';
		}else{
			echo '<div class="box-content alerts">
				<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Erro ao realizar cadastro!<br/>Consulte o administrador do sistema.
					</div>
			  </div>';
			  echo '<a href="principal.php"><button class="btn btn-success">Ok!</button></a>';
		}
	}else{
		echo '<div class="box-content alerts">
				<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Erro ao realizar cadastro!<br/>CPF já cadastrado.
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