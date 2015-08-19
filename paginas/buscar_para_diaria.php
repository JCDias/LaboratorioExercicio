<?php
	require('../conexao.php');
	
	$busca = $_GET['busca'];
	
	if($busca != "") {
		
		$sql = "select id_usuario, nome from usuarios where tipo= 'Diarista' and nome like '%$busca%' order by nome ASC;";
		
		
		$query = mysql_query($sql);
		
		if(mysql_num_rows($query)> 0){ ?>
			<!-- Striped table -->
		<div class="row">
			<div class="box col-md-12">
				<div class="box-inner">
					<div class="box-header well" data-original-title="">
						<h2>Resultado</h2>
					</div>
					<div class="box-content">
						<table class="table table-striped">
							<thead>
							<tr>
								<th style="width:70%">Nome</th>
								<th style="width:30%">Opção</th>
							</tr>
							</thead>
							<tbody>
							<?php while($linha = mysql_fetch_array ($query)): 
								echo "<tr>";
							?>
								<td class="center"><?php echo utf8_encode($linha['nome'])?></td>
								<td class="center"><a href="relatorio_diarias_pagas_individual.php?id=<?php echo utf8_encode($linha['id_usuario']);?>" class="btn btn-primary">Selecionar</a></td>
							</tr>
							<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- Striped table -->
		<?php
		}else{
			echo 'Nenhum registro encontrado!';
			}
	}
?>