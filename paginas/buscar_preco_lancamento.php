<?php
	require('../conexao.php');
	
	$busca = $_GET['busca'];
	$id = $_GET['id'];
	
	if($busca != "") {
		
		if($busca==1){
			$sql = "select p.valor, u.categoria_fk from usuarios u join preco_avaliacao p on u.categoria_fk = p.categoria_fk where u.id_usuario = $id ;";
			$tipo = 'Avaliação Física';
		}elseif($busca==2){
			$sql = "select p.valor, u.categoria_fk from usuarios u join preco_reavaliacao p on u.categoria_fk = p.categoria_fk where u.id_usuario = $id ;";
			$tipo = 'Reavaliação Física';
		}else{
			$sql = "select p.valor, u.categoria_fk from usuarios u join preco_mensalidade p on u.categoria_fk = p.categoria_fk where u.id_usuario = $id and u.horario = p.horario;";
			$tipo = 'Mensalidade';
		}
		
		$query = mysql_query($sql);
		
		if(mysql_num_rows($query)> 0){
			$linha = mysql_fetch_array($query);
		
			$cat = $linha['categoria_fk'];
			if(date('d')<=10 and ($cat==2 or $cat==3 or $cat==4 or $cat==7 or $cat==8 or $cat==9)){
			?>
				<input type="text" class="form-control" value="<?php echo "37.50"?>" disabled />
				<input type="hidden" name="valor" value="<?php echo "37.50"?>"/>
				<input type="hidden" name="tipo_lancamento" value="<?php echo $tipo;?>"/>
			<?php
			}else{?>
				<input type="text" class="form-control" value="<?php echo $linha['valor']?>" disabled />
				<input type="hidden" name="valor" value="<?php echo $linha['valor']?>"/>
				<input type="hidden" name="tipo_lancamento" value="<?php echo $tipo;?>"/>	
			<?php }?> <!--Fim do else-->
		<?php
		}
	}
?>