<?php
require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
include_once('../../../model/clscausa.php');

include_once('../../../model/clsordengeneral.php');


include_once('../../../model/clsdeposito.php');
include_once('../../../model/clspresupuesto.php');
include_once('../../../model/clsdescarga_procurador.php');
include_once('../../../model/clsconfirmacion.php');
include_once('../../../model/clscostofinal.php');
include_once('../../../model/clsdevoluciondinero.php');
/*INFORME DE PRUEBA CON LA LIBRERIA DOMPDF, el encbezado se puede repetir en las hojas*/
 $codcausa=$_GET['cod'];
  //SE DESENCRIPTA EL CODIGO PARA PODER USARLO //
   $decodificado=base64_decode($codcausa);

   $codigonuevo=$decodificado/1234567;
  // $codigonuevo=2;
   $objc=new Causa();
$resc=$objc->mostrarUnacausa($codigonuevo);
$fill=mysqli_fetch_object($resc);
$cliente=$fill->clienteasig;
$codigocausa=$fill->codigo;

$BLOQUE_1="
<html>
<head>
  <style>
   #tablapdf{
  font-family:'Arial Narrow',sans-serif;
  border-collapse: collapse;
  
}
#tablapdf td, #tablapdf th {
  border: 1px solid #ddd;
  
  text-align: center;
   border: 1px solid #000;
   border-spacing: 0;

}

#tablapdf tr:hover {background-color: #ddd;}
#tablapdf th { 
  background-color: #82C244;
  color: white;
}
#idimg {
  float:left;
  width:250px;
  margin-top:5px;
} 

    @page { margin: 60px; }
    #header { position: fixed; left: 0px; top: -60px; right: 0px; height: 50px; background-color: white; text-align: center; }
    #footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 50px; background-color: white; }
    #footer .page:after { content: counter(page, upper-number); }
  </style>
<body>
  <div id='header'>
   <img id='idimg' src='images/logoserrate3.jpg'>
   
  </div>
  <!--<div id='footer'>
    <p class='page'>Pagina </p>
  </div> -->




<div id='content'>
    
 
<center><h3>CAUSA: $codigocausa</h3>
<h3>EGRESOS (LISTADO DE ORDENES) </center></h3>




<table width='1224px;' style='font-size:8px;'  id='tablapdf'>
  <thead>
     <tr>
    <td style='text-align:center; width:35.5px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center; width:684px;  background-color:#e8e8e8;'>FECHAS</td>
    <td style='text-align:center; width:188px;  background-color:#e8e8e8;'>COTIZACION</td>
    <td style='text-align:center; width:181.5px;  background-color:#e8e8e8;'>FINANZAS</td>
    <td style='text-align:center;    background-color:#e8e8e8;'> </td> 
    </tr>
 </thead>
  <tbody>  
  </tbody>
</table>

<table  style='font-size:8px;'  id='tablapdf'>
  <thead>
     <tr>
    <td style='text-align:center;  width:35.5px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center;  width:272px; background-color:#e8e8e8;'>FECHAS DE CARGA</td>
    <td style='text-align:center;  width:66px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center;  width:134px; background-color:#e8e8e8;'>VIGENCIA DE LA ORDEN</td>
    <td style='text-align:center;  width:203px;  background-color:#e8e8e8;'>MOMENTOS PARA EL CIERRE DE LA ORDEN</td>
    <td style='text-align:center;  width:82.5px; background-color:#e8e8e8;'>PARAMETROS USADOS PARA COTIZAR ESTA ORDEN</td>
    <td style='text-align:center;  width:102.5px; background-color:#e8e8e8;'>COTIZACION DE PROCURADURIA</td>
    <td style='text-align:center;  width:59px;  background-color:#e8e8e8;'>COSTO JUDICIAL Bs.</td>
    <td style='text-align:center;  width:75.5px; background-color:#e8e8e8;'>COSTO DE PROCURADURIA</td>
    <td style='text-align:center;  width:41px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center;   background-color:#e8e8e8;'> </td>
    </tr>
  </thead>
  <tbody>  
  </tbody>
