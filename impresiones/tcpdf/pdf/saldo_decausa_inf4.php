<?php

session_start();
if(!isset($_SESSION["useradmin"]))
{
  header("location:../../../index.php");
}
$datos=$_SESSION["useradmin"];

require_once('tcpdf_include.php');

include_once('../../../model/clscausa.php');
include_once('../../../model/clsdeposito.php');
include_once('../../../model/clsordengeneral.php');
include_once('../../../model/clsdescarga_procurador.php');
include_once('../../../model/clscostofinal.php');
include_once('../../../model/clscotizacion.php');
include_once('../../../model/clsdevoluciondinero.php');

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
    //$this->Image('images/footer3.png',120,200,'', 10, '', '', '', false, 300, '', false, false, 0, false,false,false);
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
TAMAÑO TOTAL DE LA HOJA OFICIO ECHADA(ORIZONTAL)=905px DISPONIBLE PARA OCUPAR CON DATOS
/*===============================================================*/
ini_set('date.timezone','America/La_Paz');
$fechoyal=date("Y-m-d");
$horita=date("H:i");
$concat=$fechoyal.' '.$horita;

 

  /*CODIGO PARA HACER LA FECHA LITERAL*/
  $fecha = substr($concat, 0, 10);
  $numeroDia = date('d', strtotime($fecha));
  $dia = date('l', strtotime($fecha));
  $mes = date('F', strtotime($fecha));
  $anio = date('Y', strtotime($fecha));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
  $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
  $literal= $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
  /*----------------------------------------------*/


$codigonuevo=$_GET['cod'];

/*FUNCION PARA MOSTRAR EL CLIENTE DE LA CAUSA*/
$objc=new Causa();
$resc=$objc->mostrarUnacausa($codigonuevo);
$fill=mysqli_fetch_object($resc);
$cliente=$fill->clienteasig;
$codigocausa=$fill->codigo;
/*..........................................*/

$abogadonombre=$datos['nombreusuario'];
        //$pdf->Image('images/logoserrate3.jpg',10, 10, 70, 15, '', '', '', false, 300, '', false, false, 0, false,false,false);
        
        //$pdf->Cell(250, 0, '                                                                                       IMPRESION DE SALDOS DE CLIENTES EN CAUSAS ACTIVAS', 0, 0, 'C', 0, '', 0);
$pdf->SetFont('','',8);

        $pdf->Cell(0, 0, 'Santa Cruz: '.$literal, 0, 1, 'R', 0, '', 1);
        $pdf->Cell(0, 0, $subtitulo, 0, 1, 'C', 0, '', 0);
$pdf->Ln(5);

