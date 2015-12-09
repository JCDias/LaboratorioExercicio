<?php
	session_start();
	if( $_SESSION["logado"] == true ):
	
	echo '<meta charset="utf-8" />';
	require('../conexao.php');
	
	//Definindo timezone
	date_default_timezone_set('America/Sao_Paulo');
	//Fim Definindo timezone
	
	//Selecionar a data da ultima atualização
	$sql_data_mens = mysql_query("select id_data_mensalidade, date_format(data_ultima_atualizacao,'%Y-%m-%d') from data_mensalidade;",$db);
	$data_mens = mysql_fetch_array($sql_data_mens);
	$ultima = $data_mens["date_format(data_ultima_atualizacao,'%Y-%m-%d')"];
	//Fim Selecionar a data da ultima atualização
	
	//Selecionar a data atual
	$data_atual = date('Y-m-d');
	//Fim Selecionar a data atual
	
	//Converter as datas para DateTime
	$data1 = new DateTime( $data_atual);
	$data2 = new DateTime( $ultima );
	//Fim Converter as datas para DateTime
	
	//Calculando a diferença entre as datas
	$intervalo = $data1->diff( $data2 );
	//Calculando a diferença entre as datas
	
	//Convertendo o resultado para mes
	$intervalo_mes = $intervalo->m;
	//Fim Convertendo o resultado para mes
	
	//comparação entre as datas se a data da ultima atualização é menor que a data atual gera as mensalidades;
	if($intervalo_mes>=1){
		// Selecionar todos os usuários mensalistas e inserir na tabela mensalidade
		
		$sql_usuario = "select u.id_usuario, u.horario, u.dia_vencimento, u.categoria_fk, u.nome, p.valor, p.desconto from usuarios u join preco_mensalidade p on u.categoria_fk = p.categoria_fk and u.horario = p.horario where u.tipo = 'Mensalista';";
		$query_usuario = mysql_query($sql_usuario,$db);
		while($usuario = mysql_fetch_array($query_usuario)){
			// Fazer if aki para meses com 30 dias e mes de fevereiro
			switch (date('m')) 
			{
				case '01':
				case '03':
				case '05':
				case '07':
				case '08':
				case '10':
				case '12':
					if  ($usuario['dia_vencimento'] <= 31) 
					{
						// Montando a data de vencimento do mês atual
						$data_vencimento = date('Y-m').'-'.$usuario['dia_vencimento'];
						// Fim Montando a data de vencimento do mês atual
					}
					break;
				
				case '04':		
				case '06':
				case '09':
				case '11':
					if  ($usuario['dia_vencimento'] == 31) 
					{
						// Montando a data de vencimento do mês atual
						$data_vencimento = date('Y-m').'-'.($usuario['dia_vencimento']-1);
						// Fim Montando a data de vencimento do mês atual
					}else{
						// Montando a data de vencimento do mês atual
						$data_vencimento = date('Y-m').'-'.$usuario['dia_vencimento'];
						// Fim Montando a data de vencimento do mês atual
					}
					break;
				case '02':
					if  ($usuario['dia_vencimento'] == 31) 
					{
						// Montando a data de vencimento do mês atual
						$data_vencimento = date('Y-m').'-'.($usuario['dia_vencimento']-3);
						// Fim Montando a data de vencimento do mês atual
					}elseif($usuario['dia_vencimento'] == 30){
						// Montando a data de vencimento do mês atual
						$data_vencimento = date('Y-m').'-'.($usuario['dia_vencimento']-2);
						// Fim Montando a data de vencimento do mês atual
					}else{
						// Montando a data de vencimento do mês atual
						$data_vencimento = date('Y-m').'-'.$usuario['dia_vencimento'];
						// Fim Montando a data de vencimento do mês atual
					}	
					break;						
			}
			//Fim verificação dos meses
						
			//Setando as variáveis
			$id = $usuario['id_usuario'];
			$nome = $usuario['nome'];
			$categoria = $usuario['categoria_fk'];
			$horario = $usuario['horario'];
			$valor = $usuario['valor'];
			$desconto = $usuario['desconto'];
			//Fim Setando as variáveis
						
			//Montar instrução sql para inserir na tabela mensalidade;
			$sql_mensalidade = "INSERT INTO `mensalidade`(`usuario_fk`,`nome_usuario_fk`,`data_vencimento`,`categoria_fk`,`horario_usuario`,`valor_a_receber`,`desconto_a_receber`) VALUES ($id,'$nome','$data_vencimento',$categoria,$horario,$valor,$desconto)";
			
			$query_mensalidade = mysql_query($sql_mensalidade,$db);
			
			//resetando as variáveis
			$id = '';
			$nome = '';
			$categoria = '';
			$horario = '';
			$valor = '';
			$desconto = '';
			//Fim resetando as variáveis
		}
		// Fim Selecionar todos os usuários mensalistas e inserir na tabela mensalidade
		
		// Setando a data da ultima atualização
		$data_atualizacao = date('Y-m').'-01';
		
		$sql_data_mens = mysql_query("UPDATE `data_mensalidade` SET `data_ultima_atualizacao`='$data_atualizacao' where id_data_mensalidade = 1",$db);
		// Fim Setando a data da ultima atualização
		
		//Redirecionar para a página principal
		header ('Location: principal.php');
	}else{
		//Redirecionar para a página principal
		header ('Location: principal.php');
	}
	//Fim comparação entre as datas se a data da ultima atualização é menor que a data atual gera as mensalidades;
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
    -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
    <meta name="author" content="Jean Carlos">
	<title>Laboratório do Exercício</title>

    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="css/charisma-app.css" rel="stylesheet">
    <link href='bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='css/jquery.noty.css' rel='stylesheet'>
    <link href='css/noty_theme_default.css' rel='stylesheet'>
    <link href='css/elfinder.min.css' rel='stylesheet'>
    <link href='css/elfinder.theme.css' rel='stylesheet'>
    <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='css/uploadify.css' rel='stylesheet'>
    <link href='css/animate.min.css' rel='stylesheet'>

    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->

</head>
<body>
            <div class="box-content" align="center">
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
				<br/>
                <ul class="ajax-loaders">
					<li><img src="img/ajax-loaders/ajax-loader-7.gif" title="Por favor aguarde..." width="300px"></li><br/>
					<li><h4 align="center">Por favor aguarde...</h4></li>
				</ul>
            </div>
    <!--/span-->
<!-- external javascript -->

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- library for cookie management -->
<script src="js/jquery.cookie.js"></script>
<!-- calender plugin -->
<script src='bower_components/moment/min/moment.min.js'></script>
<script src='bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='js/jquery.dataTables.min.js'></script>

<!-- select or dropdown enhancer -->
<script src="bower_components/chosen/chosen.jquery.min.js"></script>
<!-- plugin for gallery image view -->
<script src="bower_components/colorbox/jquery.colorbox-min.js"></script>
<!-- notification plugin -->
<script src="js/jquery.noty.js"></script>
<!-- library for making tables responsive -->
<script src="bower_components/responsive-tables/responsive-tables.js"></script>
<!-- tour plugin -->
<script src="bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
<!-- star rating plugin -->
<script src="js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="js/charisma.js"></script>


</body>
</html>
<?php
	endif;
?>