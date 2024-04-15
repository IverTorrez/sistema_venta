<?php
include_once("modelos/empleado.modelo.php");
include_once("modelos/administrador.modelo.php");
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
        Administrar Usuarios
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Administrar usuarios</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">
            Agregar usuario
          </button>
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped tablas">
             <thead>
                <tr>
                  
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Telefono</th>
                  <th>Usuario</th>
                  <th>Contraseña</th>
                  <th>Observacion</th>
                  <th>Tipo Usuario</th>
                  <th>Permiso especial</th>
                  <th>Acciones</th>

                </tr>
             </thead>

             <tbody>
               <?php
               $contador=1;
                $objemp=new Empleado();
                $resultado=$objemp->listarEmpleadosActivos();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datosEmpleado=$fila->id_empleado."||".
                                     $fila->nombre_empleado."||".
                                     $fila->apellido_empleado."||".
                                     $fila->telefono_empleado."||".
                                     $fila->user_name_emp."||".
                                     $fila->password_emp."||".
                                     "vendedor"."||".
                                     $fila->observacion_emp."||".
                                     $fila->permiso_especial;         
              ?>
               <tr>
                
                 <td><?php echo $fila->nombre_empleado; ?></td>
                 <td><?php echo $fila->apellido_empleado; ?></td>
                 <td><?php echo $fila->telefono_empleado; ?></td>
                 <td><?php echo $fila->user_name_emp; ?></td>
                 <td><?php echo $fila->password_emp; ?></td>
                 <td><?php echo $fila->observacion_emp; ?></td>
                          
                 <td><button class="btn btn-success btn-xs">Vendedor</button> </td>
                 <td><?php switch ($fila->permiso_especial) {
                   case 1:
                    echo "Si";
                     break;
                   case 0:
                    echo "No";
                     break;
                 }
               ?></td>

                 <td>
                   <div class="btn-group">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditEmp" onclick="CargarinfoEmpleadoEnModal('<?php echo $datosEmpleado ?>')"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimEmp" onclick="CargarinfoEmpleadoEnModalElim('<?php echo $datosEmpleado ?>')"><i class="fa fa-times"></i></button>
                   </div>
                 </td>
               </tr>
               <?php
                 $contador++;
                 }
               ?>


