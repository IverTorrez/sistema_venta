<?php
include_once("../modelos/almacen.modelo.php");

if (isset($_POST["btnguardaralmacen"])) 
{
  ctrlGuardarAlmacen();	
}
if (isset($_POST["btneditAlmacen"])) 
{
	ctrlEditAlmacen();
}

if (isset($_POST["btnelimalmacen"])) 
{
	ctrlDarBajaAlmacen();
}


   function ctrlGuardarAlmacen()
   {
   	     ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;

	   	$objalm=new Almacen();
	   	$objalm->set_nombreAlmacen($_POST["nuevoNombre"]);
	   	$objalm->set_usuarioAlta($_POST["idusuario"]);
	   	$objalm->set_fechaAlta($fechaHora);
	   	$objalm->set_estado('Activo');
	   	$objalm->set_usuarioBaja(0);
	   	$objalm->set_fechaBaja('');
	   	if ($objalm->guardarAlmacen()) 
	   	{
	   		echo 1;
	   	}
	   	else
	   	{
	   		echo 0;
	   	}
   }

   function ctrlEditAlmacen()
   {
   	 $objmar=new Almacen();
   	 $objmar->set_nombreAlmacen($_POST["editNombre"]);
   	 $objmar->setid_almacen($_POST["idalmacenedit"]);
   	 if ($objmar->actualizarAlmacen()) 
	   	{
	   		echo 1;
	   	}
	   	else
	   	{
	   		echo 0;
	   	}

   }

   function ctrlDarBajaAlmacen()
   {
   	     ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;

   	$objmar=new Almacen();
   	$objmar->setid_almacen($_POST["idalmacenelim"]);
   	$objmar->set_estado("Inactivo");
   	$objmar->set_usuarioBaja($_POST["usuarioelim"]);
   	$objmar->set_fechaBaja($fechaHora);
   	if ($objmar->DarBajaAlmacen()) 
	   	{
	   		echo 1;
	   	}
	   	else
	   	{
	   		echo 0;
	   	}

   }



?>