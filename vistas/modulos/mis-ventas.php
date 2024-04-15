<?php
include_once("modelos/venta.modelo.php");
include_once("modelos/empleado.modelo.php");
ini_set('date.timezone','America/La_Paz');
$fecha=date("Y-m-d");
$hora=date("H:i");
/*$fechaHora=$fecha.' '.$hora;*/
/*if ($_SESSION["tipo_user"]!="admin")
{
  echo '<script>
        window.location="inicio";
      </script>';
}*/
//$tipoUser=$_SESSION["tipo_user"];
  if ($_SESSION["tipo_user"]=="emp")
  {
     $tipoUser="empl";
  }
  else
    { if ($_SESSION["tipo_user"]=="admin") 
       {
         $tipoUser="admin";
       }

    }
?>


<!-- <script type="text/javascript" src = " https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.0/jspdf.umd.min.js"> </script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
 -->
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reportes de ventas del día
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Reportes</li>
        <input type="hidden" name="textiduser" id="textiduser" value="<?php echo $iduseractual; ?>">
        <input type="hidden" name="textuser" id="textuser" value="<?php echo $tipoUser; ?>">
      </ol>
    </section>


    <script type="text/javascript">
      function generatePDF()
      {
        var doc =new jsPDF();
        var elementHTML=document.querySelector("#titulo").innerHTML;
        var specialElementHandlers={
          '#elemnetH': function(element,renderer){
            return true;
          }
        };
        // doc.text(20,20,'hello word');
        // doc.save('documento.pdf');
        doc.fromHTML (
          elementHTML,
          15,
          15,
          {
            'width':170,
            'elementHandlers':specialElementHandlers
          }
        );

      }








    </script>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          
                 <button style="float: right;" class="btn btn-danger btn-xs" onclick="window.open('impresiones/tcpdf/pdf/rep_mis_ventas.php')">PDF</button>
         <!--  <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div> -->
        </div>
        <div class="box-body" id="divtablareportes">

          <table class="table table-bordered table-striped ">
             <thead>
                <tr>
                 
                  <th>Cod. Venta</th>
                  <th>Producto</th>
                  <th>Codigo</th>
                  <th>Marca</th>
                  <th>Fecha venta</th>
                  <th>V. Facturada</th>
                  <th>Usuario</th>     
                   <th>Cod. Lote</th>
                <!--   <th>Costo Unit.</th>-->
                  <th>Prec. Establecido Bs.</th>
                  <th>Cantidad</th>              
                  <th>Precio Vendido Bs.</th>
                  <th>Sub. Total Bs.</th>
                 <!-- <th>Ganancia Bs.</th> -->          
                </tr>
             </thead>

             <tbody>
               <?php
               include_once("../../modelos/venta.modelo.php");

                
               $contador=1;
               $ganacia=0;
               $sub_costo=0;
               $GananciasTotales=0;
               $totalMontoVentas=0;
               $alertaColorfila='';
               $colorTexto='';
               $obj=new Venta(); 
               $resultado=$obj->reporteMisVentasDia($iduseractual,$tipoUser,$fecha); 
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                   $datosventa=$fila->id_venta."||".
                                     $fila->nombre_producto."||".
                                     $fila->codigo_producto."||".
                                     $fila->nombre_marca."||".
                                     $fila->fecha_venta."||".
                                     $fila->venta_facturada."||".
                                     $fila->Usuario."||".
                                     $fila->id_compra_producto."||".
                                     $fila->precio_venta_establecido."||".
                                     $fila->cantidad_prod."||".
                                     $fila->precio_unitario_venta."||".
                                     $fila->subtotal_venta;
                                    
                 
   /*verificacion que la venta sea mayor o igual al precio establecido*/     
                if ($fila->precio_unitario_venta<$fila->precio_venta_establecido) 
                {
                  $alertaColor="red";
                  $colorTexto="white";
                }
                else{
                      $alertaColor="none";
                  $colorTexto="none";
                    }              
                  


                  /*obtenemos la ganacia de total vendido del producto*/
                  $sub_costo=$fila->precio_compra_prod*$fila->cantidad_prod;   
                    $ganacia=$fila->subtotal_venta-$sub_costo;
              ?>
               <tr style="background-color: <?php echo $alertaColor; ?>; color: <?php echo $colorTexto?>;">
                
                 <td ><a target="_blank" href="impresiones/tcpdf/pdf/nota_venta.php?codventa=<?php echo $fila->id_venta ?>"> <?php echo $fila->id_venta; ?></a></td>
                 <td><?php echo $fila->nombre_producto; ?></td>
                 <td><?php echo $fila->codigo_producto; ?></td>
                <!--  <td><?php echo $fila->descripcion; ?></td> -->
                 <td><?php echo $fila->nombre_marca; ?></td>
                 <td><?php echo $fila->fecha_venta; ?></td>
                 <td><?php echo $fila->venta_facturada; ?></td>
                  <td><?php echo $fila->Usuario; ?></td>
                  <td><?php echo $fila->id_compra_producto; ?></td>
                 <!-- <td><?php echo $fila->precio_compra_prod; ?></td>-->
                  <td><?php echo $fila->precio_venta_establecido; ?></td>
                               
                 <td><?php echo $fila->cantidad_prod; ?></td>             
                 <td><?php echo $fila->precio_unitario_venta; ?></td>
                 <td><?php echo $fila->subtotal_venta; ?></td>
                 <!-- <td><?php echo number_format((float)$ganacia, 2, '.', ''); ?></td>-->
                 <?php
                // $costo_float= floatval($fila->precio_unit_compra);
                // $montoInvent=$costo_float*$fila->stock_actual;
                // $montoDecimal=number_format((float)$montoInvent, 2, '.', '');

                 ?>
                 <!-- <td><?php echo $montoDecimal; ?></td> -->

                 
                
              
               </tr>
               <?php
                 // $contador++; SUMA DE TOTALES
                  $totalMontoVentas=$totalMontoVentas+$fila->subtotal_venta;
                  $GananciasTotales=$GananciasTotales+$ganacia;

                 }
               ?>
             </tbody>
             <tfoot>
               <tr>
                 <td colspan="11" style="text-align: center;"><b>Totales</b> </td>
                 <td><b><?php echo number_format((float)$totalMontoVentas, 2, '.', ''); ?></b></td>
               <!--  <td><b><?php echo number_format((float)$GananciasTotales, 2, '.', ''); ?></b></td>-->
               </tr>
             </tfoot>
          </table>

         
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->


   
  </div>
  <!-- /.content-wrapper -->
  <script type="text/javascript">
    
  </script>
  <script type='text/javascript'>
  /*  generacionReporte();
      function generacionReporte()
      {
     var fecha_ini=$('#dateInico').val();
     var fecha_fin=$('#dateFinal').val();
     var idemp=$('#selectemp').val();
    
      $('#divtablareportes').load('vistas/modulos/tabla_reportes_ventas.php?fini='+fecha_ini+'&ffin='+fecha_fin+'&idemp='+idemp);
                    // alert(response);                                      
      }*/

     
</script>


