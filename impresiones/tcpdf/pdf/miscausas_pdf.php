<?php

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

include_once('../../../../model/clscausa.php');
include_once('../../../../model/clsordengeneral.php');
include_once('../../../../model/clsautoorden.php');
// create new PDF document
$pdf = new TCPDF('L', 'mm', 'Legal', true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();
$pdf->SetFont('','',10);
/*===============================================================
TAMAÑO TOTAL DE LA HOJA OFICIO ECHADA(ORIZONTAL)=785px DISPONIBLE PARA OCUPAR CON DATOS
/*===============================================================*/

$bloque1=<<<EOF

<table border="0.1px">
	<thead>
	   <tr>
		<th style="text-align:center; height: 20px; width:100px; background-color:#e8e8e8;">CODIGO</th>
		<th style="text-align:center; height: 20px; width:130px; background-color:#e8e8e8;">NOMBRE DEL PROCESO</th>
		<th style="text-align:center; height: 20px; width:80px; background-color:#e8e8e8;">PROCURADOR</th>
		<th style="text-align:center; height: 20px; width:80px; background-color:#e8e8e8;">CLIENTE</th>
		<th style="text-align:center; height: 20px; width:80px; background-color:#e8e8e8;">CATEGORIA</th>
		<th style="text-align:center; height: 20px; width:315px; background-color:#e8e8e8;">OBSERVACIONES</th>
		</tr>
	</thead>

	<tbody>
		
	</tbody>

</table>
EOF;
$pdf->writeHTML($bloque1,false,false,false,false,'');
//FIN DEL BLOQUE 1

$pdf->SetFont('','',8);
//EMPIEZA EL BLOQUE 2
$objcausa=new Causa();
$resulcausa=$objcausa->listarcausasDeAbogado(3);
while ($filc=mysqli_fetch_array($resulcausa)) 
{ 
	$ordenescausa="";
	/*ORDENES SIN SERRAR*/
	           $cont=0;
               $objordenes=new OrdenGeneral();
               $listadoor=$objordenes->listarordenssinserrardecausa($filc["id_causa"]);
               while ($filord=mysqli_fetch_object($listadoor)) 
               {  /*FECHA Y HORA ACTUAL DE BOLIVIA*/
                  if ($cont==0) 
                  {
                    $ordenescausa.="<br>";
                  }

                  ini_set('date.timezone','America/La_Paz');
                  $fechoyal=date("Y-m-d");
                  $horita=date("H:i");
                  $concat=$fechoyal.' '.$horita;

                  $vard='';

                  $objordenn=new OrdenGeneral();
                  $resultado=$objordenn->mostrarCondicionyPrioridadOrden($filord->codorden);
                  $filorden=mysqli_fetch_object($resultado);
                  $prioriorden=$filorden->Prioridadorden;

                  /*FUNCION QUE MUESTRA LA FECHA FINAL Y HORA FINA DE UNA ORDEN*/
                  $objneworden=new OrdenGeneral();
                  $resultadoorden=$objneworden->mostrarfechayhorafin($filord->codorden);
                   $filordd=mysqli_fetch_object($resultadoorden);

                   $fechafinorden=$filordd->Fechafin;
                   $newfechfin=date_create($fechafinorden);
                   $fechafinformato=date_format($newfechfin, 'Y-m-d H:i');

                   $fecha1 =new DateTime($concat);/*fechas de la zona horaria*/
                   $fecha2 =new DateTime($fechafinformato);/*FECHA Y HORA FINAL DE LA ORDEN*/

                   /*COMPARACION DE FECHAS */
                   if ($fecha1>$fecha2) {
                        $vard='R';
                        $varconcat=$vard.$prioriorden;

                        $varcaraorden="<strike>$varconcat</strike>";
                   }

                   else{

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

                             if ($resultadohora>=96) {
                               $varcaraorden='G'.$prioriorden;
                             }
                             if ($resultadohora>=24 and $resultadohora<96) {
                               $varcaraorden='C'.$prioriorden;
                             }
                             if ($resultadohora>=8 and $resultadohora<24) {
                               $varcaraorden='V'.$prioriorden;
                             }

                             if ($resultadohora>=3 and $resultadohora<8) {
                               $varcaraorden='A'.$prioriorden;
                             }
                             if ($resultadohora>=1 and $resultadohora<3) {
                               $varcaraorden='N'.$prioriorden;
                             }
                             if ($resultadohora<1) {
                               $varcaraorden='R'.$prioriorden;
                             }

                 }/*FIN DEL ELSE*/




                 
                   $mascara=$filord->codorden*10987654321;
                   $encriptada=base64_encode($mascara);
                $ordenescausa.= " $varcaraorden  ";

                 $cont++;

                  
               }/*FIN DEL LISTADO DE ORDEN DE LA CAUSA*/
	/*FIN DE ORDENES SIN SERRAR*/

$bloque2=<<<EOF
<table border="0.1px">
<tr>
   <td style="text-align:center; width:100px;">$filc[codigo] <br> $ordenescausa</td>
   <td style="width:130px;">$filc[nombrecausa]</td>
   <td style="text-align:center; width:80px;">$filc[procuradorasig]</td>
   <td style="text-align:center; width:80px;">$filc[clienteasig]</td>
   <td style="text-align:center; width:80px;">$filc[Categ]</td>
   <td style="text-align:center; width:315px;">$filc[Observ]</td>
</tr>

</table>
EOF;
$pdf->writeHTML($bloque2,false,false,false,false,'');	
}

/*SALIDAD DEL ARCHIVO*/

$pdf->Output();
?>

