<?php

session_start();
if(!isset($_SESSION["useradmin"]))
{
  header("location:../../../index.php");
}
$datos=$_SESSION["useradmin"];

require_once('tcpdf_include.php');

include_once('../../../model/clscausa.php');
include_once('../../../model/clsjuzgados.php');


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
        
        $pdf->Cell(250, 0, '                                                                                       LISTA DE TRIBUNALES', 0, 0, 'C', 0, '', 0);


        $pdf->Cell(85, 0, 'Usuario: '.$abogadonombre, 0, 1, 'R', 0, '', 1);
        $pdf->Cell(0, 0, $subtitulo, 0, 1, 'C', 0, '', 0);
$pdf->Ln(5);


$pdf->SetFont('','',8);
/*===============================================================
CABECERA DE LA TABLA
/*===============================================================*/

$bloqueCabeceraTribunales=<<<EOF

<table border="0.1px">
  <thead>
     <tr>
                <th colspan="4" style="text-align:center;  width:260px; background-color:#e8e8e8;" >NOMBRE DEL TRIBUNAL</th>
                <th rowspan="2" style="text-align:center;  width:50px; background-color:#e8e8e8;" >PISO</th>
                
                <th rowspan="2" style="text-align:center;  width:145px; background-color:#e8e8e8;" >CONTACTO 1</th>
                <th rowspan="2" style="text-align:center;  width:150px; background-color:#e8e8e8;" >CONTACTO 2</th>
                <th rowspan="2" style="text-align:center;  width:150px; background-color:#e8e8e8;" >CONTACTO 3</th>
                <th rowspan="2" style="text-align:center;  width:150px; background-color:#e8e8e8;" >CONTACTO 4</th>
                
            </tr>
        <tr>
            <td style="text-align:center;  width:50px; background-color:#e8e8e8;">NOMBRE NUMERICO</td>
            <td style="text-align:center;  width:80px; background-color:#e8e8e8;">JERARQUIA</td>
            <td style="text-align:center;  width:80px; background-color:#e8e8e8;">MATERIA</td>
            <td style="text-align:center;  width:50px; background-color:#e8e8e8;">CODIGO CIUDAD</td>
            
        </tr>
  </thead>

  

</table>
EOF;
$pdf->writeHTML($bloqueCabeceraTribunales,false,false,false,false,'');

$objjuzg=new Juzgados();
       $resul=$objjuzg->listartodosjuzgados();
   while ($fil=mysqli_fetch_array($resul)) 
   {
       
      $NombreNumerico=$fil['nombrenumerico']."º";
      $Jerarquia=$fil['jerarquia'];
      $Materia=$fil['materiajuz'];
      $Distrito=$fil['distr'];
      $Piso=$fil['piso1'];
             // echo "<td><a href='$fil->coordenadasjuz' target='_blank'><i class='fa fa-map-marker fa-2x' aria-hidden='true'></i></a></td>";

             //echo "<td><a href='fotos/fotosjuzgados/$fil->fotojuz' target='_blank'><i class='fa fa-camera fa-2x' aria-hidden='true'></i></a></td>";
      $Contacto_1=$fil['contacto1'];
      $Contacto_2=$fil['contacto2'];
      $Contacto_3=$fil['contacto3'];
      $Contacto_4=$fil['contacto4'];
           

$bloqueListaTribunales=<<<EOF
<table border="0.1px">
<thead>
<tr style="page-break-inside: avoid;" nobr="true">
   <th style="text-align:center; width:50px;">$NombreNumerico</th>
   <th style="text-align:center; width:80px;">$Jerarquia</th>
   <th style="text-align:center; width:80px;">$Materia</th>
   <th style="text-align:center; width:50px;">$Distrito</th>
   <th style="text-align:center; width:50px;">$Piso</th>
   <th style="text-align:center; width:145px;">$Contacto_1</th>
   <th style="text-align:center; width:150px;">$Contacto_2</th>
   <th style="text-align:center; width:150px;">$Contacto_3</th>
   <th style="text-align:center; width:150px;">$Contacto_4</th>
</tr>
</thead>
</table>
EOF;
$pdf->SetMargins(34, 30 ,2.5);
$pdf->writeHTML($bloqueListaTribunales,false,false,false,false,'');


    }




$pdf->Output('Tribunales.pdf');

?>