<!-- ====================LISTADO DE ADMINISTRADORES=========================-->

               <?php

               $contador=1;
                $objadmin=new Administrador();
                $resultadoadmin=$objadmin->listarAdminActivos();
                while ($filadmin=mysqli_fetch_object($resultadoadmin)) 
                {
                  $datosadmin=$filadmin->id_administrador."||".
                                     $filadmin->nombre_administrador."||".
                                     $filadmin->apellido_administrador."||".
                                     $filadmin->telefono_administrador."||".
                                     $filadmin->user_admin."||".
                                     $filadmin->password_admin."||".
                                     "admin"."||".
                                      $filadmin->observacion_admin;         
              ?>
               <tr>
                
                 <td><?php echo $filadmin->nombre_administrador; ?></td>
                 <td><?php echo $filadmin->apellido_administrador; ?></td>
                 <td><?php echo $filadmin->telefono_administrador; ?></td>
                 <td><?php echo $filadmin->user_admin; ?></td>
                 <td><?php echo $filadmin->password_admin; ?></td>
                 <td><?php echo $filadmin->observacion_admin; ?></td>
                          
                 <td><button class="btn btn-success btn-xs">Administrador</button> </td>
                 <td></td>
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditEmp" onclick="CargarinfoEmpleadoEnModal('<?php echo $datosadmin ?>')"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimEmp" onclick="CargarinfoEmpleadoEnModalElim('<?php echo $datosadmin ?>')"><i class="fa fa-times"></i></button>
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
<div id="modalAgregarUsuario" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #3c8dbc; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar usuario</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <label>Nombre</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoNombre" id="nuevoNombre" placeholder="Ingresar nombre" required="" autocomplete="off" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>

            <div class="form-group">
              <label>Apellido</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoApellido" id="nuevoApellido" placeholder="Ingresar apellido" required="" autocomplete="off" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>


            <div class="form-group">
              <label>Telefono</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoTelefono" id="nuevoTelefono" placeholder="Ingresar telefono" required="" autocomplete="off">
              </div>  
            </div>

            <div class="form-group">
              <label>Usuario</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoUsuario" id="nuevoUsuario" placeholder="Ingresar usuario" required="" autocomplete="off" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>

            <div class="form-group">
              <label>Clave</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoPassword" id="nuevoPassword" placeholder="Ingresar contraseña" required="" autocomplete="off">
              </div>  
            </div>


            <div class="form-group">
              <label>Tipo de usuario</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                  <select name="selecttipousu" id="selecttipousu" class="form-control input-lx" onchange="mostrarOcultatSelectPermiso();">
                    <option value="vendedor">Vendedor</option>
                    <option value="admin">Administrador</option>
                  </select>
              </div>  
            </div>

            <div class="form-group"  id="divpermisos" >
              <label>Permiso Especial (El empleado podra registrar compras)</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                  <select name="selecpermiso" id="selecpermiso" class="form-control input-lx">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
              </div>  
            </div>

             <div class="form-group">
               <label>Observacion</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-info"></i></span>
                
                 <textarea name="observacion" id="observacion" class="form-control input-lx" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnguardaremp" id="btnguardaremp">Guardar</button>
      </div>
     
    </div>

  </div>
</div>




 <!-- MODAL EDITAR ACEPTAR-->
  <!-- Modal -->
<div id="modalEditEmp" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #f39c12; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Actualizar usuario</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <label>Nombre</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="hidden" name="idempedit" id="idempedit" placeholder="id empleado">
                 <input type="text" class="form-control input-lx" name="editNombre" id="editNombre" placeholder="Ingresar nombre" required="">
              </div>  
            </div>

            <div class="form-group">
              <label>Apellidos</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="editApellido" id="editApellido" placeholder="Ingresar apellido" required="">
              </div>  
            </div>


            <div class="form-group">
              <label>Telefono</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                 <input type="text" class="form-control input-lx" name="editTelefono" id="editTelefono" placeholder="Ingresar telefono" required="">
              </div>  
            </div>

            <div class="form-group">
              <label>Usuario</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>
                 <input type="text" class="form-control input-lx" name="editUsuario" id="editUsuario" placeholder="Ingresar usuario" required="">
              </div>  
            </div>

            <div class="form-group">
              <label>Clave</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                 <input type="text" class="form-control input-lx" name="editPassword" id="editPassword" placeholder="Ingresar contraseña" required="">

                 <input type="hidden" class="form-control input-lx" name="tipouser" id="tipouser" placeholder="Ingresar tipo usuario" required="">
              </div>  
            </div>

             <div class="form-group"  id="divpermisosedit" >
              <label>Permiso Especial (El empleado podra registrar compras)</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                  <select name="selecpermisoedit" id="selecpermisoedit" class="form-control input-lx">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
              </div>  
            </div>

            <div class="form-group">
               <label>Observacion</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-info"></i></span>
                
                 <textarea name="editobservacion" id="editobservacion" class="form-control input-lx"></textarea>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btneditemp" id="btneditemp">Actualizar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 




 <!-- Modal Eliminar empleado-->
<div id="modalElimEmp" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #dd4b39; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eliminar usuario</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  
                  <input type="hidden" name="idempelim" id="idempelim" placeholder="id empleado">
                  <input type="hidden" name="tipouserelim" id="tipouserelim" placeholder="tipo user">
                 
              </div>  
            </div>

           
            <div class="form-group">
              <div class="input-group">
                  <label>Desea eliminar este usuario ?</label>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnelimemp" id="btnelimemp">Eliminar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 



<script type="text/javascript">
  $(document).ready(function() { 
   $("#btnguardaremp").on('click', function() {
  
   var formDataempleado = new FormData(); 
   
   var nuevoNombre=$('#nuevoNombre').val();
   var nuevoApellido=$('#nuevoApellido').val();
   var nuevoTelefono=$('#nuevoTelefono').val();
   var nuevoUsuario=$('#nuevoUsuario').val();
   var nuevoPassword=$('#nuevoPassword').val();
   var btnguardaremp=$('#btnguardaremp').val();
   var selecttipousu=$('#selecttipousu').val();
   var selecpermiso=$('#selecpermiso').val();
   var observacion=document.getElementById("observacion").value;
   
  
   if ( (nuevoNombre=='') ||  (nuevoApellido=='')||  (nuevoTelefono=='')||  (nuevoUsuario=='')||  (nuevoPassword=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataempleado.append('nuevoNombre',nuevoNombre);
     formDataempleado.append('nuevoApellido',nuevoApellido);
     formDataempleado.append('nuevoTelefono',nuevoTelefono);
     formDataempleado.append('nuevoUsuario',nuevoUsuario);
     formDataempleado.append('nuevoPassword',nuevoPassword);
     formDataempleado.append('btnguardaremp',btnguardaremp);
     formDataempleado.append('selecttipousu',selecttipousu);
     formDataempleado.append('selecpermiso',selecpermiso);
     formDataempleado.append('observacion',observacion);
     
      $.ajax({ url: 'controladores/empleadoControler.php', 
               type: 'post', 
               data: formDataempleado, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='usuarios'; }, 2000); swal('EXELENTE','','success'); 
                     
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
function CargarinfoEmpleadoEnModal(datosEmpleado) 
  {
    
    f=datosEmpleado.split('||');
    $('#idempedit').val(f[0]);
     $('#editNombre').val(f[1]);
      $('#editApellido').val(f[2]);
      $('#editTelefono').val(f[3]);
      $('#editUsuario').val(f[4]);
      $('#editPassword').val(f[5]); 
      $('#tipouser').val(f[6]); 
      $('#editobservacion').val(f[7]);
      $('#selecpermisoedit').val(f[8]);  
           
          // $('#textidalim').text(f[0]);
      var tipousuer=(f[6]); 
     //alert(tipousuer);
    if (tipousuer=='vendedor')//si el usuario es tipo vendedor se mostrara la opcion de permisos
    {
      $("#divpermisosedit").show(500);
    }
    else
    {
      if (tipousuer=='admin') 
      {
        $("#divpermisosedit").hide(500);//si es admin, se ocultara
      }
    }
  }
/*===================FUNCION QUE LLAMA AL EDITAR EMPLEADO===========================================*/
$(document).ready(function() { 
   $("#btneditemp").on('click', function() {
  
   var formDataeditempleado = new FormData(); 
   
   var btneditemp=$('#btneditemp').val();
   var idempedit=$('#idempedit').val();
   var editNombre=$('#editNombre').val();
   var editApellido=$('#editApellido').val();
   var editTelefono=$('#editTelefono').val();
   var editUsuario=$('#editUsuario').val();
   var editPassword=$('#editPassword').val();
   var tipouser=$('#tipouser').val();
   var editobservacion=document.getElementById("editobservacion").value;
   var selecpermisoedit=$('#selecpermisoedit').val();
   
  
   if ( (editNombre=='') ||  (editApellido=='')||  (editTelefono=='')||  (editUsuario=='')||  (editPassword=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataeditempleado.append('idempedit',idempedit);
     formDataeditempleado.append('btneditemp',btneditemp);
     formDataeditempleado.append('editNombre',editNombre);
     formDataeditempleado.append('editApellido',editApellido);
     formDataeditempleado.append('editTelefono',editTelefono);
     formDataeditempleado.append('editUsuario',editUsuario);
     formDataeditempleado.append('editPassword',editPassword);
     formDataeditempleado.append('tipouser',tipouser);
     formDataeditempleado.append('editobservacion',editobservacion);
     formDataeditempleado.append('selecpermisoedit',selecpermisoedit);
     
      $.ajax({ url: 'controladores/empleadoControler.php', 
               type: 'post', 
               data: formDataeditempleado, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='usuarios'; }, 2000); swal('EXELENTE','','success'); 
                     
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
function CargarinfoEmpleadoEnModalElim(datosEmpleado) 
  {
    
    f=datosEmpleado.split('||');
    $('#idempelim').val(f[0]); 
    $('#tipouserelim').val(f[6]);       
          // $('#textidalim').text(f[0]);
  }

/*===================FUNCION QUE LLAMA AL ELIMINAR EMPLEADO===========================================*/
$(document).ready(function() { 
   $("#btnelimemp").on('click', function() {
  
   var formDataelim = new FormData(); 
   
   var btnelimemp=$('#btnelimemp').val();
   var idempelim=$('#idempelim').val();
   var tipouserelim=$('#tipouserelim').val();
  
   
  
   if ( (idempelim=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataelim.append('idempelim',idempelim);
     formDataelim.append('btnelimemp',btnelimemp);
     formDataelim.append('tipouserelim',tipouserelim);
  
     
     
      $.ajax({ url: 'controladores/empleadoControler.php', 
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
                    
                    setTimeout(function(){ location.href='usuarios'; }, 2000); swal('EXELENTE','','success'); 
                     
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

 function mostrarOcultatSelectPermiso()
   {
    
    var selecttipousu=$('#selecttipousu').val();

    if (selecttipousu=='vendedor')//si el usuario es tipo vendedor se mostrara la opcion de permisos
    {
      $("#divpermisos").show(500);
    }
    else
    {
      if (selecttipousu=='admin') 
      {
        $("#divpermisos").hide(500);//si es admin, se ocultara
      }
    }
        
   }
</script>

