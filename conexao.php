<?php
	
	$db = mysql_connect('localhost','root','2863') or die ('Ocorreu um erro ao conectar o banco de dados!');
	
	mysql_select_db ('laboratorio', $db) or die ('N�o foi poss�vel selecionar o DB!');

?>