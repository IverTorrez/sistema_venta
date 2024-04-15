<?php

include_once("../modelos/ventaProducto.modelo.php");
include_once("../modelos/compraProducto.modelo.php");

if (isset($_POST["idproductoventa"]))/*preguntamos si la variable idproductosventa no esta vacia*/ 
{
	ctrlguardarVentaProducto();
}

/*=============================CREACIONES DE OBJETOS=====================================*/


   function ctrlguardarVentaProducto()
   {

   	        $objvp=new VentaProducto();
        	//$resultvp=$objvp->mostrarPrecioVentadeProducto($_POST['idproductoventa']);
        	//$filpv=mysqli_fetch_object($resultvp);
        	//$precioventaProd=$filpv->precio_venta;
        	//$precioCompraProd=$filpv->precio_compra;
        	$precioUnitario=$_POST['textsubtotal']/$_POST['textcantidadprod'];/*obtenemos el precio unitario*/
        	//$stokfacturadoProd=$filpv->stok_facturado;


/*obtenemos los datos de la compra del producto, precio compra, precio compra facturada y stock actual*/
        	$resultPrecioCOmpraProd=$objvp->mostrarDetallesDeCompraProducto($_POST['idproductoventa']);
        	$filprecioComProd=mysqli_fetch_object($resultPrecioCOmpraProd);
        	$precioCOmpraProd=$filprecioComProd->precio_unit_compra;
        	$precioCompraProdFact=$filprecioComProd->precio_unit_compraFacturado;
        	$stockActualComProd=$filprecioComProd->stock_actual;
        	$precioventaFactEstablecido=$filprecioComProd->precio_venta_prod_Fact;
        	$precioventaEstable=$filprecioComProd->precio_venta_prod;


        	/*VERIFICAMOS SI el producto que se esta vendiendo se compro facturado*/
        	$resultVerid=$objvp->verificadorCompraFacturada($_POST['idproductoventa']);
        	$filveri=mysqli_fetch_object($resultVerid);
        	$switchComprafac=$filveri->switFacturado;
        	$precioCompraProdReal=0;
        	$precioVentaEstablecido=0;
        	
        	if ($switchComprafac=="si")/*por verdadero asignamos el precio compra facturada*/ 
        	{
        		$precioCompraProdReal=$precioCompraProdFact;
 ///////////////////////	//$precioVentaEstablecido=$precioventaFactEstablecido;
        		
        	}
        	else/*por falso asignamos el precio compra normal*/
        	{
        		$precioCompraProdReal=$precioCOmpraProd;
   ///////////////////////////$precioVentaEstablecido=$precioventaEstable;
        		
        	}
        	/*FIN DE LA VERIFICACION SI ES UNA COMPRA FACTURADA*/
   	
        $porcentajeFacturaVenta=0;
        $precioFactura=0;
        $switchfac=$_POST['switchfactura'];
        /*verificamos si es venta facturada*/
        if ($switchfac=="si") 
        {
        /*preguntamos si el producto tiene en stock compra facturada, para cobrar el 13 %, por falso cobraremos el 16%*/
          $precioVentaEstablecido=$precioventaFactEstablecido;

	 	      if ($switchComprafac=="si") 
	 	      {
	 	      	$porcentajeFacturaVenta=3;
	 	      	$precioFactura=$precioventaFactEstablecido-$precioventaEstable;
	 	      }
	 	      else/*por falso,osea en stock no tiene compra facturada,se cobrara el 16%*/
	 	      {
                $porcentajeFacturaVenta=16;
	 	      	$precioFactura=($precioventaEstable/100)*16;
	 	      }
        }
        else
        {
          $precioVentaEstablecido=$precioventaEstable;
        }
	   	$objventa=new VentaProducto();
	   	$objventa->set_codigoProducto($_POST['textidentificador']);
	   	$objventa->set_subtotal($_POST['textsubtotal']);
	   	$objventa->set_cantidadProd($_POST['textcantidadprod']);
	   	$objventa->set_ventaPfacturado(0);/*es el porcentaje que se factura,(parece)*/
	   	$objventa->set_precioFactura(0);/*es el precio de la factura de un producto*/
	   	$objventa->set_idCompraProducto($_POST['idproductoventa']);
	   	$objventa->set_idVenta($_POST['idventa']);
	   	$objventa->set_PrecioUniTarioVenta($precioUnitario);/*ES EL PRECIO QUE SE ESTA VENDIENDO*/
	   	$objventa->set_PrecioCompraProd($precioCompraProdReal);
	   	$objventa->set_PrecioVentaEstablecido($precioVentaEstablecido);
        $objventa->set_estadoVentaProd("Activo");
	   	if ($objventa->guardarVentaProducto()) 
	   	{
	   		/*HECHA LA VENTA REDUCIMOS EL STOCK DEL LOTE DEL PRODUCTO*/
	   		$objComPProd=new Compra_Producto();
            $resultStock=$objComPProd->mostrarStockActualDeCompraProd($_POST['idproductoventa']);
            $filstock=mysqli_fetch_object($resultStock);
            $stockActualizado=($filstock->stock_actual)-($_POST['textcantidadprod']);

            if ($objComPProd->actualizarStockDeLoteProd($stockActualizado,$_POST['idproductoventa'])) 
            {
            	echo 1;
            }

	   		
	   		
	   	}
	   	else
	   	{
	   		echo 0;
	   	}
   }

   

   



?>