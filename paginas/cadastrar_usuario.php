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
	// Diferença entre datas
		$data_atual = date('Y-m-d');
		$data1 = new DateTime( $data_atual);
		$data2 = new DateTime( $data_nasc );

		$intervalo = $data1->diff( $data2 );
		$idade = $intervalo->y;
	//Fim Recebendo a data de nascimento e invertento para formato mm/dd/yyyy
	
	$sexo = utf8_decode($_POST['sexo']);
	$rua = utf8_decode($_POST['rua']);
	$numero = utf8_decode($_POST['numero']);
	
	//Tratando complemento vazio
	$complemento = utf8_decode($_POST['complemento']);
	if($complemento==""){
		$complemento='-';
	}
	//fim Tratando complemento vazio
	
	$bairro = utf8_decode($_POST['bairro']);
	$cidade = utf8_decode($_POST['cidade']);
	
	//Tratando telefone vazio
	$telefone = utf8_decode($_POST['telefone']);
	if($telefone==""){
		$telefone='-';
	}
	//Fim Tratando telefone vazio
	
	$celular = utf8_decode($_POST['celular']);
	
	//Tratando outro_telefone vazio
	$outro_telefone = utf8_decode($_POST['outro_telefone']);
	if($outro_telefone==""){
		$outro_telefone='-';
	}
	//Fim Tratando outro_telefone vazio
	
	//Tratando email vazio
	$email = utf8_decode($_POST['email']);
	if($email==""){
		$email='';
	}
	//Fim Tratando email vazio
	
	$categoria = utf8_decode($_POST['categoria']);
	$tipo = utf8_decode($_POST['tipo']);
	$horario = utf8_decode($_POST['horario']);
	$dia_venc = utf8_decode($_POST['dia']);
	$funcionario = utf8_decode($_POST['funcionario']);
	$data_cad = utf8_decode($_POST['data_cad']);
	//Fim Recebendo valores do post

	//Preparar consulta para inserir
	$sql_inserir = "INSERT INTO `usuarios`(`nome`, `cpf`, `rg`, `data_nasc`, `sexo`, `rua`, `numero`, `complemento`, `bairro`, `cidade`, `telefone`, `celular`, `outro_telefone`, `email`, `tipo`, `dia_vencimento`, `horario`, `data_cadastro`, `funcionario`, `categoria_fk`) VALUES('$nome', '$cpf', '$rg', '$data_nasc', '$sexo', '$rua', '$numero', '$complemento', '$bairro', '$cidade', '$telefone', '$celular', '$outro_telefone', '$email', '$tipo', '$dia_venc',  '$horario', '$data_cad','$funcionario', '$categoria');";
	//Fim Preparar consulta para inserir
	$sql = "select count(cpf) from usuarios where cpf = '$cpf';";
	$consulta = mysql_query($sql,$db);
	$res = mysql_fetch_array($consulta);
	
	if($res['count(cpf)']<=0){	
		//Inserir usuário
		$confirmar = mysql_query($sql_inserir, $db);
		//Selecionar usuário inserido
		$selecionar = mysql_query("select * from usuarios where cpf = '$cpf' order by nome DESC", $db);
		$linha = mysql_fetch_array($selecionar);
		$id = $linha['id_usuario'];
		//Mensagem de sucesso ou erro
		if($confirmar == 1){
			if($idade<=17){
				echo '<script>alert("O usuário(a) '.utf8_encode($nome).' é menor de idade!\nÉ necessário cadastrar um responsável");location.href="cad_responsavel.php?id='.$id.'&nome='.$nome.'";</script>';
			}else{
			echo '<div class="box-content alerts">
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Cadastro realizado com sucesso!
					</div>
				  </div>';
			echo '<a href="principal.php"><button class="btn btn-success">Ok!</button></a>';
			}
		}else{
			echo '<div class="box-content alerts">
				<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Erro ao realizar cadastro!<br/>Consulte o administrador do sistema.
					</div>
			  </div>';
			  echo '<a href="cad_usuario.php"><button class="btn btn-success">Ok!</button></a>';
		}
	}else{
		echo '<div class="box-content alerts">
				<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Erro ao realizar cadastro!<br/>CPF já cadastrado.
					</div>
			  </div>';
			  echo '<a href="cad_usuario.php"><button class="btn btn-success">Ok!</button></a>';
	}	

	
endif;
require ('rodape.php');
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}	
?>