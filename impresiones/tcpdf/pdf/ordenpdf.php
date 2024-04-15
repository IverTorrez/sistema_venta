<?php
error_reporting(E_ERROR);
session_start();
if(!isset($_SESSION["useradmin"]))
{
  header("location:../../../index.php");
}
$datos=$_SESSION["useradmin"];

require_once('tcpdf_include.php');

include_once('../../../model/clscausa.php');
include_once('../../../model/clsordengeneral.php');
include_once('../../../model/clsdescarga_procurador.php');
include_once('../../../model/clspresupuesto.php');
include_once('../../../model/clsconfirmacion.php');


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


 /*RECIBE EL CODIGO DE LA ORDEN*/
 $codcausa=$_GET['cod'];
  //SE DESENCRIPTA EL CODIGO DE LA ORDEN PARA PODER USARLO //
   $decodificado=base64_decode($codcausa);

   $codigonuevo=$decodificado/10987654321;


/*===============================================================
TAMAÑO TOTAL DE LA HOJA OFICIO ECHADA(ORIZONTAL)=905px DISPONIBLE PARA OCUPAR CON DATOS, RESPETANDO LOSMARGENES ESTABLECIDOS POR CODIGO EN LA FUNCION ->SetMargins(34, 30 ,2.5)
/*===============================================================*/


$abogadonombre=$datos['nombreusuario'];
        //$pdf->Image('images/logoserrate3.jpg',10, 10, 70, 15, '', '', '', false, 300, '', false, false, 0, false,false,false);
        
        $pdf->Cell(250, 0, '                                                                                       DETALLE DE LA ORDEN', 0, 0, 'C', 0, '', 0);


        $pdf->Cell(85, 0, 'Usuario: '.$abogadonombre, 0, 1, 'R', 0, '', 1);
        $pdf->Cell(0, 0, $subtitulo, 0, 1, 'C', 0, '', 0);
$pdf->Ln(5);


$pdf->SetFont('','',8);
/*===============================================================
CABECERA DE LA TABLA
/*===============================================================*/
$bloqueCabeceraDetalle=<<<EOF

<table border="0.1px">
  <thead>
     <tr id="fila1">
  <th style="text-align:center; background-color:#e8e8e8;" rowspan="2" width="150px">CODIGO DE LA CAUSA</th>
  <th style="text-align:center; background-color:#e8e8e8;" rowspan="2" width="100px">NUMERO DE LA ORDEN</th>
  <th style="text-align:center; background-color:#e8e8e8;" colspan="2" width="250">PARAMETROS USADOS PARA COTIZAR LA ORDEN</th>
  <th style="text-align:center; background-color:#e8e8e8;" rowspan="2" width="150">ULTIMA FOJA SINCRONIZADA</th>
  <th style="text-align:center; background-color:#e8e8e8;" rowspan="2" width="255">PROCURADOR <h5>(GESTOR)</h5></th>
    
</tr>
 
 <tr id="fila2">
   <th style="text-align:center; background-color:#e8e8e8;" >NIVEL DE PRIORIDAD</th>
   <th style="text-align:center; background-color:#e8e8e8;" >PLAZO EN HORAS</th>

 </tr>
  </thead>

  

</table>
EOF;
$pdf->writeHTML($bloqueCabeceraDetalle,false,false,false,false,'');



    $objorden1=new OrdenGeneral();
   $resul=$objorden1->listardetalledeordentabla1($codigonuevo);
   $fil=mysqli_fetch_array($resul); 
  
    $codigoC= $fil['codigocausa'];
    $codorden= $fil['numeroorden'];
    $proiridadorden=$fil['Prioridad'];
            switch ($fil['Condicion']) 
              {
                case 1:$plazoHoras="mas de 96"; break;
                case 2:$plazoHoras= "24-96"; break;
                case 3:$plazoHoras= "8-24"; break;
                case 4:$plazoHoras= "3-8"; break;
                case 5:$plazoHoras= "1-3"; break;
                case 6:$plazoHoras="0-1"; break;        
              }
              $objdescarga=new DescargaProcurador();
             $list=$objdescarga->mostrarfojadescarga($codigonuevo);
             $filfoja=mysqli_fetch_array($list);

    $ultimafoja=$filfoja['ultima_foja'];
  
    $procuAsignado= $fil['procuradorasig']; 

$bloqueDatosDetalle=<<<EOF
<table border="0.1px">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="text-align:center; width:150px;">$codigoC</th>
   <th style="text-align:center; width:100px;">$codorden</th>
   <th style="text-align:center; width:125px;">$proiridadorden</th>
   <th style="text-align:center; width:125px;">$plazoHoras</th>
   <th style="text-align:center; width:150px;">$ultimafoja</th>
   <th style="text-align:center; width:255px;">$procuAsignado</th>
  
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloqueDatosDetalle,false,false,false,false,'');
$pdf->SetMargins(34, 30 ,2.5);







$pdf->Ln(10);

$bloqueFechasorden=<<<EOF

