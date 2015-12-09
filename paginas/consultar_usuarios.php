<?php 
		header ('Content-type: text/html; charset=UTF-8');
		setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
		
		session_start();
		if( $_SESSION["logado"] == true ):
?>
<?php
	require('cabecalho.php');
	$sql = "select u.id_usuario,u.nome,u.celular, u.telefone, c.nome_categoria, u.tipo, horario from usuarios u join categorias c on u.categoria_fk = c.id_categoria order by nome;";
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
			location.href="apagar_generico.php?id="+id+"&campo=id_usuario&tbl=usuarios&pag=consultar_usuarios.php";
		}
	}
</script>
<!-- Script de ver -->
<script>
	function view(id){
		var pagina = 'relatorios/relatorio_ver_usuario.php?id='+id;
		window.open(pagina,'_blank','toolbar=no,Location=no,menubar=no');
	}
</script>
<!-- Fim Script de ver -->
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
            <a href="consultar_usuarios.php">Consultar</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-user"></i> Consultar Usuários</h2>
    </div>
    <div class="box-content">
	<?php if(mysql_num_rows($res)>0){?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
        <th style="width:25%">Nome</th>
        <th style="width:15%">Telefone</th>
        <th style="width:15%">Categoria</th>
		<th style="width:10%">Tipo</th>
        <th style="width:5%">Horário</th>
		<th>Opções</th>
        
    </tr>
    </thead>
    <tbody>
	<?php
		while($linha = mysql_fetch_array ($res)):
		echo "<tr>";
	?>
		<td><?php echo utf8_encode($linha['nome'])?></td>
		<?php if($linha['celular']=='-'){
			$tel = utf8_encode($linha['telefone']);
		}else{
			$tel = utf8_encode($linha['celular']);
		}
		?>
        <td class="center"><?php echo $tel;?></td>
        <td class="center"><?php echo utf8_encode($linha['nome_categoria'])?></td>
        <td class="center"><?php echo utf8_encode($linha['tipo'])?></td>
		<td class="center"><?php 
		if($linha['horario']!=""){
			echo utf8_encode($linha['horario']).'º Turno';}
		else{
			echo "-";
		}?></td>
        <td class="center">
            <a class="btn btn-success" href="javascript:view(id=<?php echo utf8_encode($linha['id_usuario'])?>)">
                <i class="glyphicon glyphicon-zoom-in icon-white"></i>
                Ver
            </a>
            <a class="btn btn-info" href="javascript:editar(id=<?php echo utf8_encode($linha['id_usuario'])?>)">
                <i class="glyphicon glyphicon-edit icon-white"></i>
                Editar
            </a>
            <a class="btn btn-danger" href="javascript:excluir(id=<?php echo utf8_encode($linha['id_usuario'])?>)">
                <i class="glyphicon glyphicon-trash icon-white"></i>
                Apagar
            </a>
        </td>
    </tr>
	<?php endwhile;?>
    </tbody>
    </table>
	<?php }else{
				echo 'Nenhum usuário cadastrado!<br/><br/>';
			}?>
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