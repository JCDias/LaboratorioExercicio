<?php 
		session_start();
		if( $_SESSION["logado"] == true):
?>
<?php
	require ('cabecalho.php');
	require ('../conexao.php');
	date_default_timezone_set('America/Sao_Paulo');
	//Recebendo id do usuário pelo get enviado pelo pesquisa
	$id = $_GET['id'];
	
	//Selecionar usuário com base no id recebido pelo get
	$sql_usuario = "select id_usuario, nome from usuarios where tipo= 'Diarista' and id_usuario = $id;";
	$res_usuario = mysql_query($sql_usuario,$db);
	$usuario = mysql_fetch_array($res_usuario);
	// fim Selecionar usuário com base no id recebido pelo get
	//Selecionar preço diária
	$sql_preco = "select valor from preco_diaria;";
	$res_preco = mysql_query($sql_preco,$db);
	$preco = mysql_fetch_array($res_preco);
	//Fim Selecionar preço diária
	
?>
<!-- voltar -->
<script>
function voltar(){
	location.href="consultar_diaria.php";
}
</script>
<!-- voltar -->

<!-- voltar -->
<script>
function confirmar(){
	var conf = confirm("Confirmar recebimento de diária?");
	if(conf){
		return true;
	}else{
		return false;
	}
}
</script>
<!-- voltar -->

<!-- breadcrumb -->
<div>
    <ul class="breadcrumb">
        <li>
            <a href="principal.php">Início</a>
        </li>
		<li>
            <a href="#">Diárias</a>
        </li>
		<li>
            <a href="consultar_diaria.php">Receber</a>
        </li>
		<li>
            <a href="#">Lançar Diária</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<div class="row">
	<div class="box col-md-4">
		<div class="box-inner">
			<div class="box-header well" data-original-title="">
				<h2>Receber diária</h2>
			</div>
			<div class="box-content">
				<div class="control-group">
					<form action="cadastrar_diaria.php" method="POST">
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
								<input type="text" value="<?php echo utf8_encode($usuario['nome']);?>" class="form-control"  disabled />
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-usd red"></i></span>
								<input type="text" value="<?php echo $preco['valor']?>" class="form-control"  disabled />
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar red"></i></span>
								<input type="text" class="form-control" value="<?php echo date('d/m/Y - H:i:s');?>" disabled />
							</div>
						</div>
						<!-- input hiden com id do usuario e funcionario -->
						<input type="hidden" value="<?php echo utf8_encode($usuario['id_usuario']);?>" name="id_usuario" />
						<input type="hidden" value="<?php echo utf8_encode($_SESSION['usuario']);?>" name="funcionario" />
						<input type="hidden" value="Diária" name="tipo" />
						<input type="hidden" value="<?php echo $preco['valor']?>" name="valor" />
						<input type="hidden" value="<?php echo utf8_encode($usuario['nome']);?>" name="nome" />
						
						<button type="submit" class="btn btn-success" onclick="return confirmar();" >Registrar</button>
						<button type="button"class="btn btn-danger" onclick="voltar();">Cancelar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
require ('rodape.php');
?>
<?php
	endif;
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
?>