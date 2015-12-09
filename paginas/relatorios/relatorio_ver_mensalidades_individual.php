<?php
require('FPDF/fpdf.php');
require('conexao_relatorios.php');
require('../../conexao.php');

$id = $_GET['id'];
// Buscar dados do usuário
	$sql_usuario = "select nome from usuarios where id_usuario = $id;";
	$query_usuario = mysql_query($sql_usuario,$db);
	$usuario = mysql_fetch_array($query_usuario);
// Fim Buscar dados do usuário

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
	$this->Cell(0,2.2,utf8_decode('RELATÓRIO DE MENSALIDADES PAGAS'),1,0,'C');
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

$pdf = new PDF('l','cm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//Criando a conexão pelo PDO
$sql = $pdo->prepare("select *, date_format(data_vencimento,'%d/%m/%Y'), date_format(data_pagamento,'%d/%m/%Y %H:%i:%s') from mensalidade where usuario_fk = $id and status_pagamento = 'pago' order by data_pagamento"); // consulta
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
	$pdf->Cell(0,1,utf8_decode('LABORATÓRIO DO EXERCÍCIO - CURSO DE EDUCAÇÃO FÍSICA'),1,1,'C',true);
	$pdf->Cell(0,1,utf8_decode('UNIMONTES '.$hifen.' CAMPUS AVANÇADO DE JANUÁRIA'),1,1,'C',false);
	$pdf->Cell(0,1,utf8_decode(utf8_encode($usuario['nome'])),1,1,'C',true);
	$pdf->Cell(4,1,'Data Vencimento',1,0,'C',true);
	$pdf->Cell(4,1,utf8_decode('Valor'),1,0,'C',true);
	$pdf->Cell(4,1,utf8_decode('Desconto'),1,0,'C',true);
	$pdf->Cell(4,1,utf8_decode('Valor Pago'),1,0,'C',true);
	$pdf->Cell(5,1,utf8_decode('Data de Pagamento'),1,0,'C',true);
	$pdf->Cell(6.7,1,utf8_decode('Funcionário'),1,0,'C',true);
	$pdf->Ln();
	// Color and font restoration
	$pdf->SetFillColor(224,235,255);
	$pdf->SetTextColor(0);
	$pdf->SetFont('Times','',12);
//Fim Cabeçalho da tabela

//exibindo os dados
$fill = false;
foreach($sql as $resultado){
	$pdf->Cell(4,1,$resultado["date_format(data_vencimento,'%d/%m/%Y')"],'LR',0,'C',$fill);
	$pdf->Cell(4,1,'R$ '.$resultado['valor_a_receber'],'LR',0,'C',$fill);
	$pdf->Cell(4,1,$resultado['desconto_a_receber'].'%','LR',0,'C',$fill);
	$pdf->Cell(4,1,'R$ '.$resultado['valor_recebido'],'LR',0,'C',$fill);
	$pdf->Cell(5,1,$resultado["date_format(data_pagamento,'%d/%m/%Y %H:%i:%s')"],'LR',0,'C',$fill);
	$pdf->Cell(6.7,1,utf8_decode($resultado['funcionario']),'LR',0,'L',$fill);
	$pdf->Ln();
	$fill = !$fill;
	}
	$pdf->Cell(27.7,0,'','T');
//Fim exibindo os dados
$nome_relatorio = 'Relatório de Mensalidades Pagas '.date('d-m-Y').'.pdf';
$pdf->Output($nome_relatorio,'I');

?>
