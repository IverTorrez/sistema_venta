<?php
include_once("modelos/productos.modelo.php");
include_once("modelos/marca.modelo.php");
include_once("modelos/categorias.modelo.php");
include_once("modelos/almacen.modelo.php");
if ($_SESSION["tipo_user"]=="emp" and $datosUsuario["permiso_especial"]==0)
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
        Administrar Productos
        <small>Panel de control</small>
         <button class="btn btn-danger btn-xs" onclick="window.open('impresiones/tcpdf/pdf/rep_productos_activos.php')">Imprimir todo <i class="fa fa-print"></i></button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Administrar Productos</li>

      </ol>
    </section>


<!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
            Agregar producto
          </button>
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped tablas">
             <thead>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Nombre</th>
                  <th>Codigo</th>
                  <th>Descripcion</th>
                  <th>Marca</th>
                  <th>Categoria</th>
                  <th>Fecha alta</th>
                  <th>Almacen</th>
                  <?php
                  if ($_SESSION["tipo_user"]=="admin")
                  {
                  ?>
                  <th>Usuario</th>
                  
                  <?php 
                  }
                  ?>
                  <th>Acciones</th>
                </tr>
             </thead>

             <tbody>
               <?php
               $contador=1;
                $obj=new Producto();
                $resultado=$obj->listarProductosActivos();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datosProd=$fila->id_producto."||".
                                     $fila->nombre_producto."||".
                                     $fila->codigo_producto."||".
                                     $fila->descripcion."||".
                                    
                                     $fila->idmarca."||".
                                     $fila->idcategoria."||".
                                     $fila->id_almacen;
                                     
                  
              ?>
               <tr>
                 <td><?php echo $contador; ?></td>
                 <td><?php echo $fila->nombre_producto; ?></td>
                 <td><?php echo $fila->codigo_producto; ?></td>
                 <td><?php echo $fila->descripcion; ?></td>
                 <td><?php echo $fila->marca_prod; ?></td>
                 <td><?php echo $fila->cat_prod; ?></td>
                 <td><?php echo $fila->fecha_modificacion; ?></td>
                 <td><?php echo $fila->nombre_almacen; ?></td>
                <!--  <td><button class="btn btn-success btn-xs">Activo</button> </td> -->
                <?php
                  if ($_SESSION["tipo_user"]=="admin")
                  {
                  ?>
                  <td><?php echo $fila->Usuario; ?></td>
                  <?php 
                  }
                  ?>
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditProd" onclick="CargarinfoProdEnModal('<?php echo $datosProd ?>')"><i class="fa fa-pencil"></i></button>
                    <!--el boton eliminar solo se mostrara al administrador-->
                   <?php
                  if ($_SESSION["tipo_user"]=="admin")
                  {
                  ?>
                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimProd" onclick="CargarinfoProdEnModalElim('<?php echo $datosProd ?>')"><i class="fa fa-times"></i></button>
                   <?php 
                  }
                  ?>
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
<div id="modalAgregarProducto" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #3c8dbc; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Agregar producto</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">
            <input type="hidden" name="tipo_user" id="tipo_user" value="<?php echo $_SESSION["tipo_user"]; ?>" placeholder="tipo de usuario">
            <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $id_usuario; ?>" placeholder="id usuario">
            <div class="form-group">
              <label>Nombre del producto</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-gift"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoNombre" id="nuevoNombre" placeholder="Ingresar nombre" required="" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>

            <div class="form-group">
               <label>Código del producto</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-qrcode"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoCodigo" id="nuevoCodigo" placeholder="Ingresar código" required="" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>


            <div class="form-group">
              <label>Descripción del producto</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-sticky-note"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoDescripcion" id="nuevoDescripcion" placeholder="Ingresar descripción" required="" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>

            <div class="form-group">
              <label>Marca del producto</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                 <select class="form-control input-lx" name="selectNuevoMarca" id="selectNuevoMarca">
                   <option value="">Selecione Marca</option>
                   <?php
                     $objM=new Marca();
                     $resulM=$objM->listarMarcasActivos();
                     while ($filM=mysqli_fetch_object($resulM)) 
                     {?>
                       
                      <option value="<?php echo $filM->id_marca; ?>"><?php echo $filM->nombre_marca; ?></option>
                      <?php
                     }
                   ?>
                 </select>
              </div>  
            </div>

            <div class="form-group">
              <label>Categoría del producto</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                 <select class="form-control input-lx" name="selectNuevoCateg" id="selectNuevoCateg">
                   <option value="">Selecione Categoria</option>
                   <?php
                     $objCat=new Categoria();
                     $resulCat=$objCat->listarCategoriasActivos();
                     while ($filCat=mysqli_fetch_object($resulCat)) 
                     {?>
                       
                      <option value="<?php echo $filCat->id_categoria; ?>"><?php echo $filCat->nombre_categoria; ?></option>
                      <?php
                     }
                   ?>
                 </select>
              </div>  
            </div>

            <div class="form-group">
              <label>Almacen</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                 <select class="form-control input-lx" name="selectNuevoalmacen" id="selectNuevoalmacen">
                   <option value="">Selecione almacen</option>
                   <?php
                     $objalm=new Almacen();
                     $resulalm=$objalm->listarAlmacenActivos();
                     while ($filalm=mysqli_fetch_object($resulalm)) 
                     {?>
                       
                      <option value="<?php echo $filalm->id_almacen; ?>"><?php echo $filalm->nombre_almacen; ?></option>
                      <?php
                     }
                   ?>
                 </select>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnguardarprod" id="btnguardarprod">Guardar</button>
      </div>
     
    </div>

  </div>
