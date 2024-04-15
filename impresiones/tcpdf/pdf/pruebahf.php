<?php
require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
include_once('../../../model/clscausa.php');
include_once('../../../model/clspostacausa.php');
include_once('../../../model/clsinformeposta.php');
include_once('../../../model/clstipoposta.php');
include_once('../../../model/clsordengeneral.php');
/*INFORME DE PRUEBA CON LA LIBRERIA DOMPDF, el encbezado se puede repetir en las hojas*/


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
    
 
<h2>Causas Activas</h2>
<table  width='100%' style='font-size:10px;' id='tablapdf'>
  <thead>
	 <tr>
		<td style='background-color:#e8e8e8; width:10%;'>CODIGO</td>
		<td style='background-color:#e8e8e8;text-align:center; width:10%;'>NOMBRE DEL PROCESO</td>
		<td style='background-color:#e8e8e8;text-align:center; width:6%;'>CLIENTE</td>
		<td style='background-color:#e8e8e8;text-align:center; width:10%;'>DIRECCION</td>
		<td style='background-color:#e8e8e8;text-align:center; width:6%;'>TELEFONO</td>
		<td style='background-color:#e8e8e8;text-align:center; width:10%;'>CORREO</td>
		<td style='background-color:#e8e8e8;text-align:center; width:5%;'>COORDENADAS</td>
		<td style='background-color:#e8e8e8;text-align:center; width:5%;'>SALDO</td>
		<td style='background-color:#e8e8e8;text-align:center; width:38%;'>OBSERVACIONES</td>
		</tr>
	
   </thead>
	<tbody>";
$objcausa=new Causa();
  $resulcausa=$objcausa->mostrarInforme_1();
  while($row=mysqli_fetch_array($resulcausa))
  {
$BLOQUE_1.="
<tr nobr='true'>
   <td style='text-align:left; width:10%;'>$row[codigo]</td>
   <td style='text-align:left; width:10%;'>$row[nombrecausa]</td>
   <td style='text-align:left; width:6%;'>$row[clienteasig]</td>
   <td style='text-align:left; width:10%;'>$row[Dircliente]</td>
   <td style='text-align:left; width:6%;'>$row[Telfcli]</td>
   <td style='text-align:left; width:10%;'>$row[CorreoCli]</td>
   <td style='text-align:left; width:5%;'>$row[CoorCli]</td>
   <td style='text-align:left; width:5%;'>$row[caja]</td>
   <td style='text-align:left; width:38%;'>$row[obsevacionescausas]</td>
</tr>";
 }
		
$BLOQUE_1.="</tbody>

</table>
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
$canvas->page_text(470, 585, "Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 10, array(0,0,0)); 

$dompdf->stream("Informe1.pdf",array("Attachment" => 0));
?>