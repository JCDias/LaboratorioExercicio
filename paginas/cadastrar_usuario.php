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
	if($celular==""){
		$celular='-';
	}
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
		//Selecionar usuário inserido
		$selecionar = mysql_query("select * from usuarios where nome = '$nome' and categoria_fk = $categoria and cpf = '$cpf'  order by nome DESC", $db);
		$linha = mysql_fetch_array($selecionar);
		$id = $linha['id_usuario'];
		//Mensagem de sucesso ou erro
		if($confirmar == 1){
			if($tipo == 'Mensalista'){//verifica se é mensalista
			#########################################################################################
			$sql_usuario = "select u.id_usuario, u.horario, u.dia_vencimento, u.categoria_fk, u.nome, p.valor, p.desconto from usuarios u join preco_mensalidade p on u.categoria_fk = p.categoria_fk and u.horario = p.horario where u.tipo = 'Mensalista' and u.id_usuario = $id;";
			$query_usuario = mysql_query($sql_usuario,$db);
			$usuario = mysql_fetch_array($query_usuario);
			//Gerar Mensalidade ao cadastrar
			switch (date('m')) 
			{
				case '01':
				case '03':
				case '05':
				case '07':
				case '08':
				case '10':
				case '12':
					if  ($usuario['dia_vencimento'] <= 31) 
					{
						// Montando a data de vencimento do mês atual
						$data_vencimento = date('Y-m').'-'.$usuario['dia_vencimento'];
						// Fim Montando a data de vencimento do mês atual
					}
					break;
				
				case '04':		
				case '06':
				case '09':
				case '11':
					if  ($usuario['dia_vencimento'] == 31) 
					{
						// Montando a data de vencimento do mês atual
						$data_vencimento = date('Y-m').'-'.($usuario['dia_vencimento']-1);
						// Fim Montando a data de vencimento do mês atual
					}else{
						// Montando a data de vencimento do mês atual
						$data_vencimento = date('Y-m').'-'.$usuario['dia_vencimento'];
						// Fim Montando a data de vencimento do mês atual
					}
					break;
				case '02':
					if  ($usuario['dia_vencimento'] == 31) 
					{
						// Montando a data de vencimento do mês atual
						$data_vencimento = date('Y-m').'-'.($usuario['dia_vencimento']-3);
						// Fim Montando a data de vencimento do mês atual
					}elseif($usuario['dia_vencimento'] == 30){
						// Montando a data de vencimento do mês atual
						$data_vencimento = date('Y-m').'-'.($usuario['dia_vencimento']-2);
						// Fim Montando a data de vencimento do mês atual
					}else{
						// Montando a data de vencimento do mês atual
						$data_vencimento = date('Y-m').'-'.$usuario['dia_vencimento'];
						// Fim Montando a data de vencimento do mês atual
					}	
					break;						
			}
			//Fim verificação dos meses
						
			//Setando as variáveis
			$id_mens = $usuario['id_usuario'];
			$nome = $usuario['nome'];
			$categoria = $usuario['categoria_fk'];
			$horario = $usuario['horario'];
			$valor = $usuario['valor'];
			$desconto = $usuario['desconto'];
			//Fim Setando as variáveis
						
			//Montar instrução sql para inserir na tabela mensalidade;
			$sql_mensalidade = "INSERT INTO `mensalidade`(`usuario_fk`,`nome_usuario_fk`,`data_vencimento`,`categoria_fk`,`horario_usuario`,`valor_a_receber`,`desconto_a_receber`) VALUES ($id_mens,'$nome','$data_vencimento',$categoria,$horario,$valor,$desconto)";
			
			$query_mensalidade = mysql_query($sql_mensalidade,$db);
			
			if($query_mensalidade == 1){
			//Mostrando Mensalidade gerada
			echo '<div class="box-content alerts">
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Menslidade gerada com sucesso!
					</div>
				  </div>';
			#########################################################################################
			}
			}// fim verifica se é mensalista
			if($idade<=17){
				echo '<script>alert("O usuário(a) '.utf8_encode($nome).' é menor de idade!\nÉ necessário cadastrar um responsável");location.href="cad_responsavel.php?id='.$id.'&nome='.utf8_encode($nome).'";</script>';
			}else{
			echo '<div class="box-content alerts">
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						Cadastro realizado com sucesso!
					</div>
				  </div>';
			echo '<a href="consultar_usuarios.php"><button class="btn btn-success">Ok!</button></a>';
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