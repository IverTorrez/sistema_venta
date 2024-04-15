<?php
include_once("../modelos/marca.modelo.php");

if (isset($_POST["btneditMarca"])) 
{
	ctrlEditMarca();
}
if (isset($_POST["btnguardarMarca"])) 
{
  ctrlGuardarMarca();	
}
if (isset($_POST["btnelimMarca"])) 
{
	ctrlDarBajaMarca();
}


   function ctrlGuardarMarca()
   {
	   	$objmar=new Marca();
	   	$objmar->set_nombreMarca($_POST["nuevoNombre"]);
	   	$objmar->set_estadoMarca("Activo");
	   	if ($objmar->guardarMarca()) 
	   	{
	   		echo 1;
	   	}
	   	else
	   	{
	   		echo 0;
	   	}
   }

   function ctrlEditMarca()
   {
   	 $objmar=new Marca();
   	 $objmar->set_nombreMarca($_POST["editNombre"]);
   	 $objmar->setid_marca($_POST["idMarcaedit"]);
   	 if ($objmar->actualizarMarca()) 
	   	{
	   		echo 1;
	   	}
	   	else
	   	{
	   		echo 0;
	   	}

   }

   function ctrlDarBajaMarca()
   {
   	$objmar=new Marca();
   	$objmar->setid_marca($_POST["idMarcaelim"]);
   	$objmar->set_estadoMarca("Inactivo");
   	if ($objmar->DarBajaMarca()) 
	   	{
	   		echo 1;
	   	}
	   	else
	   	{
	   		echo 0;
	   	}

   }



?>