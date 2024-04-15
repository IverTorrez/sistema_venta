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
        Cierres de Caja
       
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
     
                 <label>Fecha Cierre:</label>
                 <input type="date" name="dateInico" id="dateInico" value="<?php echo $fecha ?>">
              
                  <label>Vendedor:</label>
                 <select id="selectemp" name="selectemp">                 
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
                 <button  class="btn btn-success btn-xs" onclick="generacionVentaCierre();">Generar</button>
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
<div id="modalCierreCaja" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
 
      <div class="modal-header" style="background: #3c8dbc; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="titulo_cierre"> </h4>
      </div>
      <div class="modal-body">
         <div class="box-body">
            <div class="form-group">
              <label>Ejecutivo de ventas</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="Nombre_emp" id="Nombre_emp" placeholder="Ingresar nombre" required="" autocomplete="off" readonly value="">
              </div>  
            </div>

            <div class="form-group">
              <label>Venta realizadas</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="cant_ventas" id="cant_ventas" placeholder="Cantidad ventas" required="" autocomplete="off" readonly value="">
              </div>  
            </div>

            <div class="form-group">
              <label>Cantidad de productos</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="cant_productos" id="cant_productos" placeholder="Cantidad productos" required="" autocomplete="off" readonly value="">
              </div>  
            </div>
            <div class="form-group">
              <label>Monto de ventas</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="monto_ventas" id="monto_ventas" placeholder="Monto de ventas" required="" autocomplete="off" readonly value="">
              </div>  
            </div>

            <div class="form-group">
              <label>Monto entregado de caja</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="number" class="form-control input-lx" name="monto_entregado" id="monto_entregado" placeholder="Monto entregado" required="" autocomplete="off" oninput="calcularsobrante(this.value)">
              </div>  
            </div>

            <div class="form-group">
              <label>Monto diferencia</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="number" class="form-control input-lx" name="monto_sobrante" id="monto_sobrante" placeholder="Monto de diferencia" required="" autocomplete="off" readonly value="">
              </div>  
            </div>        
                  <input type="hidden" name="idusuario_1" id="idusuario_1" value="<?php echo $iduseractual ?>">
          
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btncerrarcaja" id="btncerrarcaja">Cerrar caja</button>
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
  //  generacionVentaCierre();

      function generacionVentaCierre()
      {
     var fecha_ini=$('#dateInico').val();
    // var fecha_fin=$('#dateFinal').val();
     var idemp=$('#selectemp').val();
    
      $('#divtablareportes').load('vistas/modulos/tabla_ventas_cierre.php?fini='+fecha_ini+'&idemp='+idemp);
                    // alert(response);

      }

      function cargadeDatosModalParaCierre()
      {
        //limpiado de campos
        $('#Nombre_emp').val('');
        $('#cant_ventas').val('');
        $('#cant_productos').val('');
        $('#monto_ventas').val('');
        $('#monto_entregado').val('');
        $('#monto_sobrante').val('');

        var nombreUsuario=$('#nombre_usuario').val();
        var totalventas =$('#totalventasdia').val();
        var totalproductos =$('#totalproductos').val();
        var montoventasdia = $('#totalmontoventasdia').val();
        var  fecha_cierre   =$('#fecha_cierre').val();
        //se cargan los valores al modal
        $('#Nombre_emp').val(nombreUsuario); 
        $('#cant_ventas').val(totalventas);
        $('#cant_productos').val(totalproductos);
        $('#monto_ventas').val(montoventasdia);
        $('#monto_sobrante').val(montoventasdia);//por defecto el campo sobrante tiene el monto ventas
        $('#titulo_cierre').text('Cierre de caja de Fecha: '+fecha_cierre);
        
      }

      function calcularsobrante(montoentregado)
      {
        var monto_ventas1=$('#monto_ventas').val();
        var monto_entregado1=$('#monto_entregado').val();
        var montosobrante=monto_ventas1-monto_entregado1;
        if (montosobrante<0) 
          {
            montosobrante=montosobrante*(-1);
          }
        $('#monto_sobrante').val(montosobrante);

      }



  /*===================FUNCION QUE LLAMA AL ELIMINAR ===========================================*/
$(document).ready(function() { 
   $("#btncerrarcaja").on('click', function() {
  
   var idempleado    =$('#idempleadocierre').val();
   var  monto_sobrante   =$('#monto_sobrante').val();
   var  idadmin   =$('#idusuario_1').val();

   if ( (idempleado=='') || (idadmin=='')  ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','No hay datos del empleado o del administrador','warning'); 
        
   }
   else
   {
     if (monto_sobrante>0) 
     {
      Swal.fire({
                  title: 'Esta usted seguro de hacer el cierre?',
                  text: "Hay un monto de diferencia de "+monto_sobrante+" Bs.",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, cerrar caja'
                }).then((result) => {
                  if (result.isConfirmed) {
                    guardarCierreCaja();
                    
                  }
                })
     }//fin del if que pregunta si hay monto sobrante
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     else
     {
      guardarCierreCaja();
     }
     
          
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
function guardarCierreCaja()
{
  var formDatacerrarcaja = new FormData(); 
   
   var btncerrarcaja=$('#btncerrarcaja').val();
   var idempleado    =$('#idempleadocierre').val();
   var  cant_ventas   =$('#cant_ventas').val();
   var  cant_productos   =$('#cant_productos').val();
   var  monto_ventas   =$('#monto_ventas').val();
   var  monto_entregado   =$('#monto_entregado').val();
   var  monto_sobrante   =$('#monto_sobrante').val();
   var  fecha_cierre   =$('#fecha_cierre').val();
   var  idadmin   =$('#idusuario_1').val();
   var cod_ventas =$('#cod_ventas').val();

   formDatacerrarcaja.append('idempleado',idempleado);
     formDatacerrarcaja.append('cant_ventas',cant_ventas);
     formDatacerrarcaja.append('cant_productos',cant_productos);
     formDatacerrarcaja.append('monto_ventas',monto_ventas);
     formDatacerrarcaja.append('monto_entregado',monto_entregado);
     formDatacerrarcaja.append('monto_sobrante',monto_sobrante);
     formDatacerrarcaja.append('fecha_cierre',fecha_cierre);
     formDatacerrarcaja.append('idadmin',idadmin);
     formDatacerrarcaja.append('btncerrarcaja',btncerrarcaja);

     formDatacerrarcaja.append('cod_ventas',cod_ventas);
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
                          'Caja cerrada con exito',
                          'success',
                          setTimeout(function(){ location.href='cierre-cajas'; }, 2000)
                        )
                     
                  }
                  else
                  { if (response==0) 
                      {
                        setTimeout(function(){  }, 2000); swal('Error','Intente nuevamente','error');
                      }
                      else
                      {
                        if (response==2) 
                           {
                            Swal.fire(
                              'Error!',
                              'Este empleado ya tiene registrado cierre de caja con esta fecha',
                              'error'                         
                            )
                           }
                           else
                           {
                             if (response==3) 
                             {
                                Swal.fire(
                                  'Error!',
                                  'No puede hacer un cierre con una fecha mayor a las fecha actual',
                                  'error'                         
                                )
                             }
                             else{
                                  setTimeout(function(){  }, 2000); swal(response,'Intente nuevamente','error');
                                  }
                           }
                      }                                
                  } 
                }
            }); 

}/*fin de funcion guardar*/
     
</script>





