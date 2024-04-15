<?php
include_once("../modelos/Trn_stock_envio.modelo.php");
include_once("../modelos/compraProducto.modelo.php");
	/*CONTROLADOR DE INGRESO DE USUARIOS*/
if (isset($_POST["btnguardartrnenvio"])) 
{
	ctrlRegTrnStockEnvio();
}
if (isset($_POST["btnelimEnvio"])) 
{

	ctrlDarBajaTrnEnvio();

}
/*
if (isset($_POST["btnelimcli"])) 
{
	ctrlDarBajaSucursal();
}*/


	function ctrlRegTrnStockEnvio()
	{
		 ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;
         /*Validaciones antes de hacer el envio de mercaderia de una tienda a otra*/
         /*Que tenga cantidad en stok mayor o igual a la cantidad enviada*/
         $objcomp=new Compra_Producto();
         $resultstock=$objcomp->mostrarStockActualDeCompraProd($_POST["selectidprod"]);
         $filastock=mysqli_fetch_object($resultstock);
         $stockActualprod=$filastock->stock_actual;
         if ($stockActualprod>=$_POST["cantEnvio"]) 
         {
         	/*ATUALIZAMOS EL STOCK DEL PRODUCTO*/
			$stocActualizado=$stockActualprod-$_POST["cantEnvio"];
			$objcomp->actualizarStockDeLoteProd($stocActualizado,$_POST["selectidprod"]);

			$obj=new Trans_Stock_envio();
			$obj->set_fecha_trn_envio($fechaHora);
			$obj->set_cantidad_envio($_POST["cantEnvio"]);
			$obj->set_estado_trn_envio("enviado");
			$obj->set_idCompraProducto($_POST["selectidprod"]);
			$obj->set_descripTrnEnvio($_POST["descrip_envio"]);
			$obj->set_idSucursalDestino($_POST["selectSucursal"]);
			
			if ($obj->guardarTrnStockEnvio()) 
			{
				echo 1;
			}else
			{
				echo 0;
			}
	     }/*FIN DE LA VALIDACION SI EL STOCK ES MAYOR IGUAL A LA CNTIDAD ENVIADA*/	
	     else
	     {
	     	echo 2;/*se indica que el stock no es suficiente para el envio*/
	     }

	}

	/*function ctrlActuslizarSucursal()
	{
		$obj=new Sucursal();
		$obj->set_nombreSuc($_POST["editNombre"]);
		$obj->set_descripcionSuc($_POST["editDescripcion"]);
	    $obj->set_Contacto($_POST["editContacto"]);
		
		if ($obj->actualizarSucursal($_POST["idsucedit"])) 
			{
				echo 1;
			}else
			{
				echo 0;
			}	
	}
*/
	function ctrlDarBajaTrnEnvio()
	{
		$obj=new Trans_Stock_envio();
		/*obtenemos los datos del envio para actualizar el stock del producto*/
		$resultprod=$obj->mostrarDetalleDeUnEnvio($_POST["idenvio"]);
		$filaprod=mysqli_fetch_object($resultprod);	
		$id_compra_producto=$filaprod->id_compra_producto;
		$cantidad_enviada=$filaprod->cantidad_envio;
          /*obtenemos el stock actual del producto*/
		 $objcomp=new Compra_Producto();
         $resultstock=$objcomp->mostrarStockActualDeCompraProd($id_compra_producto);
         $filastock=mysqli_fetch_object($resultstock);
         $stockActualprod=$filastock->stock_actual;
         /*actualizamos el stock*/
         $stocActualizado=$stockActualprod+$cantidad_enviada;
		 $objcomp->actualizarStockDeLoteProd($stocActualizado,$id_compra_producto);

		if ($obj->darBajarTrnEnvio($_POST["idenvio"])) 
			{
				echo 1;
			}else
			{
				echo 0;
			}
	}
?>