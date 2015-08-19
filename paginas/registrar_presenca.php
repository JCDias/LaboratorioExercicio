<?php
date_default_timezone_set('America/Sao_Paulo');
require"../conexao.php";

$id = $_GET["id"];
$funcionario = $_GET["func"];

$confirmar = mysql_query("insert into frequencia(data_presenca, usuario_fk, funcionario) values (now(),$id,'$funcionario');", $db);

if($confirmar == 1){
	echo '<script>alert("Presença registrada com sucesso!");location.href="registrar_frequencia.php";</script>';
}else{
	echo '<script>alert("Presença não registrada!\nPor favor consulte o administrador do sistema");location.href="registrar_frequencia.php";</script>';
}
?>