</table>





<table width='1224px;' style='font-size:8px;'  id='tablapdf'>
  <thead>
     <tr>
    <td style='text-align:center;  width:35.5px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center;  width:134px; background-color:#e8e8e8;'>INFORMACION Y DOCUMENTACION</td>
    <td style='text-align:center;  width:135px; background-color:#e8e8e8;'>DINERO</td>
    <td style='text-align:center;  width:66px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center;  width:65px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center;  width:66px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center;  width:134.5px; background-color:#e8e8e8;'>FECHAS DE PRONUNCIAMIENTOS</td>
    <td style='text-align:center;  width:65.5px; background-color:#e8e8e8;'> </td>

    <td style='text-align:center;  width:39.5px; background-color:#e8e8e8; font-size:5px;'> </td>
    <td style='text-align:center;  width:40px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center;  width:31.5px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center;  width:25px; background-color:#e8e8e8;font-size:5px;'> </td>
    <td style='text-align:center;  width:40px; background-color:#e8e8e8;font-size:5px;''> </td>

    <td style='text-align:center;  width:31.5px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center;  width:25px; background-color:#e8e8e8;font-size:5px;'> </td>

    <td style='text-align:center;  width:42px; background-color:#e8e8e8;font-size:5px;'> </td>
    <td style='text-align:center;  width:30px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center;  width:41px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center;  width:60px; background-color:#e8e8e8;'> </td>
    <td style='text-align:center;   background-color:#e8e8e8;font-size:6px;'> </td>

    </tr>
  </thead>

  <tbody>
    
  </tbody>

</table>





