<?php
include_once("modelos/venta.modelo.php");
include_once("modelos/almacen.modelo.php");
ini_set('date.timezone','America/La_Paz');
$fecha=date("Y-m-d");
$hora=date("H:i");
/*$fechaHora=$fecha.' '.$hora;*/
if ($_SESSION["tipo_user"]!="admin")
{
  echo '<script>
        window.location="inicio";
      </script>';
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
        Reportes
        <small>Ganacias</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Reportes</li>
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
          
          <!-- <h3  class="box-title">Reportes De Ventas</h3> -->
     
                 <label>Fecha Inico:</label>
                 <input type="date" name="dateInico" id="dateInico" value="<?php echo $fecha ?>">
                 <label>Fecha Fin:</label>
                 <input type="date" name="dateFinal" id="dateFinal" value="<?php echo $fecha ?>">
                  <label>Almacen:</label>
                 <select id="selectemp" name="selectemp">
                  <option value="0">Todos</option>
                  <?php
                    $objemp=new Almacen();
                    $result=$objemp->listarAlmacenActivos();
                     while ($fila=mysqli_fetch_object($result)) 
                     {
                    ?>
                       <option value="<?php echo $fila->id_almacen; ?>"><?php echo $fila->nombre_almacen; ?></option>

                    <?php
                      }
                  ?>
                 
                </select>
                 <button  class="btn btn-success btn-xs" onclick="generacionReporte();">Generar</button>
                 <button style="float: right;" class="btn btn-danger btn-xs" onclick="window.open('impresiones/tcpdf/pdf/reporte_ganancias.php')">PDF</button>
         <!--  <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div> -->
        </div>
        <div class="box-body" id="divtablareportes">
         
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
    generacionReporte();
      function generacionReporte()
      {
     var fecha_ini=$('#dateInico').val();
     var fecha_fin=$('#dateFinal').val();
     var idemp=$('#selectemp').val();
     
      $('#divtablareportes').load('vistas/modulos/tabla_reportes_ganacias.php?fini='+fecha_ini+'&ffin='+fecha_fin+'&idemp='+idemp);
                    // alert(response);                                      
      }
  
</script>
