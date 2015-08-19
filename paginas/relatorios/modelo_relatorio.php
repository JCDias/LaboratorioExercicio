<?php
require('FPDF/fpdf.php');
require('conexao_relatorios.php');
class PDF extends FPDF
{
// Page header
function Header()
{
	// Logo
	$this->Image('../img/LOGO.jpg',1,1,3); // 10 margem direita,4 margem superior, 30 tamanho img
	// Arial bold 15
	$this->SetFont('Times','B',15);
	// Title
	$this->Cell(0,2,'Mensalidades Pagas',0,0,'C');
	// Line break
	$this->Ln(3);
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

$pdf = new PDF('l','cm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//Criando a conexão pelo PDO
$sql = $pdo->prepare("select *, date_format(data_nasc,'%d/%m/%Y') from usuarios order by nome"); // consulta
$sql->execute();// executar
//Fim Criando a conexão pelo PDO

//Cabeçalho da tabela
// Colors, line width and bold font
	//$pdf->SetFillColor(0,0,120);
	$pdf->SetFillColor(56,176,222);
	$pdf->SetTextColor(255);
	$pdf->SetDrawColor(1,0,0);
	$pdf->SetLineWidth(.1);
	$pdf->SetFont('Times','B',12);
	//setando títulos cabeçalho
	$pdf->Cell(5,1,'Nome',1,0,'C',true);
	$pdf->Cell(5,1,'CPF',1,0,'C',true);
	$pdf->Cell(5,1,'RG',1,0,'C',true);
	$pdf->Cell(5,1,'TIPO',1,0,'C',true);
	$pdf->Cell(5,1,'Data',1,0,'C',true);
	$pdf->Ln();
	// Color and font restoration
	$pdf->SetFillColor(224,235,255);
	$pdf->SetTextColor(0);
	$pdf->SetFont('Times','',12);
//Fim Cabeçalho da tabela

//exibindo os dados
$fill = false;
foreach($sql as $resultado){
	$pdf->Cell(5,1,$resultado['nome'],'LR',0,'L',$fill);
	$pdf->Cell(5,1,$resultado['cpf'],'LR',0,'C',$fill);
	$pdf->Cell(5,1,$resultado['rg'],'LR',0,'C',$fill);
	$pdf->Cell(5,1,$resultado['tipo'],'LR',0,'C',$fill);
	$pdf->Cell(5,1,$resultado["date_format(data_nasc,'%d/%m/%Y')"],'LR',0,'C',$fill);
	$pdf->Ln();
	$pdf->Cell(5,1,$resultado['nome'],'LR',0,'L',$fill);
	$pdf->Cell(5,1,$resultado['cpf'],'LR',0,'C',$fill);
	$pdf->Cell(5,1,$resultado['rg'],'LR',0,'C',$fill);
	$pdf->Cell(5,1,$resultado['tipo'],'LR',0,'C',$fill);
	$pdf->Cell(5,1,$resultado["date_format(data_nasc,'%d/%m/%Y')"],'LR',0,'C',$fill);
	$pdf->Ln();
	$pdf->Cell(5,1,$resultado['nome'],'LR',0,'L',$fill);
	$pdf->Cell(5,1,$resultado['cpf'],'LR',0,'C',$fill);
	$pdf->Cell(5,1,$resultado['rg'],'LR',0,'C',$fill);
	$pdf->Cell(5,1,$resultado['tipo'],'LR',0,'C',$fill);
	$pdf->Cell(5,1,$resultado["date_format(data_nasc,'%d/%m/%Y')"],'LR',0,'C',$fill);
	$pdf->Ln();
	$fill = !$fill;
}
$pdf->Cell(25,0,'','T');

//Fim exibindo os dados

$pdf->Output();

?>
