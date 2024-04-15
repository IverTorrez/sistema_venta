<?php
require('mc_table.php');
include_once('../model/clscausa.php');


function GenerateWord()
{
	//Get a random word
	$nb=rand(3,10);
	$w='';
	for($i=1;$i<=$nb;$i++)
		$w.=chr(rand(ord('a'),ord('m')));
	return $w;
}

function GenerateSentence()
{
	//Get a random sentence
	$variable="ESTA ES UNA COLUMNA ";
	$nb=rand(1,10);
	$s='';
	for($i=1;$i<=$nb;$i++)
		$s.=GenerateWord().' ';
	return substr($variable,0,-1);
}

$colum1='Columna 1';
$colum2='Columna 2';
$colum3='Columna 3';
$colum4='Columna 4 fbifgn nfnb fbnivionewinf niergvnio fdb ergi  nionk´l';
$colum5='Columna 5 y esto puede crecer mas todavia es depende del que coloque los atributos';

$pdf=new PDF_MC_Table('L','mm'/*,array(214.9,315)*/);
$pdf->AliasNbPages(10000,20000);
//$pdf->SetMargins(10, 15 , 10);/*margenes*/
$pdf->AddPage('Legal');/*el tamaño de la hoja*/

$pdf->SetFont('Arial','',7);
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(30,35,30,35,14,30,30,12,95));/*DEFINE EL TAMAÑO DE CADA COLUMNA*/
srand(microtime()*1000000);

    $pdf->SetFillColor(232,232,232);
    /*ENCABEZADO DE LA TABLA*/ 
    $pdf->Cell(30,9,'CODIGO DE CAUSA ',1,0,'C',1);
	$pdf->Cell(35,9,'NOMBRE',1,0,'C',1);
	$pdf->Cell(30,9,'CLIENTE',1,0,'C',1);
	$pdf->Cell(35,9,'DIRECCION',1,0,'C',1);
	$pdf->Cell(14,9,'TELEFONO',1,0,'C',1);
	$pdf->Cell(30,9,'CORREO',1,0,'C',1);
	$pdf->Cell(30,9,'COORDENADAS',1,0,'C',1);
	$pdf->Cell(12,9,'SALDO',1,0,'C',1);
	
	$pdf->Cell(95,9,'OBSERVACIONES',1,1,'C',1);

/*SE CREA EL OBJETO DE LA CAUSA */
  $objcausa=new Causa();
  $resulcausa=$objcausa->mostrarInforme_1();
  while($row=mysqli_fetch_object($resulcausa))
  {
  	$pdf->Row(array($row->codigo,$row->nombrecausa,$row->clienteasig,$row->Dircliente,$row->Telfcli,$row->CorreoCli,$row->CoorCli,$row->caja,$row->Observ));
  }


$pdf->Cell(340,10, 'INF 1 SALDOS ACTIVOS',0,1,'C');


/*DESDE AQUI EMPIEZA OTRA TABLA */
$pdf->SetWidths(array(40,35,35,35));/*DEFINE EL TAMAÑO DE CADA COLUMNA*/

  $pdf->SetFillColor(232,232,232);
    /*ENCABEZADO DE LA TABLA*/
    $pdf->Cell(40,9,'CODIGO DE CAUSA ',1,0,'C',1);
	$pdf->Cell(35,9,'NOMBRE',1,0,'C',1);
	$pdf->Cell(35,9,'CLIENTE',1,0,'C',1);
	$pdf->Cell(35,9,'DIRECCION',1,1,'C',1); 

for($i=0;$i<5;$i++)
	$pdf->Row(array($colum1,$colum2,$colum3,$colum4));


$pdf->Output();
?>
