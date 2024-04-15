<?php
session_start();
$fechaIni=$_GET['fini'].' 00:00:00';
$fechaFin=$_GET['ffin'].' 23:59:00';
$idemp=$_GET['idemp'];

// echo $fechaFin;
$_SESSION["frchaini"]=$fechaIni;
$_SESSION["fechafin"]=$fechaFin;
$_SESSION["idemp"]=$idemp;
include_once("../../modelos/empleado.modelo.php");
include_once("../../modelos/almacen.modelo.php");

if ($idemp==0) 
{
  $nombreVendedor='Todos';
}
else
{
  
  $objemep=new Almacen();
 $resultEmp=$objemep->mostarUnAlmacen($idemp);
 $filaemp=mysqli_fetch_object($resultEmp);
 $nombreEmp=$filaemp->nombre_almacen;
 //$apellido=$filaemp->apellido_empleado;
 $nombreVendedor=$nombreEmp;
 }
?>
<label>Almacen : <?php  echo $nombreVendedor; ?> </label>
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
                   <th>Nº. Lote</th>
                   <th>Costo Unit.</th>
                  <th>Prec. Establecido Bs.</th>
                  <th>Cantidad</th>              
                  <th>Precio Vendido Bs.</th>
                  <th>Sub. Total Bs.</th>
                  <th>Ganancia Bs.</th>
                  <th>Almacen</th>
                  <th>Borrar</th>
           

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

                if ($idemp==0)/*reporte de todos los que realizaron ventas*/
                {
                  $resultado=$obj->reporteVentas($fechaIni,$fechaFin);
                }
                else/*reporte de un ventero especifico*/
                {
                 $resultado=$obj->reporteVentasDeUnAlmacen($fechaIni,$fechaFin,$idemp); 
                }
                

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
                  <td><?php echo $fila->id_compra; ?></td><!--codigo compra (Lote)-->
                  <!-- <td><?php echo $fila->id_compra_producto; ?></td>--> 
                  <td><?php echo $fila->precio_compra_prod; ?></td>
                  <td><?php echo $fila->precio_venta_establecido; ?></td>
                
                

                 <td><?php echo $fila->cantidad_prod; ?></td>             
                 <td><?php echo $fila->precio_unitario_venta; ?></td>
                 <td><?php echo $fila->subtotal_venta; ?></td>
                  <td><?php echo number_format((float)$ganacia, 2, '.', ''); ?></td>
                 <td><?php echo $fila->nombre_almacen; ?></td>
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimventa" onclick="CargarinfoVentaElim('<?php echo $datosventa ?>')"><i class="fa fa-times"></i></button>
                   </div>
                 </td>
                
               
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
                 <td colspan="12" style="text-align: center;"><b>Totales</b> </td>
                 <td><b><?php echo number_format((float)$totalMontoVentas, 2, '.', ''); ?></b></td>
                 <td><b><?php echo number_format((float)$GananciasTotales, 2, '.', ''); ?></b></td>
               </tr>
             </tfoot>
          </table>

<script type="text/javascript">
   /*========================CARGAMOS LOS DATOS PARA ELIMINAR=========================*/
function CargarinfoVentaElim(datosventa) 
  {
    
    f=datosventa.split('||');
    $('#idventa').val(f[0]);
    $('#labelcodigo').text(f[0]);

  }
  
</script>