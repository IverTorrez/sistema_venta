<?php
session_start();
if(!isset($_SESSION["useradmin"]))
{
  header("location:../../../index.php");
}
$datos=$_SESSION["useradmin"];

require_once('tcpdf_include.php');

include_once('../../../model/clscausa.php');
include_once('../../../model/clstribunal.php');
include_once('../../../model/clsdemandante_demandado.php');


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
TAMAÑO TOTAL DE LA HOJA OFICIO ECHADA(ORIZONTAL)=905px DISPONIBLE PARA OCUPAR CON DATOS
/*===============================================================*/



   $codcausa=$_GET['squart'];
   //SE DESENCRIPTA EL CODIGO PARA PODER USARLO // 
   $decodificado=base64_decode($codcausa);

   $codigonuevo=$decodificado/1234567;

   $objcausa=new Causa();
   $resul=$objcausa->mostrarcodcausa($codigonuevo);
   $fil=mysqli_fetch_object($resul);
   // echo "<td style='width: 10%;'>$fil->codigo</td>";
   $codigocausa=$fil->codigo;
/*****************************CABECERA DE LA HOJA***********************************/
$abogadonombre=$datos['nombreabog'];
        //$pdf->Image('images/logoserrate3.jpg',10, 10, 70, 15, '', '', '', false, 300, '', false, false, 0, false, false, false);
        

        $pdf->Cell(250, 0, '                                                                                    FICHA DE LA CAUSAS: '.$fil->codigo, 0, 0, 'C', 0, '', 0);


        //$pdf->Cell(85, 0, 'Abogado: '.$abogadonombre, 0, 1, 'R', 0, '', 1);
        $pdf->Cell(0, 0, $subtitulo, 0, 1, 'C', 0, '', 0);
$pdf->Ln(10);


$pdf->SetFont('','',8);
/*===============================================================
CABECERA DE LA TABLA
/*===============================================================*/
$bloque1=<<<EOF

<table border="0.1px">
	<thead>
	   <tr>
		<th style="text-align:center; width:152px; background-color:#e8e8e8;">CODIGO</th>
		<th style="text-align:center; width:273px; background-color:#e8e8e8;">NOMBRE DEL PROCESO</th>
		<th style="text-align:center; width:150px; background-color:#e8e8e8;">ABOGADO</th>
		<th style="text-align:center; width:150px; background-color:#e8e8e8;">CLIENTE</th>
		<th style="text-align:center; width:180px; background-color:#e8e8e8;">PROCURADOR <br>(por defecto)</th>
		
		</tr>
	</thead>

	<tbody>
		
	</tbody>

</table>
EOF;
$pdf->writeHTML($bloque1,false,false,false,false,'');
//FIN DEL BLOQUE 1



$objcausa=new Causa();
   $resul=$objcausa->fichacausa($codigonuevo);
   while ($fil=mysqli_fetch_array($resul)) 
   {
     

$bloque2=<<<EOF
<table border="0.1px">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="text-align:center; width:152px;">$fil[codigo]</th>
   <th style="text-align:center; width:273px;">$fil[nombrecausa]</th>
   <th style="text-align:center; width:150px;">$fil[abogadogestor]</th>
   <th style="text-align:center; width:150px;">$fil[clienteasig]</th>
   <th style="text-align:center; width:180px;">$fil[procuradorasig]</th>  
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloque2,false,false,false,false,'');	
    }




$pdf->Ln(5);




/*======================================================================================================
                                             SECTOR EL TRIBUNAL DE LA FICHA
/*=======================================================================================================*/
$bloquetribunal=<<<EOF

<table border="0.1px">
	<thead>
	   <tr>
		<th style="text-align:center; width:60px; background-color:#e8e8e8;">FISIOLOGIA DEL TRIBUNAL</th>
		<th style="text-align:center; width:185px; background-color:#e8e8e8;">NOMBRE DEL TRIBUNAL</th>
		<th style="text-align:center; width:50px; background-color:#e8e8e8;">PISO</th>
		<th style="text-align:center; width:70px; background-color:#e8e8e8;">#DE EXPEDIENTE</th>
		<th style="text-align:center; width:80px; background-color:#e8e8e8;">CODIGO JURIDICO</th>
		<th style="text-align:center; width:115px; background-color:#e8e8e8;">CONTACTO 1</th>
		<th style="text-align:center; width:115px; background-color:#e8e8e8;">CONTACTO 2</th>
		<th style="text-align:center; width:115px; background-color:#e8e8e8;">CONTACTO 3</th>
		<th style="text-align:center; width:115px; background-color:#e8e8e8;">CONTACTO 4</th>
		
		</tr>
	</thead>


