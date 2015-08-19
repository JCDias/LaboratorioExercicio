<?php 
		session_start();
		if( $_SESSION["logado"] == true ):
?>
<?php
	require('cabecalho.php');
	
	//Selecionar Aniversariantes
	$sql_aniversariantes = "select nome, count(nome), date_format(data_nasc, '%d-%m') from usuarios where date_format(data_nasc, '%d-%m') = date_format(curdate(), '%d-%m');";
	$aniver = mysql_query($sql_aniversariantes,$db);
	$aniversariantes = mysql_fetch_array($aniver);
	//Fim Selecionar Aniversariantes
	
	//Selecionar mensalidades em aberto
	$sql_mensalidades = "select count(*) from mensalidade where data_vencimento<=curdate() and status_pagamento = 'em aberto';";
	$mens = mysql_query($sql_mensalidades,$db);
	$mensalidades = mysql_fetch_array($mens);
	//Fim Selecionar mensalidades em aberto
	
?>

<!-- breadcrumb -->
<div>
    <ul class="breadcrumb">
        <li>
            <a href="principal.php">Início</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<!-- botões no topo -->
<div class=" row">
<img src="img/cabecalhso.JPG" height="200px" width="100%"/>
<!-- Barra que divide a imagem dos outros conteúdos -->
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well">
                
            </div>
            
        </div>
    </div>
</div>
<!-- Fim Barra que divide a imagem dos outros conteúdos -->
    
	<?php if($mensalidades['count(*)']>0){ ?>
	<div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="<?php echo $mensalidades['count(*)']; if($mensalidades['count(*)']==1){echo " mensalidade vencida";}else{echo " mensalidades vencidas";}?>" class="well top-block" href="mensalidades_em_aberto.php">
			<span><i class="glyphicon glyphicon-folder-open green"></i></span>
            <div>Mensalidades Vencidas</div>
			<br/>
            <span class="notification red"><?php echo $mensalidades['count(*)']?></span>
        </a>
    </div>
	<?php  }?>
<!--
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="Avaliações Marcadas" class="well top-block" href="#">
			<span><i class="glyphicon glyphicon-check green"></i></span>
            <div>Avaliações Marcadas</div>
			<br/>
            <span class="notification red">4</span>
        </a>
    </div>

    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="Testes de Carga Marcados" class="well top-block" href="#">
			<span><i class="glyphicon glyphicon-check green"></i></span>
            <div>Testes de Carga Marcados</div>
			<br/>
            <span class="notification red">6</span>
        </a>
    </div>
	-->
	<?php if($aniversariantes['count(nome)']>0){ ?>
    <div class="col-md-3 col-sm-3 col-xs-6">
        <a data-toggle="tooltip" title="<?php echo $aniversariantes['count(nome)']; if($aniversariantes['count(nome)']==1){echo " aniversariante ";}else{echo " aniversariantes ";}?> hoje" class="well top-block" href="ver_aniversariantes.php">
		
			 <span><i class="glyphicon glyphicon-calendar green"></i></span>
            <div>Aniversariantes</div>
			<br/>
            <span class="notification red"><?php echo $aniversariantes['count(nome)']?></span>
        </a>
    </div>
	<?php  }?>
	
</div>
<!-- fim botões topo -->

<?php
require ('rodape.php');
?>
<?php
	endif;
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
?>