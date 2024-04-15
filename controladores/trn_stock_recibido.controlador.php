<?php
include_once("../modelos/Trn_stock_recibido.modelo.php");
include_once("../modelos/compraProducto.modelo.php");
	/*CONTROLADOR DE INGRESO DE USUARIOS*/
if (isset($_POST["btnguardartrnrecibido"])) 
{
	ctrlRegTrnStockRecibido();
}
if (isset($_POST["btnelimrecibido"])) 
{

	ctrlDarBajaTrnRecibido();

}
/*
if (isset($_POST["btnelimcli"])) 
{
	ctrlDarBajaSucursal();
}*/


	function ctrlRegTrnStockRecibido()
	{
		 ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;
         /*SE ACTUALIZA EL STOCK DEL PRODUCTO*/
         $objcomp=new Compra_Producto();
         $resultstock=$objcomp->mostrarStockActualDeCompraProd($_POST["selectidprod"]);
         $filastock=mysqli_fetch_object($resultstock);
         $stockActualprod=$filastock->stock_actual;
        
         	/*ATUALIZAMOS EL STOCK DEL PRODUCTO*/
			$stocActualizado=$stockActualprod+$_POST["cantRecibido"];
			$objcomp->actualizarStockDeLoteProd($stocActualizado,$_POST["selectidprod"]);

			$obj=new Trans_Stock_recibido();
			$obj->set_fecha_trn_recibido($fechaHora);
			$obj->set_idCompraProducto($_POST["selectidprod"]);
			$obj->set_cantidad_recibido($_POST["cantRecibido"]);
			$obj->set_estado_trn_recibido("recibido");			
			$obj->set_descripTrnRecibido($_POST["descrip_recibido"]);
			$obj->set_idSucursalOrigen($_POST["selectSucursal"]);
			$obj->set_cod_envio($_POST["codEnvio"]);
			
			if ($obj->guardarTrnStockRecibido()) 
			{
				echo 1;
			}else
			{
				echo 0;
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
	function ctrlDarBajaTrnRecibido()
	{
		$obj=new Trans_Stock_recibido();
		/*obtenemos los datos de la transaccion recibida para actualizar el stock del producto*/
		$resultprod=$obj->mostrarDetalleDeUnRecibido($_POST["idrecibido"]);
		$filaprod=mysqli_fetch_object($resultprod);	
		$id_compra_producto=$filaprod->id_compra_producto;
		$cantidad_recibida=$filaprod->cantidad_recibida;
          /*obtenemos el stock actual del producto*/
		 $objcomp=new Compra_Producto();
         $resultstock=$objcomp->mostrarStockActualDeCompraProd($id_compra_producto);
         $filastock=mysqli_fetch_object($resultstock);
         $stockActualprod=$filastock->stock_actual;
         /*actualizamos el stock*/
         $stocActualizado=$stockActualprod-$cantidad_recibida;
		 $objcomp->actualizarStockDeLoteProd($stocActualizado,$id_compra_producto);

		if ($obj->DarBajaRecibido($_POST["idrecibido"])) 
			{
				echo 1;
			}else
			{
				echo 0;
			}
	}
?>