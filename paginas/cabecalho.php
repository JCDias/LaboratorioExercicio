<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Laboratório do Exercício</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistema Laboratório do Exercício - Unimontes Campus januária">
    <meta name="author" content="Jean Carlos">
	<!-- icone na barra de titulo -->
	<link rel="shortcut icon" href="img/logo.ico" height="16px" width="16px"> 
	<meta http-equiv="refresh" content="1200;url=logout.php" />

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
    <!--<link rel="shortcut icon" href="img/favicon.ico">-->
<?php
	require('../conexao.php');
?>
<!-- Script de ver -->
<script>
	function relatorio(){
		var pagina = 'relatorios/relatorio_ver_mensalidades_canceladas.php';
		window.open(pagina,'_blank','toolbar=no,Location=no,menubar=no');
	}
</script>
<!-- Fim Script de ver -->	
<!-- sair-->
<script>
function sair() {
    var conf = confirm('Tem certeza que deseja sair?');
	
    if (conf){
        location.href = 'logout.php'
        }  
}
</script>
<!--sair-->
</head>

<body>
    <!-- topbar starts -->
    <div class="navbar navbar-default" role="navigation">

        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
           

            <!-- user dropdown starts -->
            <div class="btn-group pull-right">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> <?php echo $_SESSION["usuario"] ?></span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="editar_login.php?id=<?php echo $_SESSION["id"];?>">Editar Perfil</a></li>
                  <li class="divider"></li>
                    <li><a href="javascript:sair();">Sair</a></li>
                </ul>
            </div>
            <!-- user dropdown ends -->

            <!-- theme selector starts 
            <div class="btn-group pull-right theme-container animated tada">
                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-tint"></i><span
                        class="hidden-sm hidden-xs"> Change Theme / Skin</span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" id="themes">
                    <li><a data-value="classic" href="#"><i class="whitespace"></i> Classic</a></li>
                    <li><a data-value="cerulean" href="#"><i class="whitespace"></i> Cerulean</a></li>
                    <li><a data-value="cyborg" href="#"><i class="whitespace"></i> Cyborg</a></li>
                    <li><a data-value="simplex" href="#"><i class="whitespace"></i> Simplex</a></li>
                    <li><a data-value="darkly" href="#"><i class="whitespace"></i> Darkly</a></li>
                    <li><a data-value="lumen" href="#"><i class="whitespace"></i> Lumen</a></li>
                    <li><a data-value="slate" href="#"><i class="whitespace"></i> Slate</a></li>
                    <li><a data-value="spacelab" href="#"><i class="whitespace"></i> Spacelab</a></li>
                    <li><a data-value="united" href="#"><i class="whitespace"></i> United</a></li>
                </ul>
            </div>
            <!-- theme selector ends -->

            <ul class="collapse navbar-collapse nav navbar-nav top-menu">
                <li><a href="principal.php"><i class="glyphicon glyphicon-home"></i> <b>Laboratório do Exercício</b></a></li>
            </ul>

        </div>
    </div>
    <!-- topbar ends -->
