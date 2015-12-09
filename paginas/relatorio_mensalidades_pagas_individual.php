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
	
	// fazer consulta na tabela caixa quando data pagamento for do ano atual ordenar por ordem decrescente
	$sql = "select *,mensalidade.funcionario, nome, date_format(data_vencimento,'%d/%m/%Y'), date_format(data_pagamento,'%d/%m/%Y') from mensalidade join usuarios on usuario_fk = id_usuario where usuario_fk = $id and status_pagamento = 'pago' order by data_pagamento desc;";
	
	$res = mysql_query($sql,$db);
?>
<!-- Script de ver -->
<script>
	function relatorio(){
		var pagina ='relatorios/relatorio_ver_mensalidades_individual.php?id=<?php echo $id;?>';
		window.open(pagina,'_blank','toolbar=no,Location=no,menubar=no');
	}
</script>
<!-- Fim Script de ver -->
<!-- Script de excluir -->
<script>
	function excluir(id){
		var res = confirm("Deseja realmente excluir este lançamento?\nEsta ação não pode ser desfeita!");
		if(res){
			location.href="apagar_generico.php?id="+id+"&campo=id_caixa&tbl=caixa&pag=consultar_mensalidade.php";
		}
	}
</script>
<!-- breadcrumb -->
<div>
    <ul class="breadcrumb">
        <li>
            <a href="principal.php">Início</a>
        </li>
		<li>
            <a href="#">Mensalidades</a>
        </li>
		<li>
            <a href="consultar_mensalidade.php">Pagas</a>
        </li>
		<li>
            <a href="#">Relatório de Mensalidades Pagas</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<!-- Conteúdo da página  -->
<div class="row" style="display:inline">
    <div class="box col-md-12">
        <div class="box-inner">
			<div class="box-header well" data-original-title="">
                <h2>Mensalidades Pagas</h2>
            </div>
            <div class="box-content row">
                <div class="col-lg-12 col-md-12">
				
					<div class="box-content">
					<?php if(mysql_num_rows($res)>0){?>
                    <table class="table table-striped table-bordered responsive">
                        <thead>
                        <tr>
                            <th style="width:35%">Nome</th>
                            <th style="width:15%">Data Vencimento</th>
                            <th style="width:15%">Data Pagamento</th>
                            <th style="width:10%">Valor</th>
                            <th style="width:25%">Funcionário</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($linha = mysql_fetch_array ($res)):?>
						<tr>
                            <td class="center"><?php echo utf8_encode($linha['nome']);?></td>
                            <td class="center"><?php echo $linha["date_format(data_vencimento,'%d/%m/%Y')"];?></td>
                            <td class="center"><?php echo $linha["date_format(data_pagamento,'%d/%m/%Y')"];?></td>
                            <td class="center">R$ <?php echo $linha['valor_recebido'];?></td>
                            <td class="center"><?php echo utf8_encode(utf8_decode($linha['funcionario']));?></td>
						</tr>
						<?php endwhile;?>
                        </tbody>
                    </table>
                </div>
				<?php }else{ echo 'Nenhuma mensalidade paga por este usuário! <br/><br/>';}?>
				<p>
					<a href="consultar_mensalidade.php" class="btn btn-success" >Voltar</a>
					<a href="javascript:relatorio();" class="btn btn-info" >Relatório</a>
				</p>
            </div>
           </div>
		</div>
    </div>
</div>
				
<!-- fim conteudo d página -->

<?php
	endif;
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
require('rodape.php');
?>