<?php 
		header ('Content-type: text/html; charset=UTF-8');
		setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
		
		session_start();
		if( $_SESSION["logado"] == true ):
?>
<?php
	require('cabecalho.php');
	
	$sql = "select u.id_usuario,u.nome,u.celular, c.nome_categoria, u.tipo, horario from usuarios u join categorias c on u.categoria_fk = c.id_categoria where tipo= 'Diarista' order by nome ASC;";
	$res = mysql_query($sql,$db);
?>
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
    </ul>
</div>
<!-- Fim breadcrumb -->
<div class="row">
    <div class="box col-md-10">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-user"></i> Consultar Usuários</h2>
    </div>
    <div class="box-content">
	<?php if(mysql_num_rows($res)>0){?>
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
        <th style="width:35%">Nome</th>
        <th style="width:25%">Telefone</th>
        <th style="width:15%">Categoria</th>
		<th style="width:15%">Tipo</th>
		<th>Opção</th>
        
    </tr>
    </thead>
    <tbody>
	<?php
		while($linha = mysql_fetch_array ($res)):
		echo "<tr>";
	?>
		<td><?php echo utf8_encode($linha['nome'])?></td>
        <td class="center"><?php echo utf8_encode($linha['celular'])?></td>
        <td class="center"><?php echo utf8_encode($linha['nome_categoria'])?></td>
        <td class="center"><?php echo utf8_encode($linha['tipo'])?></td>
        <td class="center">
            <a class="btn btn-success" href="lancar_diaria.php?id=<?php echo utf8_encode($linha['id_usuario'])?>">
                Receber
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