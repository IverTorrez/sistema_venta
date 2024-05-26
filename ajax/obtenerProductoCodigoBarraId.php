<?php
include_once("../modelos/productos.modelo.php");

if (isset($_GET["editCodigo"]))
{
    $objcomp=new Producto();
    $resultcomp=$objcomp->mostrarProductoPorCodigoBarraId($_GET["editCodigo"],$_GET["idprodedit"]);
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