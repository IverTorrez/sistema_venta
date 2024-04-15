<?php
include_once("modelos/sucursal.modelo.php");
if ($_SESSION["tipo_user"]!="admin")
{
  echo '<script>
        window.location="inicio";
      </script>';
}
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Sucursales
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Administrar Sucursal</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
            Agregar Sucursal
          </button>
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped tablas">
             <thead>
                <tr>
                  <th style="width: 10px;">Codigo</th>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Contacto</th>                  
                 
                  <th>Acciones</th>

                </tr>
             </thead>

             <tbody>
               <?php
               $contador=1;
                $obj=new Sucursal();
                $resultado=$obj->listarSucursalesActivas();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datosCli=$fila->id_sucursal."||".
                                     $fila->nombre_suc."||".
                                     $fila->descripcion_suc."||".
                                     $fila->contacto;
                                   
                                    
                                     
                  
              ?>
               <tr>
                 <td><?php echo $fila->id_sucursal; ?></td>
                 <td><?php echo $fila->nombre_suc; ?></td>
                 <td><?php echo $fila->descripcion_suc; ?></td>
                 <td><?php echo $fila->contacto; ?></td>
                                         
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditCli" onclick="CargarinfoCliEnModal('<?php echo $datosCli ?>')"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimCli" onclick="CargarinfoCliEnModalElim('<?php echo $datosCli ?>')"><i class="fa fa-times"></i></button>
                   </div>
                 </td>
               </tr>
               <?php
                 $contador++;
                 }
               ?>
             </tbody>
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


   <!--MODAL PARA AGREGAR USUSARIOS -->
   <!-- Modal -->
<div id="modalAgregarCliente" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #3c8dbc; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar Sucursal</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <label>Nombre Sucursal</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoNombre" id="nuevoNombre" placeholder="Ingresar nombre" required="" autocomplete="off">
              </div>  
            </div>

            <div class="form-group">
              <label>Descripcion</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoDescripcion" id="nuevoDescripcion" placeholder="Ingresar Descripcion" required="" autocomplete="off">
              </div>  
            </div>


            <div class="form-group">
              <label>Contacto</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoContacto" id="nuevoContacto" placeholder="Ingresar contacto" required="" autocomplete="off">
              </div>  
            </div>

            

         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnguardarcli" id="btnguardarcli">Guardar</button>
      </div>
     
    </div>

  </div>
</div>



 <!-- Modal -->
<div id="modalEditCli" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #f39c12; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Actualizar Sucursal</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <label>Nombre</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="hidden" name="idsucedit" id="idsucedit" placeholder="id sucursal">
                 <input type="text" class="form-control input-lx" name="editNombre" id="editNombre" placeholder="Ingresar nombre" required="">
              </div>  
            </div>

            <div class="form-group">
              <label>Descripcion</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="editDescripcion" id="editDescripcion" placeholder="Ingresar Descripcion" required="">
              </div>  
            </div>


            <div class="form-group">
              <label>Contacto</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                 <input type="text" class="form-control input-lx" name="editContacto" id="editContacto" placeholder="Ingresar contacto" required="">
              </div>  
            </div>

                      
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btneditcli" id="btneditcli">Actualizar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 


 <!-- Modal Eliminar empleado-->
<div id="modalElimCli" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #dd4b39; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eliminar Sucursal</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  
                  <input type="hidden" name="idsucelim" id="idsucelim" placeholder="id sucursal">
                 
              </div>  
            </div>

           
            <div class="form-group">
              <div class="input-group">
                  <label>Desea eliminar esta sucursal ?</label>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnelimcli" id="btnelimcli">Eliminar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 



<script type="text/javascript">
  
  $(document).ready(function() { 
   $("#btnguardarcli").on('click', function() {
  
   var formDatacli = new FormData(); 
   
   var btnguardarcli=$('#btnguardarcli').val();
   var nuevoNombre=$('#nuevoNombre').val();
   var nuevoDescripcion=$('#nuevoDescripcion').val();
   var nuevoContacto=$('#nuevoContacto').val();
    
   if ( (nuevoNombre=='') ||  (nuevoDescripcion=='')||  (nuevoContacto=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDatacli.append('btnguardarcli',btnguardarcli);
     formDatacli.append('nuevoNombre',nuevoNombre);
     formDatacli.append('nuevoDescripcion',nuevoDescripcion);
     formDatacli.append('nuevoContacto',nuevoContacto);
    
      $.ajax({ url: 'controladores/sucursales.controlador.php', 
               type: 'post', 
               data: formDatacli, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='sucursales'; }, 1000); swal('EXELENTE','','success'); 
                     
                  }
                  else
                  {
                    setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                                       
                  } 
                }
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });


/*========================CARGAMOS LOS DATOS PARA ACTUALIZAR=========================*/
function CargarinfoCliEnModal(datosCli) 
  {
    
    f=datosCli.split('||');
    $('#idsucedit').val(f[0]);
     $('#editNombre').val(f[1]);
      $('#editDescripcion').val(f[2]);
      $('#editContacto').val(f[3]);
     
     
          // $('#textidalim').text(f[0]);
  }


/*===================FUNCION QUE LLAMA AL EDITAR EMPLEADO===========================================*/
$(document).ready(function() { 
   $("#btneditcli").on('click', function() {
  
   var formDataeditCli = new FormData(); 
   
   var btneditcli=$('#btneditcli').val();
   var idsucedit=$('#idsucedit').val();
   var editNombre=$('#editNombre').val();
   var editDescripcion=$('#editDescripcion').val();
   var editContacto=$('#editContacto').val();
  
   if ( (editNombre=='') ||  (editDescripcion=='')||  (editContacto=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataeditCli.append('idsucedit',idsucedit);
     formDataeditCli.append('btneditcli',btneditcli);
     formDataeditCli.append('editNombre',editNombre);
     formDataeditCli.append('editDescripcion',editDescripcion);
     formDataeditCli.append('editContacto',editContacto);
    
      $.ajax({ url: 'controladores/sucursales.controlador.php', 
               type: 'post', 
               data: formDataeditCli, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='sucursales'; }, 1000); swal('EXELENTE','','success'); 
                     
                  }
                  else
                  {
                    setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                                       
                  } 
                }
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });


/*========================CARGAMOS LOS DATOS PARA ELIMINAR=========================*/
function CargarinfoCliEnModalElim(datosCli) 
  {
    
    f=datosCli.split('||');
    $('#idsucelim').val(f[0]);       
          // $('#textidalim').text(f[0]);
  }


/*===================FUNCION QUE LLAMA AL ELIMINAR EMPLEADO===========================================*/
$(document).ready(function() { 
   $("#btnelimcli").on('click', function() {
  
   var formDataelim = new FormData(); 
   
   var btnelimcli=$('#btnelimcli').val();
   var idsucelim=$('#idsucelim').val();
  
   
  
   if ( (idsucelim=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataelim.append('idsucelim',idsucelim);
     formDataelim.append('btnelimcli',btnelimcli);
  
     
     
      $.ajax({ url: 'controladores/sucursales.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='sucursales'; }, 1000); swal('EXELENTE','','success'); 
                     
                  }
                  else
                  {
                    setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                                       
                  } 
                }
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
</script>