<?php 
		session_start();
		if( $_SESSION["logado"] == true ):

	require('cabecalho.php');
	require('../conexao.php');
	
	$id = $_GET['id'];
	
	//Data para cadastro
	date_default_timezone_set('America/Sao_Paulo');
	$date = date('Y-m-d H:i:s');
	
	//Selecionar dados da mensalidade escolhida
	$mens = mysql_fetch_array(mysql_query("SELECT * FROM `preco_reavaliacao` JOIN categorias ON categoria_fk = id_categoria where id_preco_reavaliacao=$id;",$db));
	//Selecionar dados da mensalidade escolhida
	
	//Selecionar categoria para combo box
	$sql="select id_categoria,nome_categoria from categorias order by nome_categoria;";
	
	$cons = mysql_query($sql,$db);
	
?>

<script>
function casas(valor,campo){
	var valor_convertido =  parseFloat(valor);
	var valor_formatado = valor_convertido.toFixed(2);
	campo.value = valor_formatado;
}
</script>

<!-- breadcrumb -->
<div>
    <ul class="breadcrumb">
        <li>
            <a href="principal.php">Início</a>
        </li>
        <li>
            <a href="#">Caixa</a>
        </li>
		<li>
            <a href="precos.php">Preços</a>
        </li>
		<li>
            <a href="editar_mens.php">Editar Preço Reavaliação Física</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->

<div class="row">
    <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Editar Preço Reavaliação Física</h2>
            </div>
            <div class="box-content">
                <div class="control-group">
					<form action="cadastrar_preco_reavaliacao.php" method="POST" name="cad_preco_mens">
						<div class="form-group" >
							<label>Valor:(R$)</label>
							<input type="text" name="valor" id="valor"  class="form-control" placeholder="Informe o valor no formato 00.00" onblur='casas(this.value,this)'  value="<?php echo $mens['valor']?>" />
						</div>
												
						<div class="form-group" >	
							<label>Categoria:</label>
							<select name="categoria" data-rel="chosen" required >
								<option value="<?php echo $mens['categoria_fk']?>"><?php echo utf8_encode($mens['nome_categoria'])?></option>
								<?php while($linha = mysql_fetch_array ($cons)):?>
									<option value="<?php echo $linha['id_categoria']?>"><?php echo utf8_encode($linha['nome_categoria'])?></option>
								<?php endwhile; ?>
							</select>
						</div>
						
						<input type="hidden" name="funcionario" value="<?php echo utf8_encode($_SESSION['usuario'])?>" />
						<input type="hidden" name="id" value="<?php echo $mens['id_preco_reavaliacao']?>" />
						
						<input type="hidden" name="acao" value="editar" />
											
						<br/>
						<button type="submit" class="btn btn-success">Alterar</button>
						<button type="reset" class="btn btn-info">Limpar</button></a>
						<a href="precos.php" class="btn btn-danger">Cancelar</a>
					</form>
                </div>
                
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->
<!-- Rodapé -->
<?php
	endif;
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
require('rodape.php');
?>
