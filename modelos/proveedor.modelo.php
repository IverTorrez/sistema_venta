<?php  
include_once('conexion.php');
class Proveedor extends Conexion{
	private $id_proveedor;
	private $nombre_proveedor;
	private $apellido_proveedor;
	private $telefono_proveedor;
	private $estado_proveedor;
	private $observacion;

	public function Proveedor()
	{
		parent::Conexion();
		$this->id_proveedor=0;
		$this->nombre_proveedor="";
		$this->apellido_proveedor="";
		$this->telefono_proveedor=0;
		$this->estado_proveedor="";
		$this->observacion="";

	}

	public function setid_proveedor($valor)
	{
		$this->id_proveedor=$valor;
	}
	public function getid_proveedor()
	{
		return $this->id_proveedor;
	}
	public function set_nombreProveedor($valor)
	{
		$this->nombre_proveedor=$valor;
	}
	public function get_nombreProveedor()
	{
		return $this->nombre_proveedor;
	}
	public function set_apellidoProveedor($valor)
	{
		$this->apellido_proveedor=$valor;
	}
	public function get_apellidoProveedor()
	{
		return $this->apellido_proveedor;
	}

	public function set_TelefonoProveedor($valor)
	{
		$this->telefono_proveedor=$valor;
	}
	public function get_TelefonoProveedor()
	{
		return $this->telefono_proveedor;
	}

	public function set_estadoProveedor($valor)
	{
		$this->estado_proveedor=$valor;
	}
	public function get_estadoProveedor()
	{
		return $this->estado_proveedor;
	}

	public function set_ObservacionProveedor($valor)
	{
		$this->observacion=$valor;
	}
	public function get_observacionProveedor()
	{
		return $this->observacion;
	}
	


	public function guardarProveedor()
	{
		$sql="INSERT INTO tb_proveedor(nombre_proveedor,apellido_proveedor,telefono_proveedor,estado_proveedor,observacion) VALUES('$this->nombre_proveedor','$this->apellido_proveedor','$this->telefono_proveedor','$this->estado_proveedor','$this->observacion')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function listarProveedoresActivos()
	{
		$sql="SELECT id_proveedor, nombre_proveedor, apellido_proveedor, telefono_proveedor, estado_proveedor,observacion FROM tb_proveedor WHERE estado_proveedor='Activo' ";
		return parent::ejecutar($sql);
	}

    public function actualizarProveedor()
	{
		$sql="UPDATE tb_proveedor SET nombre_proveedor='$this->nombre_proveedor', apellido_proveedor='$this->apellido_proveedor',telefono_proveedor='$this->telefono_proveedor',observacion='$this->observacion' where id_proveedor='$this->id_proveedor'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function DarBajaProveedor()
	{
		$sql="UPDATE tb_proveedor SET estado_proveedor='$this->estado_proveedor' where id_proveedor='$this->id_proveedor'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}
	

	

}
?>