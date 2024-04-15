<?php
include_once("modelos/compraProducto.modelo.php");

?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reportes
        <small>Inventario</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Reportes</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Reportes De Inventario</h3>
                 <button class="btn btn-danger btn-xs" onclick="window.open('impresiones/tcpdf/pdf/reporte_inventario_pdf.php')">PDF</button>
         <!--  <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div> -->
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped ">
             <thead>
                <tr>
                 
                  <th>Nº Lote</th>
                  <th>Producto</th>
                  <th>Codigo</th>
                  <th>Descripcion</th>
                  <th>Marca</th>
                  <th>Categoria</th>
                  <th>Stok</th>
               
                  <th>Precio Venta</th>
                  <th>Precio Venta Fact.</th>
           

                </tr>
             </thead>

             <tbody>
               <?php
               $contador=1;
               $totalSaldoInventario=0;
                $obj=new Compra_Producto();
                $resultado=$obj->reporteInventario();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                 
                                     
                  
              ?>
               <tr>
                
                 <td><?php echo $fila->id_compra_producto; ?></td>
                 <td><?php echo $fila->nombre_producto; ?></td>
                 <td><?php echo $fila->codigo_producto; ?></td>
                 <td><?php echo $fila->descripcion; ?></td>
                 <td><?php echo $fila->nombre_marca; ?></td>
                 <td><?php echo $fila->nombre_categoria; ?></td>
                 <td><?php echo $fila->stock_actual; ?></td>
               
                 <td><?php echo $fila->precio_venta_prod; ?></td>
               
                 <?php
                $costo_float= floatval($fila->precio_unit_compra);
                $montoInvent=$costo_float*$fila->stock_actual;
                $montoDecimal=number_format((float)$montoInvent, 2, '.', '');

                 ?>
                 <td><?php echo $fila->precio_venta_prod_Fact; ?></td>

                 
                
              
               </tr>
               <?php
                 $contador++;
                 $totalSaldoInventario=$totalSaldoInventario+$montoDecimal;
                 }
               ?>
             </tbody>
            <!--  <tfoot>
               <tr>
                 <td colspan="8" style="text-align: center;"><b>Total</b> </td>
                 <td><b><?php echo $totalSaldoInventario; ?></b></td>
               </tr>
             </tfoot> -->
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