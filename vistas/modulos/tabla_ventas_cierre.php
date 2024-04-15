<?php
session_start();
$fechaIni=$_GET['fini'];
//$fechaFin=$_GET['ffin'].' 23:59:00';
$idemp=$_GET['idemp'];

// echo $fechaFin;
$_SESSION["frchaini"]=$fechaIni;
//$_SESSION["fechafin"]=$fechaFin;
$_SESSION["idemp"]=$idemp;
include_once("../../modelos/empleado.modelo.php");

if ($idemp==0) 
{
  $nombreVendedor='Todos';
}
else
{
  
  $objemep=new Empleado();
 $resultEmp=$objemep->mostarUnEmpleadosActivos($idemp);
 $filaemp=mysqli_fetch_object($resultEmp);
 $idempleado=$filaemp->id_empleado;
 $nombreEmp=$filaemp->nombre_empleado;
 $apellido=$filaemp->apellido_empleado;
 $nombreVendedor=$nombreEmp.' '.$apellido;
 }
?>
<label>Ejecutivo de ventas: <?php  echo $nombreVendedor; ?> </label>
<input type="hidden" name="nombre_usuario" id="nombre_usuario" value="<?php echo $nombreVendedor; ?>">
<input type="hidden" name="idempleadocierre" id="idempleadocierre" value="<?php echo $idempleado; ?>"> 
<input type="hidden" name="fecha_cierre" id="fecha_cierre" value="<?php echo $fechaIni; ?>">
<table class="table table-bordered table-striped ">
             <thead>
                <tr>    
                  <th>Cod. Venta</th>           
                  <th>Fecha venta</th>
                  <th>V. Facturada</th>
                  <th>Usuario</th>
                  <th>Cliente</th>
                  <th>Cantidad</th> 
                  <th>Costo Productos</th>
                  <th>Monto venta</th>         
                  <th>Ganancias</th>      
                </tr>
             </thead>

             <tbody>
               <?php
               include_once("../../modelos/venta.modelo.php");     
               $contador=0;
               $totalProductos=0;
               $ganacia=0;
               $sub_costo=0;
               $GananciasTotales=0;
               $totalMontoVentas=0;
               $alertaColorfila='';
               $colorTexto='';

               $codventas='';
               $separador='';
               $obj=new Venta();
               $resultado=$obj->reporteVentasDeUnEmpleadoParaCierre($fechaIni,$idemp);

               $_SESSION['resultablacierre']=$resultado;
               $resultsession=$_SESSION['resultablacierre'];
                while ($fila=mysqli_fetch_object($resultsession)) 
                {
                   $datosventa=$fila->id_venta."||".
                                     $fila->fecha_venta."||".
                                     $fila->venta_facturada."||".
                                     $fila->cantidad_productos."||".
                                     $fila->monto_costoProducto."||".
                                     $fila->monto_venta."||".
                                     $fila->ganancia."||".
                                     $fila->Usuario."||".
                                     $fila->cliente;
                      
                    if ($contador>0)
                    {
                       $separador='||';
                    }              
                   $codventas=$codventas.$separador.$fila->id_venta;
                  /*obtenemos la ganacia de total vendido del producto*/
                 
              ?>
               <tr>        
                 <td ><a target="_blank" href="impresiones/tcpdf/pdf/nota_venta.php?codventa=<?php echo $fila->id_venta ?>"> <?php echo $fila->id_venta; ?></a></td>
                 <td><?php echo $fila->fecha_venta; ?></td>
                 <td><?php echo $fila->venta_facturada; ?></td>
                 <td><?php echo $fila->Usuario; ?></td>
                 <td><?php echo $fila->cliente; ?></td>
                 <td><?php echo $fila->cantidad_productos; ?></td>
                  <td><?php echo $fila->monto_costoProducto; ?></td>
                  <td><?php echo $fila->monto_venta; ?></td>
                  <td><?php echo $fila->ganancia; ?></td>
                  
                 <!-- <td><?php echo number_format((float)$ganacia, 2, '.', ''); ?></td>-->
                
                 <?php
                // $costo_float= floatval($fila->precio_unit_compra);
                // $montoInvent=$costo_float*$fila->stock_actual;
                // $montoDecimal=number_format((float)$montoInvent, 2, '.', '');

                 ?>
                 <!-- <td><?php echo $montoDecimal; ?></td> -->

                 
                
              
               </tr>
               <?php
                 if ($fila->id_venta>0) {
                   $contador++; //conteo de totales ventas
                   $totalProductos=$totalProductos+$fila->cantidad_productos;/*suma de productos de todas las ventas*/
                 }
                  
                 //  SUMA DE TOTALES
                  $totalMontoVentas=$totalMontoVentas+$fila->monto_venta;
                  $GananciasTotales=$GananciasTotales+$fila->ganancia;

                 }
               ?>
             </tbody>
             <tfoot>
               <tr>
                 <td colspan="7" style="text-align: center;"><b>Totales</b> </td>
                 <td><b><?php echo number_format((float)$totalMontoVentas, 2, '.', ''); ?></b></td>
                 <td><b><?php echo number_format((float)$GananciasTotales, 2, '.', ''); ?></b></td>
               </tr>
             </tfoot>
          </table>
 <input type="hidden" name="totalventasdia" id="totalventasdia" placeholder="cantidad ventas" value="<?php echo $contador; ?>"> 
 <input type="hidden" name="totalproductos" id="totalproductos" placeholder="total cantidad de Productos" value="<?php echo $totalProductos; ?>"> 
 <input type="hidden" name="totalmontoventasdia" id="totalmontoventasdia" placeholder="monto ventas" value="<?php echo number_format((float)$totalMontoVentas, 2, '.', ''); ?>">

 <input type="hidden" name="cod_ventas" id="cod_ventas" value="<?php echo $codventas; ?>" placeholder="codigos de todas las ventas">

<script type="text/javascript">
   /*===========CARGA DE DATOS PARA JAVASCRIPT======================*/
   mostrarBotonCierre();   
   function mostrarBotonCierre()
   {
     /* var totalventas=0;
      totalventas=$('#totalventasdia').val();
      if (totalventas>0)
      {
        $("#btncierrecaja").show(300);
    
      }
      else
      {
        $("#btncierrecaja").hide(500);
      }*/
     
      $("#btncierrecaja").show(300);
   }

  
</script>