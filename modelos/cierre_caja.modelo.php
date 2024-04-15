 <?php  
include_once('conexion.php');
class Cierre_caja extends Conexion{
	private $id_cierre_caja;
	private $fecha_cierre;
	private $monto_venta_cierre;
	private $monto_caja;
	private $monto_sobrante;
	private $cantidad_ventas;
	private $codigos_ventas;
	private $id_empleado;
	private $estado;
	private $id_usuario_alta;
	private $fecha_alta;
	private $id_usuario_baja;
	private $fecha_baja;
	private $cantidad_productos;

	public function Cierre_caja()
	{
		parent::Conexion();
		$this->id_cierre_caja=0;
		$this->fecha_cierre="";
		$this->monto_venta_cierre=0;
		$this->monto_caja=0;
		$this->monto_sobrante=0;
		$this->cantidad_ventas=0;
		$this->codigos_ventas=0;
		$this->id_empleado=0;
		$this->estado="";
		$this->id_usuario_alta=0;
		$this->fecha_alta="";
		$this->id_usuario_baja=0;
		$this->fecha_baja="";
		$this->cantidad_productos=0;
	}

	public function setid_cierre_caja($valor)
	{
		$this->id_cierre_caja=$valor;
	}
	public function getid_cierre_caja()
	{
		return $this->id_cierre_caja;
	}
	public function set_fecha_cierre($valor)
	{
		$this->fecha_cierre=$valor;
	}
	public function get_fecha_cierre()
	{
		return $this->fecha_cierre;
	}
	public function set_monto_venta_cierre($valor)
	{
		$this->monto_venta_cierre=$valor;
	}
	public function get_monto_venta_cierre()
	{
		return $this->monto_venta_cierre;
	}

	public function set_monto_caja($valor)
	{
		$this->monto_caja=$valor;
	}
	public function get_monto_caja()
	{
		return $this->monto_caja;
	}

	public function set_monto_sobrante($valor)
	{
		$this->monto_sobrante=$valor;
	}
	public function get_monto_sobrante()
	{
		return $this->monto_sobrante;
	}


	public function set_cantida_ventas($valor)
	{
		$this->cantidad_ventas=$valor;
	}
	public function get_cantidad_ventas()
	{
		return $this->cantidad_ventas;
	}

	public function set_codigos_ventas($valor)
	{
		$this->codigos_ventas=$valor;
	}
	public function get_codigos_ventas()
	{
		return $this->codigos_ventas;
	}

	public function set_idempleado($valor)
	{
		$this->id_empleado=$valor;
	}
	public function get_idempleado()
	{
		return $this->id_empleado;
	}
	public function set_estado_cierre($valor)
	{
		$this->estado=$valor;
	}
	public function get_estado_cierre()
	{
		return $this->estado;
	}
	public function set_idUsuarioAlta($valor)
	{
		$this->id_usuario_alta=$valor;
	}
	public function get_idUsuarioAlta()
	{
		return $this->id_usuario_alta;
	}
	public function set_fecha_alta($valor)
	{
		$this->fecha_alta=$valor;
	}
	public function get_fecha_alta()
	{
		return $this->fecha_alta;
	}
	public function set_idUsuarioBaja($valor)
	{
		$this->id_usuario_baja=$valor;
	}
	public function get_idUsuarioBaja()
	{
		return $this->id_usuario_baja;
	}
	public function set_fecha_baja($valor)
	{
		$this->fecha_baja=$valor;
	}
	public function get_fecha_baja()
	{
		return $this->fecha_baja;
	}
	public function set_cantidad_productos($valor)
	{
		$this->cantidad_productos=$valor;
	}
	public function get_cantidad_productos()
	{
		return $this->cantidad_productos;
	}
	


	public function guardarCierreCaja()
	{
		$sql="INSERT INTO tb_cierre_caja(fecha_cierre,
			                             monto_venta_cierre,
			                             monto_caja,
			                             monto_sobrante,
			                             cantidad_ventas,
			                             codigos_ventas,
			                             id_empleado,
			                             estado,
			                             id_usuario_alta,
			                             fecha_alta,
			                             id_usuario_baja,
			                             fecha_baja,
			                             cantidad_productos) 
		                           VALUES('$this->fecha_cierre',
		                           	      '$this->monto_venta_cierre',
		                           	      '$this->monto_caja',
		                           	      '$this->monto_sobrante',
		                           	      '$this->cantidad_ventas',
		                           	      '$this->codigos_ventas',
		                           	      '$this->id_empleado',
		                           	      '$this->estado',
		                           	      '$this->id_usuario_alta',
		                           	      '$this->fecha_alta',
		                           	      '$this->id_usuario_baja',
		                           	      '$this->fecha_baja',
		                           	      '$this->cantidad_productos')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	function obtenerUltimocierreUsuario($idadmin)
	{
		$sql="SELECT max(id_cierre_caja) as ultcierre
		            FROM tb_cierre_caja 
		           WHERE id_usuario_alta=$idadmin";
		     return parent::ejecutar($sql);
	}

	function verficacionSiYaHayCierreDefechaDeEmpleado($fecha,$idemp)
	{
      $sql="SELECT count(id_cierre_caja) as id_cierre_caja 
              FROM tb_cierre_caja 
             WHERE cast(fecha_cierre as date)='$fecha' 
               and id_empleado=$idemp
               and estado='Activo' ";
            return parent::ejecutar($sql);
	}

	function listarcierresActivosDefecha($fechaini,$fechafin)
	{
		$sql="SELECT a.id_cierre_caja,
		             cast(a.fecha_cierre as date) as fecha_cierre,
		             a.monto_venta_cierre,
		             a.monto_caja,
		             a.monto_sobrante,
		             a.cantidad_ventas,
		             a.cantidad_productos,
		             a.fecha_alta,
		             concat(b.nombre_empleado,' ',b.apellido_empleado) as empleado
		        FROM tb_cierre_caja as a
		  INNER JOIN tb_empleado as b
		          on a.id_empleado=b.id_empleado
		       WHERE cast(a.fecha_cierre as date) BETWEEN '$fechaini' AND '$fechafin'
		         and a.estado='Activo'
		    ORDER BY a.fecha_cierre DESC ";
		      return parent::ejecutar($sql);
	}

	function listarcierresActivosDefechaDeEmpleado($fechaini,$fechafin,$emp)
	{
		$sql="SELECT a.id_cierre_caja,
		             cast(a.fecha_cierre as date) as fecha_cierre,
		             a.monto_venta_cierre,
		             a.monto_caja,
		             a.monto_sobrante,
		             a.cantidad_ventas,
		             a.cantidad_productos,
		             a.fecha_alta,
		             concat(b.nombre_empleado,' ',b.apellido_empleado) as empleado
		        FROM tb_cierre_caja as a
		  INNER JOIN tb_empleado as b
		          on a.id_empleado=b.id_empleado
		       WHERE cast(a.fecha_cierre as date) BETWEEN '$fechaini' AND '$fechafin'
		         and a.estado='Activo'
		         and a.id_empleado=$emp
		    ORDER BY a.fecha_cierre DESC ";
		      return parent::ejecutar($sql);
	}

	function darBajaCierre($idcierre)
	{
		$sql="UPDATE tb_cierre_caja
		         set estado         ='Inactivo',
		             id_usuario_baja='$this->id_usuario_baja',
		             fecha_baja     ='$this->fecha_baja'
		       WHERE id_cierre_caja=$idcierre
		          and estado='Activo'";
		 if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	
	

	

}
?>