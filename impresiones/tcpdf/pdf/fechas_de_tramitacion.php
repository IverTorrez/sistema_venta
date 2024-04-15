<?php

session_start();
if(!isset($_SESSION["useradmin"]))
{
  header("location:../../../index.php");
}
$datos=$_SESSION["useradmin"];

require_once('tcpdf_include.php');

include_once('../../../model/clscausa.php');
include_once('../../../model/clspresupuesto.php');
include_once('../../../model/clsdescarga_procurador.php');
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


$user_nombre=$datos['nombreusuario'];
        //$pdf->Image('images/logoserrate3.jpg',10, 10, 70, 15, '', '', '', false, 300, '', false, false, 0, false,false,false);
        
        $pdf->Cell(250, 0, '                                                                                       FECHAS DE TRAMITACION DE ORDENES DE LA CAUSA: '.$codigocausa, 0, 0, 'C', 0, '', 0);


        $pdf->Cell(85, 0, 'Usuario: '.$user_nombre, 0, 1, 'R', 0, '', 1);
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




$pdf->SetFont('','',6);
/*****************TABLA FECHAS DE TRRAMITACION**************************************/
$bloqueCabecera1Fech=<<<EOF

<table border="0.1px">
  <thead>
     <tr>
    <th style="text-align:center;  width:40px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:500px; background-color:#e8e8e8;">FECHAS</th>
    
    <th style="text-align:center;  width:60px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:155px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:150px; background-color:#e8e8e8;"></th>
    </tr>
  </thead>

  

</table>
EOF;
$pdf->writeHTML($bloqueCabecera1Fech,false,false,false,false,'');

$bloqueCabecera2Fech=<<<EOF

<table border="0.1px">
  <thead>
     <tr>
    <th style="text-align:center;  width:40px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:200px; background-color:#e8e8e8;">FECHAS DE CARGA</th>
    
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;"></th>

    <th style="text-align:center;  width:100px; background-color:#e8e8e8;">VIGENCIA DE LA ORDEN</th>
    
    <th style="text-align:center;  width:150px; background-color:#e8e8e8;">MOMENTOS PARA EL CIERRE DE LA ORDEN</th>
    
    <th style="text-align:center;  width:60px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:155px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:150px; background-color:#e8e8e8;"></th>
    </tr>
  </thead>

  

</table>
EOF;
$pdf->writeHTML($bloqueCabecera2Fech,false,false,false,false,'');


$bloqueCabecera3Fech=<<<EOF

<table border="0.1px">
  <thead>
     <tr>
    <th style="text-align:center;  width:40px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:100px; background-color:#e8e8e8;">INFORMACION Y DOCUMENTACION</th>
    
    <th style="text-align:center;  width:100px; background-color:#e8e8e8;">DINERO</th>
   
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;"></th>

    <th style="text-align:center;  width:50px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:50px;  background-color:#e8e8e8;"></th>

    <th style="text-align:center;  width:100px; background-color:#e8e8e8;">FECHAS DE PRONUNCIAMIENTOS (Aprobación o Rechazo)</th>
    
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:60px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:155px; background-color:#e8e8e8;"></th>
    <th style="text-align:center;  width:150px; background-color:#e8e8e8;"></th>
    </tr>
  </thead>

  

</table>
EOF;
$pdf->writeHTML($bloqueCabecera3Fech,false,false,false,false,'');


$bloqueCabecera4Fech=<<<EOF

<table border="0.1px">
  <thead>
     <tr>
    <th style="text-align:center;  width:40px; background-color:#e8e8e8;"># DE ORDEN</th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;">GIRO</th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;">RECEPCION</th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;">PRESUPUESTO</th>
    <th style="text-align:center;  width:50px;  background-color:#e8e8e8;">RECEPCION $</th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;">FECHA DE DESCARGA</th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;">INICIO</th>
    <th style="text-align:center;  width:50px;  background-color:#e8e8e8;">FIN</th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;">DEL ABOGADO</th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;">DEL CONTADOR</th>
    <th style="text-align:center;  width:50px; background-color:#e8e8e8;">CIERRE OFICIAL</th>
    <th style="text-align:center;  width:60px; background-color:#e8e8e8;">PROCURADOR ASIGNADO A ESTA ORDEN</th>
    <th style="text-align:center;  width:155px; background-color:#e8e8e8;">CARGA DE INFORMACION</th>
    <th style="text-align:center;  width:150px; background-color:#e8e8e8;">DESCARGA DE INFORMACION</th>
    </tr>
  </thead>

  

</table>
EOF;
$pdf->writeHTML($bloqueCabecera4Fech,false,false,false,false,'');






  $objcausa=new Causa();
  $resulcausa=$objcausa->listarOrdenesParaFechasDeTramitacion($codigonuevo);
  while($row=mysqli_fetch_array($resulcausa))
  {

    $objpresup=new Presupuesto();
    $resulpresu=$objpresup->mostrarpresupuesto($row['codorden']);
    $filapresu=mysqli_fetch_array($resulpresu);
    $fechapresu=$filapresu['fecha_presupuesto'];
    $fechaentrega=$filapresu['fecha_entrega'];

    $objdesc=new DescargaProcurador();
    $resuldescarga=$objdesc->mostrardescargaorden($row['codorden']);
    $filadescarga=mysqli_fetch_array($resuldescarga);
    $Infodescarga=$filadescarga['detalle_informacion'];
    $fechadescarga=$filadescarga['fecha_descarga'];

    $objconfir=new Confirmacion();
    $resulconfir=$objconfir->mostrarfechasdeconfirmacion($row['codorden']);
    $filconfir=mysqli_fetch_array($resulconfir);
    $fechaconfirAbog=$filconfir['fecha_confir_abogado'];
    $fechaconfirCont=$filconfir['fecha_confir_contador'];


$bloqueFechasTramites=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="text-align:center; width:40px;">$row[codorden]</th>
   <th style="text-align:center; width:50px;">$row[fecha_giro]</th>
   <th style="text-align:center; width:50px;">$row[fecha_recepcion]</th>
   <th style="text-align:center; width:50px;">$fechapresu</th>
   <th style="text-align:center; width:50px;">$fechaentrega</th>
   <th style="text-align:center; width:50px;">$fechadescarga</th>
   <th style="text-align:center; width:50px;">$row[Inicio]</th>
   <th style="text-align:center; width:50px;">$row[Fin]</th>
   <th style="text-align:center; width:50px;">$fechaconfirAbog</th>
   <th style="text-align:center; width:50px;">$fechaconfirCont</th>
   <th style="text-align:center; width:50px;">$row[fecha_cierre]</th>
   <th style="text-align:center; width:60px;">$row[ProcuAsig]</th>
   <th style="width:155px;">$row[informacion]</th>
   <th style="width:150px;">$Infodescarga</th>
</tr>
</thead>
</table>
EOF;
$pdf->SetMargins(34, 30 ,2.5);
$pdf->writeHTML($bloqueFechasTramites,false,false,false,false,'');

  }




$pdf->Ln(10);
/*****************FIN   TABLA FECHAS DE TRRAMITACION**************************************/
$nameFile='FechasTramitacion_'.$codigocausa.'.pdf';

$pdf->Output($nameFile);

?>