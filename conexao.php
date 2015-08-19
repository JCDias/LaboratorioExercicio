<?php
	
	$db = mysql_connect('localhost','root','2863') or die ('Ocorreu um erro ao conectar o banco de dados!');
	
	mysql_select_db ('laboratorio', $db) or die ('Não foi possível selecionar o DB!');

?>