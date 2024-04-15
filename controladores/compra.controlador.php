<?php

include_once("../modelos/compra.modelo.php");
include_once("../modelos/compraProducto.modelo.php");
include_once("../modelos/productos.modelo.php");
include_once("../modelos/ventaProducto.modelo.php");


if (isset($_POST["btnguardarCompra"])) 
{
	ctrlGuardarCompra();
}

if (isset($_POST["btnelimcomp"])) 
{
	eliminarCompra();
}
if (isset($_POST["btnguardarCompraEdit"]))
{
	ctrlEditarCompra();
}


   function ctrlGuardarCompra()
   {
   	#verificamos si la compra es facturada
   	   /* if ($_POST["checkfact"]=="true") 
   	    {
   	    	$sw_facura="si";
   	    }
   	    else
   	    {
   	    	if ($_POST["checkfact"]=="null") 
   	    	{
   	    		$sw_facura="no";
   	    	}
   	    }*/
   	    $sw_facura="no";
   	    ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;

         $montoCompra=$_POST["nuevoCostoComp"]*$_POST["nuevoCantidad"];

	   	$objcomp=new Compra();
	   	$objcomp->set_fechaCompra($fechaHora);
	   	$objcomp->set_montoCompra($montoCompra);
	   	$objcomp->set_CompraFacturada($sw_facura);
	   	$objcomp->set_CostoFactura(0);
	   	$objcomp->set_idAdmin($_POST["idadmin"]);
	   	$objcomp->set_tipoReg($_POST["tipo_user"]);
	   	$objcomp->set_idProveedor($_POST["selectprov"]);
        $objcomp->set_estadoCompra("Activo");
	   	if ($objcomp->guardarCompra()) 
	   	{
	   		#SE REGISTRA LA TERCER TABLA COMPRA_PRODUCTO
	   		$resultultima=$objcomp->mostrarUltimaCompra();
	   		$filaul=mysqli_fetch_object($resultultima);
	   		$idutimacompra=$filaul->idultimacompra;

	   		$objCP=new Compra_Producto();
	   		$objCP->set_subtotalCompra($montoCompra);
	   		$objCP->set_cantidadCompra($_POST["nuevoCantidad"]);
	   		$objCP->set_idCompra($idutimacompra);
	   		$objCP->set_idProducto($_POST["selectprod"]);
	   		$objCP->set_precioUnitCompra($_POST["nuevoCostoComp"]);
	   		$objCP->set_precioUnitCompraFactu(0);
	   		$objCP->set_precioVentaProd($_POST["nuevoCostoVenta"]);
	   		$objCP->set_precioVentaProduFact($_POST["nuevoCostoVFact"]);
	   		$objCP->set_stockActual($_POST["nuevoCantidad"]);
	   		$objCP->set_precioTope($_POST["nuevoCostoTope"]);
	   		$objCP->set_estadoCompProd("Activo");
	   		if ($objCP->guardarCompraProducto()) 
	   		{

	   			// $objprod=new Producto();
       //          $resultprod=$objprod->mostrarStockSimpleYFacturadorDeProducto($_POST["selectprod"]);
       //          $filprod=mysqli_fetch_object($resultprod);
       //          $stokSimple=$filprod->stock_simple;
       //          $stockFacturado=$filprod->stok_facturado;

	   			// $objprod->set_PrecioCompra($_POST["nuevoCostoComp"]);
	   			// $objprod->set_precioCompraFactu($_POST["nuevoCostoCompFact"]);
	   			// $objprod->set_PrecioVenta($_POST["nuevoCostoVenta"]);
	   			// $objprod->set_PrecioFacturado($_POST["nuevoCostoVFact"]);
	   			// $objprod->set_PrecioTope($_POST["nuevoCostoTope"]);
	   			// $objprod->setid_producto($_POST["selectprod"]);
	   			// if ($objprod->ponerPreciosAProducto()) 
	   			// {
	   			// 	#actualizamos el stok del produto
	   				
	   			// 	$objprod->setid_producto($_POST["selectprod"]);
	   			// 	#preguntamos si esta tiqueado la compra facturada, por verdadero, actualizamos stok facturado
	   			// 	if ($sw_facura=="si") 
	   			// 	{
	   			// 		$nuevoStockFact=$stockFacturado+$_POST["nuevoCantidad"];
	   			// 		$objprod->set_StokFacturado($nuevoStockFact);
	   			// 		if ($objprod->actualizarStokFacturado()) 
	   			// 		{
	   			// 			echo 1;
	   			// 		}
	   					
	   			// 	}
	   			// 	#por falso, osea no es una compra facturada, actualizamos el stok simple
	   			// 	else
	   			// 	{
	   			// 		$nuevoStockSimple=$stokSimple+$_POST["nuevoCantidad"];
	   			// 		$objprod->set_StokSimple($nuevoStockSimple);
	   			// 		if ($objprod->actualizarStokSimple()) 
	   			// 		{
	   			// 			echo 1;
	   			// 		}
	   					
	   			// 	}

	   				
	   				
	   			// }
	   			echo 1;
	   			
	   		}
	   		
	   	}
	   	else
	   	{
	   		echo 0;
	   	}
   }

   

   function eliminarCompra()
   {
   	ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;
   	#validacion que no se haya echo alguna venta de esta compra(es decir, que no se haya vendido algun producto)
      $objventap=new VentaProducto();
      $resultvent=$objventap->mostrarCantidadVentasDeCodCompra($_POST["idcompra"]);
      $filvent=mysqli_fetch_object($resultvent);
      if ($filvent->cantidad_ventas>0) 
      {
      	echo 2;//muestra la alerta que indica que hay ventas con el codigo de lote(id_compra_producto)
      }
      else//por falso elimina 
      {
   	/*-------------CUANDO LA COMPRA FUE FACTURADA -------------*/
	   	if ($_POST["compfacturada"]=="si") 
	   	{
	   		/*$objprod=new Producto();

	   		$resultstok=$objprod->mostrarStockSimpleYFacturadorDeProducto($_POST["idproducto"]);
	   		$filstok=mysqli_fetch_object($resultstok);
	   		$nuevoStokfacturado=$filstok->stok_facturado-$_POST["cantCompra"];

	   		$objprod->set_StokFacturado($nuevoStokfacturado);
	   		$objprod->setid_producto($_POST["idproducto"]);
	   		if ($objprod->actualizarStokFacturado()) 
	   		{*/
	   			$objcompProd=new Compra_Producto();
	   			$objcompProd->set_idCompra($_POST["idcompra"]);
	   			if ($objcompProd->eliminarCompraProductoDeCompra()) 
	   			{
	   				$objcomp=new Compra();
	   				$objcomp->set_estadoCompra('Inactivo');
	   				$objcomp->set_usuarioBaja($_POST["idadmin_elim"]);
	   				$objcomp->set_fechaBaja($fechaHora);
	   				$objcomp->setid_compra($_POST["idcompra"]);
	   				if ($objcomp->eliminarCompra()) 
	   				{
	   					echo 1;
	   				}
	   				else
	   				{
	   					echo 0;
	   				}
	   			}
	   		//}
	   	}

	   	else
	   	{
	   		/*$objprod=new Producto();

	   		$resultstok=$objprod->mostrarStockSimpleYFacturadorDeProducto($_POST["idproducto"]);
	   		$filstok=mysqli_fetch_object($resultstok);
	   		$nuevoStoksimple1=$filstok->stock_simple-$_POST["cantCompra"];

	   		$objprod->set_StokSimple($nuevoStoksimple1);
	   		$objprod->setid_producto($_POST["idproducto"]);
	   		if ($objprod->actualizarStokSimple()) 
	   		{*/
	   			$objcompProd=new Compra_Producto();
	   			$objcompProd->set_idCompra($_POST["idcompra"]);
	   			if ($objcompProd->eliminarCompraProductoDeCompra()) 
	   			{
	   				$objcomp=new Compra();	   				
	   				$objcomp->set_estadoCompra('Inactivo');
	   				$objcomp->set_usuarioBaja($_POST["idadmin_elim"]);
	   				$objcomp->set_fechaBaja($fechaHora);
	   				$objcomp->setid_compra($_POST["idcompra"]);
	   				if ($objcomp->eliminarCompra()) 
	   				{
	   					echo 1;
	   				}
	   				else
	   				{
	   					echo 0;
	   				}
	   			}
	   		//}//funcion actualizaStokSImple

	   	}

      }//fin del else cuando no hay ventas con el codigo de compra
   }//fin de la funcion eliminar


   function ctrlEditarCompra()
   {
   	#verificamos si la compra es facturada
   	    /*if ($_POST["checkfactedit"]=="true") 
   	    {
   	    	$sw_facura="si";
   	    }
   	    else
   	    {
   	    	if ($_POST["checkfactedit"]=="null") 
   	    	{
   	    		$sw_facura="no";
   	    	}
   	    }*/
   	    $sw_facura="no";
   	 #validacion que no se haya echo alguna venta de esta compra(es decir, que no se haya vendido algun producto)
      $objventap=new VentaProducto();
      $resultvent=$objventap->mostrarCantidadVentasDeCodCompra($_POST['idcompra_edit']);
      $filvent=mysqli_fetch_object($resultvent);
      if ($filvent->cantidad_ventas>0) 
      {
      	echo 2;//muestra la alerta que indica que hay ventas con el codigo de lote(id_compra_producto)
      }
      else
      {
		   	$montoCompra=$_POST["nuevoCostoCompedit"]*$_POST["nuevoCantidadedit"];
		   	$objcomedit=new Compra();
		   	$objcomedit->set_montoCompra($montoCompra);
		   	$objcomedit->set_CompraFacturada($sw_facura);
		   	$objcomedit->set_idAdmin($_POST['idadmin_edit']);
		   	$objcomedit->set_idProveedor($_POST['selectprovedit']);
		   	
		   	if ($objcomedit->editarCompra($_POST['idcompra_edit'])) 
		   	{
		   		$objComProdedit=new Compra_Producto();
		   		$objComProdedit->set_subtotalCompra($montoCompra);
		   		$objComProdedit->set_cantidadCompra($_POST['nuevoCantidadedit']);
		   		$objComProdedit->set_idProducto($_POST['selectprodedit']);
		   		$objComProdedit->set_precioUnitCompra($_POST['nuevoCostoCompedit']);
		   		$objComProdedit->set_precioUnitCompraFactu(0);
		         $objComProdedit->set_precioVentaProd($_POST['nuevoCostoVentaedit']);
		         $objComProdedit->set_precioVentaProduFact($_POST['nuevoCostoVFactedit']);
		         $objComProdedit->set_stockActual($_POST['nuevoCantidadedit']);
		         $objComProdedit->set_precioTope($_POST['nuevoCostoTopeedit']);

			         if ($objComProdedit->editarCompraProducto($_POST['idcompra_edit'])) 
			         {
			         	echo 1;
			         }
			         else
			         {
			         	echo 0;
			         }
		   	}
   	

      }//fin del else cuando no hay ventas del lote de la compra

   }//fin de la funcion



?>