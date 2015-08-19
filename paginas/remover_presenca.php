<?php
date_default_timezone_set('America/Sao_Paulo');
require"../conexao.php";

$id = $_GET["id"];

$confirmar = mysql_query("delete from frequencia where date_format(data_presenca,'%Y-%m-%d') = curdate() and usuario_fk = $id;",$db);

if($confirmar == 1){
	echo '<script>alert("Presença removida com sucesso!");location.href="registrar_frequencia.php";</script>';
}else{
	echo '<script>alert("Presença não removida!\nPor favor consulte o administrador do sistema");location.href="registrar_frequencia.php";</script>';
}

?>