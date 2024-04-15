<?php
session_start();
$fechaIni=$_GET['fini'];
$fechaFin=$_GET['ffin'];
$idemp=$_GET['idemp'];

// echo $fechaFin;
/*$_SESSION["frchaini"]=$fechaIni;
$_SESSION["fechafin"]=$fechaFin;
$_SESSION["idemp"]=$idemp;*/
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
 $nombreEmp=$filaemp->nombre_empleado;
 $apellido=$filaemp->apellido_empleado;
 $nombreVendedor=$nombreEmp.' '.$apellido;
 }
?>
<label>Ejecutivo de ventas: <?php  echo $nombreVendedor; ?> </label>
<table class="table table-bordered table-striped ">
             <thead>
                <tr>
                  <th>Cod. cierre</th>
                  <th>Fecha cierre</th>
                   <th>Cantidad ventas</th>
                  <th>Cantidad productos</th> 
                  <th>Monto de venta</th>
                  <th>Monto entregado de caja</th>
                  <th>Monto sobrante</th>
                     
                   <th>Fecha de registro</th>
                   <th>Empleado de cierre</th>
                  <th>Borrar</th>
                </tr>
             </thead>

             <tbody>
               <?php
               include_once("../../modelos/cierre_caja.modelo.php");

                
               $contador=1;
               $suma_montosventas=0;
               $suma_cajaentregado=0;
               $suma_sobrantes=0;
               $totalMontoVentas=0;
               $alertaColorfila='';
               $colorTexto='';
                $obj=new Cierre_caja();

                if ($idemp==0)/*reporte de todos los que realizaron cierres*/
                {
                  $resultado=$obj->listarcierresActivosDefecha($fechaIni,$fechaFin);
                }
                else/*reporte de un ventero especifico*/
                {
                 $resultado=$obj->listarcierresActivosDefechaDeEmpleado($fechaIni,$fechaFin,$idemp); 
                }
                

                while ($fila=mysqli_fetch_object($resultado)) 
                {
                   $datosventa=$fila->id_cierre_caja."||".
                                     $fila->fecha_cierre."||".
                                     $fila->monto_venta_cierre."||".
                                     $fila->monto_caja."||".
                                     $fila->monto_sobrante."||".
                                     $fila->cantidad_ventas."||".
                                     $fila->cantidad_productos."||".
                                     $fila->empleado."||".
                                     $fila->fecha_alta;
                                                    
              ?>
               <tr > 
                 <td ><?php echo $fila->id_cierre_caja; ?></td>
                 <td><?php echo $fila->fecha_cierre; ?></td>
                 <td><?php echo $fila->cantidad_ventas; ?></td>
                 <td><?php echo $fila->cantidad_productos; ?></td>
                 <td><?php echo $fila->monto_venta_cierre; ?></td>
                 <td><?php echo $fila->monto_caja; ?></td>
                 <td><?php echo $fila->monto_sobrante; ?></td> 
                 
                 <td><?php echo $fila->fecha_alta; ?></td>
                  <td><?php echo $fila->empleado; ?></td>               
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimCierreCaja" onclick="CargarinfoCierreElim('<?php echo $datosventa ?>')"><i class="fa fa-times"></i></button>
                   </div>
                 </td>
                
               
                 <?php
                // $costo_float= floatval($fila->precio_unit_compra);
                 $suma_montosventas=$suma_montosventas+$fila->monto_venta_cierre;
                 $suma_cajaentregado=$suma_cajaentregado+$fila->monto_caja;
                 $suma_sobrantes=$suma_sobrantes+$fila->monto_sobrante;
                // $montoDecimal=number_format((float)$montoInvent, 2, '.', '');

                 ?>
                 <!-- <td><?php echo $montoDecimal; ?></td> -->

                 
                
              
               </tr>
               <?php
                 // $contador++; SUMA DE TOTALES
                 // $totalMontoVentas=$totalMontoVentas+$fila->subtotal_venta;
                 // $GananciasTotales=$GananciasTotales+$ganacia;

                 }
               ?>
             </tbody>
             <tfoot>
               <tr>
                 <td colspan="4" style="text-align: center;"><b>Totales</b> </td>
                 <td><b><?php echo number_format((float)$suma_montosventas, 2, '.', ''); ?></b></td>
                 <td><b><?php echo number_format((float)$suma_cajaentregado, 2, '.', ''); ?></b></td>
                 <td><b><?php echo number_format((float)$suma_sobrantes, 2, '.', ''); ?></b></td>
                 <td ></td>
                 <td ></td>
                 <td ></td>
               </tr>
             </tfoot>
          </table>

<script type="text/javascript">
   /*========================CARGAMOS LOS DATOS PARA ELIMINAR=========================*/
function CargarinfoCierreElim(datosventa) 
  {
    
    f=datosventa.split('||');
    $('#id_cierre').val(f[0]);
    $('#Nombre_emp').val(f[7]);
    $('#fecha_cierre_elim').val(f[1]);
    $('#cant_ventas').val(f[5]);
    
    

  }
  
</script>