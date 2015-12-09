<?php
require('FPDF/fpdf.php');
require('conexao_relatorios.php');
require('../../conexao.php');

$id = $_GET['id'];

//contar quantidade de presenças
$qtd = mysql_fetch_array(mysql_query("select count(*) from caixa where usuario_fk = $id",$db));
//Fim contar quantidade de presenças

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
	$this->Cell(0,2.2,utf8_decode('RELATÓRIO DE DIÁRIAS PAGAS'),1,0,'C');
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
$sql = $pdo->prepare("select *,nome, date_format(data_recebimento,'%H:%i:%s'), date_format(data_recebimento,'%d/%m/%Y') from caixa join usuarios on usuario_fk = id_usuario where date_format(curdate(),'%Y') = date_format(data_recebimento,'%Y') and usuario_fk = $id order by data_recebimento desc;"); // consulta
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
	$pdf->Cell(8,1,'Nome',1,0,'C',true);
	$pdf->Cell(4,1,utf8_decode('Valor Pago'),1,0,'C',true);
	$pdf->Cell(4,1,'Data Pagamento',1,0,'C',true);
	$pdf->Cell(4,1,utf8_decode('Horário'),1,0,'C',true);
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
	$pdf->Cell(8,1,utf8_decode(utf8_encode($resultado['nome'])),'LR',0,'L',$fill);
	$pdf->Cell(4,1,'R$'.$resultado['valor_recebido'],'LR',0,'C',$fill);
	$pdf->Cell(4,1,$resultado["date_format(data_recebimento,'%d/%m/%Y')"],'LR',0,'C',$fill);
	$pdf->Cell(4,1,$resultado["date_format(data_recebimento,'%H:%i:%s')"],'LR',0,'C',$fill);
	$pdf->Cell(7.7,1,utf8_decode($resultado['funcionario']),'LR',0,'L',$fill);
	$pdf->Ln();
	$fill = !$fill;
	}
	$pdf->Cell(20,1,utf8_decode('Total de Diárias Pagas: '),1,0,'R');
	$pdf->Cell(7.7,1,$qtd['count(*)'],1,0,'C',true);
	
//Fim exibindo os dados
$nome_relatorio = 'Relatório de Diárias Pagas '.date('d-m-Y').'.pdf';
$pdf->Output($nome_relatorio,'I');

?>
