<?php
include_once("modelos/categorias.modelo.php");
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
        Administrar Categorias
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Administrar Categorias</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

         <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria">
            Agregar Categoria
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
                $objcat=new Categoria();
                $resultado=$objcat->listarCategoriasActivos();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datosCat=$fila->id_categoria."||".
                                     $fila->nombre_categoria."||".
                                     $fila->estado_cat;
                  
              ?>
               <tr>
                 <td><?php echo $contador; ?></td>
                 <td><?php echo $fila->nombre_categoria; ?></td>
                 

                 
                 <td><button class="btn btn-success btn-xs">Activo</button> </td>
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditCat" onclick="CargarinfoCatEnModal('<?php echo $datosCat ?>')"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimCat" onclick="CargarinfoCatEnModalElim('<?php echo $datosCat ?>')"><i class="fa fa-times"></i></button>
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
<div id="modalAgregarCategoria" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #3c8dbc; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar categoria</h4>
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

        <button type="submit" class="btn btn-primary" name="btnguardarCat" id="btnguardarCat">Guardar</button>
      </div>
     
    </div>

  </div>
</div>


 <!-- Modal para editar categoria-->
<div id="modalEditCat" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #f39c12; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Actualizar categoria</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="hidden" name="idcatedit" id="idcatedit" placeholder="id categoria">
                 <input type="text" class="form-control input-lg" name="editNombre" id="editNombre" placeholder="Ingresar nombre" required="" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btneditCat" id="btneditCat">Actualizar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal -->


<!-- Modal Eliminar categoria-->
<div id="modalElimCat" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #dd4b39; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eliminar categoria</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  
                  <input type="hidden" name="idCatelim" id="idCatelim" placeholder="id categoria">
                 
              </div>  
            </div>

           
            <div class="form-group">
              <div class="input-group">
                  <label>Desea eliminar esta categoria ?</label>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnelimCat" id="btnelimCat">Eliminar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 


<script type="text/javascript">
  /*FUNCION QUE GUARDA LA CATEGORIA*/
   $(document).ready(function() { 
   $("#btnguardarCat").on('click', function() {
  
   var formDatacat = new FormData(); 
   
   var nuevoNombre=$('#nuevoNombre').val();
   var btnguardarCat=$('#btnguardarCat').val();
   
   
  
   if ( (nuevoNombre=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDatacat.append('nuevoNombre',nuevoNombre);
     formDatacat.append('btnguardarCat',btnguardarCat);
     
     
      $.ajax({ url: 'controladores/categorias.controlador.php', 
               type: 'post', 
               data: formDatacat, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='categorias'; }, 2000); swal('EXELENTE','','success'); 
                     
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
function CargarinfoCatEnModal(datosCat) 
  {    
    f=datosCat.split('||');
    $('#idcatedit').val(f[0]);
     $('#editNombre').val(f[1]);       
          // $('#textidalim').text(f[0]);
  }


/*FUNCION QUE ACTUALIZA LA CATEGORIA*/
   $(document).ready(function() { 
   $("#btneditCat").on('click', function() {
  
   var formDataEditcat = new FormData(); 
   var idcatedit=$('#idcatedit').val();
   var editNombre=$('#editNombre').val();
   var btneditCat=$('#btneditCat').val();
   
   
  
   if ( (editNombre=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataEditcat.append('idcatedit',idcatedit);
     formDataEditcat.append('editNombre',editNombre);
     formDataEditcat.append('btneditCat',btneditCat);
     
     
      $.ajax({ url: 'controladores/categorias.controlador.php', 
               type: 'post', 
               data: formDataEditcat, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='categorias'; }, 2000); swal('EXELENTE','','success'); 
                     
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
function CargarinfoCatEnModalElim(datosCat) 
  {    
    f=datosCat.split('||');
    $('#idCatelim').val(f[0]);
    // $('#editNombre').val(f[1]);       
          // $('#textidalim').text(f[0]);
  }


/*FUNCION QUE ELIMINA LA CATEGORIA*/
   $(document).ready(function() { 
   $("#btnelimCat").on('click', function() {
  
   var formDataElimCat = new FormData(); 
   var idCatelim=$('#idCatelim').val();
   var btnelimCat=$('#btnelimCat').val();
   
   
  
   if ( (idCatelim=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataElimCat.append('idCatelim',idCatelim);
     formDataElimCat.append('btnelimCat',btnelimCat);
     
     
      $.ajax({ url: 'controladores/categorias.controlador.php', 
               type: 'post', 
               data: formDataElimCat, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='categorias'; }, 2000); swal('EXELENTE','','success'); 
                     
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
