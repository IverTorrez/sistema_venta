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

include_once('../../../model/clsdeposito.php');
include_once('../../../model/clspresupuesto.php');
include_once('../../../model/clsdescarga_procurador.php');
include_once('../../../model/clsconfirmacion.php');
include_once('../../../model/clscostofinal.php');
include_once('../../../model/clsdevoluciondinero.php');

 $codcausa=$_GET['cod'];
  //SE DESENCRIPTA EL CODIGO PARA PODER USARLO //
   $decodificado=base64_decode($codcausa);

   $codigonuevo=$decodificado/1234567;

class PDF extends TCPDF
{
   //Cabecera de página
   function Header()
   {

      $this->Image('images/logoserrate3.jpg',30,3, 70, 15, '', '', '', false, 300, '', false, false, 0, false,false,false);

     //$this->SetFont('','B',12);

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
TAMAÑO TOTAL DE LA HOJA OFICIO ECHADA(ORIZONTAL)=905px DISPONIBLE PARA OCUPAR CON DATOS, RESPETANDO LOSMARGENES ESTABLECIDOS POR CODIGO EN LA FUNCION ->SetMargins(34, 30 ,2.5)
/*===============================================================*/
/*FUNCION PARA CODIGO DE CAUSA*/
$objc=new Causa();
$resc=$objc->mostrarUnacausa($codigonuevo);
$fill=mysqli_fetch_object($resc);
$cliente=$fill->clienteasig;
$codigocausa=$fill->codigo;


$USUnombre=$datos['nombreusuario'];
        //$pdf->Image('images/logoserrate3.jpg',10, 10, 70, 15, '', '', '', false, 300, '', false, false, 0, false,false,false);
        
        $pdf->Cell(250, 0, '                                                                                       CAUSA: '.$codigocausa, 0, 0, 'C', 0, '', 0);


        $pdf->Cell(85, 0, 'Usuario: '.$USUnombre, 0, 1, 'R', 0, '', 1);
        $pdf->Cell(290, 0, 'EGRESOS (LISTADO DE ORDENES)', 0, 1, 'C', 0, '', 0);
$pdf->Ln(5);


$pdf->SetFont('','',6);
/*===============================================================
CABECERA DE LA TABLA
/*===============================================================*/
$bloquecABECERA=<<<EOF

<table border="0.1px">
  <thead>
     <tr>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:500px; background-color:#e8e8e8;">FECHAS</th>
    <th style="text-align:center;  width:140px; background-color:#e8e8e8;">COTIZACION</th>
    <th style="text-align:center;  width:140px; background-color:#e8e8e8;">FINANZAS</th>
    <th style="text-align:center;  width:95px;  background-color:#e8e8e8;"></th>
    
    </tr>
  </thead>

  <tbody>
    
  </tbody>

</table>
EOF;
$pdf->writeHTML($bloquecABECERA,false,false,false,false,'');


$bloqueFechasCab=<<<EOF

<table border="0.1px">
  <thead>
     <tr>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:200px; background-color:#e8e8e8;">FECHAS DE CARGA</th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:100px; background-color:#e8e8e8;">VIGENCIA DE LA ORDEN</th>
    <th style="text-align:center;  width:150px;  background-color:#e8e8e8;">MOMENTOS PARA EL CIERRE DE LA ORDEN</th>
    <th style="text-align:center;  width:60px; background-color:#e8e8e8;">PARAMETROS USADOS PARA COTIZAR ESTA ORDEN</th>
    <th style="text-align:center;  width:80px; background-color:#e8e8e8;">COTIZACION DE PROCURADURIA</th>
    <th style="text-align:center;  width:50px;  background-color:#e8e8e8;">COSTO JUDICIAL Bs.</th>
    <th style="text-align:center;  width:60px; background-color:#e8e8e8;">COSTO DE PROCURADURIA</th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:95px; background-color:#e8e8e8;"></th>
    </tr>
  </thead>

  <tbody>
    
  </tbody>

</table>
EOF;
$pdf->writeHTML($bloqueFechasCab,false,false,false,false,'');

$bloque1Fila1=<<<EOF

<table border="0.1px">
  <thead>
     <tr>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:100px; background-color:#e8e8e8;">INFORMACION Y DOCUMENTACION</th>
    <th style="text-align:center;  width:100px; background-color:#e8e8e8;">DINERO</th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:100px; background-color:#e8e8e8;">FECHAS DE PRONUNCIAMIENTOS</th>

    <th style="text-align:center;  width:50px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8; font-size:5px;"></th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:20px; background-color:#e8e8e8;font-size:5px;"></th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;font-size:5px;"></th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:20px; background-color:#e8e8e8;font-size:5px;"></th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;font-size:5px;"></th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:45px; background-color:#e8e8e8;font-size:6px;"></th>

    </tr>
  </thead>

  <tbody>
    
  </tbody>

</table>
EOF;
$pdf->writeHTML($bloque1Fila1,false,false,false,false,'');
$pdf->SetAutoPageBreak(true,10);
$bloqueFila4=<<<EOF

<table border="0.1px">
	<thead>
	   <tr>
		<th style="text-align:center;  width:30px; background-color:#e8e8e8;">#ORDEN</th>
		<th style="text-align:center;  width:50px; background-color:#e8e8e8;">GIRO</th>
		<th style="text-align:center;  width:50px; background-color:#e8e8e8;">PRESUPUESTO</th>
		<th style="text-align:center;  width:50px; background-color:#e8e8e8;">CARGA MATERIAL DE INF. Y DOC.</th>
		<th style="text-align:center;  width:50px;  background-color:#e8e8e8;">ENTREGA DE DINERO</th>
		<th style="text-align:center;  width:50px; background-color:#e8e8e8;">FECHA DE DESCARGA</th>
		<th style="text-align:center;  width:50px; background-color:#e8e8e8;">INICIO</th>
		<th style="text-align:center;  width:50px;  background-color:#e8e8e8;">FIN</th>
		<th style="text-align:center;  width:50px; background-color:#e8e8e8;">DEL ABOGADO</th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;">DEL CONTADOR</th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;">FECHA OFICIAL DE CIERRE</th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8; font-size:5px;">NIVEL DE PRIORIDAD</th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;">PLAZO EN HORAS</th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;">COMPRA</th>
    <th style="text-align:center;  width:20px; background-color:#e8e8e8;font-size:5px;">VENTA</th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;font-size:5px;">PENALIDAD</th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;">COMPRA</th>
    <th style="text-align:center;  width:20px; background-color:#e8e8e8;font-size:5px;">VENTA</th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;font-size:5px;">COMPRA (para el procurador)</th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;">VENTA (para el cliente)</th>
    <th style="text-align:center;  width:30px; background-color:#e8e8e8;">TOTAL EGRESO (para el cliente)</th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;">PROCURADOR (GESTO)</th>
    <th style="text-align:center;  width:45px; background-color:#e8e8e8;font-size:6px;">CALIFICACION (suficiente/ insuficiente)</th>
		</tr>
	</thead>

	<tbody>
		
	</tbody>

</table>
EOF;
$pdf->writeHTML($bloqueFila4,false,false,false,false,'');

$pdf->SetAutoPageBreak(true,10);

/***************************************LISTADO DE ORDENES********************************/
ini_set('date.timezone','America/La_Paz');
$fechoyal=date("Y-m-d");
$horita=date("H:i");
////$concat es la fecha y hora de la paz Bolivia
$concat=$fechoyal.' '.$horita;

$totalcostojudicompra=0;
$totlacostojudiventa=0;
$totalparaprocurador=0;
$totalventaprocurador=0;
$totalegreso=0;
   $objorden=new OrdenGeneral();
   $resul=$objorden->listarordenesdeunacausa($codigonuevo);
   while ($fil=mysqli_fetch_array($resul)) 
   {
               /*PARA EL COLOR A LAS FILAS DEPENDIENDO DE SU URGENCIA*/
                if ($fil['estado_orden']=='Serrada')/*PREGUNTA SI ESTA SERRADA LA ORDEN*/ 
                {
                 $backgroundfila='white';
                 $fontcolor='#000000'; 
                }
                else/*POR FALSO*/
                {


                    $fechafinorden=$fil['fin'];
                    $newfechfin=date_create($fechafinorden);
                    $fechafinformato=date_format($newfechfin, 'Y-m-d H:i');

                    $fecha1 =new DateTime($concat);/*fechas de la zona horaria*/
                    $fecha2 =new DateTime($fechafinformato);/*FECHA Y HORA FINAL DE LA ORDEN*/
                    if ($fecha1>$fecha2)/*PREGUNTA SI LA ORDEN ESTA VENCIDA*/ 
                        {
                          $vard='R';
                          $varconcat=$vard.$prioriorden;

                          $varcaraorden="<strike>$varconcat</strike>";

                          $totaltiempoexpirar=0;
                          $tiempo=0;
                          $backgroundfila='#ffffff';
                          $fontcolor='#b7b3b3';

                        }
                    else
                    {
                             $intervalo= $fecha1->diff($fecha2);
                    //CONVERTIMOS A ENTEROS DIAS,HORAS Y MINUTOS PARA PODER HACER CALCULOS
                                $diasentero=intval($intervalo->format('%d'));
                                $horaentero=intval($intervalo->format('%H'));
                                $minutos=intval($intervalo->format('%i'));


                                /// CONVERTIMOS A MINUTOS LOS DIAS Y HORAS
                                $totaldeminh=$horaentero*60;
                                $totalminDia=$diasentero*1440;

                                //SUMAMOS TODOS LOS MINUTOS EN UNA SOLA VARIABLE
                                $resultadomin=$totaldeminh+$totalminDia+$minutos;
                                             
                                ///CONVERTIMOS A HORAS TODOS LOS MINUTOS
                                $resultadohora=$resultadomin/60;
                                $tiempo=$resultadohora;
                                $fontcolor='#000000';
                                if ($resultadohora>96) 
                                {
                                  $backgroundfila='#D0E2D1'; 
                                }
                                if ($resultadohora>24 and $resultadohora<=96) 
                                {
                                  $backgroundfila='#42A4D2'; 
                                }
                                if ($resultadohora>8 and $resultadohora<=24) 
                                {
                                  $backgroundfila='#39B743'; 
                                }
                                if ($resultadohora>3 and $resultadohora<=8) 
                                {
                                  $backgroundfila='#F5EB0F'; 
                                }
                                if ($resultadohora>1 and $resultadohora<=3) 
                                {
                                  $backgroundfila='#F5860F'; 
                                }
                                if ($resultadohora>0 and $resultadohora<=1) 
                                {
                                  $backgroundfila='red'; 
                                }

                                

                    }
                  }/*FIN DEL ELSE CUANDO UNA ORDEN NO ESTA SERRADA*/
               /*HASTA AQUI PONE LOS COLORES DE SU URGENCIAS*/


        //         echo "<tr style='background: $backgroundfila; color:$fontcolor;'>";
                      //SE ENCRIPTA EL CODIGO DE LA ORDEN PARA ENVIARLO POR LA URL //
                      $mascara=$fil['codigo']*10987654321;
                       $encriptado=base64_encode($mascara);
                        /*VERIFICA SI LA ORDEN ESTA PREDATADA POR VERDADERO MUESTA LA FILA DE COD ORDEN NOMALMENTE*/
                       if ($fil['Inicio']<=$concat)
                       {
        //                  echo "<td class='tdcod'><a style='color:$fontcolor;' href='ordenadmin.php?squart=$encriptado'>$fil['codigo']</a></td>";
        $numeroOrden=$fil['codigo'];
                       }
                       else/*POR FALSO MUESTA EL CODIGO CON UN * AL LADO*/
                       {
        //                 echo "<td class='tdcod'>*<a style='color:$fontcolor;' href='ordenadmin.php?squart=$encriptado'>$fil['codigo']</a></td>";
        $numeroOrden='*'.$fil['codigo'];                
                       }
                        
        //                echo "<td> $fil['fecha_giro']</td>";
        $fechaGiro=$fil['fecha_giro'];
                    //
                       ini_set('date.timezone','America/La_Paz');
                      $fechoyal=date("Y-m-d");
                      $horita=date("H:i");
                      $concat=$fechoyal.' '.$horita; 

                   ////CODIGO PARA COMPARACION DE HORAS//////////////////////////////////////////////////////////////////
                      $fec=$fil['fin'];
                      $newfec=date_create($fec);
                     $formatofechafin=date_format($newfec, 'Y-m-d H:i');

                      $fecha1 =new DateTime($concat);//fecha y hora del sistema
                      $fecha2 =new DateTime($formatofechafin); //FECHA Y HORA DE TERMINO DE VIGENCIA DE LA ORDEN
                      $intervalo= $fecha1->diff($fecha2);

                      //CONVERTIMOS A ENTEROS DIAS,HORAS Y MINUTOS PARA PODER HACER CALCULOS
                   $diasentero=intval($intervalo->format('%d'));
                   $horaentero=intval($intervalo->format('%H'));
                   $minutos=intval($intervalo->format('%i'));

          /// CONVERTIMOS A MINUTOS LOS DIAS Y HORAS
                   $totaldeminh=$horaentero*60;
                   $totalminDia=$diasentero*1440;

                  // /SUMAMOS TODOS LOS MINUTOS EN UNA SOLA VARIABLE
              $resultadomin=$totaldeminh+$totalminDia+$minutos;
             
             ///CONVERTIMOS A HORAS TODOS LOS MINUTOS
              $resultadohora=$resultadomin/60;
                    
                    if ($fecha1>$fecha2) {
                      $msm='orden vencida';
                    }
                    else{
                      $msm='hay vigencia';
                    }

           /////////////////////////////////////////////////////////////////////////////////////////////////////  
                   $objpresup=new Presupuesto();
                        $listado=$objpresup->mostrarfechaspresupuestoyentrega($fil['codigo']);
                        $filapres=mysqli_fetch_array($listado);

        //               echo "<td>$filapres['fecha_presupuesto']</td>";
        $fechaPresupuesto=$filapres['fecha_presupuesto'];                 

                       // echo "<td>$fil->fecpresupuesto</td>";//aun no hay ni en la consulta, dato aleatoria
        //                echo "<td>$fil['fecha_recepcion']</td>"; //hay en la consulta, pero esta vacia
        $fechaRecepcion=$fil['fecha_recepcion'];
        //                echo "<td>$filapres['fecha_entrega']</td>"; 
        $fechaCargaDinero=$filapres['fecha_entrega'];

                        $objdesc=new DescargaProcurador();
                        $resultado=$objdesc->mostrarfechadescarga($fil['codigo']);
                        $filafe=mysqli_fetch_array($resultado);

        //                 echo "<td>$filafe['fecha_descarga']</td>";
        $fechaDescarga=$filafe['fecha_descarga'];
        //                echo "<td>$fil['Inicio']</td>";
        $fechaInicio=$fil['Inicio'];
        //                echo "<td>$fil['fin']</td>";
        $fechaFin=$fil['fin'];

                        $objconfir=new Confirmacion();
                        $resp=$objconfir->mostrarfechasdeconfirmacion($fil['codigo']);
                        $filaco=mysqli_fetch_array($resp);


        //                 echo "<td>$filaco['fecha_confir_abogado']</td>";//aun no hay ni en la consulta, dato aleatoria
        $fechaConfirMoAbogado=$filaco['fecha_confir_abogado'];             
        //                  echo "<td>$filaco['fecha_confir_contador']</td>";//aun no hay ni en la consulta, dato aleatoria
        $fechaConfirMoContador=$filaco['fecha_confir_contador'];
        //                 echo "<td>$fil['fecha_cierre']</td>"; //hay en la consulta, pero esta vacia
        $fechaCierre=$fil['fecha_cierre'];         
        //               echo "<td>$fil['prioridad']</td>";
        $numeroPrioridad=$fil['prioridad'];
                        switch ($fil['condicion']) {
                          case 1:$PlazoHoras="mas de 96"; break;
                          case 2:$PlazoHoras="24-96"; break;
                          case 3:$PlazoHoras="8-24"; break;
                          case 4:$PlazoHoras="3-8"; break;
                          case 5:$PlazoHoras="1-3"; break;
                          case 6:$PlazoHoras="0-1"; break;
                          
                        }

                     

          //              echo "<td>$fil['Compra']</td>";
          $compraProcuraduria=$fil['Compra'];
          //             echo "<td>$fil['Venta']</td>";
          $ventaProcuraduria=$fil['Venta'];
          //              echo "<td>$fil['Penalidad']</td>";
          $penalidadProcuraduria=$fil['Penalidad'];

                        $obdesc=new DescargaProcurador();
                        $resss=$obdesc->mostrardescargaorden($fil['codigo']);
                        $filadd=mysqli_fetch_array($resss);

                        $totalcostojudicompra=$filadd['comprajudicial']+$totalcostojudicompra;

          //              echo "<td>$filadd['comprajudicial']</td>";//ES LO QUE GASTO EL PROCURADOR(COSTO JUDICIAL COMPRA)
          $costoJudicialCompra=$filadd['comprajudicial'];

                        $obcosf=new Costofinal();
                        $ls=$obcosf->mostrarcostosdeunaorden($fil['codigo']);
                        $filc=mysqli_fetch_array($ls);

                        $totlacostojudiventa=$filc['costo_procesal_venta']+$totlacostojudiventa;

          //              echo "<td>$filc['costo_procesal_venta']</td>";//ES LO QUE LE COBRAMOS POR EL COSTO JUDICIAL
          $costoJudicialVenta=$filc['costo_procesal_venta'];
                        
                        $obcc=new Costofinal();
                        $ll=$obcc->mostrarcompraparaprocuradr($fil['codigo']);
                        $filcc=mysqli_fetch_array($ll);

                        $totalparaprocurador=$filcc['Compraproc']+$totalparaprocurador;

          //             echo "<td>$filcc['Compraproc']</td>";//muestra el costo de procuradoria, sea positivo o negativo
          $costoProcuraduriaCompra_para_Procurador=$filcc['Compraproc'];

                        $totalventaprocurador=$filc['costo_procuradoria_venta']+$totalventaprocurador;
          //              echo "<td>$filc['costo_procuradoria_venta']</td>";//muestra lo que le cobramos al cliente por el procurador
          $costoProcuraduriaVentaCli=$filc['costo_procuradoria_venta'];
                        $totalegreso=$filc['total_egreso']+$totalegreso;

          //              echo "<td>$filc['total_egreso']</td>";//muestra todo lo que lecosto al cliente hacer esa orden 
          $totalEgresoParaCliente=$filc['total_egreso'];
          //             echo "<td>$fil['procuradorasig']</td>";
          $ProcuradorAsignado=$fil['procuradorasig'];
          //             echo "<td>$fil['calificacion_todo']</td>";
          $calificacionOrden=$fil['calificacion_todo'];
                      
          //        echo "</tr>";

$bloqueDatosOrdenes=<<<EOF
<table border="0.1px">
<thead>
<tr style="page-break-inside: avoid;background-color: $backgroundfila; color:$fontcolor;" nobr="true">
   <th style="text-align:center; width:30px; ">$numeroOrden</th>
   <th style="text-align:center; width:50px; ">$fechaGiro</th>
   <th style="text-align:center; width:50px; ">$fechaPresupuesto</th>
   <th style="text-align:center; width:50px; ">$fechaRecepcion</th>
   <th style="text-align:center; width:50px; ">$fechaCargaDinero</th>
   <th style="text-align:center; width:50px; ">$fechaDescarga</th>
   <th style="text-align:center; width:50px; ">$fechaInicio</th>
   <th style="text-align:center; width:50px; ">$fechaFin</th>
   <th style="text-align:center; width:50px; ">$fechaConfirMoAbogado</th>
   <th style="text-align:center; width:50px; ">$fechaConfirMoContador</th>
   <th style="text-align:center; width:50px; ">$fechaCierre</th>
   <th style="text-align:center; width:30px; ">$numeroPrioridad</th>
   <th style="text-align:center; width:30px; ">$PlazoHoras</th>
   <th style="text-align:center; width:30px; ">$compraProcuraduria</th>
   <th style="text-align:center; width:20px; ">$ventaProcuraduria</th>
   <th style="text-align:center; width:30px; ">$penalidadProcuraduria</th>
   <th style="text-align:center; width:30px; ">$costoJudicialCompra</th>
   <th style="text-align:center; width:20px; ">$costoJudicialVenta</th>
   <th style="text-align:center; width:30px; ">$costoProcuraduriaCompra_para_Procurador</th>
   <th style="text-align:center; width:30px; ">$costoProcuraduriaVentaCli</th>
   <th style="text-align:center; width:30px; ">$totalEgresoParaCliente</th>
   <th style="text-align:center; width:50px; ">$ProcuradorAsignado</th>
   <th style="text-align:center; width:45px; ">$calificacionOrden</th>
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloqueDatosOrdenes,false,false,false,false,'');

  }/*FIN DEL WHILE QUE RRECORE LAS ORDENES*/

/***************************TABLA TOTAL EGRESOS DE LAS ORDENES*************/
$bloqueTotalesCostosOrdenes=<<<EOF
<table border="0.1px" cellpadding="1" >
<tr style="page-break-inside: avoid;" nobr="true">
   <td style="text-align:center; width:670px;">TOTALES EGRESOS</td>
   <td style="text-align:center; width:30px;">$totalcostojudicompra</td>
   <td style="text-align:center; width:20px;">$totlacostojudiventa</td>
   <td style="text-align:center; width:30px;">$totalparaprocurador</td>
   <td style="text-align:center; width:30px;">$totalventaprocurador</td>
   <td style="text-align:center; width:30px;">$totalegreso</td>