</table>
EOF;
$pdf->writeHTML($bloquetribunal,false,false,false,false,'');



$objtibunal=new Tribunal();
$lista=$objtibunal->listartribunalficha($codigonuevo);
 while ($fil=mysqli_fetch_array($lista)) 
 {
$bloquetribunal2=<<<EOF
<table border="0.1px">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="text-align:center; width:60px;">$fil[tptribu]</th>
   <th style="text-align:center; width:185px;">$fil[juzg]</th>
   <th style="text-align:center; width:50px;">$fil[Pis]</th>
   <th style="text-align:center; width:70px;">$fil[expediente]</th>
   <th style="text-align:center; width:80px;">$fil[codnurejianuj]</th>
   <th style="text-align:center; width:115px;">$fil[cont1]</th>
   <th style="text-align:center; width:115px;">$fil[cont2]</th>
   <th style="text-align:center; width:115px;">$fil[cont3]</th>
   <th style="text-align:center; width:115px;">$fil[cont4]</th>
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloquetribunal2,false,false,false,false,'');	
  }







#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(34, 30 ,2.5);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);
/*======================================================================================================
                        SECTOR DE LOS TERCERISTAS DEMANDANTES Y DEMANDADOS DE LA FICHA
/*=======================================================================================================*/
$pdf->Ln(5);
$pdf->Cell(0, 0, 'DEMANDANTES-DEMANDADOS-TERCERISTAS', 0, 1, 'C', 0, '', 0);
$pdf->Ln(2);
$bloquedemandantes=<<<EOF

<table border="0.1px">
	<thead>
	   <tr nobr="true">
		<th style="text-align:center; width:202px; background-color:#e8e8e8;">DEMANDANTE</th>
		<th style="text-align:center; width:603px; background-color:#e8e8e8;">ULTIMO DOMICILIO SEÑALADO</th>
		<th style="text-align:center; width:100px; background-color:#e8e8e8;">FOJA</th>
		
		
		</tr>
	</thead>

</table>
EOF;
$pdf->writeHTML($bloquedemandantes,false,false,false,false,'');



$obdem=new Demandante_Demandado();
$lista=$obdem->listardemandante($codigonuevo);
while ($fil=mysqli_fetch_array($lista))
{
$bloquedemandantes2=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="width:202px;">$fil[nombresdeman]</th>
   <th style=" width:603px;">$fil[ultimodomicilio]</th>
   <th style="text-align:center; width:100px;">$fil[foja]</th>
  
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloquedemandantes2,false,false,false,false,'');

}




$pdf->Ln(7);
$bloquedemandados=<<<EOF

<table border="0.1px">
	<thead>
	   <tr nobr="true">
		<th style="text-align:center;  width:202px; background-color:#e8e8e8;">DEMANDADOS</th>
		<th style="text-align:center;  width:603px; background-color:#e8e8e8;">ULTIMO DOMICILIO SEÑALADO</th>
		<th style="text-align:center;  width:100px; background-color:#e8e8e8;">FOJA</th>
		
		
		</tr>
	</thead>

</table>
EOF;
$pdf->writeHTML($bloquedemandados,false,false,false,false,'');

$obdemd=new Demandante_Demandado();
$lista=$obdemd->listardemandado($codigonuevo);
while ($fil=mysqli_fetch_array($lista))
{
$bloquedemandados2=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="width:202px;">$fil[nombresdeman]</th>
   <th style=" width:603px;">$fil[ultimodomicilio]</th>
   <th style="text-align:center; width:100px;">$fil[foja]</th>
  
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloquedemandados2,false,false,false,false,'');

}






$pdf->Ln(7);
$bloquetercerista=<<<EOF

<table border="0.1px">
	<thead>
	   <tr nobr="true">
		<th style="text-align:center; width:202px; background-color:#e8e8e8;">TERCERISTA</th>
		<th style="text-align:center;  width:603px; background-color:#e8e8e8;">ULTIMO DOMICILIO SEÑALADO</th>
		<th style="text-align:center;  width:100px; background-color:#e8e8e8;">FOJA</th>
		
		
		</tr>
	</thead>

</table>
EOF;
$pdf->writeHTML($bloquetercerista,false,false,false,false,'');

$obter=new Demandante_Demandado();
$lista=$obter->listartercerista($codigonuevo);
while ($fil=mysqli_fetch_array($lista))
{
$bloquedemandados2=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="width:202px;">$fil[nombresdeman]</th>
   <th style=" width:603px;">$fil[ultimodomicilio]</th>
   <th style="text-align:center; width:100px;">$fil[foja]</th>
 </thead>
</tr>

</table>
EOF;

$pdf->writeHTML($bloquedemandados2,false,false,false,false,'');

}





