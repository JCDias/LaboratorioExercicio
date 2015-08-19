<?php 
		header ('Content-type: text/html; charset=UTF-8');
		setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
		date_default_timezone_set('America/Sao_Paulo');
		session_start();
		if( $_SESSION["logado"] == true ):
?>
<?php
	require('cabecalho.php');
	$sql = "select data_vencimento, id_mensalidade, usuario_fk, nome, date_format(data_vencimento,'%d-%m-%Y'), valor_a_receber, desconto_a_receber, usuarios.categoria_fk from mensalidade join usuarios on usuario_fk = id_usuario where status_pagamento = 'em aberto' order by data_vencimento desc;";
	$res = mysql_query($sql,$db);
?>

<!-- Script de editar-->
<script>
	function receber(id){
		location.href="confirma_receber-mensalidade.php?id="+id;
	}
</script>
<!-- Fim Script de editar-->
<!-- Script de excluir -->
<script>
	function cancelar(id){
		var res = confirm("Deseja realmente cancelar a mensalidade deste usuario?\nEsta ação não pode ser desfeita!");
		if(res){
			location.href="cancelar_mensalidade.php?id="+id;
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
            <a href="mensalidades_em_aberto.php">Mensalidades Vencidas</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-fullscreen"></i> Mensalidades Vencidas</h2>
    </div>
    <div class="box-content">
	<?php if(mysql_num_rows($res)>0){?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
        <th style="width:30%">Nome</th>
        <th style="width:15%">Data de Vencimento</th>
        <th style="width:15%">Valor Mensalidade</th>
		<th style="width:10%">Desconto</th>
		<th style="width:15%">Valor à receber</th>
		<th>Opções</th>
        
    </tr>
    </thead>
    <tbody>
	<?php
		while($linha = mysql_fetch_array ($res)):
		echo "<tr>";
	?>
		<td><?php echo utf8_encode($linha['nome'])?></td>
        <td class="center"><?php echo utf8_encode($linha["date_format(data_vencimento,'%d-%m-%Y')"])?></td>
        <td class="center">R$ <?php echo utf8_encode($linha['valor_a_receber'])?></td>
		<?php 
			$cat = $linha['categoria_fk'];
			if(date('d')<=10 and ($cat==2 or $cat==3 or $cat==4 or $cat==7 or $cat==8 or $cat==9)){
				//Condições para oferecer desconto para as categorias específicas
				$desc = number_format(25, 2, '.', '');			
				// no lugar do 23 criar tabela pra salvar o valor do desconto para não mexer no código depois e fazer select para buscar esse valor
			}else{
				$desc = $linha['desconto_a_receber'];
			}
			$valor = $linha['valor_a_receber'];
			$calculo= $valor - (($valor * $desc)/100);
			$valor_a_receber = number_format($calculo, 2, '.', '');
		?>
		 <td class="center"><?php echo $desc?> %</td>
		<td class="center">R$ <?php echo $valor_a_receber; $valor_a_receber = '';?></td>
        <td class="center">
            <a class="btn btn-success" href="javascript:receber(id=<?php echo utf8_encode($linha['id_mensalidade'])?>)">
                Receber
            </a>
			<?php if($_SESSION['privilegio']==1){ ?>
            <a class="btn btn-danger" href="javascript:cancelar(id=<?php echo utf8_encode($linha['id_mensalidade'])?>)">
                Cancelar
            </a>
			<?php }?>
        </td>
    </tr>
	<?php endwhile;?>
    </tbody>
    </table>
	<?php }else{
				echo 'Nenhuma em aberto para esse mês!<br/><br/>';
			}?>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->


<?php
require ('rodape.php');
?>
<?php
	endif;
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
?>