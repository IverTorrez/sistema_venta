<?php
include_once("../modelos/empleado.modelo.php");
include_once("../modelos/administrador.modelo.php");

	/*CONTROLADOR DE INGRESO DE USUARIOS*/
if (isset($_POST["btnguardaremp"])) 
{
    if ($_POST["selecttipousu"]=="vendedor") 
    {
    	ctrlRegEmpleado();
    }
    if ($_POST["selecttipousu"]=="admin") 
    {
    	ctrlGuardarAdmin();
    }	
}



if (isset($_POST["btneditemp"])) 
{
	if ($_POST["tipouser"]=="vendedor") 
	{
		ctrlActuslizarEmpleado();
	}
	if ($_POST["tipouser"]=="admin") 
	{
		ctrlActualizarAdmin();
	}
	
}


if (isset($_POST["btnelimemp"])) 
{
	if ($_POST["tipouserelim"]=="vendedor") 
	{
		ctrlDarBajaEmpleado();
	}
	if ($_POST["tipouserelim"]=="admin")
	{
       ctrlDarBajaAdmin();
	}
	
	
}


	 function ctrlRegEmpleado()
	 {
		
			$objemp=new Empleado();
			$objemp->set_nombreEmplado($_POST["nuevoNombre"]);
			$objemp->set_apellidoEmpleado($_POST["nuevoApellido"]);
			$objemp->set_TelefonoEmpleado($_POST["nuevoTelefono"]);
			$objemp->set_userNameEmpl($_POST["nuevoUsuario"]);
			$objemp->set_passwordEmpleado($_POST["nuevoPassword"]);
			$objemp->set_observacionEmpleado($_POST["observacion"]);
			$objemp->set_PermisoEspecial($_POST["selecpermiso"]);
			$objemp->set_estadoEmpleado("Activo");
			if ($objemp->guardarEmpleado()) 
			{
				echo 1;
			}else
			{
				echo 0;
			}	
	}

	function ctrlActuslizarEmpleado()
	{
		$objemp=new Empleado();
		$objemp->setid_empleado($_POST["idempedit"]);
		$objemp->set_nombreEmplado($_POST["editNombre"]);
	    $objemp->set_apellidoEmpleado($_POST["editApellido"]);
		$objemp->set_TelefonoEmpleado($_POST["editTelefono"]);
		$objemp->set_userNameEmpl($_POST["editUsuario"]);
		$objemp->set_passwordEmpleado($_POST["editPassword"]);
		$objemp->set_observacionEmpleado($_POST["editobservacion"]);
		$objemp->set_PermisoEspecial($_POST["selecpermisoedit"]);
		if ($objemp->actualizarEmpleado()) 
			{
				echo 1;
			}else
			{
				echo 0;
			}	
	}

	function ctrlDarBajaEmpleado()
	{
		$objemp=new Empleado();
		$objemp->setid_empleado($_POST["idempelim"]);
		$objemp->set_estadoEmpleado("Inactivo");
		if ($objemp->DarBajaEmpleado()) 
			{
				echo 1;
			}else
			{
				echo 0;
			}
	}
/*========================FUNCIONES PARA EL USUARIO ADMINISTRADOR======================*/
	function ctrlGuardarAdmin()
	{
		$objadmin=new Administrador();
		$objadmin->set_nombreAdmin($_POST["nuevoNombre"]);
		$objadmin->set_apellidoAdmin($_POST["nuevoApellido"]);
		$objadmin->set_TelefonoAdmin($_POST["nuevoTelefono"]);
		$objadmin->set_userNameAdmin($_POST["nuevoUsuario"]);
		$objadmin->set_passwordAdmin($_POST["nuevoPassword"]);
		$objadmin->set_observacionAdmin($_POST["observacion"]);
		$objadmin->set_estadoAdmin("Activo");
		if ($objadmin->guardarAdmin()) 
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}


	function ctrlActualizarAdmin()
	{
		$objadmin=new Administrador();
		$objadmin->setid_admin($_POST["idempedit"]);
		$objadmin->set_nombreAdmin($_POST["editNombre"]);
		$objadmin->set_apellidoAdmin($_POST["editApellido"]);
		$objadmin->set_TelefonoAdmin($_POST["editTelefono"]);
		$objadmin->set_userNameAdmin($_POST["editUsuario"]);
		$objadmin->set_passwordAdmin($_POST["editPassword"]);
		$objadmin->set_observacionAdmin($_POST["editobservacion"]);
		if ($objadmin->actualizarAdmin()) 
		{
			echo 1;
		}
		else
		{
			echo 0;
		}

	}

	function ctrlDarBajaAdmin()
	{
		$objadmin=new Administrador();
		$objadmin->setid_admin($_POST["idempelim"]);
		$objadmin->set_estadoAdmin("Inactivo");
		if ($objadmin->DarBajaAdmin()) 
		{
			echo 1;
		}
		else
		{
			echo 0;
		}

	}


?>
