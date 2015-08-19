<?php 
		session_start();
		if( $_SESSION["logado"] == true ):

	require('cabecalho.php');
	require('../conexao.php');
	
	$id = $_GET['id'];
	
	$usuario = mysql_fetch_array(mysql_query("select *, nome_categoria from usuarios join categorias on categoria_fk = id_categoria where id_usuario=$id",$db));
	
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
            <a href="cad_lancamento.php">Lançamento</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->

<div class="row">
    <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Lançamento</h2>
            </div>
            <div class="box-content">
                <div class="control-group">
					<form action="cadastrar_lancamento.php" method="POST">
							<div class="form-group" >
								<label>Tipo de Entrada:</label>
								<select name="tipo" data-rel="chosen" required >
									<option value="">Selecione ...</option>
									<option value="Avaliação Física">Avaliação Física</option>
									<option value="Reavaliação Física">Revaliação Física</option>
									<option value="Mensalidade">1ª Mensalidade</option>
								</select>
							</div>
							<div class="form-group" >
								<label>Nome: </label>
								<input type="text"  class="form-control" value="<?php echo utf8_encode($usuario['nome']);?>" disabled />
							</div>
							<div class="form-group" >
								<label>Categoria</label>
								<input type="text"  class="form-control" value="<?php echo utf8_encode($usuario['nome_categoria']);?>" disabled  />
							</div>
							<div class="form-group" >
								<label>Valor:(R$)</label>
								<input type="text" name="valor" id="valor"  class="form-control" placeholder="Informe o valor no formato 00.00" onblur='casas(this.value,this)' />
							</div>
						
						<input type="hidden" name="funcionario" value="<?php echo utf8_encode($_SESSION['usuario'])?>" />
						<input type="hidden" name="nome" value="<?php echo utf8_encode($usuario['nome'])?>" />
						<input type="hidden" name="usuario_fk" value="<?php echo utf8_encode($usuario['id_usuario'])?>" />
											
						<br/>
						<button type="submit" class="btn btn-success">Registrar</button>
						<a href="principal.php" class="btn btn-danger">Cancelar</a>
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
