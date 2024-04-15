<?php

session_start();
if(!isset($_SESSION["useradmin"]))
{
  header("location:../../../index.php");
}
$datos=$_SESSION["useradmin"];

require_once('tcpdf_include.php');

include_once('../../../model/clscausa.php');
include_once('../../../model/clsdescarga_procurador.php');

class PDF extends TCPDF
{
   //Cabecera de página
   function Header()
   {

      $this->Image('images/logoserrate3.jpg',30,3, 70, 15, '', '', '', false, 300, '', false, false, 0, false,false,false);

     // $this->SetFont('','B',12);

     // $this->Cell(30,10,'Title',1,0,'C');
    
   }

   function Footer()
   {


    
	$this->SetY(-10);

	$this->SetFont('','I',8);
   // $this->Image('images/footer3.png',120,200,'', 10, '', '', '', false, 300, '', false, false, 0, false,false,false);
	$this->Cell(0,10,'Pagina '.$this->PageNo().'/'.$this->getAliasNbPages(),0,0,'C');
   }
}




$pdf = new PDF('L', 'mm', 'LEGAL', true, 'UTF-8', false);/*PARA HOJA TAMAÑO LEGAL SE PONE LEGAL EN MAYUSCULA*/


$pdf->startPageGroup();
$pdf->AddPage();
$pdf->SetFont('','',10);
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(34, 30 ,2.5);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);

/*===============================================================
TAMAÑO TOTAL DE LA HOJA OFICIO ECHADA(ORIZONTAL)=905px DISPONIBLE PARA OCUPAR CON DATOS, RESPETANDO LOSMARGENES ESTABLECIDOS POR CODIGO EN LA FUNCION ->SetMargins(34, 30 ,2.5)
/*===============================================================*/
 $codcausa=$_GET['cod'];
  //SE DESENCRIPTA EL CODIGO PARA PODER USARLO //
   $decodificado=base64_decode($codcausa);

   $codigonuevo=$decodificado/1234567;

$objcausa=new Causa();
   $resul=$objcausa->mostrarcodcausa($codigonuevo);
   $fil=mysqli_fetch_object($resul);
   $codigocausa=$fil->codigo;

$abogadonombre=$datos['nombreusuario'];
        //$pdf->Image('images/logoserrate3.jpg',10, 10, 70, 15, '', '', '', false, 300, '', false, false, 0, false,false,false);
        
        $pdf->Cell(250, 0, '                                                                                       RENDIMIENTO DE PROCURADURÍA DE LA CAUSA: '.$codigocausa, 0, 0, 'C', 0, '', 0);


        $pdf->Cell(85, 0, 'Usuario: '.$abogadonombre, 0, 1, 'R', 0, '', 1);
        $pdf->Cell(0, 0, $subtitulo, 0, 1, 'C', 0, '', 0);
$pdf->Ln(5);


$pdf->SetFont('','',8);
/*===============================================================
CABECERA DE LA TABLA
/*===============================================================*/
$primerbloque=<<<EOF
<table border="0.1px">
  <thead>
     <tr>
    <th style="text-align:center; width:200px; background-color:#e8e8e8;">CODIGO</th>
    <th style="text-align:center; width:505px; background-color:#e8e8e8;">NOMBRE DEL PROCESO</th>  
    <th style="text-align:center; width:200px; background-color:#e8e8e8;">CLIENTE</th>
    
    </tr>
  </thead>

  <tbody>
    
  </tbody>

</table>
EOF;
$pdf->writeHTML($primerbloque,false,false,false,false,'');

$objcausa=new Causa();
$resul=$objcausa->fichacausa($codigonuevo);
while ($fil=mysqli_fetch_array($resul)) 
   {
     

$primerbloque2=<<<EOF
<table border="0.1px">
<tr style="page-break-inside: avoid;">
   <td style="text-align:center; width:200px;">$fil[codigo]</td>
   <td style="text-align:center; width:505px;">$fil[nombrecausa]</td>
   
   <td style="text-align:center; width:200px;">$fil[clienteasig]</td>
   
   
   
</tr>

</table>
EOF;

$pdf->writeHTML($primerbloque2,false,false,false,false,''); 
    }
//FIN DEL BLOQUE 1
$pdf->Ln(10);


$bloque1=<<<EOF

