<?php 
		header ('Content-type: text/html; charset=UTF-8');
		setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
		
		session_start();
		if( $_SESSION["logado"] == true ):
?>
<?php
	require('cabecalho.php');
	
	$sql = "select u.nome, r.id_responsavel, r.nome_responsavel, r.telefone from usuarios u join responsavel r on u.id_usuario = r.usuario_fk order by r.nome_responsavel;";
	
	$res = mysql_query($sql,$db);
?>

<!-- Script de editar-->
<script>
	function editar(id){
		var res = confirm("Deseja editar este usuario?");
		if(res){
			location.href="editar_usuario.php?id="+id;
		}
	}
</script>
<!-- Fim Script de editar-->
<!-- Script de excluir -->
<script>
	function excluir(id){
		var res = confirm("Deseja realmente excluir este usuario?\nEsta ação não pode ser desfeita!");
		if(res){
			location.href="apagar_generico.php?id="+id+"&campo=id_responsavel&tbl=responsavel&pag=consultar_responsavel.php";
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
            <a href="#">Usuários</a>
        </li>
		<li>
            <a href="consultar_responsavel.php">Consultar</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-user"></i> Consultar Responsáveis</h2>
    </div>
    <div class="box-content">
	<p align="right"><a class="btn btn-success" href="consultar_lancar_responsavel.php"><i class="glyphicon glyphicon-plus-sign icon-white"></i> Novo</a></p>
	<?php if(mysql_num_rows($res)>0){?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
        <th style="width:25%">Nome Responsável</th>
        <th style="width:15%">Nome do Usuário</th>
        <th style="width:15%">Telefone</th>
        <th style="width:15%">Opção</th>
        
    </tr>
    </thead>
    <tbody>
	<?php
		while($linha = mysql_fetch_array ($res)):
		echo "<tr>";
	?>
		<td><?php echo utf8_encode($linha['nome_responsavel'])?></td>
        <td class="center"><?php echo utf8_encode($linha['nome'])?></td>
        <td class="center"><?php echo utf8_encode($linha['telefone'])?></td>
		</td>
        <td class="center">
            <a class="btn btn-danger" href="javascript:excluir(id=<?php echo utf8_encode($linha['id_responsavel'])?>)">
                <i class="glyphicon glyphicon-trash icon-white"></i>
                Apagar
            </a>
        </td>
    </tr>
	<?php endwhile;?>
    </tbody>
    </table>
	<?php }?>
    </div>
    </div>
    </div>
    <!--/span-->
    </div><!--/row-->


<?php
require ('rodape.php');
?>
<?php
	endif;
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
?>