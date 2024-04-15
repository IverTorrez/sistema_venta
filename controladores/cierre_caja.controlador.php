<?php
session_start();
include_once("../modelos/cierre_caja.modelo.php");
include_once("../modelos/cierre_caja_venta.modelo.php");
include_once("../modelos/venta.modelo.php");  

if (isset($_POST["btncerrarcaja"])) 
{
	ctrlguardarCierreCaja();
}
 if (isset($_POST["btnelimcerrarcaja"])) 
 {
   ctrlElimCierre();	
 }
// if (isset($_POST["btnelimMarca"])) 
// {
// 	ctrlDarBajaMarca();
// }


   function ctrlguardarCierreCaja()
   {
   	$contador=0;
   	
  try {
  	     $fecha_cierre=$_POST['fecha_cierre'];
         $idempleado=$_POST['idempleado'];
         $idadmin=$_POST['idadmin'];
         $cantVentas=$_POST['cant_ventas'];
        /*verificacion si hay cierre con esa fecha y empleado*/
  	     $objcicja=new Cierre_caja();
  	      $resultcierre=$objcicja->verficacionSiYaHayCierreDefechaDeEmpleado($fecha_cierre,$idempleado);
  	      $filcierre=mysqli_fetch_object($resultcierre);
         if ($filcierre->id_cierre_caja>0)
         {
         	echo 2;//indica que ya hay cierre con esa fecha y ese empleado
         }
         else
         {
       
   	   ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;
         /*verificacion que la fecha de cierre no sea mayor a fecha actual*/
         if ($fecha_cierre>$fecha)
         {
         	echo 3; //indica que la fecha cierre es mayor a la fecha actual
         }
         else
         {
		   	$objcierre=new Cierre_caja();
		   	$objcierre->set_fecha_cierre($fecha_cierre);
		   	$objcierre->set_monto_venta_cierre($_POST['monto_ventas']);
		   	$objcierre->set_monto_caja($_POST['monto_entregado']);
		   	$objcierre->set_monto_sobrante($_POST['monto_sobrante']);
		   	$objcierre->set_cantida_ventas($cantVentas);
		   	$objcierre->set_codigos_ventas($_POST['cod_ventas']);
		   	$objcierre->set_idempleado($idempleado);
		   	$objcierre->set_estado_cierre('Activo');
		   	$objcierre->set_idUsuarioAlta($idadmin);
		   	$objcierre->set_fecha_alta($fechaHora);
		   	$objcierre->set_idUsuarioBaja(0);
		   	$objcierre->set_fecha_baja('');
		   	$objcierre->set_cantidad_productos($_POST['cant_productos']);
		   	if ($objcierre->guardarCierreCaja()) 
		   	{
		   		/*verificacion si hay ventas de esta fecha del empleado*/
		   		if ($cantVentas>0)
		   			{
		   				/*obtenemos el codigo del cierre actual*/
				   		$resulcierre=$objcierre->obtenerUltimocierreUsuario($_POST['idadmin']);
				   		$filacierre=mysqli_fetch_object($resulcierre);
				   		$ultcierre= $filacierre->ultcierre;/*devuelve el codigo del cierre para registrar el detalle*/
			             /*Rrrecorremos la tabla de resultados de ventas*/
			            // $resultablaventas=$_SESSION['resultablacierre'];
			             $obj=new Venta();
			             $resultado=$obj->reporteVentasDeUnEmpleadoParaCierre($fecha_cierre,$idempleado);
			             while ($filaventas=mysqli_fetch_object($resultado)) 
			              {
			              	$objcierreventa=new Cierre_caja_venta();
			               $objcierreventa->set_cierreCaja($ultcierre);
			               $objcierreventa->set_Venta($filaventas->id_venta);
			               $objcierreventa->set_estado('Activo');
			               $objcierreventa->set_idEmpleadocierre($idempleado);
			               $objcierreventa->set_admin($idadmin);
			               $objcierreventa->set_fecha_accion($fecha);
			               $objcierreventa->set_fecha_alta($fechaHora);
			               $objcierreventa->set_idadminBaja(0);
			               $objcierreventa->set_fechaBaja('');
			               if($objcierreventa->guardarCierreCajaVenta())
			                 {
			                    $contador++;
			                 }
			               
			              }//fin del while que recorre todas las ventas del empleado para dar el cierre
	                }//fin del if que pregunta si cantidad de ventas es mayor a cero 0
	              if ($contador==$cantVentas) //preguntamos si se registro todas la ventas  en el cierre
	              {
	              	 echo 1;
	              }
	              else{
	              	 echo 0; 
	              }

		   	}//fin del if cuando se inserta un cierre
		   	else
		   	{
		   		echo 0;
		   	}
         }/*fin del else cuando la fecha cierre no es mayor a la fecha actual*/
       }/*fin del else cuando no hay registros de cierre de una fecha y un empleado*/

	   } catch (Exception $e) {
        echo 'Excepción capturada: ',  $e->getMessage(), "\n";
      }
   }/*fin de funcion */



/*DAR BAJA UN cierre*/
function ctrlElimCierre()
{
	$idcierre=$_POST['id_cierre'];
	$idadmin=$_POST['idusuario_1'];
	$cantventas=$_POST['cant_ventas'];

	      ini_set('date.timezone','America/La_Paz');
         $fecha=date("Y-m-d");
         $hora=date("H:i");
         $fechaHora=$fecha.' '.$hora;

	$objelim=new Cierre_caja();
	$objelim->set_idUsuarioBaja($idadmin);
	$objelim->set_fecha_baja($fechaHora);
	if ($objelim->darBajaCierre($idcierre)) 
	{
		if ($cantventas>0) 
		{
			 $objelimcierreventa=new Cierre_caja_venta();
			 $objelimcierreventa->set_idadminBaja($idadmin);
			 $objelimcierreventa->set_fechaBaja($fechaHora);
			 if ($objelimcierreventa->darBajaCierreCajaVenta($idcierre)) 
			 {
			 	echo 1;///se elimino correctamente
			 }
			 else
			 {
			 	echo 0;//EL detalle no se elimino, favor comunicarse con sistemas
			 }

	   }
	   else
	   {
	   	echo 1;///se elimino correctamente
	   }
	}
	else
	{
		echo 2;
	}

}
 
   



?>