<?php
include_once("modelos/productos.modelo.php");
include_once("modelos/marca.modelo.php");
include_once("modelos/categorias.modelo.php");
include_once("modelos/clientes.modelo.php");
include_once("modelos/compraProducto.modelo.php");
?>
<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lista de Productos
        <small>Panel de control</small><input type="text" name="texttipouser" id="texttipouser" value="<?php echo $_SESSION['tipouser'] ?>">
        <input type="text" name="textiduser" id="textiduser" value="<?php echo $iduseractual; ?>">
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
      <div style="height: 200px;border: 1px solid #85929E; overflow: scroll; ">
      <div class="box">
       <!--  <div class="box-header with-border">
          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
            Agregar producto
          </button>
        </div> -->

        <div class="box-body">
          <table class="table table-bordered table-striped tablas tablaProductos">
             <thead>
                <tr>
                  
                  <th>Nombre</th>
                  <th>Codigo</th>
                  <th>Descripcion</th>
                  <th>Marca</th>
                  <th>Categoria</th>
                  <th>Stok Fac.</th>
                  <th>Stok Simple</th>
                 <!--  <th>P. Compra</th> -->
                  <th>P. Venta</th>
                  <th>P. Facturado</th>
                 <!--  <th>P. Tope</th> -->
                  
                  <th>Accion</th>
                  <!-- <th>Acciones</th> -->

                </tr>
             </thead>

             <tbody>
               <?php
               $contador=1;
                $obj=new Producto();
                $resultado=$obj->listarProductosActivosConStock();
                while ($fila=mysqli_fetch_object($resultado)) 
                {
                  $datosProd=$fila->id_producto."||".
                                     $fila->nombre_producto."||".
                                     $fila->codigo_producto."||".
                                     $fila->descripcion."||".
                                     $fila->precio_compra."||".
                                     $fila->precio_venta."||".
                                     $fila->precio_facturado."||".
                                     $fila->precio_tope."||".
                                     $fila->idmarca."||".
                                     $fila->idcategoria;
                                     
                  
              ?>
               <tr>
                
                 <td><?php echo $fila->nombre_producto; ?></td>
                 <td><?php echo $fila->codigo_producto; ?></td>
                 <td><?php echo $fila->descripcion; ?></td>
                 <td><?php echo $fila->marca_prod; ?></td>
                 <td><?php echo $fila->cat_prod; ?></td>
                 <?php
                 /*IF PARA PREGUNTAR SI EL STOK FACTURADO DEL PRODUCTO ES MENOR A 11*/
                 if ($fila->stok_facturado<=10) 
                 {
                  $tipoboton="btn-danger";
                 }
                 else
                 {
                  $tipoboton="btn-success";
                 }
                /*IF PARA PREGUNTAR SI EL STOK SIMPLE DEL PRODUCTO ES MAYOR A 10*/
                 if ($fila->stock_simple<=10) 
                 {
                  $tipobotonsim="btn-danger";
                 }
                 else
                 {
                  $tipobotonsim="btn-success";
                 }
                 ?>
                 <td><span class="btn <?php echo $tipoboton ?>"><?php echo $fila->stok_facturado; ?></span> </td>
                 <td><span class="btn <?php echo $tipobotonsim ?>"><?php echo $fila->stock_simple; ?></span></td>
                <!--  <td><?php echo $fila->stock_simple; ?></td> -->
                 <td><?php echo $fila->precio_venta; ?></td>
                 <td><?php echo $fila->precio_facturado; ?></td>
                <!--  <td><?php echo $fila->precio_tope; ?></td> -->
                 

                 
                 <td><button class="btn btn-success btn-xs agregarProducto recuperarBoton" data-id="<?php echo $fila->id_producto ?>">Agregar <i class="fa  fa-plus"></i> </button> </td>
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
   </div>
   <!-- /.div scrool -->
           <div class="form-group" style="width: 50%;">
              <label>Seleccione Cliente</label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa  fa-user"></i></span>
                 <select class="form-control select2 input-lx" name="slectcli" id="slectcli">
                   <option value="0">Sin nombre</option>
                   <?php
                    $objtcli=new Cliente();
                    $result=$objtcli->listarClientesActivos();
                    while ($filcli=mysqli_fetch_object($result)) 
                     {
                      ?> 
                    <option value="<?php echo $filcli->id_cliente; ?>"><?php echo $filcli->nombre_cliente; ?></option>
                      <?php
                     }
                   ?>
                  
                 </select>
              </div>  
            </div>

    <div class="checkbox">
                  <label>
                    <input type="checkbox" name="checkfact" id="checkfact" > Venta Facturada
                  </label>
                </div>

    <div class="form-group row " id="" >

     
       <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Productos </h3>

              <!-- <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover formularioVenta" border="1">
                <tr style="background: #d2d6de">
                  <th style="width:20%;">Producto</th>
                  <th>Codigo</th>
                  <th>Precio venta</th>
                 <!--  <th>Precio Tope</th> -->
                  <th style="width:7%;">Identificador</th>
                  <th style="width:7%;">Cantidad</th>
                  <th style="width:7%;">Precio vendido</th>
                  <th>Opcion</th>
                </tr>
                <tbody id="nuevoProducto" class="nuevoProducto">
                <!-- <tr>
                  <td>Adaptador wifi</td>
                  <td>KP-AW11</td>
                  <td>50</td>
                  <td>45</td>
                  <td><input type="number" name="" min="1" value="1" value=""> </td>
                  <td><input type="text" name="" value=""> </td>
                  <td><button class="btn btn-danger btn-xs">Eliminar</button></td>
                </tr>
                <tr>
                  <td>Adaptador wifi</td>
                  <td>KP-AW11</td>
                  <td>50</td>
                  <td>45</td>
                  <td><input type="number" name="" min="1" value="1"> </td>
                  <td><input type="text" name="" value=""> </td>
                  <td><button class="btn btn-danger btn-xs">Eliminar</button></td>
                </tr> -->
                
               
                

                </tbody>
                <tfoot>
                  <tr>
                  <td colspan="5" style="text-align: center; "><b> Total</b></td>
                  <td><input type="text"  id="totalMontoventa" name="totalMontoventa" readonly=""></td>  
                  <td></td>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col-xs-12 -->
      </div>
      <!-- /.row -->
      <button class="btn btn-primary" id="btnguardarventa" name="btnguardarventa" style="float: right;display: none;">Guardar venta</button>
                

    </div>
  <!-- /div nuevoProducto -->


    </section>
    <!-- /.content -->  
    
  </div>
  <!-- /.content-wrapper -->


   <!--MODAL PARA AGREGAR USUSARIOS -->
 

<!-- CODIGO QUE SE EJECUTA AL AGREGAR PRODUCTO A LA VENTA -->

<script type="text/javascript">
  var arrayIdproductosVenta=[];
   $(".tablaProductos").on("click","button.agregarProducto",function(){
    
  var id=$(this).attr("data-id");/*obtenemos el dato que cargamos en el campo 'data-id'  */

$("#btnguardarventa").css("display", "block");/*mostramos el boton guardar venta*/
  
  $(this).removeClass("btn-success agregarProducto");// se elimina la clase para que ya no pueda agregar el mismo producto
  $(this).addClass("btn-defaul");//se le da el color por defecto con una clase nueva
  
   $.ajax({
    url:"ajax/cargartablaProducto.php",
    data:{"id_producto":id},
    type:"POST",
    dataType:"json",
    success:function(respuesta){
     //$("#nuevoProducto").html(respuesta);
     let id_producto=respuesta["id_producto"];
     let nombre_producto=respuesta["nombre_producto"];
     let codigo_producto=respuesta["codigo_producto"];
     let precio_venta=respuesta["precio_venta"];
     let precio_facturado=respuesta["precio_facturado"];
     let precio_tope=respuesta["precio_tope"];
     let stok_facturado=respuesta["stok_facturado"];
     let stock_simple=respuesta["stock_simple"];
     let stockTotal=parseInt(stock_simple)+parseInt(stok_facturado);
    //  console.log(respuesta);
// CARGAMOS EL ID DEL PRODUCTO AL ARRAYDE PRODUCTOS SELECCIONADOS
    arrayIdproductosVenta.push(id);
   // console.log(arrayIdproductosVenta);
        $(".nuevoProducto").append(

    '<tr>'+
  '<!--producto-->'+

     '<td>'+nombre_producto+' </td>'+
     '<td>'+codigo_producto+'</td>'+
     '<td>'+precio_venta+'</td>'+
     // '<td>'+precio_tope+'</td> '+
     '<td> <input type="text" id="txtidenti'+id+'" name="txtidenti'+id+'"> </td> '+

     '<td> <input type="number" id="txtcantidad'+id+'" oninput="calculosubtotal(this.value,'+id+','+precio_venta+','+stockTotal+')" name="nuevaCantidadProducto" min="1" value="1"  class="nuevaCantidadProducto" id_producto="nuevaCantidadProducto"> </td> '+

    
     '<td> <input type="text" class="nuevoPrecio" name="preciovendido" id="precVenta'+id+'" oninput="sumarTotalPrecio()" precioReal="'+precio_venta+'" value="'+precio_venta+'" > </td>'+

     '<td><button class="btn btn-danger btn-xs quitarProducto" id_producto="'+id+'">Eliminar</button></td>'+
 
'</tr>')

sumarTotalPrecio();

//ejecutarfunciondedecalculo();/*funcion que se ejecuta para calcular monto total*/
    }
   })

 });




/*============================================================
 =           Cuando cargue la tabla cada vez que se navegue en la tabla          =
 ============================================================*/
 $(".tablaProductos").on("draw.dt",function(){
  //console.log("tabla");
  if(localStorage.getItem("quitarProducto") != null){
    var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));
    //console.log(listaIdProductos);
    for (var i =0;  i<listaIdProductos.length;  i++) {
      //console.log(listaIdProductos[i]["id_producto"]);
      $("button.recuperarBoton[data-id='"+listaIdProductos[i]["id_producto"]+"']").removeClass('btn-defaul');
      $("button.recuperarBoton[data-id='"+listaIdProductos[i]["id_producto"]+"']").addClass('btn-success agregarProducto');
    }
  }
 })


 
 /*============================================================
 =            quitar producto y recuperar el boton            =
 ============================================================*/
 var idQuitarProducto=[];
 localStorage.removeItem("quitarProducto");/*ELIMINA DEL LOCALSTORAGE LOS ID AL CARGAR LA PAGINA*/
 $(".formularioVenta").on("click","button.quitarProducto",function(){
  //console.log("boton");
  $(this).parent().parent().remove();// se elimnina el registro del la tabla producto
   let id_producto=$(this).attr("id_producto");//obtnemos el idProducto de la clase quitarproducto boton eliinar
   // ELIMINA EL ID DEL ARRAY DE PRODUCTOS PARA LA VENTA
    var i = arrayIdproductosVenta.indexOf(id_producto);
    arrayIdproductosVenta.splice( i, 1 );
 //  console.log(arrayIdproductosVenta); 

   //ALMACENA EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR

     if(localStorage.getItem("quitarProducto")== null){
      idQuitarProducto=[]; // sie le local storag vien vacio se crea un array
     }
     else{
      idQuitarProducto.concat(localStorage.getItem("quitarProducto"));
     }
     idQuitarProducto.push({"id_producto":id_producto});
     localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));// se carga el local storage y se convierte a string el array idquitarProducto


   ///
   $("button.recuperarBoton[data-id='"+id_producto+"']").removeClass('btn-defaul');
   $("button.recuperarBoton[data-id='"+id_producto+"']").addClass('btn-success agregarProducto');
   if($(".nuevoProducto").children().length==0){ //preguntamos si es que no queda registro en la tabla producto
    $("#totalMontoventa").val(0); //si esque no existe el toal de venta va ser 0
    $("#btnguardarventa").css("display", "none");/*ocultamos el boton guardar venta*/
   } 
   else{
    //y si hay registro en la tabla producto entonces va llamar a la funcion para calcular el total de ventas
     sumarTotalPrecio(); 
   }
   
 });
 /*=====  End of quitar producto y recuperar el boton  ======*/
 





 /*=============================================
 =            modificar la cantidad            =
 =============================================*/
 
 $(".formularioVenta").on("change","input.nuevaCantidadProducto",function(){
   var precio =$(this).parent(".nuevoPrecio");
    //var precioFinal=$(this).val()*precio.attr("precioReal");//multiplicamos la cantidad por el precio
    console.log("precio");
    
    //precio.val(precioFinal)
   //sumarTotalPrecio();
 });
 
 /*=====  End of modificar la cantidad  ======*/








 /*===============================================
 =            sumar todos los precios            =
 ===============================================*/
 
 function sumarTotalPrecio(){
   var precioItem=$(".nuevoPrecio");
   var arraySumaPrecio=[];
   for (var i =0; i<precioItem.length; i++) {
     arraySumaPrecio.push(Number($(precioItem[i]).val()));
   }

   function sumarArrayPrecios(total,numero){
    return total + numero;
   }
   var sumaTotalPrecios= arraySumaPrecio.reduce(sumarArrayPrecios);
  
   $("#totalMontoventa").val(sumaTotalPrecios.toFixed(2)); /*CARGA EL VALOR DE LA SUMA TOTAL CON DECIMAL*/
  
 }



 
 /*=====  End of sumar todos los precios  ======*/
 function sumaTotalventa()
 {
    var montoTotal=0;
    montoTotal=montoTotal+ document.getElementById("preciovendido").value; 
  $("#totalMontoventa").val(montoTotal);
 }



 