   <td style="text-align:center; width:50px;"></td>
   <td style="text-align:center; width:45px;"></td>
   
</tr>

</table>
EOF;

$pdf->writeHTML($bloqueTotalesCostosOrdenes,false,false,false,false,'');

  $pdf->Ln(10);
/*************************************FIN DEL LISTADO DE ORDENES*************************/



#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(34, 30 ,2.5);


/****************************************LISTADO DE INGRESOS******************************/
$pdf->SetFont('','',12);
$pdf->Cell(0, 0, 'INGRESOS', 0, 1, 'C', 0, '', 1);

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
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="text-align:center; width:200px;">$fila[fecha_deposito]</th>
   <th style="width:605px;">$fila[detalle_deposito]</th>
   
   <th style="text-align:right; width:100px;">$fila[monto_deposito]</th>
   
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloqueIngresos,false,false,false,false,''); 
    }
/***************FILA DE TOTAL INGRESOS***********************************************/
$totaldepositosFormato=number_format($totaldepositos, 2, '.', ' ');
$bloqueTOTALdep=<<<EOF
<table border="0.1px" cellpadding="1">
  
  <thead>
    <tr nobr="true">
      <th style="text-align:center; width:805px; ">TOTAL INGRESOS</th>  
      <th style="text-align:right; width:100px; ">$totaldepositosFormato</th>
    </tr>
  </thead>

