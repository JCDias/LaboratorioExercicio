<?php 
	session_start();
	if( $_SESSION["logado"] == true ):
	require('../conexao.php');
	require ('cabecalho.php');
	date_default_timezone_set('America/Sao_Paulo');
?>

<!-- breadcrumb -->
<div>
    <ul class="breadcrumb">
        <li>
            <a href="principal.php">Início</a>
        </li>
		<li>
            <a href="relatorios.php">Relatórios</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<!-- painel principal -->
<div class="row">
    <div class="box col-md-6">
		<div class="box-inner">
			<div class="box-header well" data-original-title="">
				<h2><i class="glyphicon glyphicon-stats"></i> Relatórios</h2>
			</div>
			<div class="box-content">
				<div id="botoes">
					<p>
						<a href="selecionar_data_rel_diario.php" class="btn btn-info">Relatório Diário</a>
					</p>
					<p>
						<a href="selecionar_data_rel_semanal.php" class="btn btn-info">Relatório Semanal</a>
					</p>
				</div>
			</div>
			<!--Botão voltar-->
			<p>
			<a href="principal.php" class="btn btn-success">Voltar</a>
			</p>
			<!--Fim Botão voltar-->
		</div>
	</div>
</div>
<!-- Fim painel principal -->
<?php
require ('rodape.php');
?>
<?php
	endif;
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
?>