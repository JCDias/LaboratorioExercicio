<?php 
		session_start();
		if( $_SESSION["logado"] == true ):

	require('cabecalho.php');
	require('../conexao.php');
	
	//receber id do usuario menor de idade
	$id = $_GET['id'];
	$nome = $_GET['nome'];
	//Data para cadastro
	date_default_timezone_set('America/Sao_Paulo');
	$date = date('Y-m-d H:i:s');
	$ano = date('Y') - 17; //Para se cadastrar usuário deve ter 10 anos
	
?>

<!-- Valida data-->
<script language="JavaScript">

//VALIDAÇÃO DA DATA 

function VerificaData(digData,campo) 
{
	var bissexto = 0;
	var data = digData; 
	var tam = data.length;
	if (tam == 10) 
	{
		var dia = data.substr(0,2)
		var mes = data.substr(3,2)
		var ano = data.substr(6,4)
		if ((ano > 1915)&&(ano < <?php echo $ano?>))
		{
			switch (mes) 
			{
				case '01':
				case '03':
				case '05':
				case '07':
				case '08':
				case '10':
				case '12':
					if  (dia <= 31) 
					{
						return true;
					}
					break
				
				case '04':		
				case '06':
				case '09':
				case '11':
					if  (dia <= 30) 
					{
						return true;
					}
					break
				case '02':
					/* Validando ano Bissexto / fevereiro / dia */ 
					if ((ano % 4 == 0) || (ano % 100 == 0) || (ano % 400 == 0)) 
					{ 
						bissexto = 1; 
					} 
					if ((bissexto == 1) && (dia <= 29)) 
					{ 
						return true;				 
					} 
					if ((bissexto != 1) && (dia <= 28)) 
					{ 
						return true; 
					}			
					break						
			}
		}
	}	
	alert("A data digitada é inválida!");
	campo.value = "";
	campo.focus();
	return false;
}
</script>
<!-- fim Valida data-->

<!-- valida cpf -->
<script>
function validarCPF(cpf,campo) {  
    cpf = cpf.replace(/[^\d]+/g,'');    
    if(cpf == '') {
		campo.value = "";
		campo.focus();
		return false; 
	}
    // Elimina CPFs invalidos conhecidos    
    if (cpf.length != 11 || 
        cpf == "00000000000" || 
        cpf == "11111111111" || 
        cpf == "22222222222" || 
        cpf == "33333333333" || 
        cpf == "44444444444" || 
        cpf == "55555555555" || 
        cpf == "66666666666" || 
        cpf == "77777777777" || 
        cpf == "88888888888" || 
        cpf == "99999999999"){
            campo.value = "";
			campo.focus();
			alert("CPF inválido!");
			return false;
	}			
    // Valida 1o digito 
    add = 0;    
    for (i=0; i < 9; i ++)       
        add += parseInt(cpf.charAt(i)) * (10 - i);  
        rev = 11 - (add % 11);  
        if (rev == 10 || rev == 11)     
            rev = 0;    
        if (rev != parseInt(cpf.charAt(9))){
			campo.value = "";
			campo.focus();
			alert("CPF inválido!");
            return false;       
		}
    // Valida 2o digito 
    add = 0;    
    for (i = 0; i < 10; i ++)        
        add += parseInt(cpf.charAt(i)) * (11 - i);  
    rev = 11 - (add % 11);  
    if (rev == 10 || rev == 11) 
        rev = 0;    
    if (rev != parseInt(cpf.charAt(10))){
		campo.value = "";
		campo.focus();
		alert("CPF inválido!");
        return false; 
	}
    return true;   
}
</script>
<!-- fim Valida cpf -->

<!-- formatar máscaras -->
<script src="js/jquery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $.mask.definitions['~'] = "[+-]";
		$("#telefone").mask("(99) 9999-9999");
		$("#celular").mask("(99) 9999-9999");
		$("#outro_telefone").mask("(99) 9999-9999");
        $("#data_nasc").mask("99/99/9999");
        $("#cpf").mask("999.999.999-99");
		

        $("input").blur(function() {
            $("#info").html("Unmasked value: " + $(this).mask());
        }).dblclick(function() {
            $(this).unmask();
        });
    });
	
</script>
<!-- fim formatar máscaras -->

<!-- Exibir campo outro -->
<script>
function exibirCampos(valor){
	if(valor=="Outro"){
		var obj = document.getElementById("exibir_campos");
		obj.innerHTML = '<label>Outro: </label><input type="text" name="outro" value="" required/>';
	}else{
		var obj = document.getElementById("exibir_campos");
		obj.innerHTML ='<input type="hidden" name="outro" value="" />';
	}
}
</script>
<!-- Exibir campo outro -->

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
            <a href="#">Cadastrar</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->

<div class="row">
    <div class="box col-md-7">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Cadastrar Responsável por <?php echo utf8_encode($nome);?></h2>
            </div>
            <div class="box-content">
                <div class="control-group">
					<form action="cadastrar_responsalvel.php" method="POST" name="cad_responsavel">
						<div class="form-group">
							<label>Nome Completo:</label>
							<input type="text" name="nome" class="form-control" placeholder="Digite o nome completo" required />
						</div>
						<div class="form-group" >
							<label>CPF:</label>
							<input type="text" name="cpf" id="cpf" class="form-control" placeholder="000.000.000-00." onblur="validarCPF(this.value,this);" >
						</div>
						<div class="form-group" >	
							<label>RG:</label>
							<input type="text" name="rg" class="form-control" placeholder="Digite o RG." required />
						</div>
						<div class="form-group" >
							<label>Data de nascimento:</label>
							<input type="text" name="data_nasc" id="data_nasc" class="form-control" placeholder="dd/mm/aaaa" required onBlur="VerificaData(this.value,this);"/>
							
						</div>
						<div class="form-inline" >
							<label>Telefone:</label>
							<input type="text" name="telefone" id="telefone" class="form-control" placeholder="(00) 0000-0000" />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<label>Celular:</label>
							<input type="text" name="celular" id="celular" class="form-control" placeholder="(00) 0000-0000"  />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
						<br/>
						<div class="form-group" >	
							<label>Grau de Parentesco:</label>
								<select name="grau" data-rel="chosen" onchange="exibirCampos(this.value);" required >
									<option value="">Selecione ...</option>
									<option value="Mãe">Mãe</option>
									<option value="Pai">Pai</option>
									<option value="Avô(ó)">Avô(ó)</option>
									<option value="Irmão(ã)">Irmão(ã)</option>
									<option value="Irmão(ã)">Tio(a)</option>
									<option value="Outro">Outro</option>
								</select>
						</div>
						<!-- exibir campo outro para especificar -->
						<div class="form-group" >
							<span id="exibir_campos"></span>
						</div>
						
						<input type="hidden" name="funcionario" value="<?php echo($_SESSION["usuario"]);?>" />
						<input type="hidden" name="data_cad" value="<?php echo $date?>" />
						<input type="hidden" name="usuario" value="<?php echo $id?>" />
						
						<br/>
						<button type="submit" class="btn btn-success">Cadastrar</button>
						<a href="cad_responsavel.php?id=<?php echo $id;?>&nome=<?php echo $nome;?>"><button class="btn btn-info">Limpar</button></a>
						<a href="principal.php" class="btn btn-success">Voltar</a>
					</form>
                </div>
                
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->
<!-- Rodapé -->
<?php
	endif;
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
require('rodape.php');
?>