<table width='1224px;' style='font-size:8px;'  id='tablapdf'>
  <thead>
    <tr>
    <td style='text-align:center; width:35px; background-color:#e8e8e8;'>#ORDEN</td>
    <td style='text-align:center; width:65px; background-color:#e8e8e8;'>GIRO</td>
    <td style='text-align:center; width:65px; background-color:#e8e8e8;'>PRESUPUESTO</td>
    <td style='text-align:center; width:65px; background-color:#e8e8e8;'>CARGA MATERIAL DE INF. Y DOC.</td>
    <td style='text-align:center; width:65px; background-color:#e8e8e8;'>ENTREGA DE DINERO</td>
    <td style='text-align:center; width:65px; background-color:#e8e8e8;'>FECHA DE DESCARGA</td>
    <td style='text-align:center; width:65px; background-color:#e8e8e8;'>INICIO</td>
    <td style='text-align:center; width:65px; background-color:#e8e8e8;'>FIN</td>
    <td style='text-align:center; width:65px; background-color:#e8e8e8;'>DEL ABOGADO</td>
    <td style='text-align:center; width:65px;  background-color:#e8e8e8;'>DEL CONTADOR</td>
    <td style='text-align:center; width:65px;  background-color:#e8e8e8;'>FECHA OFICIAL DE CIERRE</td>

    <td style='text-align:center; width:30px;  background-color:#e8e8e8; font-size:7px;'>NIVEL DE PRIORIDAD</td>
    <td style='text-align:center; width:40px;   background-color:#e8e8e8;'>PLAZO EN HORAS</td> 
    <td style='text-align:center; width:30px;   background-color:#e8e8e8; font-size:7px;'>COMPRA</td>
    <td style='text-align:center; width:25px;   background-color:#e8e8e8; font-size:7px;'>VENTA</td> 
    <td style='text-align:center; width:30px;   background-color:#e8e8e8; font-size:7px;'>PENALIDAD</td>

    <td style='text-align:center; width:30px;   background-color:#e8e8e8;font-size:7px;'>COMPRA</td> 
    <td style='text-align:center; width:25px;   background-color:#e8e8e8;font-size:7px;'>VENTA</td>

    <td style='text-align:center; width:40px;   background-color:#e8e8e8;'>COMPRA (para el procurador)</td>
    <td style='text-align:center; width:30px;   background-color:#e8e8e8;'>VENTA (para el cliente)</td>
    <td style='text-align:center; width:40px;   background-color:#e8e8e8;'>TOTAL EGRESO (para el cliente)</td>
    <td style='text-align:center; width:60px;   background-color:#e8e8e8;'>PROCURADOR (GESTOR)</td>
    <td style='text-align:center; width:50px;   background-color:#e8e8e8;'>CALIFICACION (suficiente/ insuficiente)</td>
    </tr>
 </thead>
  <tbody>";



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






     
  $BLOQUE_1.="<tr style=' background-color: $backgroundfila; color:$fontcolor;' >
    <td style='text-align:center; width:35px;'>$numeroOrden</td>
    <td style='text-align:center; width:65px;'>$fechaGiro</td>
    <td style='text-align:center; width:65px;'>$fechaPresupuesto</td>
    <td style='text-align:center; width:65px;'>$fechaRecepcion</td>
    <td style='text-align:center; width:65px;'>$fechaCargaDinero</td>
    <td style='text-align:center; width:65px;'>$fechaDescarga</td>
    <td style='text-align:center; width:65px;'>$fechaInicio</td>
    <td style='text-align:center; width:65px;'>$fechaFin</td>
    <td style='text-align:center; width:65px;'>$fechaConfirMoAbogado</td>
    <td style='text-align:center; width:65px;'>$fechaConfirMoContador</td>
    <td style='text-align:center; width:65px;'>$fechaCierre</td>

    <td style='text-align:center; width:30px;'>$numeroPrioridad</td>

    <td style='text-align:center; width:40px;'>$PlazoHoras</td> 
    <td style='text-align:center; width:30px;'>$compraProcuraduria</td>
    <td style='text-align:center; width:25px;'>$ventaProcuraduria</td> 
    <td style='text-align:center; width:30px;'>$penalidadProcuraduria</td>

    <td style='text-align:center; width:30px;'>$costoJudicialCompra</td> 
    <td style='text-align:center; width:25px;'>$costoJudicialVenta</td>

    <td style='text-align:center; width:40px;'>$costoProcuraduriaCompra_para_Procurador</td>
    <td style='text-align:center; width:30px;'>$costoProcuraduriaVentaCli</td>
    <td style='text-align:center; width:40px;'>$totalEgresoParaCliente</td>
    <td style='text-align:center; width:60px;'>$ProcuradorAsignado</td>
    <td style='text-align:center; width:50px;'>$calificacionOrden</td>
    </tr>  
";
}
$BLOQUE_1.="<tr >
   <td style='text-align:center;' colspan='16'>TOTALES EGRESOS</td>
   <td style='text-align:center; '>$totalcostojudicompra</td>
   <td style='text-align:center; '>$totlacostojudiventa</td>
   <td style='text-align:center; '>$totalparaprocurador</td>
   <td style='text-align:center; '>$totalventaprocurador</td>
   <td style='text-align:center; '>$totalegreso</td>

   <td style='text-align:center; '> </td>
   <td style='text-align:center; '> </td>
   
</tr>";
$BLOQUE_1.="
</tbody>
</table> <br>";


/*********************************DEPOSITOS********************************/
$BLOQUE_1.="
<center><h3>INGRESOS</h3></center>";
$BLOQUE_1.="
<table  width='100%' style='font-size:8px;' id='tablapdf'>
  <thead>
   <tr>
    <td style='background-color:#e8e8e8; width:10%;'>FECHA</td>
    <td style='background-color:#e8e8e8;text-align:center; width:80%;'>DETALLE</td>
    <td style='background-color:#e8e8e8;text-align:center; width:10%;'>MONTO</td> 
    </tr>
   </thead>
  <tbody>";

