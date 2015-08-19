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

<!-- script exibir painel de Relatório Frequência Individual -->
<script>
function frequencia_individual(){
		document.getElementById('painel_inicial').style.display = "none";
		document.getElementById('painel_Busca').style.display = "inline";
		document.getElementById('btn-limpar').style.display = "inline";
		document.getElementById('busca').focus();
}
</script>
<!-- Fim script exibir painel de Relatório Frequência Individual -->

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
	   ajax.open('get','buscar.php?busca='+id, true);
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
            <a href="#">Frequência</a>
        </li>
		<li>
            <a href="consultar_frequencia.php">Consultar</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<!-- Conteúdo da página - Painel inicial -->
<div class="row" id="painel_inicial" style="display:none">
    <div class="box col-md-4">
        <div class="box-inner">
            <div class="box-header well">
                <h2><i class="glyphicon glyphicon-retweet"></i> Consultar Frequência</h2>
            </div>
            <div class="box-content row">
                <div class="col-lg-12 col-md-12">
                    <h4>Selecione o tipo de consulta:</h4>
                    <div class="radio">
						<div class="radio">
						<label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" onclick="frequencia_individual();">
							Relatório Frequência Individual
						</label>
					</div>
						<label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="optionsRadios" id="optionsRadios1" value="1">
							Relatório Frequência Diária
						</label>
					</div>
					<p>
                        <a href="principal.php" class="btn btn-success">Voltar</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fim Conteúdo da página - Painel inicial-->

<!-- Conteúdo da página  - Painel de Busca -->
<div class="row" id="painel_Busca" style="display:inline">
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
                        <a href="principal.php" class="btn btn-success">Voltar</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fim Conteúdo da página - Painel de Busca-->

<?php
	endif;
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
require('rodape.php');
?>