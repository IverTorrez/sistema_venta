<?php
include_once("../modelos/sucursal.modelo.php");

	/*CONTROLADOR DE INGRESO DE USUARIOS*/
if (isset($_POST["btnguardarcli"])) 
{
	ctrlRegSucursal();
}
if (isset($_POST["btneditcli"])) 
{

	ctrlActuslizarSucursal();

}

if (isset($_POST["btnelimcli"])) 
{
	ctrlDarBajaSucursal();
}


	 function ctrlRegSucursal()
	 {
		
			$obj=new Sucursal();
			$obj->set_nombreSuc($_POST["nuevoNombre"]);
			$obj->set_descripcionSuc($_POST["nuevoDescripcion"]);
			$obj->set_Contacto($_POST["nuevoContacto"]);
			$obj->set_estadoSuc("Activo");
			
			if ($obj->guardarSucursal()) 
			{
				echo 1;
			}else
			{
				echo 0;
			}	
	}

	function ctrlActuslizarSucursal()
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

	function ctrlDarBajaSucursal()
	{
		$obj=new Sucursal();	
		if ($obj->DarBajaSucursal($_POST["idsucelim"])) 
			{
				echo 1;
			}else
			{
				echo 0;
			}
	}
?>