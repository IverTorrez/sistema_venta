<?php
include_once("modelos/clientes.modelo.php");
/*if ($_SESSION["tipo_user"]!="admin")
{
  echo '<script>
        window.location="inicio";
      </script>';
}*/
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Clientes
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Administrar Clientes</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
            Agregar cliente
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
                   <?php
                 if ($_SESSION["tipo_user"]=="admin")
                 {
                 ?>
                  <th>Acciones</th>
                  <?php
                 }
                 ?>
                </tr>
             </thead>

             <tbody>
               <?php
               $contador=1;
                $obj=new Cliente();
                $resultado=$obj->listarClientesActivos();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datosCli=$fila->id_cliente."||".
                                     $fila->nombre_cliente."||".
                                     $fila->apellido_cliente."||".
                                     $fila->telefono_cliente."||".
                                     $fila->observacion;
                                    
                                     
                  
              ?>
               <tr>
                 <td><?php echo $contador; ?></td>
                 <td><?php echo $fila->nombre_cliente; ?></td>
                 <td><?php echo $fila->apellido_cliente; ?></td>
                 <td><?php echo $fila->telefono_cliente; ?></td>
                  <td><?php echo $fila->observacion; ?></td>
               

                 
                 <td><button class="btn btn-success btn-xs">Activo</button> </td>
                 <?php
                 if ($_SESSION["tipo_user"]=="admin")
                 {
                 ?>
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditCli" onclick="CargarinfoCliEnModal('<?php echo $datosCli ?>')"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimCli" onclick="CargarinfoCliEnModalElim('<?php echo $datosCli ?>')"><i class="fa fa-times"></i></button>
                   </div>
                 </td>
                 <?php
                 }
                 ?>
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
        <h4 class="modal-title">Agregar cliente</h4>
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
                
                 <textarea name="observacion" id="observacion" class="form-control input-lx" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
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
        <h4 class="modal-title">Actualizar cliente</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <label>Nombre</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="hidden" name="idcliedit" id="idcliedit" placeholder="id cliente">
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
        <h4 class="modal-title">Eliminar cliente</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  
                  <input type="hidden" name="idclielim" id="idclielim" placeholder="id cliente">
                 
              </div>  
            </div>

           
            <div class="form-group">
              <div class="input-group">
                  <label>Desea eliminar este cliente ?</label>
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
   var nuevoApellido=$('#nuevoApellido').val();
   var nuevoTelefono=$('#nuevoTelefono').val();
   var observacion=document.getElementById("observacion").value;
   
   
  
   if ( (nuevoNombre=='') ||  (nuevoApellido=='')||  (nuevoTelefono=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDatacli.append('btnguardarcli',btnguardarcli);
     formDatacli.append('nuevoNombre',nuevoNombre);
     formDatacli.append('nuevoApellido',nuevoApellido);
     formDatacli.append('nuevoTelefono',nuevoTelefono);
     formDatacli.append('observacion',observacion);
     
      $.ajax({ url: 'controladores/clientes.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='clientes'; }, 1000); swal('EXELENTE','','success'); 
                     
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
    $('#idcliedit').val(f[0]);
     $('#editNombre').val(f[1]);
      $('#editApellido').val(f[2]);
      $('#editTelefono').val(f[3]);
      $('#editobservacion').val(f[4]);
     
          // $('#textidalim').text(f[0]);
  }


/*===================FUNCION QUE LLAMA AL EDITAR EMPLEADO===========================================*/
$(document).ready(function() { 
   $("#btneditcli").on('click', function() {
  
   var formDataeditCli = new FormData(); 
   
   var btneditcli=$('#btneditcli').val();
   var idcliedit=$('#idcliedit').val();
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
     formDataeditCli.append('idcliedit',idcliedit);
     formDataeditCli.append('btneditcli',btneditcli);
     formDataeditCli.append('editNombre',editNombre);
     formDataeditCli.append('editApellido',editApellido);
     formDataeditCli.append('editTelefono',editTelefono);
     formDataeditCli.append('editobservacion',editobservacion);
     
      $.ajax({ url: 'controladores/clientes.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='clientes'; }, 1000); swal('EXELENTE','','success'); 
                     
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
    $('#idclielim').val(f[0]);       
          // $('#textidalim').text(f[0]);
  }


/*===================FUNCION QUE LLAMA AL ELIMINAR EMPLEADO===========================================*/
$(document).ready(function() { 
   $("#btnelimcli").on('click', function() {
  
   var formDataelim = new FormData(); 
   
   var btnelimcli=$('#btnelimcli').val();
   var idclielim=$('#idclielim').val();
  
   
  
   if ( (idclielim=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataelim.append('idclielim',idclielim);
     formDataelim.append('btnelimcli',btnelimcli);
  
     
     
      $.ajax({ url: 'controladores/clientes.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='clientes'; }, 1000); swal('EXELENTE','','success'); 
                     
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