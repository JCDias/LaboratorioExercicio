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
	//$sql="select id_categoria,nome_categoria from categorias order by nome_categoria;";
	
	//$cons = mysql_query($sql,$db);
	
?>

<script>
function casas(valor,campo){
	var valor_convertido =  parseFloat(valor);
	var valor_formatado = valor_convertido.toFixed(2);
	campo.value = valor_formatado;
}
</script>

<!-- script pesquisa em tempo real -->
<script>
//função para pegar o objeto ajax do navegador
function xmlhttp()
{
	// XMLHttpRequest para firefox e outros navegadores
	if (window.XMLHttpRequest)
	{
		return new XMLHttpRequest();
	}

	// ActiveXObject para navegadores microsoft
	var versao = ['Microsoft.XMLHttp', 'Msxml2.XMLHttp', 'Msxml2.XMLHttp.6.0', 'Msxml2.XMLHttp.5.0', 'Msxml2.XMLHttp.4.0', 'Msxml2.XMLHttp.3.0','Msxml2.DOMDocument.3.0'];
	for (var i = 0; i < versao.length; i++)
	{
		try
		{
			return new ActiveXObject(versao[i]);
		}
		catch(e)
		{
			alert("Seu navegador não possui recursos para o uso do AJAX!");
		}
	} // fecha for
	return null;
} // fecha função xmlhttp

//função para fazer a requisição da página que efetuará a consulta no DB
function carregar()
{
   busca = document.getElementById('tipo').value;
   id = document.getElementById('usuario_fk').value;
   var url = 'buscar_preco_lancamento.php?busca='+busca+'&id='+id;
   ajax = xmlhttp();
   if (ajax)
   {
	   document.getElementById('resultados').style.display = "inline";
	   ajax.open('get',url, true);
	   ajax.onreadystatechange = trazconteudo; 
	   ajax.send(null);
   }
}

//função para incluir o conteúdo na pagina
function trazconteudo()
{
	if (ajax.readyState==4)
	{
		if (ajax.status==200)
		{
			document.getElementById('valor').innerHTML = ajax.responseText;
		}
	}
}
</script>
<!-- fim script pesquisa -->

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
								<select name="tipo" id="tipo" data-rel="chosen" onchange="carregar();" required>
									<option value="">Selecione ...</option>
									<option value="1">Avaliação Física</option>
									<option value="2">Reavaliação Física</option>
								</select>
							</div>
							<div id="resultados" style="display:none">
								<div class="form-group" >
									<label>Nome: </label>
									<input type="text"  class="form-control" value="<?php echo utf8_encode($usuario['nome']);?>" disabled />
								</div>
								<div class="form-group" >
									<label>Categoria</label>
									<input type="text"  class="form-control" value="<?php echo utf8_encode($usuario['nome_categoria']);?>" disabled  />
								</div>
									<label>Valor:(R$)</label>
								<div class="form-group" id="valor">
									<!-- valor aparece aki -->
								</div>
						</div>
						<input type="hidden" name="funcionario" value="<?php echo utf8_encode($_SESSION['usuario'])?>" />
						<input type="hidden" name="nome" value="<?php echo utf8_encode($usuario['nome'])?>" />
						<input type="hidden" name="usuario_fk" id="usuario_fk" value="<?php echo utf8_encode($usuario['id_usuario'])?>" />
											
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
