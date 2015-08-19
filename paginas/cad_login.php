<?php 
		session_start();
		if( $_SESSION["logado"] == true and $_SESSION['privilegio'] ==1){
?>
<?php
	require ('cabecalho.php');
	
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
            <a href="#">Login</a>
        </li>
		<li>
            <a href="cad_login.php">Cadastrar</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<div class="row">
	<div class="box col-md-6">
		<div class="box-inner">
			<div class="box-header well" data-original-title="">
				<h2>Cadastrar Login</h2>
			</div>
			<div class="box-content">
				<div class="control-group">
					<form action="cadastrar_login.php" method="POST" name="f1">
						<div class="form-group">
							<label>Nome Completo:</label>
							<input type="text" name="nome" class="form-control" placeholder="Digite o nome completo" required />
						</div>
						<div class="form-group">
							<label>Usuário:</label>
							<input type="text" name="usuario" class="form-control" placeholder="Digite o usuário" required />
						</div>
						<div class="form-group">
							<label>Senha:</label>
							<input type="password" name="senha1" id="input_senha" class="form-control" placeholder="Digite a senha"  required/>
						</div>
						<div class="form-group">
							<label>Confirmar Senha:</label>
							<input type="password" name="senha2" class="form-control" placeholder="Digite o a senha"  required/>
						</div>
						<div class="form-group">
						<label>Tipo:</label>
								<select name="tipo" data-rel="chosen" required>
									<option value="0">Secretário(a)</option>
									<option value="1">Administrador(a)</option>
								</select>
						</div>
						<button type="submit" class="btn btn-success" onClick="return validarSenha()">Cadastrar</button>
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
	}else{
		header ('Location: principal.php');
	}
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
?>