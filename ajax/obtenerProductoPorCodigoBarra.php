<?php
include_once("../modelos/productos.modelo.php");

if (isset($_GET["nuevoCodigo"]))
{
    $objcomp=new Producto();
    $resultcomp=$objcomp->mostrarProductoPorCodigoBarra($_GET["nuevoCodigo"]);
    $ejecutar=mysqli_fetch_array($resultcomp);
    
    if($ejecutar)
    {
        echo 1;
    }
    else{
      echo  0;
    }
    

            
}

		
?>