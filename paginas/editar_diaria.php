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
	$diaria = mysql_fetch_array(mysql_query("select id_preco_diaria,valor from preco_diaria where id_preco_diaria=$id;",$db));
	//Selecionar dados da mensalidade escolhida
	
	
?>

<script>
function casas(valor,campo){
	var valor_convertido =  parseFloat(valor);
	var valor_formatado = valor_convertido.toFixed(2);
	campo.value = valor_formatado;
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
            <a href="editar_diaria.php">Editar Preço Diária</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->

<div class="row">
    <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Editar Preço Diária</h2>
            </div>
            <div class="box-content">
                <div class="control-group">
					<form action="cadastrar_preco_diaria.php" method="POST" name="cad_preco_mens">
						<div class="form-group" >	
							<label>Valor: </label>
							<input type="text" name="valor" value="<?php echo $diaria['valor']?>" class="form-control" required onblur='casas(this.value,this)' />
							</select>
						</div>
						<input type="hidden" name="id" value="<?php echo $diaria['id_preco_diaria']?>" />
						<input type="hidden" name="acao" value="editar" />					
						<br/>
						<button type="submit" class="btn btn-success">Alterar</button>
						<button type="reset" class="btn btn-info">Limpar</button>
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