</div>





 <!-- Modal -->
<div id="modalEditProd" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #f39c12; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Actualizar producto</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

             <input type="hidden" name="tipo_user_edit" id="tipo_user_edit" value="<?php echo $_SESSION["tipo_user"]; ?>" placeholder="tipo de usuario">
             <input type="hidden" name="idUsuario_edit" id="idUsuario_edit" value="<?php echo $id_usuario; ?>" placeholder="id usuario">

            <div class="form-group">
              <label>Nombre del producto</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="hidden" name="idprodedit" id="idprodedit" placeholder="id producto">
                 <input type="text" class="form-control input-lx" name="editNombre" id="editNombre" placeholder="Ingresar nombre" required="" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>

            <div class="form-group">
              <label>Código del producto</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="editCodigo" id="editCodigo" placeholder="Ingresar codigo" required="" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>


            <div class="form-group">
              <label>Descripción del producto</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>
                 <input type="text" class="form-control input-lx" name="editDescripcion" id="editDescripcion" placeholder="Ingresar descripción" required="" style="text-transform:uppercase;"  onkeyup="javascript:this.value=this.value.toUpperCase();">
              </div>  
            </div>

            <div class="form-group">
              <label>Marca del producto</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                 <select class="form-control input-lx" name="selecteditMarca" id="selecteditMarca">
                   <option value="">Selecione Marca</option>
                   <?php
                     $objM=new Marca();
                     $resulM=$objM->listarMarcasActivos();
                     while ($filM=mysqli_fetch_object($resulM)) 
                     {?>
                       
                      <option value="<?php echo $filM->id_marca; ?>"><?php echo $filM->nombre_marca; ?></option>
                      <?php
                     }
                   ?>
                 </select>
              </div>  
            </div>


             <div class="form-group">
              <label>Categoría del producto</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                 <select class="form-control input-lx" name="selecteditCateg" id="selecteditCateg">
                   <option value="">Selecione Categoria</option>
                   <?php
                     $objCat=new Categoria();
                     $resulCat=$objCat->listarCategoriasActivos();
                     while ($filCat=mysqli_fetch_object($resulCat)) 
                     {?>
                       
                      <option value="<?php echo $filCat->id_categoria; ?>"><?php echo $filCat->nombre_categoria; ?></option>
                      <?php
                     }
                   ?>
                 </select>
              </div>  
            </div>

            <div class="form-group">
              <label>Almacen</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-tags"></i></span>
                 <select class="form-control input-lx" name="selecteditalmacen" id="selecteditalmacen">
                   <option value="">Selecione almacen</option>
                   <?php
                     $objalm=new Almacen();
                     $resulalm=$objalm->listarAlmacenActivos();
                     while ($filalm=mysqli_fetch_object($resulalm)) 
                     {?>
                       
                      <option value="<?php echo $filalm->id_almacen; ?>"><?php echo $filalm->nombre_almacen; ?></option>
                      <?php
                     }
                   ?>
                 </select>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btneditprod" id="btneditprod">Actualizar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 




