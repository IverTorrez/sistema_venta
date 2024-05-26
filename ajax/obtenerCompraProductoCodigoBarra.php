<?php
include_once("../modelos/compraProducto.modelo.php");
include_once("../modelos/productos.modelo.php");

if (isset($_GET["codigoBarra"]))
{
    $contadorCompras=0;
    $objcomp=new Compra_Producto();
    $datosCompra;
    $resultcomp=$objcomp->obtenerProductoPorCodigoBarra($_GET["codigoBarra"]);
    while($ejecutar=mysqli_fetch_array($resultcomp))
    {
        $contadorCompras++;
        $datosCompra=$ejecutar;
    }
    if($contadorCompras==1)//Si hay una sola compra del producto retorna los datos
    {
        echo json_encode($datosCompra);
    }/*Por falso retorna la cantidad de compras , ya sea cero o mayor a uno */
    else{
      echo  $contadorCompras;
    }
    

            
}

		
?>