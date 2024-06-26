<?php
error_reporting(E_ERROR);
session_start();
if ($_SESSION["usuarioAdmin"]!="") 
{
  $datosUsuario=$_SESSION["usuarioAdmin"];
  $_SESSION["nombuser"]=$datosUsuario["nombre_administrador"];
  $iduseractual=$datosUsuario["id_administrador"];
  $_SESSION["tipouser"]="admin";
}
if ($_SESSION["usuarioEmp"]!="") 
{
  $datosUsuario=$_SESSION["usuarioEmp"];
  $_SESSION["nombuser"]=$datosUsuario["nombre_empleado"];
  $iduseractual=$datosUsuario["id_empleado"];
  $_SESSION["tipouser"]="empl";
}


$fechaIni=$_SESSION["frchaini"];
$fechaFin=$_SESSION["fechafin"];
require_once('tcpdf_include.php');


include_once('../../../modelos/productos.modelo.php');
class PDF extends TCPDF
{
   //Cabecera de página
   function Header()
   { $nombreUser=$_SESSION["nombuser"];

       //$this->Image('images/logo-sonido2.png',5,3, 70, 20, '', '', '', false, 300, '', false, false, 0, false,false,false);


      $this->SetFont('','B',9);

      $this->Ln(3);
      ini_set('date.timezone','America/La_Paz');
         //$fecha=date("Y-m-d");
          $fecha=date("d-m-Y");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;
      $this->Cell(100,5, '                                                                                                                                                                                                                                     '.$fechaHora, 0, 0, 'C', 0, '', 0);
      $this->Ln(3);
      $this->Cell(00,0, ' Usuario: '.$nombreUser, 0, 0, 'R', 0, '', 0);
    
   }

   function Footer()
   {


    
	$this->SetY(-1000);

	$this->SetFont('','I',8);
   // $this->Image('images/footer3.png',120,200,'', 10, '', '', '', false, 300, '', false, false, 0, false,false,false);
	$this->Cell(0,10,'Pagina '.$this->PageNo().'/'.$this->getAliasNbPages(),0,0,'R');
   }
}




$pdf = new PDF('H', 'mm', 'A4', true, 'UTF-8', false);/*PARA HOJA TAMAÑO LEGAL SE PONE LEGAL EN MAYUSCULA*/


$pdf->startPageGroup();
$pdf->AddPage();
$pdf->SetFont('','',10);
#Establecemos los márgenes izquierda, arriba y derecha:
$pdf->SetMargins(3, 30 ,5);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,10);


 


/*===============================================================
TAMAÑO TOTAL DE LA HOJA OFICIO ECHADA(ORIZONTAL)=905px DISPONIBLE PARA OCUPAR CON DATOS, RESPETANDO LOSMARGENES ESTABLECIDOS POR CODIGO EN LA FUNCION ->SetMargins(34, 30 ,2.5)
/*===============================================================*/



        //$pdf->Image('images/logoserrate3.jpg',10, 10, 70, 15, '', '', '', false, 300, '', false, false, 0, false,false,false);
$pdf->Ln(10);    
        $pdf->Cell(100, 0, '                                                                                       REPORTE DE PRODUCTOS ACTIVOS', 0, 0, 'C', 0, '', 0);
      
       


        
$pdf->Ln(5);


$pdf->SetFont('','',8);
/*===============================================================
CABECERA DE LA TABLA
/*===============================================================*/
$bloqueCabeceraDetalle=<<<EOF

<table border="0.1px">
  <thead>
     <tr id="fila1" style="background-color:#e8e8e8;">
                  <th style="text-align:center; width:5%;"># Nº</th>
                  <th style="text-align:center; width:20%;">Producto</th>
                  <th style="text-align:center; width:15%;">Codigo</th>
                  <th style="text-align:center; width:20%;">Descripcion</th>
                  <th style="text-align:center; width:20%;">Marca</th>
                  <th style="text-align:center; width:20%;">Categoria</th>                
    </tr>
  </thead>
</table>
EOF;
$pdf->writeHTML($bloqueCabeceraDetalle,false,false,false,false,'');

               
                $contador=1;
               $totalSaldoInventario=0;
                $obj=new Producto();
                $resultado=$obj->listarProductosActivos();
                while ($fila=mysqli_fetch_object($resultado)) 
                {                                 
              $bloqueDatosDetalle=<<<EOF
                    <table border="0.1px">
                    <thead>
                     <tr style="page-break-inside: avoid;background-color:$alertaColor; color:$colorTexto; " nobr="true">
                     <th style="text-align:center; width:5%;">$contador</th>
                     <th style="text-align:left; width:20%;">$fila->nombre_producto</th>
                     <th style="text-align:center; width:15%;">$fila->codigo_producto</th>
                     <th style="text-align:left; width:20%;">$fila->descripcion</th>
                     <th style="text-align:center; width:20%;">$fila->marca_prod</th>
                     <th style="text-align:center; width:20%;">$fila->cat_prod</th>                            
                     </tr>
                     </thead>
                    </table>
                EOF;

                $pdf->writeHTML($bloqueDatosDetalle,false,false,false,false,'');
                 $pdf->SetMargins(34, 30 ,5);
                 $contador=$contador+1;
                 }
                 /***************************TABLA TOTAL EGRESOS DE LAS ORDENES*************/
  
$nameFile='reporte_productos_activos.pdf';
ob_end_clean(); //LIMPIA ESPACIOS EN BLANCO PARA NO GENERAR ERROREA
$pdf->Output($nameFile);

?>