<?php
include_once("modelos/almacen.modelo.php");
if ($_SESSION["tipo_user"]!="admin")
{
  echo '<script>
        window.location="inicio";
      </script>';
}

if ($_SESSION["usuarioAdmin"]!="") 
{
   $datosUsuario=$_SESSION["usuarioAdmin"];
  $id_usuario=$datosUsuario["id_administrador"];
}
if ($_SESSION["usuarioEmp"]!="") 
{
  $datosUsuario=$_SESSION["usuarioEmp"];
  $id_usuario=$datosUsuario["id_empleado"];
}
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Almacen
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Administrar Almacen</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

         <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarMarca">
            Agregar Almacen
          </button>
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped tablas">
             <thead>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Nombre</th>
                  <th>Estado</th>
                  <th>Acciones</th>
                  

                </tr>
             </thead>

             <tbody>
               <?php
                $contador=1;
                $objmar=new Almacen();
                $resultado=$objmar->listarAlmacenActivos();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datosalmacen=$fila->id_almacen."||".
                                     $fila->nombre_almacen."||".
                                     $fila->estado;
                  
              ?>
               <tr>
                 <td><?php echo $contador; ?></td>
                 <td><?php echo $fila->nombre_almacen; ?></td>
                 

                 
                 <td><button class="btn btn-success btn-xs">Activo</button> </td>
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditMarca" onclick="CargarinfoMarcaEnModal('<?php echo $datosalmacen ?>')"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimMarca" onclick="CargarinfoMarcaEnModalElim('<?php echo $datosalmacen ?>')"><i class="fa fa-times"></i></button>
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

   <!--MODAL PARA AGREGAR CATEGORIA -->
   <!-- Modal -->
<div id="modalAgregarMarca" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
 
      <input type="hidden" name="idusuario" id="idusuario" placeholder="id usuario" value="<?php echo $id_usuario; ?>">
      <div class="modal-header" style="background: #3c8dbc; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar Almacen</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lg" name="nuevoNombre" id="nuevoNombre" placeholder="Ingresar nombre" required="" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>



         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnguardaralmacen" id="btnguardaralmacen">Guardar</button>
      </div>
     
    </div>

  </div>
</div>


 <!-- Modal para editar categoria-->
<div id="modalEditMarca" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #f39c12; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Actualizar Almacen</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">
             
            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="hidden" name="idalmacenedit" id="idalmacenedit" placeholder="id almacen">
                 <input type="text" class="form-control input-lg" name="editNombre" id="editNombre" placeholder="Ingresar nombre" required="" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btneditAlmacen" id="btneditAlmacen">Actualizar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal -->


<!-- Modal Eliminar marca-->
<div id="modalElimMarca" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #dd4b39; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eliminar Almacen</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  <input type="hidden" name="usuarioelim" id="usuarioelim" placeholder="usuario elimina" value="<?php echo $id_usuario;  ?>">
                  <input type="hidden" name="idalmacenelim" id="idalmacenelim" placeholder="id marca">
                 
              </div>  
            </div>

           
            <div class="form-group">
              <div class="input-group">
                  <label>Desea eliminar este Almacen ?</label>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnelimalmacen" id="btnelimalmacen">Eliminar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 


<script type="text/javascript">
  /*FUNCION QUE GUARDA LA CATEGORIA*/
   $(document).ready(function() { 
   $("#btnguardaralmacen").on('click', function() {
  
   var formDataMarca = new FormData(); 
   
   var nuevoNombre=$('#nuevoNombre').val();
   var btnguardaralmacen=$('#btnguardaralmacen').val();
   var idusuario=$('#idusuario').val();
   
   
  
   if ( (nuevoNombre=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataMarca.append('nuevoNombre',nuevoNombre);
     formDataMarca.append('btnguardaralmacen',btnguardaralmacen);
     formDataMarca.append('idusuario',idusuario);
     
      $.ajax({ url: 'controladores/almacen.controlador.php', 
               type: 'post', 
               data: formDataMarca, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='almacen'; }, 2000); swal('EXELENTE','','success'); 
                     
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
function CargarinfoMarcaEnModal(datosalmacen) 
  {    
    f=datosalmacen.split('||');
    $('#idalmacenedit').val(f[0]);
     $('#editNombre').val(f[1]);       
          // $('#textidalim').text(f[0]);
  }


/*FUNCION QUE ACTUALIZA LA CATEGORIA*/
   $(document).ready(function() { 
   $("#btneditAlmacen").on('click', function() {
  
   var formDataEditMarca = new FormData(); 
   var idalmacenedit=$('#idalmacenedit').val();
   var editNombre=$('#editNombre').val();
   var btneditAlmacen=$('#btneditAlmacen').val();
   
   
  
   if ( (editNombre=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataEditMarca.append('idalmacenedit',idalmacenedit);
     formDataEditMarca.append('editNombre',editNombre);
     formDataEditMarca.append('btneditAlmacen',btneditAlmacen);
     
     
      $.ajax({ url: 'controladores/almacen.controlador.php', 
               type: 'post', 
               data: formDataEditMarca, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='almacen'; }, 2000); swal('EXELENTE','','success'); 
                     
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
function CargarinfoMarcaEnModalElim(datosalmacen) 
  {    
    f=datosalmacen.split('||');
    $('#idalmacenelim').val(f[0]);
    // $('#editNombre').val(f[1]);       
          // $('#textidalim').text(f[0]);
  }


/*FUNCION QUE ELIMINA almacen*/
   $(document).ready(function() { 
   $("#btnelimalmacen").on('click', function() {
  
   var formDataElimMarca = new FormData(); 
   var idalmacenelim=$('#idalmacenelim').val();
   var btnelimalmacen=$('#btnelimalmacen').val();
   var usuarioelim=$('#usuarioelim').val();
   
   
  
   if ( (idalmacenelim=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataElimMarca.append('idalmacenelim',idalmacenelim);
     formDataElimMarca.append('btnelimalmacen',btnelimalmacen);
     formDataElimMarca.append('usuarioelim',usuarioelim);
     
      $.ajax({ url: 'controladores/almacen.controlador.php', 
               type: 'post', 
               data: formDataElimMarca, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='almacen'; }, 2000); swal('EXELENTE','','success'); 
                     
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
