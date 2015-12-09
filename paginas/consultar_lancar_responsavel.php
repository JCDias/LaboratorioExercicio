<?php 
		session_start();
		if( $_SESSION["logado"] == true ):

	require('cabecalho.php');
	require('../conexao.php');
		
?>
<!-- limpar campo de busca -->
<script>
function limpar(){
		document.getElementById('busca').value = "";
		document.getElementById('busca').focus();
}
</script>
<!-- Fim limpar campo de busca -->

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
   id = document.getElementById('busca').value;
   ajax = xmlhttp();
   if (ajax)
   {
	   document.getElementById('resultados').style.display = "inline";
	   ajax.open('get','buscar_para_responsavel.php?busca='+id, true);
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
			document.getElementById('resultados').innerHTML = ajax.responseText;
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
            <a href="#">Responsável</a>
        </li>
		<li>
            <a href="consultar_lancae_responsavel.php">Consultar</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->

<!-- Conteúdo da página  - Painel de Busca -->
<!--<div class="row" id="painel_Busca" style="display:inline">
    <div class="box col-md-8">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-search"></i> Pesquisar</h2>
            </div>
            <div class="box-content row">
                <div class="col-lg-12 col-md-12">
                    <h4>Digite o nome desejado:</h4>
                    <p>
					<input class="form-control" type="text" name="busca" id="busca" value="" onkeyUp="carregar()"/>
					</p>
					
					<div id="resultados" style="display:none"></div>
					
					<p align="right">
                        <a href="javascript:limpar();" class="btn btn-info" id="btn-limpar" style="display:none">Limpar</a>
                        <a href="consultar_responsavel.php" class="btn btn-success">Voltar</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>-->
<!-- Fim Conteúdo da página - Painel de Busca-->
<?php
		$sql = "select nome, id_usuario, TIMESTAMPDIFF(YEAR, data_nasc, current_date) from usuarios where TIMESTAMPDIFF(DAY, data_nasc, current_date) <=6573 and 0 = (select count(*) from responsavel where usuario_fk = id_usuario)order by nome ASC;";
		
		
		$query = mysql_query($sql);
		
		if(mysql_num_rows($query)> 0){ ?>
			<!-- Striped table -->
		<div class="row">
			<div class="box col-md-7">
				<div class="box-inner">
					<div class="box-header well" data-original-title="">
						<h2>Cadastrar Responsável</h2>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
							<thead>
							<tr>
								<th style="width:50%">Nome</th>
								<th style="width:30%">Idade</th>
								<th style="width:20%">Opção</th>
							</tr>
							</thead>
							<tbody>
							<?php while($linha = mysql_fetch_array ($query)): 
								echo "<tr>";
							?>
								<td class="center"><?php echo utf8_encode($linha['nome'])?></td>
								<td class="center"><?php echo utf8_encode($linha['TIMESTAMPDIFF(YEAR, data_nasc, current_date)'])?> anos</td>
								<td class="center"><a href="cad_responsavel.php?id=<?php echo utf8_encode($linha['id_usuario']);?>&nome=<?php echo utf8_encode($linha['nome']);?>" class="btn btn-primary">Selecionar</a></td>
							</tr>
							<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- Striped table -->
		<?php
		}else{
			echo 'Nenhum registro encontrado!';
			}?>

<?php
	endif;
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
require('rodape.php');
?>