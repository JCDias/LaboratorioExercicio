<?php 
		session_start();
		if( $_SESSION["logado"] == true ){
?>
<?php
	require('cabecalho.php');
	
	$sql = "select u.id_usuario,u.nome,u.celular, c.nome_categoria, u.tipo, horario from usuarios u join categorias c on u.categoria_fk = c.id_categoria order by nome;";
	$res = mysql_query($sql,$db);
?>

<!-- Script de registrar-->
<script>
	function registrar(id){
		var res = confirm("Deseja registrar a presença deste usuario?");
		if(res){
			location.href="registrar_presenca.php?id="+id+"&func=<?php echo $_SESSION['usuario']?>";
		}
	}
</script>
<!-- Fim Script de registrar-->
<!-- Script de remover-->
<script>
	function remover(id){
		var res = confirm("Deseja remover a presença deste usuario?");
		if(res){
			location.href="remover_presenca.php?id="+id;
		}
	}
</script>
<!-- Fim Script de registrar-->
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
            <a href="registrar_frequencia.php">Registrar</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<div class="row">
    <div class="box col-md-10">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-user"></i> Registrar Frequência</h2>
    </div>
    <div class="box-content">
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
        <th style="width:35%">Nome</th>
        <th style="width:25%">Tipo</th>
        <th style="width:25%">Horário</th>
		<th style="width:10%">Presente</th>
		<th>Ação</th>
        
    </tr>
    </thead>
    <tbody>
	<?php
		while($linha = mysql_fetch_array ($res)):
		echo "<tr>";
	?>
		<td><?php echo utf8_encode($linha['nome'])?></td>
        <td class="center"><?php echo utf8_encode($linha['tipo'])?></td>
		<td class="center"><?php 
		if($linha['horario']!=""){
			echo utf8_encode($linha['horario']).'º Turno';}
		else{
			echo "-";
		}?></td>
		<!-- fazer if aki com resultado da consulta para exibir o certo ou errado -->
		<?php
		$id = $linha['id_usuario'];
		$sql_frequencia = "select count(*) from frequencia where date_format(data_presenca, '%d/%m/%Y') = date_format(curdate(), '%d/%m/%Y') and usuario_fk = $id";
		$resultado = mysql_query($sql_frequencia,$db);
		$frequencia = mysql_fetch_array ($resultado);
		//fazer if aki com resultado da consulta para exibir o certo ou errado 
		 if($frequencia['count(*)'] == 0){ 
			//	<!-- errado -->
			echo '
			<td class="center">
			<img align="center" src="img/errado.png" width="32px" height="32px" />
			</td>';
			
			echo '<td class="center">
            <a class="btn btn-success" title ="Lançar presença de hoje: '.date('d-m-Y').'" href="javascript:registrar(id='.$linha['id_usuario'].')">
                <i class="glyphicon glyphicon-zoom-in icon-white"></i>
                Lançar
            </a>
			</td>';
			//<!-- fim errado -->
		}else{ 
			//<!-- certo -->
			echo '<td class="center">
			<img align="center" src="img/certo.png" width="32px" title ="Presença já registrada para hoje: '.date('d-m-Y').'" height="32px" />
			</td>';
			//<!-- Fim certo -->
		
			echo '<td class="center">
            <a class="btn btn-danger" title ="Remover presença de hoje: '.date('d-m-Y').'" href="javascript:remover(id='.$linha['id_usuario'].')">
                <i class="glyphicon glyphicon-trash icon-white"></i>
                Remover
            </a>
			</td>';
		} ?>
    </tr>
	<!-- fim fazer if aki com resultado da consulta para exibir o certo ou errado -->
	<?php endwhile;?>
    </tbody>
    </table>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->


<?php
require ('rodape.php');
?>
<?php
	}
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
?>