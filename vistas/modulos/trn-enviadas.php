<?php
include_once("modelos/empleado.modelo.php");
include_once("modelos/administrador.modelo.php");
include_once("modelos/Trn_stock_envio.modelo.php");
include_once("modelos/compraProducto.modelo.php");
include_once("modelos/sucursal.modelo.php");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Intercambios de Envio
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <!-- <li><a href="#">Examples</a></li> -->
        <li class="active">Administrar Intercambio de Envios</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarEnvio">
            Registrar un Envio
          </button>
        </div>

        <div class="box-body">
          <table class="table table-bordered table-striped tablas">
             <thead>
                <tr>
                  
                  <th>Cod_envio</th>
                  <th>Fecha </th>
                  <th>Cantidad</th>
                  <th>Estado</th>
                  <th>Producto</th>
                  <th>Codigo</th>
                  <th>Sucursal destino</th>
                  <th>Nº Lote</th>
                  <th>Acciones</th>

                </tr>
             </thead>

             <tbody>
               <?php
              
                $objemp=new Trans_Stock_envio();
                $resultado=$objemp->listarTrnStock_enviadas();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datosEnvio=$fila->id_transferencia_envio."||".
                                     $fila->fecha_transferencia_enviada."||".
                                     $fila->cantidad_envio."||".
                                     $fila->estado."||".
                                     $fila->nombre_producto."||".
                                     $fila->codigo_producto."||".
                                     $fila->nombre_suc."||".
                                     $fila->id_compra_producto."||".
                                     $fila->descripcion_trans_envio;
                                          
              ?>
               <tr>
                
                 <td><?php echo $fila->id_transferencia_envio; ?></td>
                 <td><?php echo $fila->fecha_transferencia_enviada; ?></td>
                 <td><?php echo $fila->cantidad_envio; ?></td>
                 <td><?php echo $fila->estado; ?></td>
                 <td><?php echo $fila->nombre_producto; ?></td>
                 <td><?php echo $fila->codigo_producto; ?></td>

                 <td><?php echo $fila->nombre_suc; ?></td>
                 <td><?php echo $fila->id_compra_producto; ?></td>

                 
                 
                 <td>
                   <div class="btn-group">
                      <button class="btn btn-info" data-toggle="modal" data-target="#modalinfoenvio" onclick="CargarinfoEnvio('<?php echo $datosEnvio ?>')"><i class="fa fa-info"></i></button>

                      <button class="btn btn-danger" data-toggle="modal" data-target="#modalElimenvio" onclick="CargarinfoEnvioElim('<?php echo $datosEnvio ?>')"><i class="fa fa-times"></i></button>
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

  <!--MODAL PARA AGREGAR ENVIOS -->
   <!-- Modal -->
<div id="modalAgregarEnvio" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #3c8dbc; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Registro de envio de Stock</h4>
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
                     $resultp=$objprod->listadoProductosDisponiblesConStock();
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
              <label>Cantidad a enviar</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                 <input type="number" class="form-control input-lx" name="cantEnvio" id="cantEnvio" placeholder="Ingresar cantidad" required="" autocomplete="off">
              </div>  
            </div>


            <div class="form-group">
              <label>Seleccione sucursal</label>
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
               <label>Descripcion envio</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-info"></i></span>
                
                 <textarea name="descrip_envio" id="descrip_envio" class="form-control input-lx"></textarea>
              </div>  
            </div>


         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnguardartrnenvio" id="btnguardartrnenvio">Guardar</button>
      </div>
     
    </div>

  </div>
</div>


  <!-- Modal info de envio -->
