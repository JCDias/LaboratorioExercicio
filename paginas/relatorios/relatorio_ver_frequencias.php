<?php
require('FPDF/fpdf.php');
require('conexao_relatorios.php');

//Definindo Data
setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y');
$data =  strftime("%A, %d de %B de %Y", strtotime($date));
// fim Definindo Data

$inicio = $_GET['inicio'];
$fim = $_GET['fim'];

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
	$this->Cell(0,2.2,utf8_decode('RELATÓRIO DE FREQUÊNCIAS'),1,0,'C');
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
$pdf->AddPage();

//Criando a conexão pelo PDO
$sql = $pdo->prepare("select u.nome,date_format(data_presenca,'%d/%m/%Y'),date_format(data_presenca,'%H:%i:%s'), f.funcionario from usuarios u join frequencia f on usuario_fk = id_usuario where date_format(data_presenca,'%d-%m-%Y')>= '$inicio' and date_format(data_presenca,'%d-%m/-Y') <= '$fim'order by u.nome;"); // consulta
$sql->execute();// executar
//Fim Criando a conexão pelo PDO

//Inserir hífen
$hifen = '-' ;
//Fim Inserir hífen

//Cabeçalho da tabela
// Colors, line width and bold font
	$pdf->SetFillColor(0,0,120);
	$pdf->SetFillColor(56,176,222);
	$pdf->SetTextColor(0);
	$pdf->SetDrawColor(1,0,0);
	$pdf->SetLineWidth(.1);
	$pdf->SetFont('Times','B',12);
	//setando títulos cabeçalho
	//$pdf->Cell(0,1,utf8_decode('RELATÓRIO DE ENTRADAS DIÁRIAS'),1,1,'C',true);
	$pdf->Cell(0,1,utf8_decode('LABORATÓRIO DO EXERCÍCIO - CURSO DE EDUCAÇÃO FÍSICA'),1,1,'C',true);
	$pdf->Cell(0,1,utf8_decode('UNIMONTES '.$hifen.' CAMPUS AVANÇADO DE JANUÁRIA'),1,1,'C',false);
	$pdf->Cell(0,1,utf8_decode('Período: '.$inicio.' à '.$fim),1,1,'C',true);
	$pdf->Cell(7,1,'Cliente',1,0,'C',true);
	$pdf->Cell(3,1,'Data',1,0,'C',true);
	$pdf->Cell(3,1,utf8_decode('Horário'),1,0,'C',true);
	$pdf->Cell(6,1,utf8_decode('Funcionário'),1,0,'C',true);
	$pdf->Ln();
	// Color and font restoration
	$pdf->SetFillColor(224,235,255);
	$pdf->SetTextColor(0);
	$pdf->SetFont('Times','',12);
//Fim Cabeçalho da tabela

//exibindo os dados
$fill = false;
foreach($sql as $resultado){
	$pdf->Cell(7,1,utf8_decode(utf8_encode($resultado["nome"])),'LR',0,'L',$fill);
	$pdf->Cell(3,1,$resultado["date_format(data_presenca,'%d/%m/%Y')"],'LR',0,'C',$fill);
	$pdf->Cell(3,1,$resultado["date_format(data_presenca,'%H:%i:%s')"],'LR',0,'C',$fill);
	$pdf->Cell(6,1,utf8_decode(utf8_encode($resultado['funcionario'])),'LR',0,'L',$fill);
	$pdf->Ln();
	$fill = !$fill;
	}
	$pdf->Cell(19,0,'','T');
//Fim exibindo os dados

$pdf->Output();

?>
