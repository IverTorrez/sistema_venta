<?php

session_start();
if(!isset($_SESSION["useradmin"]))
{
  header("location:../../../index.php");
}
$datos=$_SESSION["useradmin"];

require_once('tcpdf_include.php');

include_once('../../../model/clscausa.php');
include_once('../../../model/clsordengeneral.php');
include_once('../../../model/clsprocurador.php');

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


$nombrecont=$datos['nombreusuario'];

   $objprocu=new Procurador();
   $list=$objprocu->mostrarunprocuradro($_SESSION['idprocurador1']);
   $fi=mysqli_fetch_object($list);
   $nombreprocurador=$fi->Nombre;

        //$pdf->Image('images/logoserrate3.jpg',10, 10, 70, 15, '', '', '', false, 300, '', false, false, 0, false,false,false);
        
        $pdf->Cell(250, 0, '                                                                                       CONSULTA DE PAGO A PROCURADOR', 0, 0, 'C', 0, '', 0);


        $pdf->Cell(85, 0, 'Usuario: '.$nombrecont, 0, 1, 'R', 0, '', 1);
$pdf->Ln(5);
        $pdf->Cell(0, 0, 'Procurador: '.$nombreprocurador, 0, 1, 'L', 0, '', 0);
        $pdf->Cell(0, 0, 'Fecha Inicio De La Consulta: '.$_SESSION['fechapago1'], 0, 1, 'L', 0, '', 0);
        $pdf->Cell(0, 0, 'Fecha Final De La Consulta: '.$_SESSION['fechapago2'], 0, 1, 'L', 0, '', 0);
$pdf->Ln(5);


$pdf->SetFont('','',8);
/*===============================================================
CABECERA DE LA TABLA
/*===============================================================*/
$bloque1=<<<EOF

<table border="0.1px">
	<thead>
	   <tr>
		<th style="text-align:center;  width:160px; background-color:#e8e8e8;">CODIGO DEL PROCESO</th>
		<th style="text-align:center;  width:130px; background-color:#e8e8e8;">NUMERO DE ORDEN</th>
		<th style="text-align:center;  width:90px; background-color:#e8e8e8;">PRIORIDAD</th>
    <th style="text-align:center;  width:140px; background-color:#e8e8e8;">PLAZO DE VIGENCIA DE LA ORDEN</th>
		<th style="text-align:center;  width:140px; background-color:#e8e8e8;">COTIZACIÓN POSITIVA DE PROCURADURÍA</th>
		<th style="text-align:center;  width:140px;  background-color:#e8e8e8;">COTIZACIÓN NEGATIVA DE PROCURADURÍA (PENALIDAD)</th>
		<th style="text-align:center;  width:105px; background-color:#e8e8e8;">MONTO A PAGAR</th>
		</tr>
	</thead>

	

</table>
EOF;
$pdf->writeHTML($bloque1,false,false,false,false,'');


$montoapagar=0;

$objorden=new OrdenGeneral();
$result=$objorden->consultaparapagoaprocurador($_SESSION['idprocurador1']);
while($fila=mysqli_fetch_object($result))
    {
        if ($fila->fecha_cierre>=$_SESSION['fechapago1'] and $fila->fecha_cierre<=$_SESSION['fechapago2']) 
        {
           $contador++;
           array_push($_SESSION['arraysesion'], $fila->codorden);
   /*         echo "<tr>";
           echo "<td>$fila->codigocausa</td>";
           echo "<td>$fila->codorden</td>";
           echo "<td>$fila->priori</td>";*/
  $codigocausa=$fila->codigocausa;
  $numeroOrden=$fila->codorden;
  $prioridadorden=$fila->priori;
           switch ($fila->condicion) 
           {
             case 1:$plazoHoras= "mas de 96"; break;
             case 2:$plazoHoras="24 a 96"; break;
             case 3:$plazoHoras= "8 a 24"; break;
             case 4:$plazoHoras= "3 a 8"; break;
             case 5:$plazoHoras= "1 a 3"; break;
             case 6:$plazoHoras= "0 a 1"; break;
           }
          // echo "<td>$fila->condicion</td>";
  /*         echo "<td>$fila->cotcompra</td>";
           echo "<td>$fila->cotpenalidad</td>";*/
  $CotCompraProcu=$fila->cotcompra;
  $CotPenalidadProcu=$fila->cotpenalidad;
           if ($fila->compraprocu==0) {
            $montoapagar=$fila->penalidadproc+$montoapagar;
  //           echo "<td>$fila->penalidadproc</td>";
  $montoPagarOrden=$fila->penalidadproc;
           }
           else{
            $montoapagar=$fila->compraprocu+$montoapagar;
  //          echo "<td>$fila->compraprocu</td>";
  $montoPagarOrden=$fila->compraprocu;
           }
           
    //       echo "</tr>";
$bloque2=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="text-align:center; width:160px;">$codigocausa</th>
   <th style="text-align:center; width:130px;">$numeroOrden</th>
   <th style="text-align:center; width:90px;">$prioridadorden</th>
   <th style="text-align:center; width:140px;">$plazoHoras</th>
   <th style="text-align:center; width:140px;">$CotCompraProcu</th>
   <th style="text-align:center; width:140px;">$CotPenalidadProcu</th>
   <th style="text-align:center; width:105px;">$montoPagarOrden</th>
</tr>
</thead>
</table>
EOF;
$pdf->SetMargins(34, 30 ,2.5);
$pdf->writeHTML($bloque2,false,false,false,false,'');
        }/*FIN DEL IF QUE PREGUNTA SI LAS ORDENES ESTAN DENTRO DE LAS FECHAS INDICADAS*/
    }/*FIN DEL WHILE*/


/*==========================================TABLA TOTALES====================================*/
$bloqueTotales=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="text-align:center; width:800px;">TOTAL A PAGAR EN ESE RANGO DE TIEMPO</th>
   
   <th style="text-align:center; width:105px;">$montoapagar</th>
</tr>
</thead>
</table>
EOF;
$pdf->SetMargins(34, 30 ,2.5);
$pdf->writeHTML($bloqueTotales,false,false,false,false,'');


$nameFile='ConsultaPagoProcurador.pdf';
$pdf->Output($nameFile);

?>