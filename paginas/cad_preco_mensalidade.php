<?php 
		session_start();
		if( $_SESSION["logado"] == true ):

	require('cabecalho.php');
	require('../conexao.php');
	
	
	//Data para cadastro
	date_default_timezone_set('America/Sao_Paulo');
	$date = date('Y-m-d H:i:s');
	
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

<!-- fazer calculo do valor com desconto -->
<script>
function calcular(){
	var preco = document.getElementById('valor').value;
	var desc = document.getElementById('desconto').value;
	var calculo = preco - ((preco*desc)/100);
	var resultado = calculo.toFixed(2);
	document.getElementById('valor_com_desc').value = resultado;
	
}
</script>
<!-- Fim fazer calculo do valor com desconto -->

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
            <a href="cad_preco_mensalidade.php">Preço Mensalidade</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->

<div class="row">
    <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Cadastrar Preço Mensalidade</h2>
            </div>
            <div class="box-content">
                <div class="control-group">
					<form action="cadastrar_preco_mensalidade.php" method="POST" name="cad_preco_mens">
						<div class="form-group" >	
							<label>Horário: </label>
							<select name="horario" data-rel="chosen" required > 
								<option value="">Selecione ...</option>
								<option value="1">1º Turno</option>
								<option value="2">2º Turno</option>
								<option value="3">3º Turno</option>
								<option value="4">4º Turno</option>
							</select>
						</div>
						<div class="form-group" >
							<label>Valor:(R$)</label>
							<input type="text" name="valor" id="valor"  class="form-control" placeholder="Informe o valor no formato 00.00" onblur='casas(this.value,this)' onkeyup='calcular()' />
						</div>
						<div class="form-group" >	
							<label>Desconto:(%)</label>
							<input type="text" name="desconto" id="desconto" value="0.00" class="form-control" placeholder="informe a porcentagem no formato 00.00" required onblur='casas(this.value,this)' onkeyup='calcular()' />
						</div>
						<div class="form-group" >					
							<label>Valor com Desconto: (R$)</label>
							<input type="text" name="valor_com_desc" id="valor_com_desc" class="form-control"  disabled />
						</div>
						
						<div class="form-group" >	
							<label>Categoria:</label>
							<select name="categoria" data-rel="chosen" required >
								<option value="">Selecione ...</option>
								<?php while($linha = mysql_fetch_array ($cons)):?>
									<option value="<?php echo $linha['id_categoria']?>"><?php echo utf8_encode($linha['nome_categoria'])?></option>
								<?php endwhile; ?>
							</select>
						</div>
						
						<input type="hidden" name="funcionario" value="<?php echo utf8_encode($_SESSION['usuario'])?>" />
						
						<input type="hidden" name="acao" value="cadastrar" />
											
						<br/>
						<button type="submit" class="btn btn-success">Cadastrar</button>
						<a href="cad_preco_mensalidade.php"><button type="button" class="btn btn-info">Limpar</button></a>
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
