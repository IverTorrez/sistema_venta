 <?php  
include_once('conexion.php');
class Cierre_caja_venta extends Conexion{
	private $id_cierre_caja_venta;
	private $id_cierre_caja;
	private $id_venta;
	private $estado;
	private $id_empleado;
	private $id_admin;
	private $fecha_accion;
	private $fecha_alta;
	private $id_admin_baja;
	private $fecha_baja;

	public function Cierre_caja_venta()
	{
		parent::Conexion();
		$this->id_cierre_caja_venta=0;
		$this->id_cierre_caja=0;
		$this->id_venta=0;
		$this->estado="";
		$this->id_empleado=0;
		$this->id_admin=0;
		$this->fecha_accion="";
		$this->fecha_alta="";
		$this->id_admin_baja=0;
		$this->fecha_baja="";

	}

	public function setid_cierre_caja_venta($valor)
	{
		$this->id_cierre_caja_venta=$valor;
	}
	public function getid_cierre_caja_venta()
	{
		return $this->id_cierre_caja_venta;
	}
	public function set_cierreCaja($valor)
	{
		$this->id_cierre_caja=$valor;
	}
	public function get_cierreCaja()
	{
		return $this->id_cierre_caja;
	}
	public function set_Venta($valor)
	{
		$this->id_venta=$valor;
	}
	public function get_Venta()
	{
		return $this->id_venta;
	}

	public function set_estado($valor)
	{
		$this->estado=$valor;
	}
	public function get_estado()
	{
		return $this->estado;
	}

	public function set_idEmpleadocierre($valor)
	{
		$this->id_empleado=$valor;
	}
	public function get_idEmpleadoCierre()
	{
		return $this->id_empleado;
	}

	public function set_admin($valor)
	{
		$this->id_admin=$valor;
	}
	public function get_admin()
	{
		return $this->id_admin;
	}

	public function set_fecha_accion($valor)
	{
		$this->fecha_accion=$valor;
	}
	public function get_fecha_accion()
	{
		return $this->fecha_accion;
	}


	public function set_fecha_alta($valor)
	{
		$this->fecha_alta=$valor;
	}
	public function get_fecha_alta()
	{
		return $this->fecha_alta;
	}

	public function set_idadminBaja($valor)
	{
		$this->id_admin_baja=$valor;
	}
	public function get_idadminBaja()
	{
		return $this->id_admin_baja;
	}

	public function set_fechaBaja($valor)
	{
		$this->fecha_baja=$valor;
	}
	public function get_fechaBaja()
	{
		return $this->fecha_baja;
	}
	


	public function guardarCierreCajaVenta()
	{
		$sql="INSERT INTO tb_cierre_caja_venta
		                 (id_cierre_caja,
		                  id_venta,
		                  estado,
		                  id_empleado,
		                  id_admin,
		                  fecha_accion,
		                  fecha_alta,
		                  id_admin_baja,
		                  fecha_baja) 
		            VALUES('$this->id_cierre_caja',
		            	    '$this->id_venta',
		            	    '$this->estado',
		            	    '$this->id_empleado',
		            	    '$this->id_admin',
		            	    '$this->fecha_accion',
		            	    '$this->fecha_alta',
		            	    '$this->id_admin_baja',
		            	    '$this->fecha_baja')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	function darBajaCierreCajaVenta($idcierre)
	{
		$sql="UPDATE tb_cierre_caja_venta
		         set estado='Inactivo',
		             id_admin_baja='$this->id_admin_baja',
		             fecha_baja='$this->fecha_baja'
		       WHERE id_cierre_caja=$idcierre
		         and estado='Activo'";
		  if (parent::ejecutar($sql)) 
			return true;
		  else
			return false;
	}

	
	

}
?>