<?php
include_once("modelos/empleado.modelo.php");
include_once("modelos/administrador.modelo.php");
include_once("modelos/Trn_stock_recibido.modelo.php");
include_once("modelos/compraProducto.modelo.php");
include_once("modelos/sucursal.modelo.php");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Intercambios (Recibidos)
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Administrar Intercambio (Recibidos)</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarReciboStock">
            Registrar Recibo de mercaderia
          </button>
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped tablas">
             <thead>
                <tr>
                  
                  <th>Cod_Recibo</th>
                  <th>Fecha </th>
                  <th>Cantidad</th>
                  <th>Estado</th>
                  <th>Producto</th>
                  <th>Codigo</th>
                  <th>Sucursal destino</th>
                  <th>Nº Lote</th>
                  <th>Código de envio</th>
                  <th>Acciones</th>

                </tr>
             </thead>

             <tbody>
               <?php
              
                $objemp=new Trans_Stock_recibido();
                $resultado=$objemp->listarTrnStock_recibidas();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datosRecibido=$fila->id_transferencia_recibido."||".
                                     $fila->fecha_trn_recibido."||".
                                     $fila->cantidad_recibida."||".
                                     $fila->estado_recibida."||".
                                     $fila->nombre_producto."||".
                                     $fila->codigo_producto."||".
                                     $fila->nombre_suc."||".
                                     $fila->id_compra_producto."||".
                                     $fila->codigo_de_envio."||".
                                     $fila->descripcion_recibido;
                                          
              ?>
               <tr>
                
                 <td><?php echo $fila->id_transferencia_recibido; ?></td>
                 <td><?php echo $fila->fecha_trn_recibido; ?></td>
                 <td><?php echo $fila->cantidad_recibida; ?></td>
                 <td><?php echo $fila->estado_recibida; ?></td>
                 <td><?php echo $fila->nombre_producto; ?></td>
                 <td><?php echo $fila->codigo_producto; ?></td>

                 <td><?php echo $fila->nombre_suc; ?></td>
                 <td><?php echo $fila->id_compra_producto; ?></td>
                 <td><?php echo $fila->codigo_de_envio; ?></td>

                 
                 
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-info" data-toggle="modal" data-target="#modalinforecibido" onclick="CargarinfoRecibido('<?php echo $datosRecibido ?>')"><i class="fa fa-info"></i></button>

                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimRecibo" onclick="CargarinfoRecibidoElim('<?php echo $datosRecibido ?>')"><i class="fa fa-times"></i></button>
                   </div>
                 </td>
               </tr>
               <?php
                
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

  <!--MODAL PARA AGREGAR STOCK RECIBIDO -->
   <!-- Modal -->
<div id="modalAgregarReciboStock" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #3c8dbc; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Registro de Stock recibido</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <label>Producto</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                  <select class="form-control input-lx" name="selectidprod" id="selectidprod">
                    <?php
                     $objprod=new Compra_Producto();
                     $resultp=$objprod->listadoProductosDisponiblesActivos();
                     while ($filp=mysqli_fetch_object($resultp)) 
                     {
                      ?>
                      <option value="<?php echo $filp->id_compra_producto ?>"> <?php echo 'Prod:'.$filp->nombre_producto.' |Lote:'.$filp->id_compra_producto.' |Stock:'.$filp->stock_actual; ?> </option>
                     <?php  
                     }
                    ?>
                     
                  </select>
              </div>  
            </div>

            <div class="form-group">
              <label>Cantidad a recibir</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="number" class="form-control input-lx" name="cantRecibido" id="cantRecibido" placeholder="Ingresar cantidad" required="" autocomplete="off">
              </div>  
            </div>


            <div class="form-group">
              <label>Seleccione sucursal origen</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                 <select class="form-control input-lx" name="selectSucursal" id="selectSucursal">
                   <?php
                    $objsuc=new Sucursal();
                    $resulSuc=$objsuc->listarSucursalesActivas();
                    while ($fils=mysqli_fetch_object($resulSuc)) 
                    {
                     ?>
                     <option value="<?php echo $fils->id_sucursal; ?>"><?php echo $fils->nombre_suc;?></option>

                     <?php
                    }
                   ?>
                   
                 </select>
              </div>  
            </div>

             <div class="form-group">
              <label>Código de envio</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="number" class="form-control input-lx" name="codEnvio" id="codEnvio" placeholder="Ingresar codigo de envio" required="" autocomplete="off">
              </div>  
            </div>

                      
             <div class="form-group">
               <label>Descripcion recibido</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-info"></i></span>
                
                 <textarea name="descrip_recibido" id="descrip_recibido" class="form-control input-lx"></textarea>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnguardartrnrecibido" id="btnguardartrnrecibido">Guardar</button>
      </div>
     
    </div>

  </div>
</div>


  <!-- Modal info de recibido -->
