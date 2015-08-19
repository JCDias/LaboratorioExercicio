<?php 
	session_start();
	if( $_SESSION["logado"] == true ):
	require('../conexao.php');
	require ('cabecalho.php');
	date_default_timezone_set('America/Sao_Paulo');
?>

<!-- Script de ver -->
<script>
	function relatorio(){
		var inicio = document.getElementById('inicio').value;
		var fim = document.getElementById('fim').value;
		if(inicio == '' || fim == ''){
			alert("Preencha todos os campos!");
		}else{
			var pagina = 'relatorios/relatorio_ver_frequencias.php?inicio='+inicio+'&fim='+fim;
			window.open(pagina,'_blank','toolbar=no,Location=no,menubar=no');
			var inicio = document.getElementById('inicio').value = '';
			var fim = document.getElementById('fim').value = '';
			var inicio = document.getElementById('inicio').focus;
		}
	}
</script>
<!-- Fim Script de ver -->

<!-- calendário -->
<link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/excite-bike/jquery-ui-1.10.4.custom.css" />
<link rel="stylesheet" href="js/jquery-ui-1.10.4.custom/css/excite-bike/jquery-ui-1.10.4.custom.min.css" />
<script src="js/jquery-ui-1.10.4.custom/js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js"></script>
<script src="js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
<script>
$(function() {
    $(".calendario").datepicker({
        dateFormat: 'dd-mm-yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		showOtherMonths: true,
        selectOtherMonths: true,
		showAnim: "drop",
    });
});
</script>

<style type="text/css" >
/* FUNDO DE TODA A COLUNA DE SÁBADO E DOMINGO*/
.ui-datepicker-week-end, .ui-datepicker-week-end a.ui-state-default{
        background: #F00000;
}

/* FUNDO DA COLUNA DE TÍTULO DE DE SÁBADO E DOMINGO */
.ui-datepicker-title-row, .ui-datepicker-week-end {
        background: none 0% 0% transparent;
}
</style>
<!-- Fim calendário -->
<!-- breadcrumb -->
<div>
    <ul class="breadcrumb">
        <li>
            <a href="principal.php">Início</a>
        </li>
		<li>
            <a href="relatorios.php">Relatórios</a>
        </li>
		<li>
            <a href="#">Selecionar Data</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<!-- painel principal -->
<div class="row">
    <div class="box col-md-4">
		<div class="box-inner">
			<div class="box-header well" data-original-title="">
				<h2><i class="glyphicon glyphicon-stats"></i> Selecionar Data</h2>
			</div>
			<div class="box-content">
			<div class="control-group">
					<form action="" method="POST">
						<div class="form-group">
							<label>Data Início:</label>
							<input type="text" name="inicio" id="inicio" class="form-control calendario" required />
						</div>
						<div class="form-group">
							<label>Data Término:</label>
							<input type="text" name="fim" id="fim" class="form-control calendario" required />
						</div>
						<a href="principal.php" class="btn btn-success">Voltar</a>
						<button type="reset" class="btn btn-danger" >Limpar</button>
						<a href="javascript:relatorio();" class="btn btn-info">Relatório</a>
					</form>
				</div>
			<!--Botão voltar-->
			<p>
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
