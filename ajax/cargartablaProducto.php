<?php
include_once("../modelos/compraProducto.modelo.php");
include_once("../modelos/productos.modelo.php");
$objcomp=new Compra_Producto();
$resultcomp=$objcomp->mostrarDetallesDeProductoDeUnaCOmpra($_POST["idcompraprod"]);
// $filacomp=mysqli_fetch_object($resultcomp);


// $id_producto=$_POST["id_producto"];
// $objprod=new Producto();
// $resultado=$objprod->mostrarUnProducto($id_producto);

		



		$ejecutar=mysqli_fetch_array($resultcomp);
		echo json_encode($ejecutar);
		
?>