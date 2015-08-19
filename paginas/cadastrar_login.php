<?php 
	session_start();
	if( $_SESSION["logado"] == true ):

	date_default_timezone_set('America/Sao_Paulo');
	require"../conexao.php";
	require"cabecalho.php";
	
	//Recebendo valores do post
	$nome = utf8_decode($_POST['nome']);
	$usuario = utf8_decode($_POST['usuario']);
	$senha1 = utf8_decode($_POST['senha1']);
	$tipo = utf8_decode($_POST['tipo']);
	$senha = md5($senha1);
	//Fim Recebendo valores do post

	//Preparar consulta para inserir
	$sql_inserir = "INSERT INTO `login`(`login_user`, `senha_user`, `nome`, `privilegio`) VALUES('$usuario', '$senha', '$nome', '$tipo');";
	//Fim Preparar consulta para inserir
	$sql = "select count(login_user) from login where login_user = '$usuario';";
	$consulta = mysql_query($sql,$db);
	$res = mysql_fetch_array($consulta);
	
	if($res['count(login_user)']<=0){	
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
			echo '<a href="listar_login.php"><button class="btn btn-success">Ok!</button></a>';
		}else{
			echo '<div class="box-content alerts">
				<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Erro ao realizar cadastro!<br/>Consulte o administrador do sistema.
					</div>
			  </div>';
			  echo '<a href="cad_login.php"><button class="btn btn-success">Ok!</button></a>';
		}
	}else{
		echo '<div class="box-content alerts">
				<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Erro ao realizar cadastro!<br/>Login já cadastrado.
					</div>
			  </div>';
			  echo '<a href="cad_login.php"><button class="btn btn-success">Ok!</button></a>';
	}	

	
endif;
require ('rodape.php');
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}	
?>