<div id="modalinfoenvio" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header" style="background: #00c0ef;; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Información del envio</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

 
              <label>Código de envio:</label>
              <label id="codigo" style="font-weight: normal;"></label><br>
      
              <label>Producto:</label>
              <label id="producto" style="font-weight: normal;"></label><br>
                    
              <label>Código de producto:</label>
              <label id="cod_producto" style="font-weight: normal;"></label><br>               
          
              <label>Cantidad enviada:</label>
                <label id="cantidadenviada" style="font-weight: normal;"></label><br>
           
              <label>Nº Lote:</label>
                <label id="lote" style="font-weight: normal;"></label><br>
                
              <label>Sucursal Destino:</label>
              <label id="sucursal_destino" style="font-weight: normal;"></label><br>
                   
              <label>Fecha envio:</label>
              <label id="fecha_envio" style="font-weight: normal;"></label><br>

               <label>Descripción del envio:</label>             
              <label id="descripcion_envio" style="font-weight: normal;"></label>
              
                   
             
            
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
<div id="modalElimenvio" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      
      <div class="modal-header" style="background: #dd4b39; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Eliminar envio</h4>
      </div>
      <div class="modal-body">
         <div class="box-body">

            <div class="form-group">
              <div class="input-group">
                  
                  <input type="hidden" name="idenvio" id="idenvio" placeholder="id envio">
                
              </div>  
            </div>
           
            <div class="form-group">
              <div class="input-group">
                  <label>Desea eliminar este envio ?</label>
              </div>  
            </div>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <button type="submit" class="btn btn-primary" name="btnelimEnvio" id="btnelimEnvio">Eliminar</button>
      </div>
     
    </div>

  </div>
</div>

        <!-- /.modal -->

<script type="text/javascript">
  $(document).ready(function() { 
   $("#btnguardartrnenvio").on('click', function() {
  
   var formDataempleado = new FormData(); 
   
   var selectidprod=$('#selectidprod').val();
   var cantEnvio=$('#cantEnvio').val();
   var selectSucursal=$('#selectSucursal').val();
   var descrip_envio=$('#descrip_envio').val();
   
   var btnguardartrnenvio=$('#btnguardartrnenvio').val();

   
  /*validacion de la cantidad*/

  
  /*VALIDACION DE LOS CAMPOS VACIOS*/
   if ( (selectidprod=='') ||  (cantEnvio=='')||  (selectSucursal=='')||  (descrip_envio=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning'); 
     
     
   }

   else
   {   
     if ( (cantEnvio%1 == 0) && cantEnvio>0 ) 
       {
       /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/       
     formDataempleado.append('selectidprod',selectidprod);
     formDataempleado.append('cantEnvio',cantEnvio);
     formDataempleado.append('selectSucursal',selectSucursal);
     formDataempleado.append('descrip_envio',descrip_envio);    
     formDataempleado.append('btnguardartrnenvio',btnguardartrnenvio);    
     
      $.ajax({ url: 'controladores/trn_stock_envio.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='trn-enviadas'; }, 2000); swal('EXELENTE','','success'); 
                     
                  }
                  if (response==2) 
                  {
                    setTimeout(function(){  }, 2000); swal('ERROR','El stock de este producto no es suficiente','error');
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
function CargarinfoEnvio(datosEnvio) 
  {
    
    f=datosEnvio.split('||');
    $('#codigo').text(f[0]);
     $('#producto').text(f[4]);
      $('#cod_producto').text(f[5]);
      $('#cantidadenviada').text(f[2]);
      $('#lote').text(f[7]);
      $('#sucursal_destino').text(f[6]); 
      $('#descripcion_envio').text(f[8]); 
      $('#fecha_envio').text(f[1]);  
           
  }


/*========================CARGAMOS LOS DATOS PARA ELIMINAR=========================*/
function CargarinfoEnvioElim(datosEnvio) 
  {
    
    f=datosEnvio.split('||');
    $('#idenvio').val(f[0]);  
  }

/*===================FUNCION QUE LLAMA AL ELIMINAR ENVIO===========================================*/
$(document).ready(function() { 
   $("#btnelimEnvio").on('click', function() {
  
   var formDataelim = new FormData(); 
   
   var btnelimEnvio=$('#btnelimEnvio').val();
   var idenvio=$('#idenvio').val();

   if ( (idenvio=='') ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','Deve de completar todos los campos','warning');         
   }
   else
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
     formDataelim.append('idenvio',idenvio);
     formDataelim.append('btnelimEnvio',btnelimEnvio); 
      $.ajax({ url: 'controladores/trn_stock_envio.controlador.php', 
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
                    
                    setTimeout(function(){ location.href='trn-enviadas'; }, 2000); swal('EXELENTE','','success'); 
                     
                  }
                  else
                  {
                    setTimeout(function(){  }, 2000); swal('ERROR','Intente eliminar nuevamente','error');
                                       
                  } 
                }
            }); 

      }/*FIN DEL ELSE QUE SE EJECTUTA AL CONFIRMAR QUE TODOS LOS CAMPOS FUERON LLENADOS*/
        return false;


    }); 
  });

</script>