<div class="ch-container">
    <div class="row">
        
        <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">

                    </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header">Menu</li>
                        <li><a class="ajax-link" href="principal.php"><i class="glyphicon glyphicon-home"></i><span> Início</span></a>
                        </li>
                        <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-user"></i><span> Usuários</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="cad_usuario.php"><i class="glyphicon glyphicon-edit"></i><span> Cadastrar</span></a></li>
                                <li><a href="consultar_usuarios.php"><i class="glyphicon glyphicon-search"></i><span> Consultar</span></a></li>
								<li><a href="ver_aniversariantes.php"><i class="glyphicon glyphicon-calendar"></i></span> Aniversariantes</span></a></li>
								<!--<li><a href="#">Termo de responsabilidade</a></li>-->
                            </ul>
                        </li>
						<li><a class="ajax-link" href="consultar_responsavel.php"><i class="glyphicon glyphicon-flag"></i><span> Responsável</span></a>
						 <li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-retweet"></i><span> Frequência</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="registrar_frequencia.php"><i class="glyphicon glyphicon-edit"></i><span> Registrar</span></a></li>
                                <li><a href="consultar_frequencia.php"><i class="glyphicon glyphicon-search"></i><span> Consultar</span></a></li>
								<!--<li><a href="#">Relatórios</a></li>-->
                            </ul>
                        </li>
						<!-- submenu diárias -->
								<li class="accordion">
									<a href="#"><i class="glyphicon glyphicon-tags"></i><span>  Diárias</span></a>
									<ul class="nav nav-pills nav-stacked">
										<li><a href="consultar_diaria.php"><i class="glyphicon glyphicon-edit"></i><span> Receber</span></a></li>
										<li><a href="consultar_ver_diaria.php"><i class="glyphicon glyphicon-search"></i><span> Consultar</span></a></li>
									</ul>
								</li>
								<!-- Fim submenu diárias -->
								<!-- submenu Mensalidades -->
								<li class="accordion">
									<a href="#"><i class="glyphicon glyphicon-credit-card"></i><span> Mensalidades</span></a>
									<ul class="nav nav-pills nav-stacked">
										<li><a href="mensalidades_em_aberto.php"><i class="glyphicon glyphicon-exclamation-sign"></i><span> Vencidas</span></a></li>
										<!--
										<li><a href="#"><i class="glyphicon glyphicon-repeat"></i><span> Gerar</span></a></li>
										-->
										<li><a href="consultar_mensalidade.php"><i class="glyphicon glyphicon-check"></i><span> Pagas</span></a></li>
										<li><a href="todas_mensalidades_em_aberto.php"><i class="glyphicon glyphicon-folder-open"></i><span> Abertas</span></a></li>
										<li><a href="javascript:relatorio();"><i class="glyphicon glyphicon-ban-circle"></i><span> Canceladas</span></a></li>
									</ul>
								</li>
								<!-- Fim submenu Mensalidades -->
						<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-gift"></i><span> Caixa</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <?php if($_SESSION["privilegio"]==0):?>
									<li><a href="javascript:window.open('img/precos2015.pdf','_blank','toolbar=no,Location=no,menubar=no');location.href = document.URL;"><i class="glyphicon glyphicon-usd"></i><span> Preços</span></a></li>
								<?php endif; ?>
								<?php if($_SESSION["privilegio"]==1):?>
									<li><a href="precos.php"><i class="glyphicon glyphicon-usd"></i><span> Preços</span></a></li>
								<?php endif; ?>
								<li><a href="consultar_lancamento.php"><i class="glyphicon glyphicon-share-alt"></i><span> Lançamento</span></a></li>
								
                            </ul>
                        </li>
						<!-- Menu relatórios -->
						<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-stats"></i><span> Relatórios</span></a>
                            <ul class="nav nav-pills nav-stacked">
								<li><a href="selecionar_data_rel_diario.php"><i class="glyphicon glyphicon-file"></i><span> Diário</span></a></li>
								<li><a href="selecionar_data_rel_semanal.php"><i class="glyphicon glyphicon-tasks"></i><span> Semanal</span></a></li>
								<li><a href="javascript:window.open('relatorios/relatorio_todos_usuarios.php','_blank','toolbar=no,Location=no,menubar=no');location.href = document.URL;"><i class="glyphicon glyphicon-list-alt"></i><span> Usuários</span></a></li>
								<li><a href="selecionar_data_rel_frequencia.php"><i class="glyphicon glyphicon-tasks"></i><span> Frequência</span></a></li>
                            </ul>
                        </li>
						<!-- Menu relatórios -->
						
						<!-- exibir este menu somente se for administrador -->
						<?php if($_SESSION["privilegio"]==1):?>
						<li class="accordion">
                            <a href="#"><i class="glyphicon glyphicon-lock"></i><span> Login</span></a>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="cad_login.php"><i class="glyphicon glyphicon-edit"></i><span> Cadastrar</span></a></li>
								<li><a href="listar_login.php"><i class="glyphicon glyphicon-search"></i><span> Consultar</span></a></li>
                            </ul>
                        </li>
						<?php endif; ?>
						<!-- Fim exibir este menu somente se for administrador -->
						<li><a class="ajax-link" href="editar_login.php?id=<?php echo $_SESSION["id"];?>"><i class="glyphicon glyphicon-edit"></i><span> Editar Perfil</span></a>
						<li><a class="ajax-link" href="javascript:sair();"><span><i class="glyphicon glyphicon-off"></i> Sair</span></a>
                    </ul>
                </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->

        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <div>
    
</div>