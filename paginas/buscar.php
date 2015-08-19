<?php
	require('../conexao.php');
	
	$busca = $_GET['busca'];
	
	if($busca != "") {
		
		$sql = "select f.usuario_fk, u.nome from usuarios u join frequencia f on f.usuario_fk = u.id_usuario where u.nome like '%$busca%' group by u.nome order by u.nome ASC;";
			
		
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
								<td class="center"><a href="relatorio_frequencia_individual.php?id=<?php echo utf8_encode($linha['usuario_fk']);?>" class="btn btn-primary">Relatório</a></td>
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
			echo 'Usuário não encontrado ou não possui presenças!';
			}
	}
?>