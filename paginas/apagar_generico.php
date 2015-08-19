<?php 
	session_start();
	if( $_SESSION["logado"] == true ){
		
		require('../conexao.php');	
		
		//Recebendo parametros
		$id= $_GET['id'];
		$campo = $_GET['campo'];
		$tabela = $_GET['tbl'];
		$pagina = $_GET['pag'];
		
		$sql_apagar = "DELETE FROM $tabela WHERE $campo = $id;";
		$query = mysql_query($sql_apagar,$db);

		if(mysql_affected_rows()>=1){
			echo '<script>alert("Exclusão  efetuada com sucesso!");location.href="'.$pagina.'";</script>';
		}else{
			echo '<script>alert("A exclusão não foi realizada!");location.href="'.$pagina.'";</script>';
		}
		
	}
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}	
?>