$totaldepositos=0;
$objdep=new Deposito();
$resuldep=$objdep->Listardepositodecausa($codigonuevo);
while ($fila=mysqli_fetch_array($resuldep)) 
   {
     
   $totaldepositos=$totaldepositos+$fila['monto_deposito'];
$BLOQUE_1.="
<tr nobr='true'>
   <td style='text-align:center; '>$fila[fecha_deposito]</td>
   <td style='text-align:left;'>$fila[detalle_deposito]</td>
   
   <td style='text-align:right; '>$fila[monto_deposito]</td>
   
</tr>";
    }
$totaldepositosFormato=number_format($totaldepositos, 2, '.', ' ');
$BLOQUE_1.="
<tr nobr='true'>
   <td style='text-align:center; ' colspan='2'>TOTAL INGRESOS</td>
   <td style='text-align:right;'>$totaldepositos</td>
</tr>";
    
 $BLOQUE_1.="
 </tbody>
  </table><br>";

/*****************FINDE TABLA INGRESOS************************/


/*********************************TRANSFERENCIAS********************************/
$BLOQUE_1.="
<center><h3>TRANSFERENCIAS ENTRE SUS CAUSAS</h3></center>";
$BLOQUE_1.="
<table  width='100%' style='font-size:8px;' id='tablapdf'>
  <thead>
   <tr>
    <td style='background-color:#e8e8e8; width:45%;'>TRANSFERECIA DE: (INGRESO)</td>
    <td style='background-color:#e8e8e8;text-align:center; width:45%;'>TRANSFERECIA A: (EGRESO)</td>
    <td style='background-color:#e8e8e8;text-align:center; width:10%;'>MONTO</td> 
    </tr>
   </thead>
  <tbody>";

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

$BLOQUE_1.="
    <tr style='page-break-inside: avoid;' nobr='true'>
    <td style='text-align:center;  width:45%; '>$filacausaorigen[codigo]</td>
    <td style='text-align:center;  width:45%; '> </td>
    <td style='text-align:right;  width:10%; '>$filacausa[monto_deposito]</td>
    </tr>";

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
$BLOQUE_1.="
    <tr style='page-break-inside: avoid;' nobr='true'>
    <td style='text-align:center;  width:425px; '> </td>
    <td style='text-align:center;  width:425px; '>$filacausadestino[codigo]</td>
    <td style='text-align:right;  width:55px; ''>$filacausasalida[monto_deposito]</td>
    </tr>";

        } /*FIN DEL WHILE QUE RRECORRE LAS TRANSFERENCIAS EMTREGADAS A OTRAS CAUSAS*/  
    
 $BLOQUE_1.="
 </tbody>
  </table><br>";

/*****************FINDE TABLA TRANSFERENCIAS************************/



/*********************************DEVOLUCIONES********************************/
$BLOQUE_1.="
<center><h3>DEVOLUCIONES AL CLIENTE</h3></center>";
$BLOQUE_1.="
<table  width='100%' style='font-size:8px;' id='tablapdf'>
  <thead>
   <tr>
    <td style='background-color:#e8e8e8; width:90%;'>FECHA</td>
    <td style='background-color:#e8e8e8;text-align:center; width:10%;'>MONTO</td> 
    </tr>
   </thead>
  <tbody>";

$objdevolu=new DevolucionDinero();
        $resuldev=$objdevolu->listarLasDevolucionesdeCausa($codigonuevo);
        $totaldevuelto=0;
        while ($filadev=mysqli_fetch_array($resuldev))
        {
            $totaldevuelto=$totaldevuelto+$filadev['montodevolucion'];
        
      $BLOQUE_1.="
          <tr style='page-break-inside: avoid;' nobr='true'>
          
          <td style=''>$filadev[fechadevolucion]</td>
          <td style='text-align:right; '>$filadev[montodevolucion]</td>
          </tr>";
     
        }/*FIN DEL WHILE QUE RRECORE TODAS LAS DEVOLUCIONES*/

