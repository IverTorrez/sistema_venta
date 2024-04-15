<?php
include_once("../modelos/administrador.modelo.php");

	/*CONTROLADOR DE INGRESO DE USUARIOS*/
if (isset($_POST["btnguardaradmin"])) 
{
	ctrlRegAdmin();
}
if (isset($_POST["btneditadmin"])) 
{
	ctrlActualizarAdmin();
}

if (isset($_POST["btnelimadmin"])) 
{
	ctrlDarBajaAdmin();
}


	 function ctrlRegAdmin()
	 {
		
			$obj=new Administrador();
			$obj->set_nombreAdmin($_POST["nuevoNombre"]);
			$obj->set_apellidoAdmin($_POST["nuevoApellido"]);
			$obj->set_TelefonoAdmin($_POST["nuevoTelefono"]);
			$obj->set_userNameAdmin($_POST["nuevoUsuario"]);
			$obj->set_passwordAdmin($_POST["nuevoPassword"]);
			$obj->set_estadoAdmin("Activo");
			if ($obj->guardarAdmin()) 
			{
				echo 1;
			}else
			{
				echo 0;
			}	
	}

	function ctrlActualizarAdmin()
	{
		$obj=new Administrador();
		$obj->setid_admin($_POST["idadminedit"]);
		$obj->set_nombreAdmin($_POST["editNombre"]);
	    $obj->set_apellidoAdmin($_POST["editApellido"]);
		$obj->set_TelefonoAdmin($_POST["editTelefono"]);
		$obj->set_userNameAdmin($_POST["editUsuario"]);
		$obj->set_passwordAdmin($_POST["editPassword"]);
		if ($obj->actualizarAdmin()) 
			{
				echo 1;
			}else
			{
				echo 0;
			}	
	}

	function ctrlDarBajaAdmin()
	{
		$obj=new Administrador();
		$obj->setid_admin($_POST["idadminelim"]);
		$obj->set_estadoAdmin("Inactivo");
		if ($obj->DarBajaAdmin()) 
			{
				echo 1;
			}else
			{
				echo 0;
			}
	}
?>