$pdf->Cell(0, 0, 'Señor:', 0, 1, 'L', 0, '', 1);
$pdf->Cell(0, 0, $cliente.' (Cliente)', 0, 1, 'L', 0, '', 0);
$pdf->Cell(0, 0, 'Presente.-', 0, 1, 'L', 0, '', 0);
$pdf->Cell(0, 0,'REF.-   INFORME DE AVANCE FINANCIERO', 0, 1, 'L', 0, '', 0);
$pdf->Cell(0, 0,'Señor cliente,', 0, 1, 'L', 0, '', 0);
$pdf->Cell(0, 0,'Mediante la presente adjunto informe del avance Financiero del proceso nominado con el codigo: '.$codigocausa.', que su persona tiene con nosotros.
', 0, 1, 'L', 0, '', 0);

$pdf->SetFont('','',12);
$pdf->Cell(0, 0, 'INFORME DE AVANCE FINANCIERO', 0, 1, 'C', 0, '', 1);

$pdf->Ln(1);

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
<table border="0.1px" cellpadding="1">
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







/****************************************LISTADO DE INGRESOS (DEPOSITOS)*******************************/
$pdf->SetFont('','',12);
$pdf->Cell(0, 0, 'I.  INGRESOS (COSTOS PROCESALES). - Los ingresos que su persona ha realizado para ser apropiados a la Partida de Costos Procesales, son los siguientes:
', 0, 1, 'L', 0, '', 1);

$pdf->Ln(1);

$pdf->SetFont('','',8);
$bloqueIngresosCab=<<<EOF
<table border="0.1px">
  <thead>
     <tr>
    <th style="text-align:center; width:200px; background-color:#e8e8e8;">FECHA</th>
    <th style="text-align:center; width:605px; background-color:#e8e8e8;">DETALLE</th>  
    <th style="text-align:center; width:100px; background-color:#e8e8e8;">MONTO</th>
    
    </tr>
  </thead>

  <tbody>
    
  </tbody>

</table>
EOF;
$pdf->writeHTML($bloqueIngresosCab,false,false,false,false,'');

$totaldepositos=0;
$objdep=new Deposito();
$resuldep=$objdep->Listardepositodecausa($codigonuevo);
while ($fila=mysqli_fetch_array($resuldep)) 
   {
     
   $totaldepositos=$totaldepositos+$fila['monto_deposito'];
$bloqueIngresos=<<<EOF
<table border="0.1px" cellpadding="1">
<tr style="page-break-inside: avoid;">
   <td style="text-align:center; width:200px;">$fila[fecha_deposito]</td>
   <td style="width:605px;">$fila[detalle_deposito]</td>
   
   <td style="text-align:right; width:100px;">$fila[monto_deposito]</td>
   
</tr>

</table>
EOF;

$pdf->writeHTML($bloqueIngresos,false,false,false,false,''); 
    }
/***************FILA DE TOTAL INGRESOS***********************************************/
$totaldepositosFormato=number_format($totaldepositos, 2, '.', ' ');
$bloqueTOTALdep=<<<EOF
<table border="0.1px">
  
  <tbody>
    <tr>
      <td style="text-align:center; width:805px; ">TOTAL INGRESOS</td>  
      <td style="text-align:right; width:100px; ">$totaldepositosFormato</td>
    </tr>
  </tbody>

</table>
EOF;
$pdf->writeHTML($bloqueTOTALdep,false,false,false,false,'');


$pdf->Ln(10);
/*********************************************FIN DE LISTADO DE INGRESOS******************************/

















/****************************************LISTADO DE ORDENES(GASTOS PROCESALES)************************/
$pdf->SetFont('','',12);
$pdf->Cell(0, 0, 'II.  EGRESOS (COSTOS PROCESALES). - Por su parte, los Costos Procesales realizados hasta la emision del presente informe, son los siguientes:', 0, 1, 'L', 0, '', 1);

$pdf->Cell(0, 0, 'EGRESOS POR COSTOS PROCESALES (Expresado en Bolivianos)', 0, 1, 'C', 0, '', 1);
$pdf->Ln(1);
$pdf->SetFont('','',8);

$bloqueEgresosCab=<<<EOF
<table border="0.1px">
  <thead>
     <tr>
    <th style="text-align:center; width:50px; background-color:#e8e8e8;"># ORDEN</th>
    <th style="text-align:center; width:50px; background-color:#e8e8e8;">PRIORIDAD</th>  
    <th style="text-align:center; width:70px; background-color:#e8e8e8;">INICIO</th>
    <th style="text-align:center; width:70px; background-color:#e8e8e8;">FIN</th>
    <th style="text-align:center; width:235px; background-color:#e8e8e8;">ORDEN GIRADA</th>
    <th style="text-align:center; width:240px; background-color:#e8e8e8;">RESULTADO</th>
    <th style="text-align:center; width:50px; background-color:#e8e8e8;">GASTOS</th>
    <th style="text-align:center; width:70px; background-color:#e8e8e8;">PROCURADURIA</th>
    <th style="text-align:center; width:70px; background-color:#e8e8e8;">TOTAL EGRESO</th>
    
    </tr>
  </thead>


</table>
EOF;
$pdf->writeHTML($bloqueEgresosCab,false,false,false,false,'');

/*****************COMIENZA EL LISTADO DE ORDENES**********/
$totalcostojudicial=0;
  $totalcostprocuradoria=0;
  $totalegreasotodasorden=0;
  $objorden=new OrdenGeneral();
  $resultor=$objorden->listarordenesParaClientedeCausa($codigonuevo);
  while ($filor=mysqli_fetch_array($resultor)) 
  {
         if ($filor['estado_orden']!='Serrada') 
        {
          $backgroundfila='#d0f3bc';
        }
        else
        {
         $backgroundfila='white'; 
        }

       // echo "<tr style='background: $backgroundfila'>";
           //echo "<td>$filor->idorden</td>";
  $numOrden=$filor['idorden'];
           //echo "<td style='text-align: justify;'>$filor->informacion</td>";
  $cargaInfo=$filor['informacion'];
            $objdesc=new DescargaProcurador();
            $resultdes=$objdesc->muestraDescargaDeorden($filor['idorden']);
            $fildes=mysqli_fetch_array($resultdes);

          // echo "<td style='text-align: justify;'>$fildes->detalle_informacion</td>";
  $descargaInfo=$fildes['detalle_informacion'];
          // echo "<td>$filor->Fin</td>";
  $fechaInicio=$filor['Inicio'];
  $fechaFin=$filor['Fin'];
         //  echo "<td>$filor->prioridadcot</td>";
  $prioridadOrden=$filor['prioridadcot'];
          /* switch ($filor->condicioncot) {
              case 1:echo "<td>mas de 96</td>";break;
              case 2:echo "<td>24 a 96</td>";break;
              case 3:echo "<td>8 a 24</td>";break;
              case 4:echo "<td>3 a 8</td>";break;
              case 5:echo "<td>1 a 3</td>";break;  
              case 6:echo "<td>0 a 1</td>";break;
             
            
           }*/
           $egresototalorden=0;

          // ESTE CODIGO VERIFICA QUE EL ADMIN YA AYGA PUESTO EL VERDADERO COSTO PROCESAL A LA ORDEN
           $objcostof=new Costofinal();
           $resultcostf=$objcostof->mostrarcostosdeunaorden($filor['idorden']);
           $filcof=mysqli_fetch_array($resultcostf);
           if ($filcof['validadofinal']=='Si') 
           {
             $costoproceventa=$filcof['costo_procesal_venta'];
            // $egresototalorden=$filcof->total_egreso;

            // $totalegreasotodasorden=$egresototalorden+$totalegreasotodasorden;
           }
           else
           {
             $costoproceventa='??';
           //  $egresototalorden='??';
           }
           //////////////////////////////////////////////////////////////////////////////////////////
        /*VERIFICA QUE LA ORDEN YA ESTE SERRADA PARA MOSTRAR EL REAL COSTO DE PROCURADORIA POR FALSO MOSTRARA EL COSTO DE COTIZACION CON UNA LEYENDA "MONTO POR CONFIRMAR"*/
           if ($filor['estado_orden']=='Serrada') 
           {
             $costoventaprocuradoria=$filcof['costo_procuradoria_venta'];
             //$egresototalorden=$costoventaprocuradoria+$egresototalorden;
             $switchprocu='Confirmado';
           }
           else
           {
             $objcotiz=new Cotizacion();
             $resulcotiz=$objcotiz->mostrarcotizaciondeorden($filor['idorden']);
             $filcotiz=mysqli_fetch_array($resulcotiz);
             
             $costoventaprocuradoria=$filcotiz['venta'].'  monto por confirmar';
             $switchprocu='Noconfirmado';

           }
           /*--------------------------------------------------------------------*/

           if ($costoproceventa=='??') 
           {
             $egresototalorden='??';
           }
           else
           {
             $egresototalorden=$egresototalorden+$costoproceventa;
           }



       /*IF QUE PREGUNTA SI YA SE SERRO LA ORDEN*/
           if ($switchprocu=='Confirmado') 
           {
             $egresototalorden=$egresototalorden+$filcof['costo_procuradoria_venta'];
           }
         
           //echo "<td>$costoproceventa</td>";
    $CostoProcesal=$costoproceventa;
           //echo "<td>$costoventaprocuradoria</td>";
    $CostoProcuraduria=$costoventaprocuradoria;

           /*IF QUE PREGUNTA SI TODAVIA NO SE COLOCO EL COSTO JUDICIAL VENTA Y SI TODAVIA NO SE SERRO LA ORDEN*/
           if ($costoproceventa=='??' and $switchprocu=='Noconfirmado') 
           {
             //echo "<td>??</td>";
   $TotalEgresoOrden='??';
           }

          /*IF QUE PREGUNTA SI TODAVIA NO SE COLOCO EL COSTO JUDICIAL VENTA Y SI LA ORDEN YA ESTA SERRADA*/
           if ($costoproceventa=='??' and $switchprocu=='Confirmado') 
           {
             $egresototalordenConmensaje=$egresototalorden.' hasta ahora';
             //echo "<td>$egresototalordenConmensaje</td>";
    $TotalEgresoOrden=$egresototalordenConmensaje;

             $totalegreasotodasorden=$totalegreasotodasorden+$egresototalorden;

             /*CALCULA EL SUBTOTAL DEL COSTO DE PROCURADORIA*/
             $totalcostprocuradoria=$totalcostprocuradoria+$filcof['costo_procuradoria_venta'];
           }

          /*IF QUE PREGUNTA SI YA SE COLOCO EL COSTO JUDICIAL VENTA Y SI YA SE SERRO LA ORDEN*/
           if ($costoproceventa!='??' and $switchprocu=='Confirmado') 
           {
            $nuevoegresoorden=$filcof['costo_procuradoria_venta']+$filcof['costo_procesal_venta'];
             //echo "<td>$nuevoegresoorden</td>";
    $TotalEgresoOrden=$nuevoegresoorden;
             $totalegreasotodasorden=$totalegreasotodasorden+$filcof['costo_procuradoria_venta']+$filcof['costo_procesal_venta'];

             /*CALCULA EL TOTAL DE COSTO DE PROCURADORIA DE TODAS LAS ORDENES*/
             $totalcostprocuradoria=$totalcostprocuradoria+$filcof['costo_procuradoria_venta'];
             /*CALCULA EL TOTAL COSTO JUDICIAL DE TODAS LAS ORDENES*/
             $totalcostojudicial=$totalcostojudicial+$filcof['costo_procesal_venta'];
           }

          // echo "<td>$egresototalorden</td>";
       // echo "</tr>";

$bloqueEgresos=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;background-color: $backgroundfila;" nobr="true">
   <th style="text-align:center; width:50px;">$numOrden</th>
   <th style="text-align:center; width:50px;">$prioridadOrden</th>
   <th style="text-align:center; width:70px;">$fechaInicio</th>
   <th style="text-align:center; width:70px;">$fechaFin</th>
   <th style="text-align:left; width:235px;">$cargaInfo</th>
   <th style="text-align:left; width:240px;">$descargaInfo</th>
   <th style="text-align:right; width:50px;">$CostoProcesal</th>
   <th style="text-align:right; width:70px;">$CostoProcuraduria</th>
   <th style="text-align:right; width:70px;">$TotalEgresoOrden</th>
</tr>
</thead>
</table>
EOF;
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(34, 30 ,2.5);
$pdf->writeHTML($bloqueEgresos,false,false,false,false,'');
    
  }/********FIN DEL WHILE QUE RECORRE TODAS LAS ORDENES DE UNA CAUSA*******************/

$totalcostojudicialFormato= number_format($totalcostojudicial, 2, '.', ' ');
$totalcostprocuradoriaFormato=number_format($totalcostprocuradoria, 2, '.', ' ');
$totalegreasotodasordenFormato=number_format($totalegreasotodasorden, 2, '.', ' ');

$bloqueEgresosTotales=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="text-align:center; width:715px;">TOTAL EGRESOS</th>
   
   <th style="text-align:right; width:50px;">$totalcostojudicialFormato</th>
   <th style="text-align:right; width:70px;">$totalcostprocuradoriaFormato</th>
   <th style="text-align:right; width:70px;">$totalegreasotodasordenFormato</th>
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloqueEgresosTotales,false,false,false,false,'');


/*****************FIN DEL LISTADO DE ORDENES**********/

$pdf->Ln(10);
/**************************************FIN LISTADO DE ORDENES(GASTOS PROCESALES)************************/













/***********************************LISTADO DE TRANFERENCIAS**************************************/
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(34, 30 ,2.5);
$pdf->SetFont('','',12);
$pdf->Cell(0, 0, 'III.  EGRESOS E INGRESOS POR MOTIVO DE TRANFERENCIAS. - Tranferencis de dinero entre sus causas tanto de ingresos como de egresos', 0, 1, 'L', 0, '', 1);

$pdf->Cell(0, 0, 'TRANSFERENCIAS ENTRE SUS CAUSAS', 0, 1, 'C', 0, '', 1);
$pdf->Ln(1);
$pdf->SetFont('','',8);

$bloqueTransfCab=<<<EOF

<table border="0.1px">
  <thead>
     <tr style="page-break-inside: avoid;" nobr="true">
    <th style="text-align:center;  width:425px; background-color:#e8e8e8;">TRANSFERECIA DE: (INGRESO)</th>
    <th style="text-align:center;  width:425px; background-color:#e8e8e8;">TRANSFERECIA A: (EGRESO)</th>
    <th style="text-align:center;  width:55px; background-color:#e8e8e8;">MONTO</th>
    </tr>
  </thead>

</table>
EOF;
$pdf->writeHTML($bloqueTransfCab,false,false,false,false,'');


/*ENLISTA LAS TRANSFERENCIAS QUE LE HACEN A LA CAUSA (ES DECIR LOS INGRESOS QUE SE LE HACE A LA CAUSA)*/
        $objcausa2=new Causa();
        $resulcausa1=$objcausa2->mostrarDetallesTransferenciasRecibidasDeCausa($codigonuevo);
       // $totalingreso=0;
        $totalTranferenciasRecibidas=0;
        while ($filacausa=mysqli_fetch_array($resulcausa1))
        {
            $idorigeningreso=$filacausa['idorigendeposito'];

            $obcausa22=new Causa();
            $resultca=$obcausa22->mostrarUnacausa($idorigeningreso);
            $filacausaorigen=mysqli_fetch_array($resultca);

         /* echo "<tr>"; 
          echo "<td>$filacausaorigen['codigo']</td>";
          echo "<td style='text-align: left;'></td>";
          echo "<td style='text-align: right;'>$filacausa['monto_deposito']</td>";
          echo "</tr>";*/
         $totalTranferenciasRecibidas=$totalTranferenciasRecibidas+$filacausa['monto_deposito'];

$bloqueTransfRecibidas=<<<EOF
<table border="0.1px" cellpadding="1">

  <thead>
    <tr style="page-break-inside: avoid;" nobr="true">
    <th style="text-align:center;  width:425px; ">$filacausaorigen[codigo]</th>
    <th style="text-align:center;  width:425px; "></th>
    <th style="text-align:right;  width:55px; ">$filacausa[monto_deposito]</th>
    </tr>
  </thead>

</table>
EOF;
$pdf->writeHTML($bloqueTransfRecibidas,false,false,false,false,'');

        }/*FIN DEL WHILE QUE RECORRE LAS TRANSFERENCIAS RECIBIDAS*/



 /***********************DESDE AQUI ENLISTAS LAS TRANSFERENCIAS QUE SE HACE A OTRA CAUSA ES DECIR (LOS EGRESOS DE LA CAUSA A OTRA CAUSA) ***************************/
        $totalTranferenciaEntregadas=0;
        $obcausasalida=new Causa();
        $resultcausasalida=$obcausasalida->mostrarDetallesTransferenciasEntregadasDeCausa($codigonuevo);
        while ($filacausasalida=mysqli_fetch_array($resultcausasalida))
        {
            $iddestinoingreso=$filacausasalida['id_causa'];

            $obcausa33=new Causa();
            $resultca=$obcausa33->mostrarUnacausa($iddestinoingreso);
            $filacausadestino=mysqli_fetch_array($resultca);

         /* echo "<tr>"; 
          echo "<td></td>";
          echo "<td style='text-align: left;'>$filacausadestino[codigo]</td>";
          echo "<td style='text-align: right;'>$filacausasalida[monto_deposito]</td>";
          echo "</tr>";*/
          $totalTranferenciaEntregadas=$totalTranferenciaEntregadas+$filacausasalida['monto_deposito'];
$bloqueTransfEntregadas=<<<EOF
<table border="0.1px" cellpadding="1">

  <thead>
    <tr style="page-break-inside: avoid;" nobr="true">
    <th style="text-align:center;  width:425px; "></th>
    <th style="text-align:center;  width:425px; ">$filacausadestino[codigo]</th>
    <th style="text-align:right;  width:55px; ">$filacausasalida[monto_deposito]</th>
    </tr>
  </thead>

</table>
EOF;
$pdf->writeHTML($bloqueTransfEntregadas,false,false,false,false,'');
        } /*FIN DEL WHILE QUE RRECORRE LAS TRANSFERENCIAS EMTREGADAS A OTRAS CAUSAS*/      



$pdf->Ln(10);
/***********************************FIN DEL LISTADO DE TRANSFERENCIAS*****************************/









/************************LISTADO DE DEVOLUCIONES AL CLIENTE**********************************/
$pdf->SetFont('','',12);
$pdf->Cell(0, 0, 'IV. DEVOLUCIONES DEL RESTO DE DINERO EN TERMINO DE CAUSA. - Devolucion del monto sobrante de dinero tras el termino de causa', 0, 1, 'L', 0, '', 1);

$pdf->Cell(0, 0, 'DEVOLUCIONES AL CLIENTE', 0, 1, 'C', 0, '', 1);
$pdf->Ln(1);
$pdf->SetFont('','',8);

$bloqueDeveloucionCab=<<<EOF

<table border="0.1px">
  <thead>
     <tr style="page-break-inside: avoid;" nobr="true">
    <th style="text-align:center;  width:850px; background-color:#e8e8e8;">FECHA</th>
    <th style="text-align:center;  width:55px; background-color:#e8e8e8;">MONTO</th>
    </tr>
  </thead>

  <tbody>
    
  </tbody>

</table>
EOF;
$pdf->writeHTML($bloqueDeveloucionCab,false,false,false,false,'');


$objdevolu=new DevolucionDinero();
        $resuldev=$objdevolu->listarLasDevolucionesdeCausa($codigonuevo);
        $totaldevuelto=0;
        while ($filadev=mysqli_fetch_array($resuldev))
        {
            $totaldevuelto=$totaldevuelto+$filadev['montodevolucion'];
         /* echo "<tr>"; 
          echo "<td>$filadev[fechadevolucion]</td>";
          //echo "<td style='text-align: left;'>$fila->detalle_deposito</td>";
          echo "<td style='text-align: right;'>$filadev[montodevolucion]</td>";
          echo "</tr>";*/
   
$bloqueDevelouciones=<<<EOF
<table border="0.1px" cellpadding="1">

  <thead>
    <tr style="page-break-inside: avoid;" nobr="true">
    
    <th style="width:850px; ">$filadev[fechadevolucion]</th>
    <th style="text-align:right;  width:55px; ">$filadev[montodevolucion]</th>
    </tr>
  </thead>

</table>
EOF;
$pdf->writeHTML($bloqueDevelouciones,false,false,false,false,'');
        }/*FIN DEL WHILE QUE RRECORE TODAS LAS DEVOLUCIONES*/


/*TOTAL DEVOLUCIONES*/
$totaldevueltoFormato=number_format($totaldevuelto, 2, '.', ' ');
$bloqueDevelouciones=<<<EOF
<table border="0.1px" cellpadding="1">

  <thead>
    <tr style="page-break-inside: avoid;" nobr="true">
    
    <th style="text-align:center;  width:850px; ">TOTAL DEVOLUCIONES</th>
    <th style="text-align:right;  width:55px; ">$totaldevueltoFormato</th>
    </tr>
  </thead>

</table>
EOF;
$pdf->writeHTML($bloqueDevelouciones,false,false,false,false,'');
$pdf->Ln(10);


/************************FIN DEL LISTADO DE DEVOLUCIONES AL CLIENTE**********************************/












/***********************TABLA DE RESUMEN TOTAL*****************************************/
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(144, 30 ,121.5);
$pdf->SetFont('','',12);

$pdf->Ln(1);
$pdf->SetFont('','',8);


$totalTranferenciasRecibidasFormato=number_format($totalTranferenciasRecibidas, 2, '.', ' ');

$totalTranferenciaEntregadasFormato=number_format($totalTranferenciaEntregadas, 2, '.', ' ');

$saldototal=$totaldepositos-$totalegreasotodasorden+$totalTranferenciasRecibidas-$totalTranferenciaEntregadas-$totaldevuelto;

$saldototalFormato=number_format($saldototal, 2, '.', ' ');

$bloqueTablaResumen=<<<EOF
<center>
<table border="0.1px" nobr="true" cellpadding="1">
  <thead>
    <tr style="page-break-inside: avoid;">
      <th style="text-align:center; font-size:15px;">RESUMEN</th>
    </tr>
    <tr style="page-break-inside: avoid;">
    <th style="text-align:center;  width:200px; ">TOTAL EGRESOS</th>
    <th style="text-align:right;  width:55px;">-$totalegreasotodasordenFormato</th>
    </tr>
    <tr style="page-break-inside: avoid;">
    <th style="text-align:center;  width:200px; ">TOTAL INGRESOS</th>
    <th style="text-align:right;  width:55px; ">$totaldepositosFormato</th>
    </tr>
    <tr style="page-break-inside: avoid;">
    <th style="text-align:center;  width:200px; ">TOTAL TRANSFERENCIA RECIBIDA</th>
    <th style="text-align:right;  width:55px; ">$totalTranferenciasRecibidasFormato</th>
    </tr>
    <tr style="page-break-inside: avoid;">
    <th style="text-align:center;  width:200px; ">TOTAL TRANSFERENCIA ENTREGADA</th>
    <th style="text-align:right;  width:55px; ">-$totalTranferenciaEntregadasFormato</th>
    </tr>
    <tr style="page-break-inside: avoid;">
    <th style="text-align:center;  width:200px; ">TOTAL DEVUELTO AL CLIENTE</th>
    <th style="text-align:right;  width:55px; ">-$totaldevueltoFormato</th>
    </tr>
    <tr style="page-break-inside: avoid;">
    <th style="text-align:center;  width:200px; ">SALDO</th>
    <th style="text-align:right;  width:55px; ">$saldototalFormato</th>
    </tr>
  </thead>
</table>
</center>
EOF;
$pdf->writeHTML($bloqueTablaResumen,false,false,false,false,'');
/**********************FIN DE LA TABLA RESUMEN TOTAL**************************************/
$pdf->Ln(5);
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(30, 30 ,2.5);
$pdf->SetFont('','',10);

$pdf->Cell(0, 0, ' ', 0, 1, 'L', 0, '', 1);
$pdf->Cell(0, 0, 'Es por cuanto tenemos a bien informar.', 0, 1, 'L', 0, '', 1);
$pdf->Ln(3);
$pdf->Cell(0, 0, 'LA ADMINISTRACION', 0, 1, 'C', 0, '', 1);


$nameFile='Informe4_'.$codigocausa.'.pdf';
$pdf->Output($nameFile);

?>