<table border="0.1px">
  <thead>
     <tr id="fila1">
     <th style="text-align:center; background-color:#e8e8e8;" colspan="4" width="360px">FECHAS DE CARGA</th>
     <th style="text-align:center; background-color:#e8e8e8;" rowspan="2" width="180px" colspan="2">FECHAS PARA LA GESTION</th>
     <th style="text-align:center; background-color:#e8e8e8;" rowspan="2" width="270px" colspan="3" >FECHAS PARA LA DESCARGA</th>
     <th style="text-align:center; background-color:#e8e8e8;" rowspan="4" width="95px">FECHA  OFICIAL DE CIERRE DE LA ORDEN</th>
    </tr>

    <tr id="fila2">
      <td style="text-align:center; background-color:#e8e8e8;" width="180px" colspan="2">INFORMACION Y DOCUMENTACION</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="180px" colspan="2">DINERO</td>
    </tr>

    <tr id="fila2">
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">FECHA 1</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">FECHA 2</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">FECHA 3</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">FECHA 4</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="180px" colspan="2">FECHA 5</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">FECHA 6</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">FECHA 7</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">FECHA 8</td>
    </tr>

    <tr id="fila2">
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">GIRO DE UNA NUEVA ORDEN</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">ASIGNACION DE PRESUPUESTO</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">CARGA MATERIAL DE INFORMACION Y DOCUMENTACION</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">ENTREGA DE DINERO</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">INICIO DE LA VIGENCIA DE LA ORDEN</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">TERMINO DE LA VIGENCIA DE LA ORDEN</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">DESCARGA GENERAL</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">PRONUCIAMIENTO DEL ABOGADO</td>
      <td style="text-align:center; background-color:#e8e8e8;" width="90px">DEVOLUCION DEL SALDO DE DINERO</td>
    </tr>
  </thead>

  

</table>
EOF;
$pdf->writeHTML($bloqueFechasorden,false,false,false,false,'');

       $objorden2=new OrdenGeneral();
        $resul=$objorden2->listarfechasdeunaorden($codigonuevo);
        $fila=mysqli_fetch_array($resul);
           
         
    $fechagiro= $fila['fecha_giro'];

          $objpresup=new Presupuesto();
          $listado=$objpresup->mostrarfechaspresupuestoyentrega($codigonuevo);
          $filapres=mysqli_fetch_array($listado);


    $fechapresupuesto=$filapres['fecha_presupuesto'];

          
    $fecharecepcion=$fila['fecha_recepcion'];
    $fechaentregapresupuesto=$filapres['fecha_entrega'];
    $FechaInicio=$fila['Inicio'];
    $FechaFin=$fila['Fin'];

            $objdesc=new DescargaProcurador();
            $resultado=$objdesc->mostrarfechadescarga($codigonuevo);
            $filafe=mysqli_fetch_array($resultado);

    $fechaDescarga=$filafe['fecha_descarga'];

          $objconfir=new Confirmacion();
          $resultconfir=$objconfir->mostrarfechasdeconfirmacion($codigonuevo);
          $filaconfir=mysqli_fetch_array($resultconfir);

    $fechaConfirAbogado=$filaconfir['fecha_confir_abogado'];
    $fechaConfirCOntador=$filaconfir['fecha_confir_contador'];

    $fechaCierre=$fila['fecha_cierre'];
    



$bloqueDatosFechas=<<<EOF
<table border="0.1px">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="text-align:center; width:90px;">$fechagiro</th>
   <th style="text-align:center; width:90px;">$fechapresupuesto</th>
   <th style="text-align:center; width:90px;">$fecharecepcion</th>
   <th style="text-align:center; width:90px;">$fechaentregapresupuesto</th>
   <th style="text-align:center; width:90px;">$FechaInicio</th>
   <th style="text-align:center; width:90px;">$FechaFin</th>
   <th style="text-align:center; width:90px;">$fechaDescarga</th>
   <th style="text-align:center; width:90px;">$fechaConfirAbogado</th>
   <th style="text-align:center; width:90px;">$fechaConfirCOntador</th>
   <th style="text-align:center; width:95px;">$fechaCierre</th>
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloqueDatosFechas,false,false,false,false,'');

$pdf->Ln(10);


$pdf->SetFont('','',10);
$pdf->Cell(300, 0, 'ELEMENTOS DE LA ORDEN', 0, 1, 'C', 0, '', 0);
$pdf->SetFont('','',8);




$bloqueCabeceraElementosordenInfo=<<<EOF

<table border="0.1px">
  <thead>
    <tr style="page-break-inside: avoid;" nobr="true">
      <th style="text-align:center; background-color:#e8e8e8;" colspan="2">INFORMACION</th>
    </tr>

   <tr style="page-break-inside: avoid;" nobr="true">
    <th style="text-align:center; background-color:#e8e8e8;" width="50%">CARGA DE INFORMACION</th>
    <th style="text-align:center; background-color:#e8e8e8;" width="50%">DESCARGA DE INFORMACION</th>
  
  </tr>
  </thead>

  

</table>
EOF;
$pdf->writeHTML($bloqueCabeceraElementosordenInfo,false,false,false,false,'');

 $objorden3=new OrdenGeneral();
