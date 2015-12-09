<?php 
		session_start();
		if( $_SESSION["logado"] == true ):
?>
<?php
require ('cabecalho.php');	

	$sql = "select nome, date_format(data_nasc, '%d-%m') from usuarios where date_format(data_nasc, '%d-%m') = date_format(curdate(), '%d-%m');";
	$res = mysql_query($sql,$db);
	
	//Todos
	$sql_todos = "select nome, date_format(data_nasc, '%d-%m') from usuarios where date_format(data_nasc, '%m') = date_format(curdate(), '%m') order by date_format(data_nasc, '%d-%m');";
	$res_todos = mysql_query($sql_todos,$db);
	
?>
<!-- breadcrumb -->
<div>
    <ul class="breadcrumb">
        <li>
            <a href="principal.php">Início</a>
        </li>
		<li>
            <a href="#">Usuários</a>
        </li>
		<li>
            <a href="ver_aniversariantes.php">Ver Aniversariantes</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
	<!-- Striped table -->
	<div class="row">
		<div class="box col-md-6">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2>Aniversariantes do Dia</h2>
                </div>
                <div class="box-content">
				<?php if(mysql_num_rows($res)>0){?>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data</th>
                        </tr>
                        </thead>
                        <tbody>
						<?php 
							while($linha = mysql_fetch_array ($res)):
							#######################
								echo "<tr>";
								
							?>
                            <td><?php echo utf8_encode($linha['nome'])?></td>
                            <td class="center"><?php echo utf8_encode($linha["date_format(data_nasc, '%d-%m')"])?></td>
                        </tr>
						<?php endwhile; ?>
                        </tbody>
                    </table>
					<?php
						}else{
							echo 'Nenhum aniversariante hoje!<br/><br/>';
							}
					?>
					<a href="principal.php"><button class="btn btn-success">Voltar</button></a>
                </div>
            </div>
        </div>
	
	<!-- Striped table -->
	<!-- Striped table -->
	
		<div class="box col-md-6">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2>Aniversariantes do Mês</h2>
                </div>
                <div class="box-content">
				<?php if(mysql_num_rows($res_todos)>0){?>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data</th>
                        </tr>
                        </thead>
                        <tbody>
						<?php 
							while($todos = mysql_fetch_array ($res_todos)):
							#######################
								echo "<tr>";
								
							?>
                            <td><?php echo utf8_encode($todos['nome'])?></td>
                            <td class="center"><?php echo utf8_encode($todos["date_format(data_nasc, '%d-%m')"])?></td>
                        </tr>
						<?php endwhile; ?>
                        </tbody>
                    </table>
					<?php
						}else{
							echo 'Nenhum aniversariante este Mês!<br/><br/>';
							}
					?>
				
                </div>
            </div>
        </div>
	</div>
	<!-- Striped table -->
	
<?php
require ('rodape.php');
?>
<?php
	endif;
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
?>