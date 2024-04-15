<?php

session_start();
if(!isset($_SESSION["useradmin"]))
{
  header("location:../../../index.php");
}
$datos=$_SESSION["useradmin"];

require_once('tcpdf_include.php');

include_once('../../../model/clscausa.php');


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


$abogadonombre=$datos['nombreusuario'];
        //$pdf->Image('images/logoserrate3.jpg',10, 10, 70, 15, '', '', '', false, 300, '', false, false, 0, false,false,false);
        
        $pdf->Cell(250, 0, '                                                                                       IMPRESION DE SALDOS DE CLIENTES EN CAUSAS TERMINADAS', 0, 0, 'C', 0, '', 0);


        $pdf->Cell(85, 0, 'Usuario: '.$abogadonombre, 0, 1, 'R', 0, '', 1);
        $pdf->Cell(0, 0, $subtitulo, 0, 1, 'C', 0, '', 0);
$pdf->Ln(5);


$pdf->SetFont('','',8);
/*===============================================================
CABECERA DE LA TABLA
/*===============================================================*/
$bloque1=<<<EOF

<table border="0.1px">
	<thead>
	   <tr>
		<th style="text-align:center;  width:90px; background-color:#e8e8e8;">CODIGO</th>
		<th style="text-align:center;  width:110px; background-color:#e8e8e8;">NOMBRE DEL PROCESO</th>
		<th style="text-align:center;  width:70px; background-color:#e8e8e8;">CLIENTE</th>
		<th style="text-align:center;  width:80px; background-color:#e8e8e8;">DIRECCION</th>
		<th style="text-align:center;  width:50px;  background-color:#e8e8e8;">TELEFONO</th>
		<th style="text-align:center;  width:100px; background-color:#e8e8e8;">CORREO</th>
		<th style="text-align:center;  width:75px; background-color:#e8e8e8;">COORDENADAS</th>
		<th style="text-align:center;  width:30px;  background-color:#e8e8e8;">SALDO</th>
		<th style="text-align:center;  width:300px; background-color:#e8e8e8;">OBSERVACIONES</th>
		</tr>
	</thead>

	

</table>
EOF;
$pdf->writeHTML($bloque1,false,false,false,false,'');


  $objcausa=new Causa();
  $resulcausa=$objcausa->mostrarInforme_3saldosterminados();
  while($row=mysqli_fetch_array($resulcausa))
  {
$bloque2=<<<EOF
<table border="0.1px" cellpadding="1">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="text-align:center; width:90px;">$row[codigo]</th>
   <th style="text-align:center; width:110px;">$row[nombrecausa]</th>
   <th style="text-align:center; width:70px;">$row[clienteasig]</th>
   <th style="text-align:center; width:80px;">$row[Dircliente]</th>
   <th style="text-align:center; width:50px;">$row[Telfcli]</th>
   <th style="text-align:center; width:100px;">$row[CorreoCli]</th>
   <th style="text-align:center; width:75px;">$row[CoorCli]</th>
   <th style="text-align:center; width:35px;">$row[caja]</th>
   <th style="width:295px;">$row[obsevacionescausas]</th>
</tr>
</thead>
</table>
EOF;
$pdf->SetMargins(34, 30 ,2.5);
$pdf->writeHTML($bloque2,false,false,false,false,'');

  }

$pdf->Output('Informe3.pdf');

?>