<!-- Modal Eliminar-->
<div id="modalElimProd" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

       <input type="hidden" name="tipo_user_elim" id="tipo_user_elim" value="<?php echo $_SESSION["tipo_user"]; ?>" placeholder="tipo de usuario">
             <input type="hidden" name="idUsuario_elim" id="idUsuario_elim" value="<?php echo $id_usuario; ?>" placeholder="id usuario">

      <div class="modal-header" style="background: #dd4b39; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eliminar producto</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  
                  <input type="hidden" name="idprodelim" id="idprodelim" placeholder="id producto">
                 
              </div>  
            </div>

           
            <div class="form-group">
              <div class="input-group">
                  <label>Desea eliminar este producto ?</label>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnelimprod" id="btnelimprod">Eliminar</button>
      </div>
     
    </div>

  </div>
</div>

<!-- /.modal --> 


<script type="text/javascript">
  $(document).ready(function() { 
   $("#btnguardarprod").on('click',async function() {
  
   var formDataProd = new FormData(); 
   
   var nuevoNombre=$('#nuevoNombre').val();
   var nuevoCodigo=$('#nuevoCodigo').val().replace(/\s+/g, '');
   var nuevoDescripcion=$('#nuevoDescripcion').val();
 
   var selectNuevoMarca=$('#selectNuevoMarca').val();
   var selectNuevoCateg=$('#selectNuevoCateg').val();
   var selectNuevoalmacen=$('#selectNuevoalmacen').val();
   var tipo_user=$('#tipo_user').val();
   var idUsuario=$('#idUsuario').val();
   var btnguardarprod=$('#btnguardarprod').val();
   const pasoValidacion=await pasoValidacionCamposDeFormularioProducto();
   console.log(pasoValidacion);
  
   if ( (nuevoNombre=='') ||  (nuevoCodigo=='')||  (nuevoDescripcion=='')|| (selectNuevoMarca=='') ||  (selectNuevoCateg=='') ||  (selectNuevoalmacen=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
   }
   else if (!pasoValidacion) {
      swal('ATENCION','El código del producto ya existe registrado','warning'); 
    }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataProd.append('nuevoNombre',nuevoNombre);
     formDataProd.append('nuevoCodigo',nuevoCodigo);
     formDataProd.append('nuevoDescripcion',nuevoDescripcion);
     formDataProd.append('selectNuevoMarca',selectNuevoMarca);
     formDataProd.append('selectNuevoCateg',selectNuevoCateg);
     formDataProd.append('tipo_user',tipo_user);
     formDataProd.append('idUsuario',idUsuario);
     formDataProd.append('btnguardarprod',btnguardarprod);
     formDataProd.append('selectNuevoalmacen',selectNuevoalmacen);
     
     try {
        const response = await $.ajax({
          url: 'controladores/productos.controlador.php', 
          type: 'POST', 
          data: formDataProd, 
          contentType: false, 
          processData: false
        });
        
        console.info(response);
        if (response == 1) {
          setTimeout(function(){ location.href='productos'; }, 1000); 
          swal('EXCELENTE','','success'); 
        } else {
          setTimeout(function(){  }, 2000); 
          swal('ERROR','Intente nuevamente','error');
        } 
      } catch (error) {
        console.error("Error en la solicitud AJAX:", error);
        swal('ERROR','Hubo un problema con la solicitud','error');
      }

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;
    }); 
  });






/*===================FUNCION QUE LLAMA AL EDITAR EMPLEADO===========================================*/
$(document).ready(function() { 
   $("#btneditprod").on('click',async function() {
  
   var formDataeditProd = new FormData(); 
   
   var btneditprod=$('#btneditprod').val();
   var idprodedit=$('#idprodedit').val();
   var editNombre=$('#editNombre').val();
   var editCodigo=$('#editCodigo').val().replace(/\s+/g, '');
   var editDescripcion=$('#editDescripcion').val();
   
   var selecteditMarca=$('#selecteditMarca').val();
   var selecteditCateg=$('#selecteditCateg').val();
   var selecteditalmacen=$('#selecteditalmacen').val();
   var tipo_user_edit=$('#tipo_user_edit').val();
   var idUsuario_edit=$('#idUsuario_edit').val();
   const pasoValidacion= await pasoValidacionCamposDeFormularioProductoEditar()
  
   if ( (editNombre=='') ||  (editCodigo=='')||  (editDescripcion=='') || (selecteditMarca=='') ||  (selecteditCateg=='') ||  (selecteditalmacen=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else if (!pasoValidacion) {
      swal('ATENCION','El código del producto ya existe registrado','warning'); 
    }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataeditProd.append('idprodedit',idprodedit);
     formDataeditProd.append('btneditprod',btneditprod);
     formDataeditProd.append('editNombre',editNombre);
     formDataeditProd.append('editCodigo',editCodigo);
     formDataeditProd.append('editDescripcion',editDescripcion);
  
     formDataeditProd.append('selecteditMarca',selecteditMarca);
     formDataeditProd.append('selecteditCateg',selecteditCateg);
     formDataeditProd.append('selecteditalmacen',selecteditalmacen);
     formDataeditProd.append('tipo_user_edit',tipo_user_edit);
     formDataeditProd.append('idUsuario_edit',idUsuario_edit);
     
      $.ajax({ url: 'controladores/productos.controlador.php', 
               type: 'post', 
               data: formDataeditProd, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='productos'; }, 2000); swal('EXELENTE','','success'); 
                     
                  }
                  else
                  {
                    if (response==2) 
                    {
                      setTimeout(function(){  }, 2000); swal('ERROR','No puede actualizar porque usted no dio de alta este producto','error');
                    }
                    else
                    {   
                    setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                    }                   
                  } 
                }
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });


  /*========================CARGAMOS LOS DATOS PARA ACTUALIZAR=========================*/
function CargarinfoProdEnModal(datosProd) 
  {
    
    f=datosProd.split('||');
    $('#idprodedit').val(f[0]);
     $('#editNombre').val(f[1]);
      $('#editCodigo').val(f[2]);
      $('#editDescripcion').val(f[3]);
      
      $('#selecteditMarca').val(f[4]);
      $('#selecteditCateg').val(f[5]);
      $('#selecteditalmacen').val(f[6]);
           
          // $('#textidalim').text(f[0]);
  }





  /*========================CARGAMOS LOS DATOS PARA ELIMINAR=========================*/
function CargarinfoProdEnModalElim(datosProd) 
  {
    
    f=datosProd.split('||');
    $('#idprodelim').val(f[0]);       
          // $('#textidalim').text(f[0]);
  }





  /*===================FUNCION QUE LLAMA AL ELIMINAR===========================================*/
$(document).ready(function() { 
   $("#btnelimprod").on('click', function() {
  
   var formDataelim = new FormData(); 
   
   var btnelimprod=$('#btnelimprod').val();
   var idprodelim=$('#idprodelim').val();
   var tipo_user_elim=$('#tipo_user_elim').val();
   var idUsuario_elim=$('#idUsuario_elim').val();
   
  
   
  
   if ( (idprodelim=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataelim.append('idprodelim',idprodelim);
     formDataelim.append('btnelimprod',btnelimprod);
     formDataelim.append('tipo_user_elim',tipo_user_elim);
     formDataelim.append('idUsuario_elim',idUsuario_elim);
  
     
     
      $.ajax({ url: 'controladores/productos.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='productos'; }, 2000); swal('EXELENTE','','success'); 
                     
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

  async function pasoValidacionCamposDeFormularioProducto() {
  var nuevoCodigo = $('#nuevoCodigo').val().replace(/\s+/g, '');
  var pasoValidacion = true;

  try {
    const respuesta = await $.ajax({
      url: "ajax/obtenerProductoPorCodigoBarra.php",
      data: { "nuevoCodigo": nuevoCodigo },
      method: "GET",
      cache: false,
      dataType: "json",
    });

    console.log('reessss', respuesta);
    if (respuesta == 1) {
      pasoValidacion = false;
    } else {
      pasoValidacion = true;
    }
  } catch (error) {
    console.error("Error en la solicitud AJAX:", error);
    pasoValidacion = false; // Maneja el error como creas conveniente
  }
  console.log('devolvio', pasoValidacion);
  return pasoValidacion;
}


async function pasoValidacionCamposDeFormularioProductoEditar() {
  var idprodedit=$('#idprodedit').val();
   var editCodigo=$('#editCodigo').val().replace(/\s+/g, '');

  var pasoValidacion = true;

  try {
    const respuesta = await $.ajax({
      url: "ajax/obtenerProductoCodigoBarraId.php",
      data: { "editCodigo": editCodigo,
               "idprodedit": idprodedit 
       },
      method: "GET",
      cache: false,
      dataType: "json",
    });

    console.log('reessss', respuesta);
    if (respuesta == 1) {
      pasoValidacion = false;
    } else {
      pasoValidacion = true;
    }
  } catch (error) {
    console.error("Error en la solicitud AJAX:", error);
    pasoValidacion = false; // Maneja el error como creas conveniente
  }
  console.log('devolvio', pasoValidacion);
  return pasoValidacion;
}


</script>



