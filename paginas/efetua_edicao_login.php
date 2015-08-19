<?php 
	session_start();
	if( $_SESSION["logado"] == true ):

	date_default_timezone_set('America/Sao_Paulo');
	require"../conexao.php";
	require"cabecalho.php";

	$id = $_POST["id"];
	$nome = utf8_decode($_POST['nome']);
	$senha1 = utf8_decode($_POST['senha1']);
	$usuario = utf8_decode($_POST['usuario']);
	$senha = md5($senha1);
	
	/*$consulta = mysql_query("select login_user from login where login_user = '$usuario'", $db);
	$res = mysql_fetch_array($consulta);
	echo $res['login_user'];
	if(mysql_num_rows($res)<=0){*/
		if($senha1==""){
			$confirmar = mysql_query("UPDATE `login` SET `nome`= '$nome', `login_user`='$usuario' WHERE `id_login`=$id;", $db);
		}else{
			$confirmar = mysql_query("UPDATE `login` SET `nome`= '$nome', `login_user`='$usuario', `senha_user` = '$senha' WHERE `id_login`=$id;", $db);
		}
	//}
	
	if($confirmar == 1){
	echo '<div class="box-content alerts">
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				Alteração realizada com sucesso!
			</div>
		  </div>';
		if($_SESSION["id"] == $id){
			$_SESSION["usuario"] = utf8_encode($nome);
		}
	echo '<a href="principal.php"><button class="btn btn-success">Ok!</button></a>';
	}else{
		echo '<div class="box-content alerts">
			<div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Erro ao realizar alteração!<br/>Consulte o administrador do sistema.
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