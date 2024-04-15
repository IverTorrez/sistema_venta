<?php
include_once("modelos/productos.modelo.php");
include_once("modelos/marca.modelo.php");
include_once("modelos/categorias.modelo.php");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lista de Productos
        <small>Panel de control</small>
        <button class="btn btn-danger btn-xs" onclick="window.open('impresiones/tcpdf/pdf/rep_productos_venta.php')">Imprimir todo <i class="fa fa-print"></i></button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Lista de Productos</li>

      </ol>
    </section>


<!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
       <!--  <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
            Agregar producto
          </button>
        </div> -->

        <div class="box-body">

          <table class="table table-bordered table-striped tablas">
             <thead>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Nº Lote</th>
                  <th>Nombre</th>
                  <th>Codigo</th>
                  <th>Descripcion</th>
                  <th>Marca</th>
                  <th>Categoria</th>
                  <th>Stok</th>
               
                  <th>P. Venta</th>
                  <th>P. Facturado</th>
                 
                  
                  <th>Estado</th>
                  <!-- <th>Acciones</th> -->

                </tr>
             </thead>

             <tbody>
               <?php
               $contador=1;
                $obj=new Producto();
                $resultado=$obj->listarProductosDisponiblesEnVenta();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                 /* $datosProd=$fila->id_producto."||".
                                     $fila->nombre_producto."||".
                                     $fila->codigo_producto."||".
                                     $fila->descripcion."||".
                                     $fila->precio_compra."||".
                                     $fila->precio_venta."||".
                                     $fila->precio_facturado."||".
                                     $fila->precio_tope."||".
                                     $fila->idmarca."||".
                                     $fila->idcategoria;*/
                                     
                  
              ?>
               <tr>
                 <td><?php echo $contador; ?></td>
                 <td><?php echo $fila->codigo_lote; ?></td>
                 <td><?php echo $fila->nombre_producto; ?></td>
                 <td><?php echo $fila->codigo_producto; ?></td>
                 <td><?php echo $fila->descripcion; ?></td>
                 <td><?php echo $fila->nombre_marca; ?></td>
                 <td><?php echo $fila->nombre_categoria; ?></td>
                 <td><?php echo $fila->stock_actual; ?></td>
               
                 <td><?php echo $fila->precio_venta_prod; ?></td>
                 <td><?php echo $fila->precio_venta_prod_Fact; ?></td>
                 
                 

                 
                 <td><button class="btn btn-success btn-xs">Activo</button> </td>
               <!--   <td>
                   <div class="btn-group">
                      <button class="btn btn-warning" data-toggle="modal" data-target="#modalEditProd" onclick="CargarinfoProdEnModal('<?php echo $datosProd ?>')"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimProd" onclick="CargarinfoProdEnModalElim('<?php echo $datosProd ?>')"><i class="fa fa-times"></i></button>
                   </div>
                 </td> -->
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

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-gift"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoNombre" id="nuevoNombre" placeholder="Ingresar nombre" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-qrcode"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoCodigo" id="nuevoCodigo" placeholder="Ingresar código" required="">
              </div>  
            </div>


            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-sticky-note"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoDescripcion" id="nuevoDescripcion" placeholder="Ingresar descripción" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoPCompra" id="nuevoPCompra" placeholder="Ingresar precio compra" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoPVenta" id="nuevoPVenta" placeholder="Ingresar precio venta" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoPFacturado" id="nuevoPFacturado" placeholder="Ingresar precio facturado" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-money"></i></span>
                 <input type="text" class="form-control input-lx" name="nuevoPTope" id="nuevoPTope" placeholder="Ingresar precio tope" required="">
              </div>  
            </div>

            <div class="form-group">
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

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="hidden" name="idprodedit" id="idprodedit" placeholder="id producto">
                 <input type="text" class="form-control input-lx" name="editNombre" id="editNombre" placeholder="Ingresar nombre" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="text" class="form-control input-lx" name="editCodigo" id="editCodigo" placeholder="Ingresar codigo" required="">
              </div>  
            </div>


            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-key"></i></span>
                 <input type="text" class="form-control input-lx" name="editDescripcion" id="editDescripcion" placeholder="Ingresar descripción" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                 <input type="text" class="form-control input-lx" name="editPCompra" id="editPCompra" placeholder="Ingresar precio compra" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                 <input type="text" class="form-control input-lx" name="editPVenta" id="editPVenta" placeholder="Ingresar precio venta" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                 <input type="text" class="form-control input-lx" name="editPFacturado" id="editPFacturado" placeholder="Ingresar precio facturado" required="">
              </div>  
            </div>

            <div class="form-group">
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                 <input type="text" class="form-control input-lx" name="editPTope" id="editPTope" placeholder="Ingresar precio tope" required="">
              </div>  
            </div>


            <div class="form-group">
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
   $("#btnguardarprod").on('click', function() {
  
   var formDataProd = new FormData(); 
   
   var nuevoNombre=$('#nuevoNombre').val();
   var nuevoCodigo=$('#nuevoCodigo').val();
   var nuevoDescripcion=$('#nuevoDescripcion').val();
   var nuevoPCompra=$('#nuevoPCompra').val();
   var nuevoPVenta=$('#nuevoPVenta').val();
   var nuevoPFacturado=$('#nuevoPFacturado').val();
   var nuevoPTope=$('#nuevoPTope').val();
   var selectNuevoMarca=$('#selectNuevoMarca').val();
   var selectNuevoCateg=$('#selectNuevoCateg').val();
   var btnguardarprod=$('#btnguardarprod').val();
   
  
   if ( (nuevoNombre=='') ||  (nuevoCodigo=='')||  (nuevoDescripcion=='')||  (nuevoPCompra=='')||  (nuevoPVenta=='') ||  (nuevoPFacturado=='') ||  (nuevoPTope=='') ||  (selectNuevoMarca=='') ||  (selectNuevoCateg=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataProd.append('nuevoNombre',nuevoNombre);
     formDataProd.append('nuevoCodigo',nuevoCodigo);
     formDataProd.append('nuevoDescripcion',nuevoDescripcion);
     formDataProd.append('nuevoPCompra',nuevoPCompra);
     formDataProd.append('nuevoPVenta',nuevoPVenta);
     formDataProd.append('nuevoPFacturado',nuevoPFacturado);
     formDataProd.append('nuevoPTope',nuevoPTope);
     formDataProd.append('selectNuevoMarca',selectNuevoMarca);
     formDataProd.append('selectNuevoCateg',selectNuevoCateg);
     formDataProd.append('btnguardarprod',btnguardarprod);
     
      $.ajax({ url: 'controladores/productos.controlador.php', 
               type: 'post', 
               data: formDataProd, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='productos'; }, 1000); swal('EXELENTE','','success'); 
                     
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






/*===================FUNCION QUE LLAMA AL EDITAR EMPLEADO===========================================*/
$(document).ready(function() { 
   $("#btneditprod").on('click', function() {
  
   var formDataeditProd = new FormData(); 
   
   var btneditprod=$('#btneditprod').val();
   var idprodedit=$('#idprodedit').val();
   var editNombre=$('#editNombre').val();
   var editCodigo=$('#editCodigo').val();
   var editDescripcion=$('#editDescripcion').val();
   var editPCompra=$('#editPCompra').val();
   var editPVenta=$('#editPVenta').val();
   var editPFacturado=$('#editPFacturado').val();
   var editPTope=$('#editPTope').val();
   var selecteditMarca=$('#selecteditMarca').val();
   var selecteditCateg=$('#selecteditCateg').val();
   
  
   if ( (editNombre=='') ||  (editCodigo=='')||  (editDescripcion=='')||  (editPCompra=='')||  (editPVenta=='') ||  (editPFacturado=='') ||  (editPTope=='') ||  (selecteditMarca=='') ||  (selecteditCateg=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataeditProd.append('idprodedit',idprodedit);
     formDataeditProd.append('btneditprod',btneditprod);
     formDataeditProd.append('editNombre',editNombre);
     formDataeditProd.append('editCodigo',editCodigo);
     formDataeditProd.append('editDescripcion',editDescripcion);
     formDataeditProd.append('editPCompra',editPCompra);
     formDataeditProd.append('editPVenta',editPVenta);
     formDataeditProd.append('editPFacturado',editPFacturado);
     formDataeditProd.append('editPTope',editPTope);
     formDataeditProd.append('selecteditMarca',selecteditMarca);
     formDataeditProd.append('selecteditCateg',selecteditCateg);
     
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
                    setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                                       
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
      $('#editPCompra').val(f[4]);
      $('#editPVenta').val(f[5]);
      $('#editPFacturado').val(f[6]);  
      $('#editPTope').val(f[7]);
      $('#selecteditMarca').val(f[8]);
      $('#selecteditCateg').val(f[9]);
           
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
  
   
  
   if ( (idprodelim=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataelim.append('idprodelim',idprodelim);
     formDataelim.append('btnelimprod',btnelimprod);
  
     
     
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

</script>



