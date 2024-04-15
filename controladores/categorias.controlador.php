<?php
include_once("../modelos/categorias.modelo.php");

if (isset($_POST["btneditCat"])) 
{
	ctrlEditCategoria();
}
if (isset($_POST["btnguardarCat"])) 
{
  ctrlGuardarCategoria();	
}
if (isset($_POST["btnelimCat"])) 
{
	ctrlDarBajaCategoria();
}


   function ctrlGuardarCategoria()
   {
	   	$objcat=new Categoria();
	   	$objcat->set_nombreCategoria($_POST["nuevoNombre"]);
	   	$objcat->set_estadoCategoria("Activo");
	   	if ($objcat->guardarCategoria()) 
	   	{
	   		echo 1;
	   	}
	   	else
	   	{
	   		echo 0;
	   	}
   }

   function ctrlEditCategoria()
   {
   	 $objcat=new Categoria();
   	 $objcat->set_nombreCategoria($_POST["editNombre"]);
   	 $objcat->setid_categoria($_POST["idcatedit"]);
   	 if ($objcat->actualizarCategoria()) 
	   	{
	   		echo 1;
	   	}
	   	else
	   	{
	   		echo 0;
	   	}

   }

   function ctrlDarBajaCategoria()
   {
   	$objcat=new Categoria();
   	$objcat->setid_categoria($_POST["idCatelim"]);
   	$objcat->set_estadoCategoria("Inactivo");
   	if ($objcat->DarBajaCategoria()) 
	   	{
	   		echo 1;
	   	}
	   	else
	   	{
	   		echo 0;
	   	}

   }



?>