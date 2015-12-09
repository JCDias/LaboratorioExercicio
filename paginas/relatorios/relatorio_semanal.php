<?php
require('FPDF/fpdf.php');
require('conexao_relatorios.php');
require('../../conexao.php');

//Definindo Data
setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$date = date('d-m-Y');
$data =  strftime("%A, %d de %B de %Y", strtotime($date));
// fim Definindo Data

$turno = $_GET['turno'];
$inicio = $_GET['inicio'];
$fim = $_GET['fim'];


if($turno == 1){
	$h1 = '05:00:00';
	$h2 = '13:59:59';
	$nome_turno = 'Turno: Matutino';
}elseif($turno == 2){
	$h1 = '14:00:00';
	$h2 = '22:00:00';
	$nome_turno = 'Turnos: Vespertino e Noturno';
}else{
	$h1 = '05:00:00';
	$h2 = '22:00:00';
	$nome_turno = 'Turnos: Matutino,Vespertino e Noturno';
}

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
	$this->Cell(0,2.2,utf8_decode('RELATÓRIO DE ENTRADAS SEMANAIS'),1,0,'C');
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

$pdf = new PDF('L','cm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//Criando a conexão pelo PDO
$sql = $pdo->prepare("select caixa.tipo, caixa.funcionario, valor_recebido, u.nome, date_format(data_recebimento,'%d/%m/%Y %H:%i:%s') 
from caixa join usuarios u on u.id_usuario = usuario_fk 
where date_format(data_recebimento,'%H:%i:%s') > '$h1' and date_format(data_recebimento,'%H:%i:%s') < '$h2' and date_format(data_recebimento,'%d-%m-%Y') >= '$inicio' and date_format(data_recebimento,'%d-%m-%Y') <= '$fim'
order by data_recebimento ASC;"); // consulta
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
	$pdf->Cell(0,1,utf8_decode($nome_turno),1,1,'C',false);
	$pdf->Cell(0,1,utf8_decode('UNIMONTES '.$hifen.' CAMPUS AVANÇADO DE JANUÁRIA'),1,1,'C',true);
	$pdf->Cell(0,1,utf8_decode('Período: '.$inicio.' à '.$fim),1,1,'C',false);
	$pdf->Cell(4,1,utf8_decode('Data'),1,0,'C',true);
	$pdf->Cell(8,1,utf8_decode('Cliente'),1,0,'C',true);
	$pdf->Cell(4,1,utf8_decode('Tipo'),1,0,'C',true);
	$pdf->Cell(4,1,utf8_decode('Valor'),1,0,'C',true);
	$pdf->Cell(7.7,1,utf8_decode('Funcionário'),1,0,'C',true);
	$pdf->Ln();
	// Color and font restoration
	$pdf->SetFillColor(224,235,255);
	$pdf->SetTextColor(0);
	$pdf->SetFont('Times','',12);
//Fim Cabeçalho da tabela

//exibindo os dados
$fill = false;
foreach($sql as $resultado){
	$pdf->Cell(4,1,$resultado["date_format(data_recebimento,'%d/%m/%Y %H:%i:%s')"],'LR',0,'C',$fill);
	$pdf->Cell(8,1,' '.$resultado['nome'],'LR',0,'L',$fill);
	$pdf->Cell(4,1,$resultado['tipo'],'LR',0,'C',$fill);
	$pdf->Cell(4,1,'R$ '.$resultado['valor_recebido'],'LR',0,'C',$fill);
	$pdf->Cell(7.7,1,utf8_decode(' '.$resultado['funcionario']),'LR',0,'L',$fill);
	$pdf->Ln();
	$fill = !$fill;
	}
	//Exibir a soma
	$sum = "select sum(valor_recebido) from caixa join usuarios u on u.id_usuario = usuario_fk 
where date_format(data_recebimento,'%H:%i:%s') > '$h1' and date_format(data_recebimento,'%H:%i:%s') < '$h2' and date_format(data_recebimento,'%d-%m-%Y') >= '$inicio' and date_format(data_recebimento,'%d-%m-%Y') <= '$fim';";
	$soma = mysql_fetch_array(mysql_query($sum, $db));
	$pdf->Cell(20,1,'Total Recebido: ',1,0,'R',true);
	$pdf->Cell(7.7,1,'R$ '.$soma['sum(valor_recebido)'],1,1,'C');
	//Exibir a soma
	//$pdf->Cell(27.7,0,'','T');
	$pdf->Ln(2);
	$pdf->Cell(0,0,'_____________________________________________',0,1,'C');
	$pdf->Cell(0,1,utf8_decode('Responsável'),0,1,'C');
//Fim exibindo os dados

$nome_relatorio = 'Relatório Semanal '.$inicio.' à '.$fim.'.pdf';
$pdf->Output($nome_relatorio,'I');

?>
