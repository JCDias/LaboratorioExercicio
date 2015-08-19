<?php 
		session_start();
		if( $_SESSION["logado"] == true):
?>
<?php
	require ('cabecalho.php');
	//recebendo id pelo GET
	$id = $_GET['id'];

	$sql="select * from login where id_login = $id";
	
	$cons= mysql_query ($sql,$db);
	
	$linha = mysql_fetch_array ($cons);
	if($linha['privilegio']==1){
		$tipo = "Administrador(a)";
	}else{
		$tipo = "Secretário(a)";
	}

?>
<!-- validar senhas iguais -->
<script language="javascript">
function validarSenha(){
	senha1 = document.f1.senha1.value;
	senha2 = document.f1.senha2.value;
 
	if (senha1 != senha2){
		alert("SENHAS DIFERENTES");
		document.f1.senha1.value='';
		document.f1.senha2.value='';
		document.f1.senha1.focus();
		return false;
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
            <a href="editar_login.php">Editar Perfil</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<div class="row">
	<div class="box col-md-6">
		<div class="box-inner">
			<div class="box-header well" data-original-title="">
				<h2>Editar Login</h2>
			</div>
			<div class="box-content">
				<div class="control-group">
					<form action="efetua_edicao_login.php" method="POST" name="f1">
						<div class="form-group">
							<label>Nome Completo:</label>
							<input type="text" name="nome" value="<?php echo utf8_encode($linha['nome']);?>" class="form-control" placeholder="Digite o nome completo" required />
						</div>
						<div class="form-group">
							<label>Usuário:</label>
							<input type="text" name="usuario" value="<?php echo $linha['login_user']?>" class="form-control" placeholder="Digite o usuário" required />
						</div>
						<div class="form-group">
							<label>Senha:</label>
							<input type="password" name="senha1" id="input_senha" class="form-control" placeholder="Digite a senha"  />
						</div>
						<div class="form-group">
							<label>Confirmar Senha:</label>
							<input type="password" name="senha2" class="form-control" placeholder="Digite o a senha"  />
						</div>
						<input type="hidden" name="id" value="<?php echo $linha['id_login']?>" />
						<button type="submit" class="btn btn-success" onClick="return validarSenha()">Salvar</button>
						<button type="reset" class="btn btn-info" >Limpar</button>
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