</table>
EOF;
$pdf->writeHTML($bloqueTOTALdep,false,false,false,false,'');
  $pdf->Ln(16);
/*************************************FIN DEL LISTADO DE INGRESOS (DEPOSITOS)******************************/









/************************LISTADOR DE TRANSFERENCIAS********************************************/
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(34, 30 ,2.5);
$pdf->SetFont('','',12);


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
/***********************FIN DEL LISTADO DE TRANSFERENCIAS***************************************/









/************************LISTADO DE DEVOLUCIONES AL CLIENTE**********************************/
$pdf->SetFont('','',12);

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
<table border="0.1px" cellpadding="1" >

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

#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(144, 30 ,121.5);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);





/***********************TABLA DE RESUMEN TOTAL*****************************************/
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(144, 30 ,121.5);
$pdf->SetFont('','',12);

$pdf->Ln(1);
$pdf->SetFont('','',8);


$totalTranferenciasRecibidasFormato=number_format($totalTranferenciasRecibidas, 2, '.', ' ');

$totalTranferenciaEntregadasFormato=number_format($totalTranferenciaEntregadas, 2, '.', ' ');

$totalegreasotodasordenFormato=number_format($totalegreso, 2, '.', ' ');


$saldototal=$totaldepositos-$totalegreso+$totalTranferenciasRecibidas-$totalTranferenciaEntregadas-$totaldevuelto;

$saldototalFormato=number_format($saldototal, 2, '.', ' ');





$bloqueTablaResumen=<<<EOF
<center>
<table border="0.1px" nobr="true" cellpadding="1">

  <thead>
    <tr>
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

$nombre='ListaOrdenes_'.$codigocausa.'.pdf';

$pdf->Output($nombre);

?>