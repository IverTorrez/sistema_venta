<?php
include_once("modelos/proveedor.modelo.php");
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
        Administrar Proveedor
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Administrar Proveedor</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProveedor">
            Agregar Proveedor
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
                  <th>Observacion</th>
                  <th>Estado</th>
                  <th>Acciones</th>

                </tr>
             </thead>

             <tbody>
               <?php
               $contador=1;
                $obj=new Proveedor();
                $resultado=$obj->listarProveedoresActivos();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datosProv=$fila->id_proveedor."||".
                                     $fila->nombre_proveedor."||".
                                     $fila->apellido_proveedor."||".
                                     $fila->telefono_proveedor."||".
                                     $fila->observacion;
                                
                                     
                  
              ?>
               <tr>
                 <td><?php echo $contador; ?></td>
                 <td><?php echo $fila->nombre_proveedor; ?></td>
                 <td><?php echo $fila->apellido_proveedor; ?></td>
                 <td><?php echo $fila->telefono_proveedor; ?></td>
                 <td><?php echo $fila->observacion; ?></td>
                 
                 <td><button class="btn btn-success btn-xs">Activo</button> </td>
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditProv" onclick="CargarinfoProvEnModal('<?php echo $datosProv ?>')"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimProv" onclick="CargarinfoProveedorEnModalElim('<?php echo $datosProv ?>')"><i class="fa fa-times"></i></button>
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
<div id="modalAgregarProveedor" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #3c8dbc; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar Proveedor</h4>
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
               <label>Apellidos</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoApellido" id="nuevoApellido" placeholder="Ingresar apellido" required="" autocomplete="off" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>


            <div class="form-group">
               <label>Telefono</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoTelefono" id="nuevoTelefono" placeholder="Ingresar telefono" required="" autocomplete="off" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>

            <div class="form-group">
               <label>Observacion</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-info"></i></span>
                
                 <textarea name="textobservacion" id="textobservacion" class="form-control input-lx" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
              </div>  
            </div>



         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnguardarProv" id="btnguardarProv">Guardar</button>
      </div>
     
    </div>

  </div>
</div>




 <!-- MODAL ACEPTAR CAPACITACION -->
  <!-- Modal -->
<div id="modalEditProv" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #f39c12; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Actualizar Proveedor</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
               <label>Nombre</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="hidden" name="idProvedit" id="idProvedit" placeholder="id proveedor">
                 <input type="text" class="form-control input-lx" name="editNombre" id="editNombre" placeholder="Ingresar nombre" required="" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>

            <div class="form-group">
               <label>Apellidos</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="editApellido" id="editApellido" placeholder="Ingresar apellido" required="" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>


            <div class="form-group">
               <label>Telefono</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                 <input type="text" class="form-control input-lx" name="editTelefono" id="editTelefono" placeholder="Ingresar telefono" required="" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>

            <div class="form-group">
               <label>Observacion</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-info"></i></span>
                
                 <textarea name="editobservacion" id="editobservacion" class="form-control input-lx" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
              </div>  
            </div>

      


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btneditProv" id="btneditProv">Actualizar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 




 <!-- Modal Eliminar empleado-->
<div id="modalElimProv" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #dd4b39; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eliminar proveedor</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  
                  <input type="hidden" name="idProvelim" id="idProvelim" placeholder="id proveedor">
                 
              </div>  
            </div>

           
            <div class="form-group">
              <div class="input-group">
                  <label>Desea eliminar este proveedor ?</label>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btneliprov" id="btneliprov">Eliminar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 



<script type="text/javascript">
  $(document).ready(function() { 
   $("#btnguardarProv").on('click', function() {
  
   var formDataprov = new FormData(); 
   
   var nuevoNombre=$('#nuevoNombre').val();
   var nuevoApellido=$('#nuevoApellido').val();
   var nuevoTelefono=$('#nuevoTelefono').val();
   var btnguardarProv=$('#btnguardarProv').val();
   var textobservacion=document.getElementById("textobservacion").value;
  
   
  
   if ( (nuevoNombre=='') ||  (nuevoApellido=='')||  (nuevoTelefono=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataprov.append('nuevoNombre',nuevoNombre);
     formDataprov.append('nuevoApellido',nuevoApellido);
     formDataprov.append('nuevoTelefono',nuevoTelefono);
     formDataprov.append('btnguardarProv',btnguardarProv);
     formDataprov.append('textobservacion',textobservacion);
    
      $.ajax({ url: 'controladores/proveedor.controlador.php', 
               type: 'post', 
               data: formDataprov, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='proveedores'; }, 2000); swal('EXELENTE','','success'); 
                     
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
function CargarinfoProvEnModal(datosProv) 
  {
    
    f=datosProv.split('||');
    $('#idProvedit').val(f[0]);
     $('#editNombre').val(f[1]);
      $('#editApellido').val(f[2]);
      $('#editTelefono').val(f[3]);
      $('#editobservacion').val(f[4]);
      
           
          // $('#textidalim').text(f[0]);
  }
/*===================FUNCION QUE LLAMA AL EDITAR EMPLEADO===========================================*/
$(document).ready(function() { 
   $("#btneditProv").on('click', function() {
  
   var formDataeditProv = new FormData(); 
   
   var btneditProv=$('#btneditProv').val();
   var idProvedit=$('#idProvedit').val();
   var editNombre=$('#editNombre').val();
   var editApellido=$('#editApellido').val();
   var editTelefono=$('#editTelefono').val();
   var editobservacion=document.getElementById("editobservacion").value;
  
   
  
   if ( (editNombre=='') ||  (editApellido=='')||  (editTelefono=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataeditProv.append('idProvedit',idProvedit);
     formDataeditProv.append('btneditProv',btneditProv);
     formDataeditProv.append('editNombre',editNombre);
     formDataeditProv.append('editApellido',editApellido);
     formDataeditProv.append('editTelefono',editTelefono);
     formDataeditProv.append('editobservacion',editobservacion);
     
      $.ajax({ url: 'controladores/proveedor.controlador.php', 
               type: 'post', 
               data: formDataeditProv, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='proveedores'; }, 2000); swal('EXELENTE','','success'); 
                     
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
function CargarinfoProveedorEnModalElim(datosProv) 
  {
    
    f=datosProv.split('||');
    $('#idProvelim').val(f[0]);       
          // $('#textidalim').text(f[0]);
  }

/*===================FUNCION QUE LLAMA AL ELIMINAR EMPLEADO===========================================*/
$(document).ready(function() { 
   $("#btneliprov").on('click', function() {
  
   var formDataelim = new FormData(); 
   
   var btneliprov=$('#btneliprov').val();
   var idProvelim=$('#idProvelim').val();
  
   
  
   if ( (idProvelim=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataelim.append('idProvelim',idProvelim);
     formDataelim.append('btneliprov',btneliprov);
  
     
     
      $.ajax({ url: 'controladores/proveedor.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='proveedores'; }, 2000); swal('EXELENTE','','success'); 
                     
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