/*======================================================================================================
                                             SECTOR ESPACIO DE LA CAUSA
/*=======================================================================================================*/
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(34, 30 ,2.5);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);
$pdf->Ln(5);
$pdf->Cell(0, 0, 'EL ESPACIO DE LA CAUSA', 0, 1, 'C', 0, '', 0);
$pdf->Ln(2);

$bloqueobsevaciones=<<<EOF

<table border="0.1px">
	<thead>
	   <tr nobr="true">
		<th style="text-align:center; width:905px; background-color:#e8e8e8;">OBSERVACIONES</th>
		
		
		</tr>
	</thead>

</table>
EOF;
$pdf->writeHTML($bloqueobsevaciones,false,false,false,false,'');

$objcausa=new Causa();
  $lista=$objcausa->mostrarobservaciones($codigonuevo);
  $fil=mysqli_fetch_array($lista);
       
$bloqueobsevaciones2=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="width:905px;">$fil[obsevacionescausas]</th>
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloqueobsevaciones2,false,false,false,false,'');




$pdf->Ln(5);
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(34, 30 ,2.5);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);
$bloqueobjetivos=<<<EOF

<table border="0.1px">
	<thead>
	   <tr nobr="true">
		<th style="text-align:center; width:905px; background-color:#e8e8e8;">OBJETIVOS</th>
		
		
		</tr>
	</thead>


</table>
EOF;
$pdf->writeHTML($bloqueobjetivos,false,false,false,false,'');

       
$bloqueobjetivos2=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="width:905px;">$fil[objetivos]</th>
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloqueobjetivos2,false,false,false,false,'');

/*----------------------------------------------------------------------------------------*/
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(34, 30 ,2.5);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);
$pdf->Ln(5);
$bloqueestrategias=<<<EOF

<table border="0.1px">
	<thead>
	   <tr nobr="true">
		<th style="text-align:center; width:905px; background-color:#e8e8e8;">ESTRATEGIAS</th>
		
		
		</tr>
	</thead>


</table>
EOF;
$pdf->writeHTML($bloqueestrategias,false,false,false,false,'');

$bloqueestrategias2=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="width:905px;">$fil[estrategias]</th>
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloqueestrategias2,false,false,false,false,'');
/*--------------------------------------------------------------------------------------------*/



/*----------------------------------------------------------------------------------------*/
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(34, 30 ,2.5);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);

$pdf->Ln(5);
$bloqueapuntes=<<<EOF

<table border="0.1px">
	<thead>
	   <tr nobr="true">
		<th style="text-align:center; width:905px; background-color:#e8e8e8;">AOUNTES JURIDICOS</th>
		
		
		</tr>
	</thead>


</table>
EOF;
$pdf->writeHTML($bloqueapuntes,false,false,false,false,'');

$bloqueapuntes2=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="width:905px;">$fil[apuntesjuridicos]</th>  
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloqueapuntes2,false,false,false,false,'');
/*--------------------------------------------------------------------------------------------*/




/*----------------------------------------------------------------------------------------*/
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(34, 30 ,2.5);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);
$pdf->Ln(5);
$bloquehonorarios=<<<EOF

<table border="0.1px">
	<thead>
	   <tr nobr="true">
		<th style="text-align:center; width:905px; background-color:#e8e8e8;">HONORARIOS</th>
		
		
		</tr>
	</thead>


</table>
EOF;
$pdf->writeHTML($bloquehonorarios,false,false,false,false,'');

$bloquehonorarios2=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="width:905px;">$fil[apunteshonorarios]</th>
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloquehonorarios2,false,false,false,false,'');
/*--------------------------------------------------------------------------------------------*/




/*----------------------------------------------------------------------------------------*/
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(34, 30 ,2.5);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);
$pdf->Ln(5);
$bloqueotrainfo=<<<EOF

<table border="0.1px">
	<thead>
	   <tr nobr="true">
		<th style="text-align:center; width:905px; background-color:#e8e8e8;">OTRA INFORMACION</th>
		
		
		</tr>
	</thead>

	<tbody>
		
	</tbody>

</table>
EOF;
$pdf->writeHTML($bloqueotrainfo,false,false,false,false,'');

$bloqueotrainfo2=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="width:905px;">$fil[informacion]</th>
   
  
</tr>
</thead>
</table>
EOF;

$pdf->writeHTML($bloqueotrainfo2,false,false,false,false,'');
/*--------------------------------------------------------------------------------------------*/

$nameFile='Ficha_'.$codigocausa.'.pdf';
$pdf->Output($nameFile);
?>