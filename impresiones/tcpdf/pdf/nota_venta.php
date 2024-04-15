<?php
error_reporting(E_ERROR);
session_start();
$idventa=$_GET["codventa"];

require_once('tcpdf_include.php');


include_once('../../../modelos/venta.modelo.php');
class PDF extends TCPDF
{
   //Cabecera de página
   function Header()
   {

     // $this->Image('images/logo-sonido2.png',5,3, 70, 20, '', '', '', false, 300, '', false, false, 0, false,false,false);

     // $this->SetFont('','B',12);

     // $this->Cell(30,10,'Title',1,0,'C');
    
   }

   function Footer()
   {


    
	$this->SetY(-10);

	$this->SetFont('','I',8);
   // $this->Image('images/footer3.png',120,200,'', 10, '', '', '', false, 300, '', false, false, 0, false,false,false);
	$this->Cell(0,10,'GRACIAS POR SU PREFERENCIA ',0,0,'C');
   }
}




$pdf = new PDF('H', 'mm', 'A4', true, 'UTF-8', false);/*PARA HOJA TAMAÑO LEGAL SE PONE LEGAL EN MAYUSCULA*/


$pdf->startPageGroup();
$pdf->AddPage();
$pdf->SetFont('','',10);
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(3, 30 ,2.5);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);


 


/*===============================================================
TAMAÑO TOTAL DE LA HOJA OFICIO ECHADA(ORIZONTAL)=905px DISPONIBLE PARA OCUPAR CON DATOS, RESPETANDO LOSMARGENES ESTABLECIDOS POR CODIGO EN LA FUNCION ->SetMargins(34, 30 ,2.5)
/*===============================================================*/

$obj2=new Venta();
$resultado2=$obj2->mostrarDatosDeVenta($idventa);
$fila1=mysqli_fetch_object($resultado2);
if ($fila1->cliente==NULL) 
  {
    $cliente="Sin nombre";
  }
  else
  {
    $cliente=$fila1->cliente;
  }

$fechaventa=$fila1->fecha_venta;
$fechaComoEntero = strtotime($fechaventa);


$pdf->Ln(0);    
        $pdf->Cell(0,0, '                                                                                       NOTA DE VENTA', 0, 6, 'C', 0, '', 10);
        $pdf->Cell(0,0, '                                                                                       Nº 00'.$idventa, 0, 6, 'C', 0, '', 10);
     $pdf->Ln(1); 
    // $pdf->Cell(0, 0, 'TEST CELL STRETCH: force scaling', 1, 1, 'R', 0, '', 2);   


        
$pdf->Ln(5);


$pdf->SetFont('','',8);

#Establecemos el margen inferior:
/*$bloqueInfoEmpresa=<<<EOF
<table  style="width: 150px;">
  <thead>
  <tr >
      <th style="text-align:center; ">Propietario: Alex Ventura Montero</th>                             
    </tr>
     <tr >
      <th style="text-align:center; ">CASA MATRIZ</th>                             
    </tr>
    <tr >
      <th style="text-align:center; ">Dir. Calle Arenales Nº123 Zona/Barrio:</th>                       
    </tr>
    <tr >
      <th style="text-align:center; ">25 de Diciembre Telf.: 9227894</th>                       
    </tr>
    <tr >
      <th style="text-align:center; ">Montero - Santa Cruz - Bolivia</th>                       
    </tr>

  </thead>
</table>
EOF;
$pdf->writeHTML($bloqueInfoEmpresa,false,false,false,false,'');*/


$pdf->Ln(1);
$bloqueFecha=<<<EOF

<table  style="width: 150px;">
  <thead>
     <tr style="background-color:#e8e8e8;">
                  <th style="text-align:center; ">Lugar</th>
                  <th style="text-align:center; ">Dia</th>
                  <th style="text-align:center; ">Mes</th>  
                  <th style="text-align:center; ">Año</th>               
    </tr>

  </thead>
</table>
EOF;
$pdf->writeHTML($bloqueFecha,false,false,false,false,'');

// ini_set('date.timezone','America/La_Paz');
//          $dia=date("d");
//          $mes=date("m");
//          $anio=date("Y");
//          $hora=date("H:i");
//          $fechaHora=$fecha.' '.$hora;

         $anio = date("Y", $fechaComoEntero);
         $mes = date("m", $fechaComoEntero);
         $dia = date("d", $fechaComoEntero);
$bloqueFechaDatos=<<<EOF

<table  style="width: 150px;">
  <thead>
     <tr >
                  <th style="text-align:center; ">Montero</th>
                  <th style="text-align:center; ">$dia</th>
                  <th style="text-align:center; ">$mes</th>  
                  <th style="text-align:center; ">$anio</th>               
    </tr>

  </thead>
</table>
EOF;
$pdf->writeHTML($bloqueFechaDatos,false,false,false,false,'');

$pdf->Ln(2);




$pdf->Cell(0,0, 'Señor(es): '.$cliente, 0, 6, 'L', 0, '', 1);

$pdf->Ln(2);
$bloqueCabeceraDetalle=<<<EOF

<table border="0.1px">
  <thead>
     <tr id="fila1" style="background-color:#e8e8e8;">
                  <th style="text-align:center;width: 10%; ">Cantidad</th>
                  <th style="text-align:center;width: 70%; ">Descripción</th>
                  <th style="text-align:center;width: 10%; ">Valor Unitario</th>
                  <th style="text-align:center;width: 10%; ">Valor Total</th>
                 
                 
    </tr>

  </thead>

  

</table>
EOF;
$pdf->writeHTML($bloqueCabeceraDetalle,false,false,false,false,'');

               
                $contador=1;
               $totalVenta=0;
                $obj=new Venta();
                $resultado=$obj->nota_Venta($idventa);
                while ($fila=mysqli_fetch_object($resultado)) 
                {            
                  $totalVenta=$fila->monto_venta;
              $bloqueDatosDetalle=<<<EOF
                                  <table border="0.1px">
                                  <thead>
                                  <tr style="page-break-inside: avoid; " nobr="true">
                                     <th style="text-align:center; width: 10%;">$fila->cantidad_prod</th>
                                     <th style="text-align:left; width: 70%;">$fila->nombre_producto - $fila->codigo_producto - $fila->nombre_marca - $fila->codigo_prod</th>
                                     
                                     <th style="text-align:center; width: 10%;">$fila->precio_unitario_venta</th>
                                     <th style="text-align:center;width: 10%; ">$fila->subtotal_venta</th>                                
                                  </tr>
                                  </thead>
                                  </table>
                                  EOF;

$pdf->writeHTML($bloqueDatosDetalle,false,false,false,false,'');
$pdf->SetMargins(34, 30 ,2.5);

             
                 // $contador++;
                  
                 }
                 /***************************TABLA TOTAL EGRESOS DE LAS ORDENES*************/
                 // $totalventasDecimal=number_format((float)$totalMontoVentas, 2, '.', '');
$bloqueTotal=<<<EOF
<table border="0.1px" cellpadding="1" >
<tr style="page-break-inside: avoid;" nobr="true">
   <td style="text-align:center; width:90%;">TOTAL</td>
   <td style="text-align:center; width:10%;">$totalVenta</td>

</tr>

</table>
EOF;

$pdf->writeHTML($bloqueTotal,false,false,false,false,'');


$nameFile='nota_Venta.pdf';
ob_end_clean(); //LIMPIA ESPACIOS EN BLANCO PARA NO GENERAR ERROREA
$pdf->Output($nameFile);

?>