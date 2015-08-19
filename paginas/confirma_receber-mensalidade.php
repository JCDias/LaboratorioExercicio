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
	$sql_usuario = "select data_vencimento, id_mensalidade, usuario_fk, nome, date_format(data_vencimento,'%d-%m-%Y'), valor_a_receber, desconto_a_receber, usuarios.categoria_fk from mensalidade join usuarios on usuario_fk = id_usuario where status_pagamento = 'em aberto' and id_mensalidade = $id;";
	$res_usuario = mysql_query($sql_usuario,$db);
	$usuario = mysql_fetch_array($res_usuario);
	// fim Selecionar usuário com base no id recebido pelo get
	$cat = $usuario['categoria_fk'];
	if(date('d')<=10 and ($cat==2 or $cat==3 or $cat==4 or $cat==7 or $cat==8 or $cat==9)){
		//Condições para oferecer desconto para as categorias específicas
		$desc = number_format(25, 2, '.', '');			
		$valor_a_receber = '37.50';
		// no lugar do 23 criar tabela pra salvar o valor do desconto para não mexer no código depois e fazer select para buscar esse valor
	}else{
		$valor_a_receber = $usuario['valor_a_receber'];
		$desc = $usuario['desconto_a_receber'];
	}
	$valor = $usuario['valor_a_receber'];
	//$calculo= $valor - (($valor * $desc)/100);
	//$valor_a_receber = number_format($calculo, 2, '.', '');

?>
<!-- voltar -->
<script>
function voltar(){
	location.href="todas_mensalidades_em_aberto.php";
}
</script>
<!-- voltar -->

<!-- Confirmar -->
<script>
function confirmar(){
	var conf = confirm("Confirmar recebimento de mensalidade?");
	if(conf){
		return true;
	}else{
		return false;
	}
}
</script>
<!-- Confirmar -->

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
            <a href="consultar_diaria.php">Receber</a>
        </li>
		<li>
            <a href="#">Receber Mensalidade</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<div class="row">
	<div class="box col-md-10">
		<div class="box-inner">
			<div class="box-header well" data-original-title="">
				<h2>Receber Mensalidade</h2>
			</div>
			<div class="box-content">
				<div class="control-group">
					<form action="cadastrar_mensalidade.php" method="POST">
						<div class="form-group">
								<label>Nome: </label>
								<input type="text" value="<?php echo utf8_encode($usuario['nome']);?>" class="form-control"  disabled />
						</div>
						<div class="form-inline">
							<label>Data de vencimento: </label>
							<input type="text" value="<?php echo utf8_encode($usuario["date_format(data_vencimento,'%d-%m-%Y')"]);?>" class="form-control"  disabled />
							&nbsp;&nbsp;
							<label>Data de Pagamento:</label>
							<input type="text" value="<?php echo date('d/m/Y H:i:s');?>" class="form-control"  disabled />
						</div>
						<br/>
						<div class="form-inline">
							<label>Valor: </label>
							<input type="text" value="R$ <?php echo utf8_encode($usuario['valor_a_receber']);?>" class="form-control"  disabled />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<label>Desconto: </label>
							<input type="text" value="<?php echo utf8_encode($desc);?>%" class="form-control"  disabled />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<label>Valor à Receber: </label>
							<input type="text" value="R$ <?php echo utf8_encode($valor_a_receber);?>" class="form-control"  disabled />
						</div>
						
						<!-- input hidden com os valores para o post -->
						<input type="hidden" value="<?php echo utf8_encode($usuario['usuario_fk']);?>" name="usuario_fk" />
						<input type="hidden" value="<?php echo utf8_encode($usuario['nome']);?>" name="nome" />
						<input type="hidden" value="Mensalidade" name="tipo" />
						<input type="hidden" value="<?php echo utf8_encode($valor_a_receber);?>" name="valor_recebido" />
						<input type="hidden" value="<?php echo utf8_encode($usuario['id_mensalidade']);?>" name="id_mens" />
						<input type="hidden" value="<?php echo utf8_encode($desc);?>" name="desconto" />
						<input type="hidden" value="<?php echo utf8_encode($_SESSION['usuario']);?>" name="funcionario" />
						<!-- input hidden com os valores para o post -->
						<br/>
						<button type="submit" class="btn btn-success" onclick="return confirmar();" >Registrar</button>
						<button type="button" class="btn btn-danger" onclick="voltar();">Cancelar</button>
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