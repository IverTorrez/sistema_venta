<?php
include_once("../modelos/proveedor.modelo.php");

if (isset($_POST["btneditProv"])) 
{
	ctrlEditProveedor();
}
if (isset($_POST["btnguardarProv"])) 
{
  ctrlGuardarProveedor();	
}
if (isset($_POST["btneliprov"])) 
{
	ctrlDarBajaProveedor();
}


   function ctrlGuardarProveedor()
   {
	   	$obj=new Proveedor();
	   	$obj->set_nombreProveedor($_POST["nuevoNombre"]);
	   	$obj->set_apellidoProveedor($_POST["nuevoApellido"]);
	   	$obj->set_TelefonoProveedor($_POST["nuevoTelefono"]);
	   	$obj->set_ObservacionProveedor($_POST["textobservacion"]);
	   	$obj->set_estadoProveedor("Activo");
	   	
	   	if ($obj->guardarProveedor()) 
	   	{
	   		echo 1;
	   	}
	   	else
	   	{
	   		echo 0;
	   	}
   }

   function ctrlEditProveedor()
   {
   	 $obj=new Proveedor();
   	 $obj->set_nombreProveedor($_POST["editNombre"]);
   	 $obj->set_apellidoProveedor($_POST["editApellido"]);
   	 $obj->set_TelefonoProveedor($_POST["editTelefono"]);
   	 $obj->set_ObservacionProveedor($_POST["editobservacion"]);
   	 $obj->setid_proveedor($_POST["idProvedit"]);
   	 if ($obj->actualizarProveedor()) 
	   	{
	   		echo 1;
	   	}
	   	else
	   	{
	   		echo 0;
	   	}

   }

   function ctrlDarBajaProveedor()
   {
   	$objcat=new Proveedor();
   	$objcat->setid_proveedor($_POST["idProvelim"]);
   	$objcat->set_estadoProveedor("Inactivo");
   	if ($objcat->DarBajaProveedor()) 
	   	{
	   		echo 1;
	   	}
	   	else
	   	{
	   		echo 0;
	   	}

   }



?>