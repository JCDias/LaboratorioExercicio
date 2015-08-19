<?php 
	session_start();
	if( $_SESSION["logado"] == true ):

	require('cabecalho.php');
	require('../conexao.php');
	//Definir nomes dos meses em portugues;
	$query = mysql_query("SET lc_time_names ='pt_BR';",$db);
	setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	//echo strftime('%A, %d de %B de %Y', strtotime('today'));
	
	$id = $_GET['id'];
	//continuar aki se o mes for 2 exibir dezembro tbm e se for 1 exibir novembro para sempre exibir a frequencia dos últimos 3 meses
	$mes1 = date('m');
	$ano1 = date('Y');
	if($mes1==01){
		$mes2 = 12;
		$ano2 = $ano1 - 1;
		$mes3 = 11;
		$ano3 = $ano1 - 1;
	}elseif($mes1==02){
		$mes2 = 01;
		$ano2 = $ano1;
		$mes3 = 12;
		$ano3 = $ano1 - 1;
	}else{
		if($mes1 <=10){
			$mes2 = '0'.($mes1 - 1);
			$ano2 = $ano1;
			$mes3 = '0'.($mes2 - 1);
			$ano3 = $ano1;
		}else{
			$mes2 = $mes1 - 1;
			$ano2 = $ano1;
			$mes3 = $mes2 - 1;
			$ano3 = $ano1;
		}
	}
	// datas dos 3 ultimos meses para consulta inicio
	$data1_i = $ano1.'-'.$mes1.'-01';
	$data2_i = $ano2.'-'.$mes2.'-01';
	$data3_i = $ano3.'-'.$mes3.'-01';
	// datas dos 3 ultimos meses para consulta terminio
	$data1_f = $ano1.'-'.$mes1.'-31';
	$data2_f = $ano2.'-'.$mes2.'-31';
	$data3_f = $ano3.'-'.$mes3.'-31';
	
	
	// Buscar dados do usuário
	$sql_usuario = "select *, date_format(data_cadastro,'%d/%m/%Y %H:%i:%s'), c.nome_categoria from usuarios join categorias c on c.id_categoria = categoria_fk where id_usuario = $id;";
	
	$query_usuario = mysql_query($sql_usuario,$db);
	
	$usuario = mysql_fetch_array($query_usuario);
	// Fim Buscar dados do usuário
	
	// Buscar Frequências 1
	$sql_frequencia1 = "select *,date_format(data_presenca,'%d/%m/%Y - %H:%i:%s') from frequencia where date_format(data_presenca,'%Y-%m-%d') >= '$data1_i' and  date_format(data_presenca,'%Y-%m-%d') <= '$data1_f' and usuario_fk = $id order by data_presenca ;";
	
	$query_frequencia1 = mysql_query($sql_frequencia1,$db);
	$query_qtd1 = mysql_query("select count(*) from frequencia where date_format(data_presenca,'%Y-%m-%d') >= '$data1_i' and  date_format(data_presenca,'%Y-%m-%d') <= '$data1_f' and usuario_fk = $id order by data_presenca DESC;",$db);
	
	$qtd1= mysql_fetch_array($query_qtd1);
	// Fim Buscar Frequências 1
	
	// Buscar Frequências 2
	$sql_frequencia2 = "select *,date_format(data_presenca,'%d/%m/%Y - %H:%i:%s') from frequencia where date_format(data_presenca,'%Y-%m-%d') >= '$data2_i' and  date_format(data_presenca,'%Y-%m-%d') <= '$data2_f' and usuario_fk = $id order by data_presenca ;";
	
	$query_frequencia2 = mysql_query($sql_frequencia2,$db);
	$query_qtd2 = mysql_query("select count(*) from frequencia where date_format(data_presenca,'%Y-%m-%d') >= '$data2_i' and  date_format(data_presenca,'%Y-%m-%d') <= '$data2_f' and usuario_fk = $id order by data_presenca DESC;",$db);
	
	$qtd2= mysql_fetch_array($query_qtd2);
	// Fim Buscar Frequências 2
	
	// Buscar Frequências 3
	$sql_frequencia3 = "select *,date_format(data_presenca,'%d/%m/%Y - %H:%i:%s') from frequencia where date_format(data_presenca,'%Y-%m-%d') >= '$data3_i' and  date_format(data_presenca,'%Y-%m-%d') <= '$data3_f' and usuario_fk = $id order by data_presenca ;";
	
	$query_frequencia3 = mysql_query($sql_frequencia3,$db);
	$query_qtd3 = mysql_query("select count(*) from frequencia where date_format(data_presenca,'%Y-%m-%d') >= '$data3_i' and  date_format(data_presenca,'%Y-%m-%d') <= '$data3_f' and usuario_fk = $id order by data_presenca DESC;",$db);
	
	$qtd3= mysql_fetch_array($query_qtd3);
	// Fim Buscar Frequências 3
	
