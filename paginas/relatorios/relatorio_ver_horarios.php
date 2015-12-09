<?php
require('FPDF/fpdf.php');
require('conexao_relatorios.php');

//Definindo Data
setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y');
$data =  strftime("%A, %d de %B de %Y", strtotime($date));
// fim Definindo Data

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
	$this->Cell(0,2.2,utf8_decode('Quantidade de Pessoas por Horário'),1,0,'C');
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

$pdf = new PDF('P','cm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//Criando a conexão pelo PDO
$sql = $pdo->prepare("select horario from usuarios;"); // consulta
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
	$pdf->Cell(6,1,utf8_decode('Turno'),1,0,'C',true);
	$pdf->Cell(7,1,utf8_decode('Horário'),1,0,'C',true);
	$pdf->Cell(6,1,utf8_decode('Quantidade'),1,0,'C',true);
	$pdf->Ln();
	// Color and font restoration
	$pdf->SetFillColor(224,235,255);
	$pdf->SetTextColor(0);
	$pdf->SetFont('Times','',12);
//Fim Cabeçalho da tabela

//exibindo os dados
$fill = false;
$h1 = 0;
$h2 = 0;
$h3 = 0;
$h4 = 0;
foreach($sql as $resultado){
		if($resultado['horario']==1){
			$h1++;
		}elseif($resultado['horario']==2){
			$h2++;
		}elseif($resultado['horario']==3){
			$h3++;
		}elseif($resultado['horario']==4){
			$h4++;
		}
	}
	if($h1==1 || $h1==0){$p = 'pessoa';}else{$p = 'pessoas';};
	$pdf->Cell(6,1,utf8_decode('1º Turno'),'LR',0,'C',true);
	$pdf->Cell(7,1,utf8_decode('6h às 9h'),'LR',0,'C',true);
	$pdf->Cell(6,1,$h1.' '.$p,'LR',0,'C',true);
	$pdf->Ln();
	if($h2==1 || $h2==0){$p = 'pessoa';}else{$p = 'pessoas';};
	$pdf->Cell(6,1,utf8_decode('2º Turno'),'LR',0,'C',false);
	$pdf->Cell(7,1,utf8_decode('9h às 12h'),'LR',0,'C',false);
	$pdf->Cell(6,1,$h2.' '.$p,'LR',0,'C',false);
	$pdf->Ln();
	if($h3==1 || $h3==0){$p = 'pessoa';}else{$p = 'pessoas';};
	$pdf->Cell(6,1,utf8_decode('3º Turno'),'LR',0,'C',true);
	$pdf->Cell(7,1,utf8_decode('15h às 18h'),'LR',0,'C',true);
	$pdf->Cell(6,1,$h3.' '.$p,'LR',0,'C',true);
	$pdf->Ln();
	if($h4==1 || $h4==0){$p = 'pessoa';}else{$p = 'pessoas';};
	$pdf->Cell(6,1,utf8_decode('4º Turno'),'LR',0,'C',false);
	$pdf->Cell(7,1,utf8_decode('18h às 21h'),'LR',0,'C',false);
	$pdf->Cell(6,1,$h4.' '.$p,'LR',0,'C',false);
	$pdf->Ln();
	$pdf->Cell(19,0,'','T');
//Fim exibindo os dados
$nome_relatorio = 'Relatório de Horários '.date('d-m-Y').'.pdf';
$pdf->Output($nome_relatorio,'I');

?>
