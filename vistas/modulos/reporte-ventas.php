<?php
include_once("modelos/venta.modelo.php");
include_once("modelos/empleado.modelo.php");
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
        <small>Ventas</small>
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
                 <button style="float: right;" class="btn btn-danger btn-xs" onclick="window.open('impresiones/tcpdf/pdf/reporte_ventas.php')">PDF</button>
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


    <!-- Modal Eliminar venta-->
<div id="modalElimventa" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #dd4b39; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eliminar venta</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  
                  <input type="hidden" name="idventa" id="idventa" placeholder="id venta">
                  <input type="hidden" name="idusuario_1" id="idusuario_1" value="<?php echo $iduseractual ?>">
                  

                 
              </div>  
            </div>

           
            <div class="form-group">
              <div class="input-group">
                 <!-- <label>Todos los productos  de venta se eliminaran </label>-->
                  <label >Desea eliminar la venta con codigo&nbsp;  </label> <label id="labelcodigo"></label> <label>&nbsp;?</label>                 
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnelimventa" id="btnelimventa">Eliminar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 


    
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
    
      $('#divtablareportes').load('vistas/modulos/tabla_reportes_ventas.php?fini='+fecha_ini+'&ffin='+fecha_fin+'&idemp='+idemp);
                    // alert(response);                                      
      }



  /*===================FUNCION QUE LLAMA AL ELIMINAR ===========================================*/
$(document).ready(function() { 
   $("#btnelimventa").on('click', function() {
  
   var formDataelim = new FormData(); 
   
   var btnelimventa=$('#btnelimventa').val();
   var idventa    =$('#idventa').val();
   var idusuario_1=$('#idusuario_1').val();
   
 
   if ( (idventa=='') || (idusuario_1=='')  ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
    
     formDataelim.append('idventa',idventa);
     formDataelim.append('idusuario_1',idusuario_1);
     formDataelim.append('btnelimventa',btnelimventa);
      $.ajax({ url: 'controladores/venta.controlador.php', 
               type: 'post', 
               data: formDataelim, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='reporte-ventas'; }, 2000); swal('EXELENTE','Eliminado correctamente','success'); 
                     
                  }
                  else
                  {
                    if (response==0) 
                    {
                    setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente, no se acutlizo stock, codigo de error '+response,'error');
                    }
                    else
                    {
                      if (response==2) 
                      {
                        setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente, no se elimino el detalle  de la venta, codigo de error '+response,'error');
                      }
                      else
                      {
                        if (response==3) 
                        {
                          setTimeout(function(){  }, 2000); swal('ERROR','No se puede eliminar la venta porque ya esta en un cierre de caja, debe eliminar el cierre de caja para eliminar la venta, codigo de error '+response,'error');
                        }
                        else
                        {
                          if (response==9) 
                           {
                             setTimeout(function(){  }, 2000); swal('ERROR','No se puede eliminar la venta, intente nuevamente, codigo de error '+response,'error');
                           }
                        }
                      }
                    }
                                       
                  } 
                }
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
     
</script>


