<?php
include_once("modelos/administrador.modelo.php");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Administradores
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Administrar Administradores</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarAdmin">
            Agregar Administradores
          </button>
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped tablas">
             <thead>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Telefono</th>
                  <th>Usuario</th>
                  <th>Contraseña</th>
                  <th>Estado</th>
                  <th>Acciones</th>

                </tr>
             </thead>

             <tbody>
               <?php
               $contador=1;
                $objemp=new Administrador();
                $resultado=$objemp->listarAdminActivos();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datosAdmin=$fila->id_administrador."||".
                                     $fila->nombre_administrador."||".
                                     $fila->apellido_administrador."||".
                                     $fila->telefono_administrador."||".
                                     $fila->user_admin."||".
                                     $fila->password_admin;
                                     
                  
              ?>
               <tr>
                 <td><?php echo $contador; ?></td>
                 <td><?php echo $fila->nombre_administrador; ?></td>
                 <td><?php echo $fila->apellido_administrador; ?></td>
                 <td><?php echo $fila->telefono_administrador; ?></td>
                 <td><?php echo $fila->user_admin; ?></td>
                 <td><?php echo $fila->password_admin; ?></td>

                 
                 <td><button class="btn btn-success btn-xs">Activo</button> </td>
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditAdmin" onclick="CargarinfoAdminEnModal('<?php echo $datosAdmin ?>')"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimAdmin" onclick="CargarinfoAdminEnModalElim('<?php echo $datosAdmin ?>')"><i class="fa fa-times"></i></button>
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
<div id="modalAgregarAdmin" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #3c8dbc; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar administradores</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lg" name="nuevoNombre" id="nuevoNombre" placeholder="Ingresar nombre" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lg" name="nuevoApellido" id="nuevoApellido" placeholder="Ingresar apellido" required="">
              </div>  
            </div>


            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                 <input type="text" class="form-control input-lg" name="nuevoTelefono" id="nuevoTelefono" placeholder="Ingresar telefono" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>
                 <input type="text" class="form-control input-lg" name="nuevoUsuario" id="nuevoUsuario" placeholder="Ingresar usuario" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                 <input type="text" class="form-control input-lg" name="nuevoPassword" id="nuevoPassword" placeholder="Ingresar contraseña" required="">
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnguardaradmin" id="btnguardaradmin">Guardar</button>
      </div>
     
    </div>

  </div>
</div>




 <!-- MODAL ACEPTAR CAPACITACION -->
  <!-- Modal -->
<div id="modalEditAdmin" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #f39c12; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Actualizar administrador</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="hidden" name="idadminedit" id="idadminedit" placeholder="id admin">
                 <input type="text" class="form-control input-lg" name="editNombre" id="editNombre" placeholder="Ingresar nombre" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lg" name="editApellido" id="editApellido" placeholder="Ingresar apellido" required="">
              </div>  
            </div>


            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                 <input type="text" class="form-control input-lg" name="editTelefono" id="editTelefono" placeholder="Ingresar telefono" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>
                 <input type="text" class="form-control input-lg" name="editUsuario" id="editUsuario" placeholder="Ingresar usuario" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                 <input type="text" class="form-control input-lg" name="editPassword" id="editPassword" placeholder="Ingresar contraseña" required="">
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btneditadmin" id="btneditadmin">Actualizar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 




 <!-- Modal Eliminar empleado-->
<div id="modalElimAdmin" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #dd4b39; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eliminar administrador</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  
                  <input type="hidden" name="idadminelim" id="idadminelim" placeholder="id admin">
                 
              </div>  
            </div>

           
            <div class="form-group">
              <div class="input-group">
                  <label>Desea eliminar este administrador ?</label>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnelimadmin" id="btnelimadmin">Eliminar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 



