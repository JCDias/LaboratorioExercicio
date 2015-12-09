<?php
require('FPDF/fpdf.php');
require('conexao_relatorios.php');

//Definindo Data
setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y');
$data =  strftime("%A, %d de %B de %Y", strtotime($date));
$hora = date('H:i:s');
class PDF extends FPDF
{
// Page header
function Header()
{
	// Logo
	$this->Image('../img/LOGO.jpg',1.2,1.2,2.6); // 10 margem direita,4 margem superior, 30 tamanho img
	// Arial bold 15
	$this->SetFont('Times','B',15);
	$this->SetDrawColor(1,0,0);
	$this->SetLineWidth(.1);
	// Title
	$this->Cell(0,2.2,utf8_decode('RELATÓRIO DE USUÁRIOS INATIVOS'),0,0,'C');
	// Line break
	$this->Ln(2);
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-6);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
}
}
// Instanciation of inherited class

$pdf = new PDF('p','cm','A4');
$pdf->AliasNbPages();

//Criando a conexão pelo PDO
$sql = $pdo->prepare("select * , date_format(data_cadastro, '%d/%m/%Y - %H:%i:%s'),date_format(data_nasc, '%d/%m/%Y'), c.nome_categoria from usuarios join categorias c on categoria_fk = c.id_categoria where tipo='Inativo' order by nome"); // consulta
$sql->execute();// executar
//Fim Criando a conexão pelo PDO

// Colors, line width and bold font
	$pdf->SetFillColor(0,0,120);
	$pdf->SetFillColor(56,176,222);
	$pdf->SetTextColor(0);
	$pdf->SetDrawColor(1,0,0);
	$pdf->SetLineWidth(.1);
	$pdf->SetFont('Times','B',12);
//exibindo os dados

//Inserir hífen
$hifen = '-' ;
//Fim Inserir hífen
$L1 = 5;
$L2 = 14;
$total = 0;
foreach($sql as $resultado){
	$pdf->AddPage();
	$total++;
	$pdf->Cell($L1,1,utf8_decode('Matrícula: '),1,0,'R',true);
	$pdf->Cell($L2,1,str_pad($resultado['id_usuario'],"4","0", STR_PAD_LEFT),1,0,'L');
	$pdf->Ln();
	$pdf->Cell($L1,1,'Nome: ',1,0,'R',true);
	$pdf->Cell($L2,1,ucfirst(utf8_decode(utf8_encode($resultado['nome']))),1,0,'L');
	$pdf->Ln();
	$pdf->Cell($L1,1,'CPF: ',1,0,'R',true);
	$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado['cpf'])),1,0,'L');
	$pdf->Ln();
	$pdf->Cell($L1,1,'RG: ',1,0,'R',true);
	$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado['rg'])),1,0,'L');
	$pdf->Ln();
	$pdf->Cell($L1,1,'Data de Nascimento: ',1,0,'R',true);
	$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado["date_format(data_nasc, '%d/%m/%Y')"])),1,0,'L');
	$pdf->Ln();
	$pdf->Cell($L1,1,'Sexo: ',1,0,'R',true);
	$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado['sexo'])),1,0,'L');
	$pdf->Ln();
	$pdf->Cell($L1,1,utf8_decode('Endereço: '),1,0,'R',true);
	$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado['rua'])).', '
	.utf8_decode('nº '.utf8_encode($resultado['numero'])).', '
	.utf8_decode(utf8_encode($resultado['complemento'])).', '
	.utf8_decode(utf8_encode($resultado['bairro'])).', '
	.utf8_decode(utf8_encode($resultado['cidade']))
	,1,0,'L');
	$pdf->Ln();
	$pdf->Cell($L1,1,'Telefone: ',1,0,'R',true);
	$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado['telefone'])),1,0,'L');
	$pdf->Ln();
	$pdf->Cell($L1,1,'Celular: ',1,0,'R',true);
	$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado['celular'])),1,0,'L');
	$pdf->Ln();
	$pdf->Cell($L1,1,'Outro telefone: ',1,0,'R',true);
	$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado['outro_telefone'])),1,0,'L');
	$pdf->Ln();
	$pdf->Cell($L1,1,'E-mail: ',1,0,'R',true);
	if($resultado['email']!=""){
		$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado['email'])),1,0,'L');
	}else{
		$pdf->Cell($L2,1,'-',1,0,'L');
	}
	$pdf->Ln();
	$pdf->Cell($L1,1,'Categoria: ',1,0,'R',true);
	$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado['nome_categoria'])),1,0,'L');
	$pdf->Ln();
	$pdf->Cell($L1,1,'Tipo: ',1,0,'R',true);
	
	$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado['tipo'])),1,0,'L');
	$pdf->Ln();
	if($resultado['tipo']=='Mensalista'){
		$pdf->Cell($L1,1,'Dia de vencimento: ',1,0,'R',true);
		$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado['dia_vencimento'])),1,0,'L');
		$pdf->Ln();
		$pdf->Cell($L1,1,utf8_decode('Horário: '),1,0,'R',true);
		$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado['horario']).'º Turno'),1,0,'L');
		$pdf->Ln();
	}
	if($resultado['tipo']=='Inativo'){
		$pdf->Cell($L1,1,'Inativo desde: ',1,0,'R',true);
	}else{
		$pdf->Cell($L1,1,'Data de Cadastro: ',1,0,'R',true);
	}
	$pdf->Cell($L2,1,utf8_decode(utf8_encode($resultado["date_format(data_cadastro, '%d/%m/%Y - %H:%i:%s')"])),1,0,'L');
	$pdf->Ln();
	$pdf->Cell($L1,1,utf8_decode('Funcionário: '),1,0,'R',true);
	$pdf->Cell($L2,1,utf8_decode($resultado["funcionario"]),1,0,'L');
	$pdf->Ln();
}
	$pdf->Ln();
	$pdf->Ln();
	$pdf->Cell(0,1,utf8_decode('Estatísticas '),1,0,'C',false);
	$pdf->Ln();
	$pdf->Cell(7,1,utf8_decode('Total de Usuários Inativos: '),1,0,'R',true);
	$pdf->Cell(12,1,' '.$total,1,0,'L');
	$pdf->Ln();
	$pdf->Cell(0,1,utf8_decode(utf8_encode(ucfirst($data)).' '.$hifen.' '.$hora),1,0,'C',false);
//Fim exibindo os dados
$pdf->Output();

?>