/*TOTAL DEVOLUCIONES*/
$totaldevueltoFormato=number_format($totaldevuelto, 2, '.', ' ');
$BLOQUE_1.="
    <tr style='page-break-inside: avoid;' nobr='true'>
    
    <td style='text-align:center;   '>TOTAL DEVOLUCIONES</td>
    <td style='text-align:right;   '>$totaldevueltoFormato</td>
    </tr>";

    
 $BLOQUE_1.="
 </tbody>
  </table><br>";

/*****************FINDE TABLA DEVOLUCIONES************************/
$totalTranferenciasRecibidasFormato=number_format($totalTranferenciasRecibidas, 2, '.', ' ');

$totalTranferenciaEntregadasFormato=number_format($totalTranferenciaEntregadas, 2, '.', ' ');

$totalegreasotodasordenFormato=number_format($totalegreso, 2, '.', ' ');


$saldototal=$totaldepositos-$totalegreso+$totalTranferenciasRecibidas-$totalTranferenciaEntregadas-$totaldevuelto;

$saldototalFormato=number_format($saldototal, 2, '.', ' ');

/***********************TABLA DE RESUMEN TOTAL*****************************************/
$BLOQUE_1.="
<center>
<table width='50%' style='font-size:10px; margin-left:500px;' id='tablapdf'>

  <thead>
    <tr>
      <td style='text-align:center; font-size:15px;' colspan='2'>RESUMEN</td>
    </tr>

    <tr style='page-break-inside: avoid;'>
    <td style='text-align:center;  width:200px; '>TOTAL EGRESOS</td>
    <td style='text-align:right;  width:55px;'>-$totalegreasotodasordenFormato</td>
    </tr>

    <tr style='page-break-inside: avoid;'>
    <td style='text-align:center;  width:200px; '>TOTAL INGRESOS</th>
    <td style='text-align:right;  width:55px; '>$totaldepositosFormato</td>
    </tr>

    <tr style='page-break-inside: avoid;'>
    <td style='text-align:center;  width:200px; '>TOTAL TRANSFERENCIA RECIBIDA</td>
    <td style='text-align:right;  width:55px; '>$totalTranferenciasRecibidasFormato</td>
    </tr>

    <tr style='page-break-inside: avoid;'>
    <td style='text-align:center;  width:200px; '>TOTAL TRANSFERENCIA ENTREGADA</td>
    <td style='text-align:right;  width:55px; '>-$totalTranferenciaEntregadasFormato</td>
    </tr>

    <tr style='page-break-inside: avoid;'>
    <td style='text-align:center;  width:200px; '>TOTAL DEVUELTO AL CLIENTE</td>
    <td style='text-align:right;  width:55px; '>-$totaldevueltoFormato</td>
    </tr>

    <tr style='page-break-inside: avoid;'>
    <td style='text-align:center;  width:200px; '>SALDO</td>
    <td style='text-align:right;  width:55px; '>$saldototalFormato</td>
    </tr>



  </thead>

</table>
</center>
";

/**********************FIN DE LA TABLA RESUMEN TOTAL**************************************/




$BLOQUE_1.="
 </div>


</body>
</html>";



//CODIGO PARA VISUALIZAR EL PDF



$dompdf=new Dompdf();
$dompdf->load_html($BLOQUE_1);
$dompdf->setPaper('LEGAL','landscape');
ini_set("memory_limit", "32M");
$dompdf->render();

// add the header 
$canvas = $dompdf->get_canvas(); 
//$font = get_font("helvetica", "bold"); 

// the same call as in my previous example 
$canvas->page_text(470, 585, "Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 8, array(0,0,0)); 

$dompdf->stream("Informe1.pdf",array("Attachment" => 0));
?>