<script type="text/javascript">
  $(document).ready(function() { 
   $("#btnguardaradmin").on('click', function() {
  
   var formDataAdmin = new FormData(); 
   
   var nuevoNombre=$('#nuevoNombre').val();
   var nuevoApellido=$('#nuevoApellido').val();
   var nuevoTelefono=$('#nuevoTelefono').val();
   var nuevoUsuario=$('#nuevoUsuario').val();
   var nuevoPassword=$('#nuevoPassword').val();
   var btnguardaradmin=$('#btnguardaradmin').val();
  
   if ( (nuevoNombre=='') ||  (nuevoApellido=='')||  (nuevoTelefono=='')||  (nuevoUsuario=='')||  (nuevoPassword=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataAdmin.append('nuevoNombre',nuevoNombre);
     formDataAdmin.append('nuevoApellido',nuevoApellido);
     formDataAdmin.append('nuevoTelefono',nuevoTelefono);
     formDataAdmin.append('nuevoUsuario',nuevoUsuario);
     formDataAdmin.append('nuevoPassword',nuevoPassword);
     formDataAdmin.append('btnguardaradmin',btnguardaradmin);
     
      $.ajax({ url: 'controladores/administrador.controlador.php', 
               type: 'post', 
               data: formDataAdmin, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='administradores'; }, 2000); swal('EXELENTE','','success'); 
                     
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
function CargarinfoAdminEnModal(datosAdmin) 
  {
    
    f=datosAdmin.split('||');
    $('#idadminedit').val(f[0]);
     $('#editNombre').val(f[1]);
      $('#editApellido').val(f[2]);
      $('#editTelefono').val(f[3]);
      $('#editUsuario').val(f[4]);
      $('#editPassword').val(f[5]);  
           
          // $('#textidalim').text(f[0]);
  }
/*===================FUNCION QUE LLAMA AL EDITAR EMPLEADO===========================================*/
$(document).ready(function() { 
   $("#btneditadmin").on('click', function() {
  
   var formDataeditadmin = new FormData(); 
   
   var btneditadmin=$('#btneditadmin').val();
   var idadminedit=$('#idadminedit').val();
   var editNombre=$('#editNombre').val();
   var editApellido=$('#editApellido').val();
   var editTelefono=$('#editTelefono').val();
   var editUsuario=$('#editUsuario').val();
   var editPassword=$('#editPassword').val();
   
  
   if ( (editNombre=='') ||  (editApellido=='')||  (editTelefono=='')||  (editUsuario=='')||  (editPassword=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataeditadmin.append('idadminedit',idadminedit);
     formDataeditadmin.append('btneditadmin',btneditadmin);
     formDataeditadmin.append('editNombre',editNombre);
     formDataeditadmin.append('editApellido',editApellido);
     formDataeditadmin.append('editTelefono',editTelefono);
     formDataeditadmin.append('editUsuario',editUsuario);
     formDataeditadmin.append('editPassword',editPassword);
     
      $.ajax({ url: 'controladores/administrador.controlador.php', 
               type: 'post', 
               data: formDataeditadmin, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='administradores'; }, 2000); swal('EXELENTE','','success'); 
                     
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
function CargarinfoAdminEnModalElim(datosAdmin) 
  {
    
    f=datosAdmin.split('||');
    $('#idadminelim').val(f[0]);       
          // $('#textidalim').text(f[0]);
  }

/*===================FUNCION QUE LLAMA AL ELIMINAR EMPLEADO===========================================*/
$(document).ready(function() { 
   $("#btnelimadmin").on('click', function() {
  
   var formDataelim = new FormData(); 
   
   var btnelimadmin=$('#btnelimadmin').val();
   var idadminelim=$('#idadminelim').val();
  
   
  
   if ( (idadminelim=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataelim.append('idadminelim',idadminelim);
     formDataelim.append('btnelimadmin',btnelimadmin);
  
     
     
      $.ajax({ url: 'controladores/administrador.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='administradores'; }, 2000); swal('EXELENTE','','success'); 
                     
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

