<?php
include_once("modelos/venta.modelo.php");
include_once("modelos/empleado.modelo.php");
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
<script src="vistas/plugins/sweetalert2/package/dist/sweetalert2.all.min.js"></script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reportes de cierres de Caja
       
      </h1>
      
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
     
                 <label>Fecha inicio:</label>
                 <input type="date" name="dateInico" id="dateInico" value="<?php echo $fecha ?>">

                 <label>Fecha fin:</label>
                 <input type="date" name="datefin" id="datefin" value="<?php echo $fecha ?>">
              
                  <label>Vendedor:</label>
                 <select id="selectemp" name="selectemp"> 
                 <option value="0">Todos</option>                
                  <?php
                    $objemp=new Empleado();
                    $result=$objemp->listarEmpleadosActivos();
                     while ($fila=mysqli_fetch_object($result)) 
                     {
                    ?>
                       <option value="<?php echo $fila->id_empleado; ?>"><?php echo $fila->nombre_empleado.' '.$fila->apellido_empleado; ?></option>

                    <?php
                      }
                  ?>
                 
                </select>
                 <button  class="btn btn-success btn-xs" onclick="generacionReporteCierre();">Generar</button>
                 <button style="display:none;" name="btncierrecaja" id="btncierrecaja" data-toggle="modal" data-target="#modalCierreCaja" class="btn btn-danger btn-xs" onclick="cargadeDatosModalParaCierre();">CERRAR CAJA</button>
        
        </div>
        <div class="box-body" id="divtablareportes">
         
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->


    <!-- Modal Cierre caja-->
<div id="modalElimCierreCaja" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
 
      <div class="modal-header" style="background: #d73925; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="titulo_cierre">Eliminacion de cierre de caja</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">
            <div class="form-group">
              <label>Ejecutivo de ventas</label>
              <div class="input-group">
                <input type="hidden" class="form-control input-lx" name="id_cierre" id="id_cierre" placeholder="id  cierre" required="" autocomplete="off"  value="">

                <input type="hidden" class="form-control input-lx" name="cant_ventas" id="cant_ventas" placeholder="cantidad  ventas" required="" autocomplete="off"  value="">

                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="Nombre_emp" id="Nombre_emp" placeholder="Ingresar nombre" required="" autocomplete="off" readonly value="">
              </div>  
            </div>

            <div class="form-group">
              <label>Fecha de cierre</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="fecha_cierre_elim" id="fecha_cierre_elim" placeholder="Fecha de cierre para eliminar" required="" autocomplete="off" readonly value="">
              </div>  
            </div>

            <label>Esta usted seguro de eliminar este cierre?</label>
   
                
                  <input type="hidden" name="idusuario_1" id="idusuario_1" value="<?php echo $iduseractual ?>">
          
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnelimcerrarcaja" id="btnelimcerrarcaja">Eliminar cierre</button>
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
  //  generacionReporteCierre();

      function generacionReporteCierre()
      {
     var fecha_ini=$('#dateInico').val();
     var fecha_fin=$('#datefin').val();
     var idemp=$('#selectemp').val();
    
      $('#divtablareportes').load('vistas/modulos/tabla_reportes_cierre.php?fini='+fecha_ini+'&ffin='+fecha_fin+'&idemp='+idemp);
                    // alert(response);

      }

    


  /*===================FUNCION QUE LLAMA AL ELIMINAR ===========================================*/
$(document).ready(function() { 
   $("#btnelimcerrarcaja").on('click', function() {
  
   var idcierre    =$('#id_cierre').val();
   var  idadmin   =$('#idusuario_1').val();

   if ( (idcierre=='') || (idadmin=='')  ) 
   {
     Swal.fire(
                'Error!',
                'Se perdieron datos, Favor de recargar la pagina, y vuelva a intentar',
                'error'                         
              )    
   }
   else
   { 
      ElimCierreCaja();      
      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });


/*Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )
  }
})*/
function ElimCierreCaja()
{
  var formDatacerrarcaja = new FormData(); 
   
   var btnelimcerrarcaja=$('#btnelimcerrarcaja').val();
   var id_cierre    =$('#id_cierre').val();
   var  idusuario_1   =$('#idusuario_1').val();
   var  cant_ventas   =$('#cant_ventas').val();
   
   
     formDatacerrarcaja.append('id_cierre',id_cierre);
     formDatacerrarcaja.append('idusuario_1',idusuario_1); 
     formDatacerrarcaja.append('btnelimcerrarcaja',btnelimcerrarcaja);
     formDatacerrarcaja.append('cant_ventas',cant_ventas);

      $.ajax({ url: 'controladores/cierre_caja.controlador.php', 
               type: 'post', 
               data: formDatacerrarcaja, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                     Swal.fire(
                          'Exelente!',
                          'Se elimino el cierre con exito',
                          'success',
                          setTimeout(function(){ location.href='reporte-cierre'; }, 2000)
                        )
                     
                  }
                  else
                  { if (response==2) 
                      {
                        Swal.fire(
                              'Error!',
                              'Intente nuevamente',
                              'error'                         
                            )
                      }
                      else
                      {
                         Swal.fire(
                                  'Error!',
                                  'EL detalle no se elimino, favor comunicarse con sistemas',
                                  'error'                         
                                )
                      }                                
                  } 
                }
            }); 

}/*fin de funcion guardar*/
     
</script>





