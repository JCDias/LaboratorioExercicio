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
  <link rel="shortcut icon" href="css-admin/logo.ico" height="16px" width="16px"> 
  <!-- icone na barra de titulo -->
  <link rel="shortcut icon" href="paginas/img/logo.ico" height="16px" width="16px"> 
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <script language="javascript">
	document.getElementById("somefield").required = true;
</script>
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
    <p>
      <label for="login">Usuário:</label>
      <input type="text" name="login" id="usuario" value="" required="true" placeholder="Username">
    </p>

    <p>
      <label for="Password">Senha:</label>
      <input type="password" name="password" id="senha"  required="true" placeholder="Password">
    </p>

    <p class="login-submit">
      <button type="submit" class="login-button">Entrar</button>
    </p>

  </form>
<span id="titulo">Laboratório do Exercício Físico - Campus Januária</span>
<div class="figura" align="center">
  <p><img class="escala" src="img/LOGO UNIMONTES.png"
    ></div>
<!--<div class="logo"><img src="img/LOGO UNIMONTES.png" height="600" width="1200" align="center"/></div>-->
  </body>
</html>
<?php 
	$_SESSION["logado"] = false;
?>