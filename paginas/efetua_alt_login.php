<?php
date_default_timezone_set('America/Sao_Paulo');
require"../conexao.php";

$id = $_GET["id"];

$consulta = mysql_query("select * from login where id_login=$id;", $db);
$res = mysql_fetch_array($consulta);

if($res['ativo'] == "sim"){
	$auto = "nao";
}else{
	$auto = "sim";
}

$confirmar = mysql_query("UPDATE `login` SET `ativo`= '$auto' WHERE `id_login`=$id;", $db);

if($confirmar == 1){
	echo '<script>alert("Alteração realizada com sucesso!");location.href="listar_login.php";</script>';
}else{
	echo '<script>alert("Alteração não efetuada!");location.href="listar_login.php";</script>';
}