?>
<!-- Script de ver -->
<script>
	function relatorio(){
		var pagina ='relatorios/relatorio_ver_frequencias_individual.php?id=<?php echo $id;?>&nome=<?php echo utf8_encode($usuario['nome']);?>';
		window.open(pagina,'_blank','toolbar=no,Location=no,menubar=no');
	}
</script>
<!-- Fim Script de ver -->

<!-- breadcrumb -->
<div>
    <ul class="breadcrumb">
        <li>
            <a href="principal.php">Início</a>
        </li>
        <li>
            <a href="#">Frequência</a>
        </li>
		<li>
            <a href="consultar_frequencia.php">Consultar</a>
        </li>
		<li>
            <a href="#">Relatório de Frequência Individual</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->

<!-- Conteúdo da página  -->
<div class="row" style="display:inline">
    <div class="box col-md-12">
        <div class="box-inner">
			<div class="box-header well" data-original-title="">
                <h2>Dados do Usuário</h2>
            </div>
            <div class="box-content row">
                <div class="col-lg-12 col-md-12">
					<div class="box-content">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width:35%">Nome</th>
                            <th style="width:30%">Categoria</th>
                            <th style="width:15%">Horário</th>
                            <!--<th style="width:20%">Data de Cadastro</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="center"><?php echo utf8_encode($usuario['nome']);?></td>
                            <td class="center"><?php echo utf8_encode($usuario['nome_categoria']);?></td>
                            <td class="center"><?php echo utf8_encode($usuario['horario']);?>º Turno</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
				
<!-- fim conteudo d página -->
<!-- primeiro mes -->
<?php if($qtd1['count(*)']>0){?>
			<div class="box col-md-4">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><?php echo strtoupper(strftime('%B', strtotime($data1_i))); ?></h2>
                </div>
                <div class="box-content">
                    <table class="table">
                        <tbody>
						<?php
							while($frequencia1 = mysql_fetch_array ($query_frequencia1)):
						?>
                            <tr>
							<td><?php echo $frequencia1["date_format(data_presenca,'%d/%m/%Y - %H:%i:%s')"];?></td>
							<td><img src="img/certo.png" width="20px" height="20px" /></td>
							</tr>
						<?php 
						endwhile;
						?>
                        </tbody>
                    </table>
					<p><b>Total de Presenças: &nbsp;</b><?php echo $qtd1['count(*)'];?></p>
				</div>
			</div>
	</div>
	<?php }?>
<!-- Fim primeiro mes -->
<!-- segundo mes -->
<?php if($qtd2['count(*)']>0){?>
			<div class="box col-md-4">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><?php echo strtoupper(strftime('%B', strtotime($data2_i))); ?></h2>
                </div>
                <div class="box-content">
                    <table class="table table-striped">
                        <tbody>
						<?php
							while($frequencia2 = mysql_fetch_array ($query_frequencia2)):
							?>
							<tr>
							<td><?php echo $frequencia2["date_format(data_presenca,'%d/%m/%Y - %H:%i:%s')"];?></td>
							<td><img src="img/certo.png" width="20px" height="20px" /></td>
							</tr>
						<?php 
						endwhile;
						?>
                        </tbody>
                    </table>
					<p><b>Total de Presenças: &nbsp;</b><?php echo $qtd2['count(*)'];?></p>
				</div>
			</div>
	</div>
	<?php }?>
<!-- Fim segundo mes -->
<!-- terceiro mes -->
<?php if($qtd3['count(*)']>0){?>
			<div class="box col-md-4">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2><?php echo strtoupper(strftime('%B', strtotime($data3_i))); ?></h2>
                </div>
                <div class="box-content">
                    <table class="table table-striped">
                        <tbody>
						<?php
							while($frequencia3 = mysql_fetch_array ($query_frequencia3)):
						?>
							<tr>
							<td><?php echo $frequencia3["date_format(data_presenca,'%d/%m/%Y - %H:%i:%s')"];?></td>
							<td><img src="img/certo.png" width="20px" height="20px" /></td>
							</tr>
						<?php
						endwhile;
						?>
                        </tbody>
                    </table>
					<p><b>Total de Presenças: &nbsp;</b><?php echo $qtd3['count(*)'];?></p>
				</div>
			</div>
	</div>
	<?php }?>
<!-- Fim terceiro mes -->
				<div class="box-content row">
                <div class="col-lg-12 col-md-12">
				<p>
                    <a href="consultar_frequencia.php" class="btn btn-success">Voltar</a>
                    <a href="javascript:relatorio();" class="btn btn-info">
					Relatório</a>
				</p>
				</div>
				</div>
				</div>
            </div>
        </div>
    </div>
</div>
<!-- Fim Conteúdo da página -->
<?php
	endif;
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
require('rodape.php');
?>