</script>
<script type="text/javascript">
  function calculosubtotal(cantidad,idprod,precVenta,stockTotal)
  {
    var idtextcantidad="txtcantidad"+idprod;
   var idtextsubtotal="precVenta"+idprod;/*obtenemos el id del input subtotal*/
   var subtotalprod=cantidad*precVenta;
     if (cantidad<=stockTotal) /*preguntamos si la cantidad que vendera no supera el stock*/
     {
     $("#"+idtextsubtotal+"").val(subtotalprod.toFixed(2));

     sumarTotalPrecio();/*FUNCION QUE SUMA EL MONTO TOTAL DE LA VENTA*/
     }
       else
       {
         $("#"+idtextcantidad+"").val(1);/*la cantidad se vuelve 1 porque escogio cantidad fuera de stock*/
         subtotalprod=precVenta*1;/*hacemos el calculo multiplicado por uno*/
         $("#"+idtextsubtotal+"").val(subtotalprod.toFixed(2));/*ponemos el sobtotal multiplicado por uno*/
         sumarTotalPrecio();/*FUNCION QUE SUMA EL MONTO TOTAL DE LA VENTA*/
 
        swal({
             title:"La cantidad supera el Stock",
             text: "¡Solo hay "+stockTotal+" unidades!",
             type: "error",
             confirmButtonText: "¡Cerrar!"
        });

       }
  }

 // function funcionsubtotal(subtotal)
 // {
 //  alert(subtotal);
 // }

 /* function ejecutarfunciondedecalculo()
  {
    // txtcantidad.oninput = function() {
    // var cantidadprod=txtcantidad.value;
    //  };
  preciovendido.oninput = function() {
    console.log(preciovendido.value);
  };
  }*/
  /*=============================FUNCION QUE GUARDA LA VENTA=================================*/
   $(document).ready(function() { 
   $("#btnguardarventa").on('click', function() {
  
   var formDataVenta = new FormData(); 
   var totaldeprodventa=arrayIdproductosVenta.length;
   var btnguardarventa=$('#btnguardarventa').val();
   var slectcli=$('#slectcli').val();
   var montoventatotal=$("#totalMontoventa").val();
   var textiduser=$("#textiduser").val();
   var texttipouser=$("#texttipouser").val();
   
   var switchfactura="";

   if ( (totaldeprodventa<0) ) 
   {
     setTimeout(function(){  }, 2000); swal('ATENCION','No hay productos seleccionados, selecione uno','warning'); 
     
     
   }
   else/*por falso guardamos la venta*/
   {
     /*cargamos las nueva variables a a los parametros que se enviara al archivo php que registra*/
    var Cheq1=document.getElementById("checkfact").checked
          if (Cheq1==false) 
          {
            formDataVenta.append("checkfact",'null');
            switchfactura="no";
          }
          else
          {
            if (Cheq1==true) 
            {
              formDataVenta.append("checkfact",'true');
              switchfactura="si";
            }
          }
     formDataVenta.append('btnguardarventa',btnguardarventa);
     formDataVenta.append('montoventatotal',montoventatotal);
     formDataVenta.append('textiduser',textiduser);
     formDataVenta.append('slectcli',slectcli);
     formDataVenta.append('texttipouser',texttipouser);
      $.ajax({ url: 'controladores/venta.controlador.php', 
               type: 'post', 
               data: formDataVenta, 
               contentType: false, 
               processData: false, 
               success: function(response) { 
                //console.info(response);
        /*PREGUNTAMOS SI LA RESPUESTA ES MAYOR A CERO, OSEA ES EL ID DE LA VENTA, SE REGISTRA EL DETALLE VENTA*/
                  if (response>0) 
                  {
                           var contadorid=0;
                           var idventa=response;
                           while(contadorid<totaldeprodventa)
                           {
                            var idtextidentificado="txtidenti"+arrayIdproductosVenta[contadorid];/*obtenemos el id del txt identificador*/
                            var idtextcantidadprod="txtcantidad"+arrayIdproductosVenta[contadorid];/*obtenemos el id del txt cantidad*/
                            var idtextsubtotalprod="precVenta"+arrayIdproductosVenta[contadorid];/*obtenemos el id del txt subtotal venta*/

                            var idproductoventa=arrayIdproductosVenta[contadorid];
                            var textidentificador=$("#"+idtextidentificado+"").val();
                            var textcantidadprod=$("#"+idtextcantidadprod+"").val();
                            var textsubtotal=$("#"+idtextsubtotalprod+"").val();
                            var formDataVentaProd = new FormData();
                           
                            formDataVentaProd.append('idproductoventa',idproductoventa);
                            formDataVentaProd.append('textidentificador',textidentificador);
                            formDataVentaProd.append('textcantidadprod',textcantidadprod);
                            formDataVentaProd.append('textsubtotal',textsubtotal);
                            formDataVentaProd.append('idventa',idventa);
                            formDataVentaProd.append('switchfactura',switchfactura);
                            
                               $.ajax({ url: 'controladores/ventaProducto.controlador.php', 
                                     type: 'post', 
                                     data: formDataVentaProd, 
                                     contentType: false, 
                                     processData: false, 
                                     success: function(response) { 
                                      console.info(response);
                                     
                                        // if (response==1) 
                                        // {
                                          
                                        //   setTimeout(function(){ location.href='marcas'; }, 2000); swal('EXELENTE','','success'); 
                                           
                                        // }
                                        // else
                                        // {
                                        //   setTimeout(function(){  }, 2000); swal('ERROR','Intente nuevamente','error');
                                                             
                                        // } 
                                      }
                                  }); 

                             contadorid++;
                           }/*fin del while*/

                    
                  setTimeout(function(){ location.href='crear-ventas'; }, 1000); swal('EXELENTE','','success');    
                  }/*FIN DEL IF QUE INSERTA EL DETALLE DE VENTA*/
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
/*=========================================================================================*/
/*========================================================================================*/
</script>



