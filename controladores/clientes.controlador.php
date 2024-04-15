<?php
include_once("../modelos/clientes.modelo.php");

	/*CONTROLADOR DE INGRESO DE USUARIOS*/
if (isset($_POST["btnguardarcli"])) 
{
	ctrlRegCliente();
}
if (isset($_POST["btneditcli"])) 
{
	ctrlActuslizarCliente();
}

if (isset($_POST["btnelimcli"])) 
{
	ctrlDarBajaCliente();
}


	 function ctrlRegCliente()
	 {
		
			$obj=new Cliente();
			$obj->set_nombreCliente($_POST["nuevoNombre"]);
			$obj->set_apellidoCliente($_POST["nuevoApellido"]);
			$obj->set_TelefonoCliente($_POST["nuevoTelefono"]);
			$obj->set_observacionCliente($_POST["observacion"]);
			$obj->set_estadoCliente("Activo");
			
			if ($obj->guardarCliente()) 
			{
				echo 1;
			}else
			{
				echo 0;
			}	
	}

	function ctrlActuslizarCliente()
	{
		$obj=new Cliente();
		$obj->setid_cliente($_POST["idcliedit"]);
		$obj->set_nombreCliente($_POST["editNombre"]);
	    $obj->set_apellidoCliente($_POST["editApellido"]);
		$obj->set_TelefonoCliente($_POST["editTelefono"]);
		$obj->set_observacionCliente($_POST["editobservacion"]);
		if ($obj->actualizarCliente()) 
			{
				echo 1;
			}else
			{
				echo 0;
			}	
	}

	function ctrlDarBajaCliente()
	{
		$obj=new Cliente();
		$obj->setid_cliente($_POST["idclielim"]);
		$obj->set_estadoCliente("Inactivo");
		if ($obj->DarBajaCliente()) 
			{
				echo 1;
			}else
			{
				echo 0;
			}
	}
?>