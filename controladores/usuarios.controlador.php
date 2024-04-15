<?php
session_start();
	/*CONTROLADOR DE INGRESO DE USUARIOS*/
include_once("../modelos/administrador.modelo.php");
include_once("../modelos/empleado.modelo.php");

if (isset($_POST["ingUsuario"])) 
{
	ctrlIngresoUsuario();
}
	 function ctrlIngresoUsuario() 
	{
		if (isset($_POST["ingUsuario"])) {

			if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
		        preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])) {
                /*USUARIO ADMINISTRADOR*/
				$objadmin=new Administrador();
				$objadmin->set_userNameAdmin($_POST['ingUsuario']);
				$objadmin->set_passwordAdmin($_POST['ingPassword']);

				$resul1=$objadmin->loginAdmin();
				$datosUsuarioAdmin=array();
                /*USUARIO EMPLEADO*/
				$objemp=new Empleado();
				$objemp->set_userNameEmpl($_POST['ingUsuario']);
				$objemp->set_passwordEmpleado($_POST['ingPassword']);

				$resul2=$objemp->loginEmpleado();
				$datosUsuarioEmp=array();


				if($data=mysqli_fetch_array($resul1))
				{
					$datosUsuarioAdmin["id_administrador"]=$data["id_administrador"];
					$datosUsuarioAdmin["nombre_administrador"]=$data["nombre_administrador"];
					$datosUsuarioAdmin["apellido_administrador"]=$data["apellido_administrador"];
					$datosUsuarioAdmin["telefono_administrador"]=$data["telefono_administrador"];
					
					

					$_SESSION["usuarioAdmin"]=$datosUsuarioAdmin;
					$_SESSION["iniciarSesion"]="ok";
					$_SESSION["tipo_user"]="admin";
			    /*	echo '<script>
			    	        windows.location="inicio";
			    	      </script>';*/

				    echo 1;/*SE DIRECCIONA A LA VISTA PRINCIPAL DEL PROCURADOR*/

						
				}
				else
				{
					if ($dataemp=mysqli_fetch_array($resul2)) 
					{
						$datosUsuarioEmp["id_empleado"]=$dataemp["id_empleado"];
						$datosUsuarioEmp["nombre_empleado"]=$dataemp["nombre_empleado"];
						$datosUsuarioEmp["apellido_empleado"]=$dataemp["apellido_empleado"];
						$datosUsuarioEmp["telefono_empleado"]=$dataemp["telefono_empleado"];
						$datosUsuarioEmp["permiso_especial"]=$dataemp["permiso_especial"];

						$_SESSION["usuarioEmp"]=$datosUsuarioEmp;
						$_SESSION["iniciarSesion"]="ok";
						$_SESSION["tipo_user"]="emp";
						echo 2;
					}
					else
					{
						//	echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>  ';
					    echo 0;/*devuelve cero cuando no se encuentra ningun usuario*/
					}
				
				}

			}
		}
	}

	function listarUsuarios()
	{
		$objadmin=new Administrador();
		//$objadmin->listarAdmin();
		$resultado=$objadmin->listarAdmin();
       while ($fila=mysqli_fetch_object($resultado)) 
              {
                  echo $fila->id_administrador." ";
                  echo $fila->nombre_administrador." ";
                                    
              }
				
	}




?>