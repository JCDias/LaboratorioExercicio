<?php 
		header ('Content-type: text/html; charset=UTF-8');
		setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
		
		session_start();
		if( $_SESSION["logado"] == true ):
?>
<?php
	require('cabecalho.php');
	//Selecionar preço Diária
	$sql_diaria = mysql_query("select id_preco_diaria,valor from preco_diaria;",$db);
	//Fim Selecionar preço Diária
	
	//Selecionar preço mensalidade
	$sql_men = mysql_query("select id_preco_mensalidade, horario, valor, desconto, c.nome_categoria from preco_mensalidade join categorias c on c.id_categoria = categoria_fk order by c.nome_categoria,horario;",$db);
	//Fim Selecionar preço mensalidade
	
	//Selecionar preço Avaliação
	$sql_ava = mysql_query("SELECT * FROM `preco_avaliacao` join categorias on categoria_fk = id_categoria order by nome_categoria;",$db);
	//Fim Selecionar preço Avaliação
	//Selecionar preço Avaliação
	$sql_reava = mysql_query("SELECT * FROM `preco_reavaliacao` join categorias on categoria_fk = id_categoria order by nome_categoria;",$db);
	//Fim Selecionar preço Avaliação
	
?>
<!-- editar -->
<script>
function editar_mens(id){
	var res = confirm("Deseja realmente editar este preço?");
	if(res){
		location.href="editar_mens.php?id="+id;
	}
}
</script>
<!-- Fim editar -->

<!-- editar -->
<script>
function editar_reavaliacao(id){
	var res = confirm("Deseja realmente editar este preço?");
	if(res){
		location.href="editar_preco_reavalicao.php?id="+id;
	}
}
</script>
<!-- Fim editar -->

<!-- editar -->
<script>
function editar_avaliacao(id){
	var res = confirm("Deseja realmente editar este preço?");
	if(res){
		location.href="editar_preco_avaliacao.php?id="+id;
	}
}
</script>
<!-- Fim editar -->

<!-- editar -->
<script>
function editar_diaria(id){
	var res = confirm("Deseja realmente editar este preço?");
	if(res){
		location.href="editar_diaria.php?id="+id;
	}
}
</script>
<!-- Fim editar -->

<!-- breadcrumb -->
<div>
    <ul class="breadcrumb">
        <li>
            <a href="principal.php">Início</a>
        </li>
		<li>
            <a href="#">Caixa</a>
        </li>
		<li>
            <a href="precos.php">Preços</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->
<div class="row">
    <div class="box col-md-12">
		<div class="box-inner">
			<div class="box-header well" data-original-title="">
				<h2><i class="glyphicon glyphicon-usd"></i> Preços</h2>
			</div>
		<div class="box-content row">
			<!-- Painel Mensalidade -->
			 <div class="box col-md-6">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2>Mensalidades</h2>
                </div>
                <div class="box-content">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Horario</th>
                            <th>Valor</th>
                            <th>Desconto</th>
							<?php if($_SESSION['privilegio'] == 1){
								echo '<th>Opção</th>';
							}
                            ?>  
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($mens = mysql_fetch_array($sql_men)):?>
						<tr>
                            <td><?php echo utf8_encode($mens['nome_categoria']);?></td>
                            <td class="center"><?php echo utf8_encode($mens['horario']);?>º Turno</td>
                            <td class="center">R$ <?php echo utf8_encode($mens['valor']);?></td>
                            <td class="center"><?php echo utf8_encode($mens['desconto']);?>%</td>
							<?php if($_SESSION['privilegio'] == 1){
							echo '<td class="center"><a href="javascript:editar_mens('.$mens['id_preco_mensalidade'].')" ><span class="label-default label">Editar</a></span></td>';
							}
                            ?>
                        </tr>
                        <?php endwhile;?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
       
        <!--/span-->

			<!-- Fim Painel Mensalidade -->
			
			<!-- Painel Diária -->
			
			<div class="box col-md-6">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2>Diária</h2>
                </div>
                <div class="box-content">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Valor</th>
                           <?php if($_SESSION['privilegio'] == 1){
								echo '<th>Opção</th>';
							}
                            ?> 
                        </tr>
                        </thead>
                        <tbody>
                         <?php while($diaria = mysql_fetch_array($sql_diaria)):?>
						<tr>
                            <td><?php echo utf8_encode($diaria['valor']);?></td>
                        <?php if($_SESSION['privilegio'] == 1){
							echo '<td class="center"><a href="javascript:editar_diaria('.$diaria['id_preco_diaria'].')" ><span class="label-default label">Editar</a></span></td>';
							}
                            ?>
                        </tr>
                        <?php endwhile;?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
		<!--</div>-->
        <!--/span-->

			<!-- Fim Painel Diária -->
			
			<!-- Painel Avaliação Física -->
		<!--<div class="box-content row">-->
			<div class="box col-md-6">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2>Avaliação Física</h2>
                </div>
                <div class="box-content">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Valor</th>
							<?php if($_SESSION['privilegio'] == 1){
								echo '<th>Opção</th>';
							}
                            ?>  
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($ava = mysql_fetch_array($sql_ava)):?>
						<tr>
                            <td><?php echo utf8_encode($ava['nome_categoria']);?></td>
                            <td class="center">R$ <?php echo utf8_encode($ava['valor']);?></td>
							<?php if($_SESSION['privilegio'] == 1){
							echo '<td class="center"><a href="javascript:editar_avaliacao('.$ava['id_preco_avaliacao'].')" ><span class="label-default label">Editar</a></span></td>';
							}
                            ?>
                        </tr>
                        <?php endwhile;?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
        <!--/span-->

			<!-- Fim Painel Avaliação Física -->
			
			<!-- Painel Reavaliação Física -->
			 <div class="box col-md-6">
            <div class="box-inner">
                <div class="box-header well" data-original-title="">
                    <h2>Reavaliação Física</h2>
                </div>
                <div class="box-content">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Valor</th>
							<?php if($_SESSION['privilegio'] == 1){
								echo '<th>Opção</th>';
							}
                            ?>  
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($reava = mysql_fetch_array($sql_reava)):?>
						<tr>
                            <td><?php echo utf8_encode($reava['nome_categoria']);?></td>
                            <td class="center">R$ <?php echo utf8_encode($reava['valor']);?></td>
							<?php if($_SESSION['privilegio'] == 1){
							echo '<td class="center"><a href="javascript:editar_reavaliacao('.$reava['id_preco_reavaliacao'].')" ><span class="label-default label">Editar</a></span></td>';
							}
                            ?>
                        </tr>
                        <?php endwhile;?>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
		
        <!--/span-->

			<!-- Fim Painel Reavaliação Física -->
			<?php if($_SESSION['privilegio']==1){?>
			<p align="center">
				<a href="cad_preco_mensalidade.php"><button type="button" class="btn btn-success">Mensalidade</button></a>
				<a href="cad_preco_diaria.php"><button type="button" class="btn btn-success">Diária</button></a>
				<a href="cad_preco_avaliacao.php"><button type="button" class="btn btn-success">Avaliação Física</button></a>
				<a href="cad_preco_reavaliacao.php"><button type="button" class="btn btn-success">Reavaliação Física</button></a>
			</p>
			<?php }?>
			</div>
		</div>
		</div>
    </div><!--/span-->

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