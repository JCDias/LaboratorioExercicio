﻿<?php 
		session_start();
		if( $_SESSION["logado"] == true ):

	require('cabecalho.php');
	require('../conexao.php');
	
	//Data para cadastro
	date_default_timezone_set('America/Sao_Paulo');
	$date = date('Y-m-d H:i:s');
	$ano = date('Y') - 5; //Para se cadastrar usuário deve ter 10 anos
	
?>

<script>
function Vemail(email,campo){
	if(email.indexOf(('@' && '.'),0)== -1){
		alert("E-mail inválido.");
		campo.value = "";
		campo.focus();
		return false;
	}
}
 </script>
<!-- fim valida email --> 
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

<!-- Receber somente Números -->
<script language='JavaScript'>
function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}
</script>
<!-- Fim Receber somente números -->

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

<!-- Exibir horario e tipo vencimento -->
<script>
function exibirCampos(valor){
	if(valor=="Mensalista"){
		var obj = document.getElementById("exibir_campos");
		obj.innerHTML = '<label>Dia Vencimento:</label><select name="dia" data-rel="chosen" required>					<option value="">Selecione ...</option><?php for($d=1;$d<=31;$d++){if($d<10){$d = "0".$d;}echo ('<option value="'.$d.'">'.$d.'</option>');} ?></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label>Horario:</label><select name="horario" data-rel="chosen" required><option value="">Selecione ...</option><option value="1">1º Turno</option><option value="2">2º Turno</option><option value="3">3º Turno</option><option value="4">4º Turno</option></select>';
	}else{
		var obj = document.getElementById("exibir_campos");
		obj.innerHTML ='<input type="hidden" name="horario" value="" /><input type="hidden" name="dia" value="" />';
	}
}
</script>
<!-- Exibir horario e tipo vencimento -->

<!-- selecionar categoria -->
<?php
	
	//Selecionar categoria para combo box
	$sql="select id_categoria,nome_categoria from categorias order by nome_categoria;";
	
	$cons = mysql_query($sql,$db);
	if(mysql_num_rows($cons)> 0) :
?>
<!-- fim selecionar categoria -->

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
            <a href="cad_usuario.php">Cadastrar</a>
        </li>
    </ul>
</div>
<!-- Fim breadcrumb -->

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-edit"></i> Cadastrar Usuário</h2>
            </div>
            <div class="box-content">
                <div class="control-group">
					<form action="cadastrar_usuario.php" method="POST" name="cad_usuario">
						<div class="form-group">
							<label>Nome Completo:</label>
							<input type="text" name="nome" class="form-control" placeholder="Digite o nome completo" required />
						</div>
						<div class="form-inline" >
							<label>CPF:</label>
							<input type="text" name="cpf" id="cpf" class="form-control" placeholder="000.000.000-00." onblur="validarCPF(this.value,this);" />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<label>RG:</label>
							<input type="text" name="rg" class="form-control" placeholder="Digite o RG." />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<label>Data de nascimento:</label>
							<input type="text" name="data_nasc" id="data_nasc" class="form-control" placeholder="dd/mm/aaaa" required onBlur="VerificaData(this.value,this);"/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
								<label>Sexo:</label>
								<select name="sexo" data-rel="chosen" required>
									<option value="">Selecione ...</option>
									<option value="Masculino">Masculino</option>
									<option value="Feminino">Feminino</option>
								</select>
						</div>
						<br/>
						<div class="form-group">
							<label>Rua</label>
							<input type="text" name="rua" class="form-control" placeholder="Digite o nome noma da rua" required />
						</div>
						<div class="form-inline" >
							<label>Número:</label>
							<input type="text" name="numero" class="form-control" placeholder="Digite o número" onkeypress='return SomenteNumero(event)' maxlength="8" >
							&nbsp;&nbsp;&nbsp;&nbsp;
							
							<label>Complemento:</label>
							<input type="text" name="complemento" class="form-control" placeholder="Digite o complemento"/>
							&nbsp;&nbsp;&nbsp;&nbsp;
							
							<label>Bairro:</label>
							<input type="text" name="bairro" class="form-control" placeholder="Digite o bairro"  />
							&nbsp;
							
							<label>Cidade:</label>
							<input type="text" name="cidade" value="Januária-MG" class="form-control" placeholder="Digite a cidade" required onclick="this.value=''"/>
						</div>
						<br/>
						<div class="form-inline" >
							<label>Telefone:</label>
							<input type="text" name="telefone" id="telefone" class="form-control" placeholder="(00) 0000-0000" />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<label>Celular:</label>
							<input type="text" name="celular" id="celular" class="form-control" placeholder="(00) 0000-0000"  />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
							<label>Outro Telefone:</label>
							<input type="text" name="outro_telefone" id="outro_telefone" class="form-control" placeholder="(00) 0000-0000"/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
						<br/>
						<div class="form-group">
							<label>Email:</label>
							<input type="email" name="email" class="form-control" placeholder="Digite o email" onBlur="Vemail(this.value,this);" />
						</div>
						<div class="form-inline" >
							<label>Categoria:</label>
								<select name="categoria" data-rel="chosen" required >
									<option value="">Selecione ...</option>
									<?php while($linha = mysql_fetch_array ($cons)):?>
										<option value="<?php echo $linha['id_categoria']?>"><?php echo utf8_encode($linha['nome_categoria'])?></option>
									<?php endwhile; ?>
								</select>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							
								<label>Tipo:</label>
								<select name="tipo" data-rel="chosen" required onchange="exibirCampos(this.value);">
									<option value="">Selecione ...</option>
									<option value="Mensalista">Mensalista</option>
									<option value="Diarista">Diarista</option>
									<option value="Outro">Outro</option>
									<option value="Monitor(a)">Monitor(a)</option>
								</select>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<!-- local destinado  exibir os campos dia e horario -->
								<span id="exibir_campos"></span>
						</div>
						<input type="hidden" name="funcionario" value="<?php echo($_SESSION["usuario"]);?>" />
						<input type="hidden" name="data_cad" value="<?php echo $date?>" />
						
						<br/>
						<button type="submit" class="btn btn-success">Cadastrar</button>
						<a href="cad_usuario.php"><button class="btn btn-info">Limpar</button></a>
						<a href="principal.php"><button class="btn btn-danger">Cancelar</button></a>
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
	endif;
if( $_SESSION["logado"] == false){
	header ('Location: logout.php');
	}
require('rodape.php');
?>
