<?php
	require ('conexao.php');
	

	$user= $_POST ['login'];
	$senha1= $_POST ['password'];
	$senha = md5($senha1);
	
	$sql="select * from login where login_user='$user' and senha_user='$senha'";
	
	
	$cons= mysql_query ($sql,$db);
	
	session_start();	
	if(mysql_num_rows($cons)> 0) {
		$linha = mysql_fetch_array ($cons);
		if($linha['ativo']=='sim'){
			$_SESSION["logado"] = true;
			$_SESSION["usuario"] = utf8_encode($linha['nome']);
			$_SESSION["privilegio"] = $linha['privilegio'];
			$_SESSION["id"] = $linha['id_login'];
			header ('Location: paginas/gerar_mensalidade.php');
		}else{
			$_SESSION["logado"] = false;
			echo '<script>alert("Este usuário está inativo! \nPor favor, procure o administrador do sistema!");location.href="paginas/logout.php";</script>';
		}
	}else{
		$_SESSION["logado"] = false;
	}
	
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css">
  <!-- icone na barra de titulo -->
  <link rel="shortcut icon" href="paginas/img/logo.ico" height="16px" width="16px"> 
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!-- setar foco no campo usuario -->
<script>
function foco(){
	var obj = document.getElementById("usuario");
	obj.focus();
}
</script>
<!-- setar foco no campo usuario -->
</head>
<body onload="foco();">
	
  <form method="POST" action="verifica_login.php" class="login">
	<div id="incorreto">Usuário e/ou senha incorretos!</div>
	<p>
      <label for="login">Usuário:</label>
      <input type="text" name="login" id="usuario" value="" placeholder="Username" required="true" >
    </p>

    <p>
      <label for="Password">Senha:</label>
      <input type="password" name="password" id="senha"  required="true" placeholder="Password" required="true">
    </p>

    <p class="login-submit">
      <button type="submit" class="login-button">Entrar</button>
    </p>
   
  </form>
<span id="titulo">Laboratório do Exercício Físico - Campus Januária</span>
<div class="figura" align="center">
  <p><img class="escala" src="img/LOGO UNIMONTES.png"
    alt="St. Tropez"></div>
  </body>
</html>
