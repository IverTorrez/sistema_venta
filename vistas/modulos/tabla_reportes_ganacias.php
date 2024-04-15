<?php
session_start();
include_once("../../modelos/almacen.modelo.php");
$fechaIni=$_GET['fini'].' 00:00:00';
$fechaFin=$_GET['ffin'].' 23:59:00';
$idemp=$_GET['idemp'];
// echo $fechaFin;
$_SESSION["frchaini_g"]=$fechaIni;
$_SESSION["fechafin_g"]=$fechaFin;
$_SESSION["idemp"]=$idemp;

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
                    
                  <th>Cod. Lote</th>
                   <th>Cantidad</th>
                  <th>Prec. Establecido Bs.</th>
                  <th>Costo Unitario Bs.</th>     
                  <th>Precio Vendido Bs.</th>
                  <th>Sub. Total Bs.</th>
                  <th>Almacen</th>
                  <th>Ganancia Bs.</th>
           

                </tr>
             </thead>

             <tbody>
               <?php
               include_once("../../modelos/venta.modelo.php");

                
               $contador=1;
               $ganacia=0;
               $GananciasTotales=0;
               $totalMontoVentas=0;
               $alertaColorfila='';
               $colorTexto='';
                $obj=new Venta();
                if ($idemp==0) 
                {
                  $resultado=$obj->reporteGanacias($fechaIni,$fechaFin);
                }
                else
                {
                  $resultado=$obj->reporteGanaciasUnAlmacen($fechaIni,$fechaFin,$idemp);
                }
                
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                 
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

                    $sub_costo=$fila->precio_compra_prod*$fila->cantidad_prod;   
                    $ganacia=$fila->subtotal_venta-$sub_costo;
                  
              ?>
               <tr style="background-color: <?php echo $alertaColor; ?>; color: <?php echo $colorTexto?>;">
                
                 <td ><?php echo $fila->id_venta; ?></td>
                 <td><?php echo $fila->nombre_producto; ?></td>
                 <td><?php echo $fila->codigo_producto; ?></td>
                <!--  <td><?php echo $fila->descripcion; ?></td> -->
                 <td><?php echo $fila->nombre_marca; ?></td>
                 <td><?php echo $fila->fecha_venta; ?></td>
                 <td><?php echo $fila->venta_facturada; ?></td>
                
                  <td><?php echo $fila->id_compra_producto; ?></td>
                  <td><?php echo $fila->cantidad_prod; ?></td>
                  <td><?php echo $fila->precio_venta_establecido; ?></td>
                
                
                 <td><?php echo $fila->precio_compra_prod; ?></td>
                              
                 <td><?php echo $fila->precio_unitario_venta; ?></td>
                 <td><?php echo $fila->subtotal_venta; ?></td>
                 <td><?php echo $fila->nombre_almacen; ?></td>
                 <td><?php echo number_format((float)$ganacia, 2, '.', ''); ?></td>
                
               
                 <?php
                // $costo_float= floatval($fila->precio_unit_compra);
                // $montoInvent=$costo_float*$fila->stock_actual;
                // $montoDecimal=number_format((float)$montoInvent, 2, '.', '');

                 ?>
                 <!-- <td><?php echo $montoDecimal; ?></td> -->

                 
                
              
               </tr>
               <?php
                 // $contador++;
                  $GananciasTotales=$GananciasTotales+$ganacia;
                 }
               ?>
             </tbody>
             <tfoot>
               <tr>
                 <td colspan="13" style="text-align: center;"><b>Total Ganancias</b> </td>
                 <td><b><?php echo number_format((float)$GananciasTotales, 2, '.', ''); ?></b></td>
               </tr>
             </tfoot>
          </table>