<div id="modalinforecibido" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #00c0ef;; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Información de recibido</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

 
              <label>Código de recibido:</label>
              <label id="codigo" style="font-weight: normal;"></label><br>
      
              <label>Producto:</label>
              <label id="producto" style="font-weight: normal;"></label><br>
                    
              <label>Código de producto:</label>
              <label id="cod_producto" style="font-weight: normal;"></label><br>               
          
              <label>Cantidad recibida:</label>
                <label id="cantidadrecibida" style="font-weight: normal;"></label><br>
           
              <label>Nº Lote:</label>
                <label id="lote" style="font-weight: normal;"></label><br>
                
              <label>Sucursal Origen:</label>
              <label id="sucursal_origen" style="font-weight: normal;"></label><br>
                   
              <label>Fecha recibido:</label>
              <label id="fecha_recibido" style="font-weight: normal;"></label><br>

              <label>Código de envio:</label>             
              <label id="cod_envio" style="font-weight: normal;"></label><br>

               <label>Descripción de recibido:</label>             
              <label id="descripcion_recibido" style="font-weight: normal;"></label>
              
                   
             
            
         </div>
      </div>
      <div class="modal-footer">
       
        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal --> 



 <!-- Modal Eliminar envio-->
<div id="modalElimRecibo" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #dd4b39; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eliminar Recibido</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  
                  <input type="hidden" name="idrecibido" id="idrecibido" placeholder="id recibido">
                
              </div>  
            </div>
           
            <div class="form-group">
              <div class="input-group">
                  <label>Desea eliminar este Recibido ?</label>
              </div>  
            </div>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnelimrecibido" id="btnelimrecibido">Eliminar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal -->

<script type="text/javascript">
  $(document).ready(function() { 
   $("#btnguardartrnrecibido").on('click', function() {
  
   var formDatatrnrecibido = new FormData(); 
   
   var selectidprod=$('#selectidprod').val();
   var cantRecibido=$('#cantRecibido').val();
   var selectSucursal=$('#selectSucursal').val();
   var codEnvio =$('#codEnvio').val();
   var descrip_recibido=$('#descrip_recibido').val();
   
   var btnguardartrnrecibido=$('#btnguardartrnrecibido').val();

   
  /*validacion de la cantidad*/

  
  /*VALIDACION DE LOS CAMPOS VACIOS*/
   if ( (selectidprod=='') ||  (cantRecibido=='')||  (selectSucursal=='')||  (descrip_recibido=='') ||  (codEnvio=='')) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }

   else
   {   
     if ( (cantRecibido%1 == 0) && cantRecibido>0 ) 
       {
       /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/       
     formDatatrnrecibido.append('selectidprod',selectidprod);
     formDatatrnrecibido.append('cantRecibido',cantRecibido);
     formDatatrnrecibido.append('selectSucursal',selectSucursal);
     formDatatrnrecibido.append('codEnvio',codEnvio);
     formDatatrnrecibido.append('descrip_recibido',descrip_recibido);    
     formDatatrnrecibido.append('btnguardartrnrecibido',btnguardartrnrecibido);    
     
      $.ajax({ url: 'controladores/trn_stock_recibido.controlador.php', 
               type: 'post', 
               data: formDatatrnrecibido, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                console.info(response);
                //    var posOk=response[1];
                //    var posIdpregunta=response[4];
                //    console.info(posIdpregunta);
                  if (response==1) 
                  {
                    
                    setTimeout(function(){ location.href='trn-recibidas'; }, 2000); swal('EXELENTE','','success'); 
                     
                  }
                 
                  if (response==0) 
                  {
                    setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                                       
                  } 
                }
            }); 

          }/*fin del if que verifica que sea un numero entero*/
           else
           {
            setTimeout(function(){  }, 3000); swal('ATENCION','Cantidad debe ser un numero entero y mayor a cero','warning'); 
           }

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });
/*========================CARGAMOS LOS DATOS PARA ACTUALIZAR=========================*/
function CargarinfoRecibido(datosRecibido) 
  {
    
    f=datosRecibido.split('||');
    $('#codigo').text(f[0]);
     $('#producto').text(f[4]);
      $('#cod_producto').text(f[5]);
      $('#cantidadrecibida').text(f[2]);
      $('#lote').text(f[7]);
      $('#sucursal_origen').text(f[6]); 
      $('#cod_envio').text(f[8]);
      $('#descripcion_recibido').text(f[9]); 
      $('#fecha_recibido').text(f[1]);  
           
         
  }


/*========================CARGAMOS LOS DATOS PARA ELIMINAR=========================*/
function CargarinfoRecibidoElim(datosRecibido) 
  {
    
    f=datosRecibido.split('||');
    $('#idrecibido').val(f[0]);  
  }

/*===================FUNCION QUE LLAMA AL ELIMINAR EMPLEADO===========================================*/
$(document).ready(function() { 
   $("#btnelimrecibido").on('click', function() {
  
   var formDataelim = new FormData(); 
   
   var btnelimrecibido=$('#btnelimrecibido').val();
   var idrecibido=$('#idrecibido').val();
    
   if ( (idrecibido=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataelim.append('idrecibido',idrecibido);
     formDataelim.append('btnelimrecibido',btnelimrecibido);
    
      $.ajax({ url: 'controladores/trn_stock_recibido.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='trn-recibidas'; }, 2000); swal('EXELENTE','','success'); 
                     
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

