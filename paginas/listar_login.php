<?php 
		session_start();
		if( $_SESSION["logado"] == true and $_SESSION["privilegio"]==1 ){
?>
<?php
require ('cabecalho.php');	

	$sql = "select id_login,nome,login_user,privilegio,ativo from login;";
	$res = mysql_query($sql,$db);
	
?>

<!-- Script de excluir -->
<script>
	function excluir(id){
		var res = confirm("Deseja realmente excluir este Login?\nEsta ação não pode ser desfeita!");
		if(res){
			location.href="apagar_generico.php?id="+id+"&campo=id_login&tbl=login&pag=listar_login.php";
		}
	}
</script>
<!-- Script de ver -->

<!--autorizar -->
	<script>
		function autorizar(id){
			var res = confirm("Deseja autorizar este login?");
			if(res){
				location.href="efetua_alt_login.php?id="+id;
			}
		}
	</script>
	<script>
		function naoautorizar(id){
			var res = confirm("Deseja desativar este login?");
			if(res){
				location.href="efetua_alt_login.php?id="+id;
			}
		}
	</script>
<!-- fim autorizar -->
<!-- editar -->
<script>
		function editar(id){
			var res = confirm("Deseja editar este login?");
			if(res){
				location.href="editar_login.php?id="+id;
			}
		}
	</script>
<!-- fim editar -->
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
            <a href="listar_login.php">Consultar</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->

	<!-- Striped table -->
	<div class="row">
		<div class="box col-md-8">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2>Logins Cadastrados</h2>
                </div>
                <div class="box-content">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Login</th>
                            <th>Privilégio</th>
                            <th>Ativo</th>
                        </tr>
                        </thead>
                        <tbody>
						<?php 
							while($linha = mysql_fetch_array ($res)):
							#####################
							if($linha['privilegio']==1){
								$privilegio = 'Administrador(a)';
							}else{
								$privilegio = utf8_decode('Secretário(a)');
							}	
							######################
							if($linha['ativo']=="sim"){
								if($linha['privilegio']==1 && $linha['id_login']==1){
									$img = '<span class="label-success label label-default" title="O login de administrador não pode ser desativado.">Ativo</span>
									<a href="javascript:editar(id=' . $linha['id_login'] . ')"><span class="label-default label">Editar</span></a>';
								}else{
									$img = '<a href="javascript:naoautorizar(id=' . $linha['id_login'] . ')"> <span class="label-success label label-default" title="Login Autorizado">Ativo</span></a>
									<a href="javascript:editar(id=' . $linha['id_login'] . ')"><span class="label-default label">Editar</span></a>
									<a href="javascript:excluir(id=' . $linha['id_login'] . ')"><span class="label-danger label">Excluir</span></a>';
								}
							}else{
								$img = '<a href="javascript:autorizar(id=' . $linha['id_login'] . ')"><span class="label-default label label-danger" title="Login não autorizado">Inativo</span></a> 
								<a href="javascript:editar(id=' . $linha['id_login'] . ')"><span class="label-default label">Editar</span></a>
								<a href="javascript:excluir(id=' . $linha['id_login'] . ')"><span class="label-danger label">Excluir</span></a>';
							}
							#######################
							
							#######################
								echo "<tr>";
								
							?>
                            <td><?php echo utf8_encode($linha['nome'])?></td>
                            <td class="center"><?php echo utf8_encode($linha['login_user'])?></td>
                            <td class="center"><?php echo utf8_encode($privilegio)?></td>
                            <td class="center"><?php echo $img;?> <a href=""></a></td>
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