<table border="0.1px">
	<thead>
	   <tr>
		<th style="text-align:center;  width:50px; background-color:#e8e8e8;"># DE ORDEN</th>
		<th style="text-align:center;  width:250px; background-color:#e8e8e8;">CARGA DE INFORMACION</th>
		<th style="text-align:center;  width:245px; background-color:#e8e8e8;">DESCARGA DE INFORMACION</th>
		<th style="text-align:center;  width:45px; background-color:#e8e8e8;">NIVEL DE PRIORIDAD</th>
		<th style="text-align:center;  width:40px;  background-color:#e8e8e8;">PLAZO EN HORAS</th>
		<th style="text-align:center;  width:60px; background-color:#e8e8e8;">COTIZACION POSITIVA PARA PAGAR AL PROCURADOR</th>
		<th style="text-align:center;  width:60px; background-color:#e8e8e8;">COTIZACION NEGATIVA PARA PAGAR AL PROCURADOR</th>
		<th style="text-align:center;  width:60px;  background-color:#e8e8e8;">MONTO PAGADO AL PROCURADOR</th>
		<th style="text-align:center;  width:95px; background-color:#e8e8e8;">PROCURADOR QUE ATENDIO CADA ORDEN</th>
		</tr>
	</thead>

	

</table>
EOF;
$pdf->writeHTML($bloque1,false,false,false,false,'');

  
  $totalCotPositiva=0;
  $totalCotNegativa=0;
  $totalPagadoProcurador=0;
  $objcausa=new Causa();
  $resulcausa=$objcausa->funcionParaMostrarRendimientodeProcurduriadeCausa($codigonuevo);
  while($row=mysqli_fetch_array($resulcausa))
  {

              switch ($row['condicion']) 
              {
                  case 1:$PlazoHoras="mas de 96"; break;
                  case 2:$PlazoHoras="24-96"; break;
                  case 3:$PlazoHoras="8-24"; break;
                  case 4:$PlazoHoras="3-8"; break;
                  case 5:$PlazoHoras="1-3"; break;
                  case 6:$PlazoHoras="0-1"; break;
                          
              }

    $objdesc=new DescargaProcurador();
    $resuldescarga=$objdesc->mostrardescargaorden($row['codorden']);
    $filadescarga=mysqli_fetch_array($resuldescarga);
    $Infodescarga=$filadescarga['detalle_informacion'];

    $obcosf=new Causa();
    $resucostof=$obcosf->mostrarCostoFinalDeOrden($row['codorden']);
    $filcostfin=mysqli_fetch_array($resucostof);
    $pagadoAlprocurador=$filcostfin['pagadoProcurador'];

  
  $totalCotPositiva=$totalCotPositiva+$row['cot_positiva'];
  $totalCotNegativa=$totalCotNegativa+$row['cot_negativa'];
  $totalPagadoProcurador=$totalPagadoProcurador+$filcostfin['pagadoProcurador'];
  
$bloque2=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="text-align:center; width:50px;">$row[codorden]</th>
   <th style=" width:250px;">$row[CargaInfo]</th>
   <th style=" width:245px;">$Infodescarga</th>
   <th style="text-align:center; width:45px;">$row[Prioriorden]</th>
   <th style="text-align:center; width:40px;">$PlazoHoras</th>
   <th style="text-align:center; width:60px;">$row[cot_positiva]</th>
   <th style="text-align:center; width:60px;">$row[cot_negativa]</th>
   <th style="text-align:center; width:60px;">$pagadoAlprocurador</th>
   <th style="text-align:center; width:95px;">$row[procuAsignado]</th>
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloque2,false,false,false,false,'');
$pdf->SetMargins(34, 30 ,2.5);
  }




  /**************TABLA FINAL DE TOTALES**********************/
  $bloqueTotales=<<<EOF

<table border="0.1px">
  <thead>
     <tr>
    <th style="text-align:center;  width:630px;">TOTAL RENDIMIENTO</th>
    
    <th style="text-align:center;  width:60px;">$totalCotPositiva</th>
    <th style="text-align:center;  width:60px;">$totalCotNegativa</th>
    <th style="text-align:center;  width:60px;">$totalPagadoProcurador</th>
    <th style="text-align:center;  width:95px;"></th>
    </tr>
  </thead>

  

</table>
EOF;
$pdf->writeHTML($bloqueTotales,false,false,false,false,'');

 /**************fin de tabla totales************************/
$nameFile='RendimientoProcuraduria_'.$codigocausa.'.pdf';
$pdf->Output($nameFile);

?>