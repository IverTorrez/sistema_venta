<?php
include_once("modelos/marca.modelo.php");
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
        Administrar Marcas
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Administrar Marcas</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

         <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarMarca">
            Agregar Marca
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
                $objmar=new Marca();
                $resultado=$objmar->listarMarcasActivos();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datosMarca=$fila->id_marca."||".
                                     $fila->nombre_marca."||".
                                     $fila->estado_marca;
                  
              ?>
               <tr>
                 <td><?php echo $contador; ?></td>
                 <td><?php echo $fila->nombre_marca; ?></td>
                 

                 
                 <td><button class="btn btn-success btn-xs">Activo</button> </td>
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditMarca" onclick="CargarinfoMarcaEnModal('<?php echo $datosMarca ?>')"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimMarca" onclick="CargarinfoMarcaEnModalElim('<?php echo $datosMarca ?>')"><i class="fa fa-times"></i></button>
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

      
      <div class="modal-header" style="background: #3c8dbc; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar Marca</h4>
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

        <button type="submit" class="btn btn-primary" name="btnguardarMarca" id="btnguardarMarca">Guardar</button>
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
        <h4 class="modal-title">Actualizar Marca</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="hidden" name="idMarcaedit" id="idMarcaedit" placeholder="id categoria">
                 <input type="text" class="form-control input-lg" name="editNombre" id="editNombre" placeholder="Ingresar nombre" required="" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btneditMarca" id="btneditMarca">Actualizar</button>
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
        <h4 class="modal-title">Eliminar Marca</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  
                  <input type="hidden" name="idMarcaelim" id="idMarcaelim" placeholder="id marca">
                 
              </div>  
            </div>

           
            <div class="form-group">
              <div class="input-group">
                  <label>Desea eliminar esta Marca ?</label>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnelimMarca" id="btnelimMarca">Eliminar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 


<script type="text/javascript">
  /*FUNCION QUE GUARDA LA CATEGORIA*/
   $(document).ready(function() { 
   $("#btnguardarMarca").on('click', function() {
  
   var formDataMarca = new FormData(); 
   
   var nuevoNombre=$('#nuevoNombre').val();
   var btnguardarMarca=$('#btnguardarMarca').val();
   
   
  
   if ( (nuevoNombre=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataMarca.append('nuevoNombre',nuevoNombre);
     formDataMarca.append('btnguardarMarca',btnguardarMarca);
     
     
      $.ajax({ url: 'controladores/marca.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='marcas'; }, 2000); swal('EXELENTE','','success'); 
                     
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
function CargarinfoMarcaEnModal(datosMarca) 
  {    
    f=datosMarca.split('||');
    $('#idMarcaedit').val(f[0]);
     $('#editNombre').val(f[1]);       
          // $('#textidalim').text(f[0]);
  }


/*FUNCION QUE ACTUALIZA LA CATEGORIA*/
   $(document).ready(function() { 
   $("#btneditMarca").on('click', function() {
  
   var formDataEditMarca = new FormData(); 
   var idMarcaedit=$('#idMarcaedit').val();
   var editNombre=$('#editNombre').val();
   var btneditMarca=$('#btneditMarca').val();
   
   
  
   if ( (editNombre=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataEditMarca.append('idMarcaedit',idMarcaedit);
     formDataEditMarca.append('editNombre',editNombre);
     formDataEditMarca.append('btneditMarca',btneditMarca);
     
     
      $.ajax({ url: 'controladores/marca.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='marcas'; }, 2000); swal('EXELENTE','','success'); 
                     
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
function CargarinfoMarcaEnModalElim(datosMarca) 
  {    
    f=datosMarca.split('||');
    $('#idMarcaelim').val(f[0]);
    // $('#editNombre').val(f[1]);       
          // $('#textidalim').text(f[0]);
  }


/*FUNCION QUE ELIMINA LA CATEGORIA*/
   $(document).ready(function() { 
   $("#btnelimMarca").on('click', function() {
  
   var formDataElimMarca = new FormData(); 
   var idMarcaelim=$('#idMarcaelim').val();
   var btnelimMarca=$('#btnelimMarca').val();
   
   
  
   if ( (idMarcaelim=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataElimMarca.append('idMarcaelim',idMarcaelim);
     formDataElimMarca.append('btnelimMarca',btnelimMarca);
     
     
      $.ajax({ url: 'controladores/marca.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='marcas'; }, 2000); swal('EXELENTE','','success'); 
                     
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