$resul=$objorden3->mostrarinfodocuorden($codigonuevo);
$fila1=mysqli_fetch_array($resul);

$cargaInfo=$fila1['informacion'];


$objdesc=new DescargaProcurador();
$result=$objdesc->mostrardescargaorden($codigonuevo);
$fild=mysqli_fetch_array($result);
$descargaInformacion=$fild['detalle_informacion'];

$bloqueDatosOrdenInfo=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style=" width:50%;">$cargaInfo</th>
   <th style=" width:50%;">$descargaInformacion</th>
   
</tr>
</thead>
</table>
EOF;
$pdf->SetMargins(34, 30 ,2.5);
$pdf->writeHTML($bloqueDatosOrdenInfo,false,false,false,false,'');


$pdf->Ln(10);


$bloqueCabeceraElementosordenDoc=<<<EOF

<table border="0.1px">
  <thead>
    <tr style="page-break-inside: avoid;" nobr="true">
      <th style="text-align:center; background-color:#e8e8e8;" colspan="2">DOCUMENTACION</th>
    </tr>

   <tr style="page-break-inside: avoid;" nobr="true">
    <th style="text-align:center; background-color:#e8e8e8;" width="50%">CARGA DE DOCUMENTACION</th>
    <th style="text-align:center; background-color:#e8e8e8;" width="50%">DESCARGA DE DOCUMENTACION</th>
  
  </tr>
  </thead> 

</table>
EOF;
$pdf->SetMargins(34, 30 ,2.5);
$pdf->writeHTML($bloqueCabeceraElementosordenDoc,false,false,false,false,'');

$CargaDocumentacion=$fila1['documentacion'];
$descargaDocumentacion=$fild['documentaciondescarga'];
$bloqueDatosOrdenDocu=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style=" width:50%;">$CargaDocumentacion</th>
   <th style=" width:50%;">$descargaDocumentacion</th>
   
</tr>
</thead>
</table>
EOF;
$pdf->SetMargins(34, 30 ,2.5);
$pdf->writeHTML($bloqueDatosOrdenDocu,false,false,false,false,'');

$pdf->Ln(10);



$bloqueCabeceraElementosordenDoc=<<<EOF

<table border="0.1px">
  <thead>
    <tr style="page-break-inside: avoid;" nobr="true">
      <th style="text-align:center; background-color:#e8e8e8;" colspan="3">DINERO</th>
    </tr>

   <tr style="page-break-inside: avoid;" nobr="true">
    <th style="text-align:center; background-color:#e8e8e8;" width="50%">PRESUPUESTO</th>
    <th style="text-align:center; background-color:#e8e8e8;" width="25%">GASTO</th>
    <th style="text-align:center; background-color:#e8e8e8;" width="25%">SALDO</th>
  
  </tr>
  </thead> 

</table>
EOF;
$pdf->SetMargins(34, 30 ,2.5);
$pdf->writeHTML($bloqueCabeceraElementosordenDoc,false,false,false,false,'');

$objpresupuesto=new Presupuesto();
$list=$objpresupuesto->mostrarpresupuesto($codigonuevo);
$fila1Presu=mysqli_fetch_array($list);
$montoPresupuesto=$fila1Presu['monto_presupuesto'];
$montogastado=$fild['gastos'];
$saldodegasto=$fild['saldo'];

$bloqueDatosOrdenDinero=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="text-align:right; width:50%;">$montoPresupuesto</th>
   <th style="text-align:right; width:25%;">$montogastado</th>
   <th style="text-align:right; width:25%;">$saldodegasto</th>
   
</tr>
</thead>
</table>
EOF;
$pdf->SetMargins(34, 30 ,2.5);
$pdf->writeHTML($bloqueDatosOrdenDinero,false,false,false,false,'');

$bloqueCabeceraDetalleDeGastos=<<<EOF

<table border="0.1px">
  <thead>
   <tr style="page-break-inside: avoid;" nobr="true">
    <th style="text-align:center; background-color:#e8e8e8;" width="50%">DETALLE DEL PRESUPUESTO POR GASTAR (CARGA DE DINERO)</th>
    <th style="text-align:center; background-color:#e8e8e8;" width="50%">DETALLE DEL DINERO GASTADO (DESCARGA DE DINERO)</th>
  
  </tr>
  </thead>
</table>
EOF;
$pdf->writeHTML($bloqueCabeceraDetalleDeGastos,false,false,false,false,'');


$detallePresupuesto=$fila1Presu['detalle_presupuesto'];
$detalleGastoPresupuesto=$fild['detalle_gasto'];

$bloqueDatosDetalleDeGasto=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   
   <th style=" width:50%;">$detallePresupuesto</th>
   <th style=" width:50%;">$detalleGastoPresupuesto</th>
   
</tr>
</thead>
</table>
EOF;
$pdf->SetMargins(34, 30 ,2.5);
$pdf->writeHTML($bloqueDatosDetalleDeGasto,false,false,false,false,'');


$nameFile='Orden_'.$codigonuevo.'_causa_'.$codigoC.'.pdf';

$pdf->Output($nameFile);

?>