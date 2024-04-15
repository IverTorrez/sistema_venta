 <?php  
include_once('conexion.php');
class Cliente extends Conexion{
	private $id_cliente;
	private $nombre_cliente;
	private $apellido_cliente;
	private $telefono_cliente;
	private $estado_cliente;
	private $observacion;

	public function Cliente()
	{
		parent::Conexion();
		$this->id_cliente=0;
		$this->nombre_cliente="";
		$this->apellido_cliente="";
		$this->telefono_cliente=0;
		$this->estado_cliente="";
		$this->observacion="";

	}

	public function setid_cliente($valor)
	{
		$this->id_cliente=$valor;
	}
	public function getid_cliente()
	{
		return $this->id_cliente;
	}
	public function set_nombreCliente($valor)
	{
		$this->nombre_cliente=$valor;
	}
	public function get_nombreCliente()
	{
		return $this->nombre_cliente;
	}
	public function set_apellidoCliente($valor)
	{
		$this->apellido_cliente=$valor;
	}
	public function get_apellidoCliente()
	{
		return $this->apellido_cliente;
	}

	public function set_TelefonoCliente($valor)
	{
		$this->telefono_cliente=$valor;
	}
	public function get_TelefonoCliente()
	{
		return $this->telefono_cliente;
	}

	public function set_estadoCliente($valor)
	{
		$this->estado_cliente=$valor;
	}
	public function get_estadoCliente()
	{
		return $this->estado_cliente;
	}


	public function set_observacionCliente($valor)
	{
		$this->observacion=$valor;
	}
	public function get_observacionCliente()
	{
		return $this->observacion;
	}
	


	public function guardarCliente()
	{
		$sql="INSERT INTO tb_cliente(nombre_cliente,apellido_cliente,telefono_cliente,estado_cliente,observacion) VALUES('$this->nombre_cliente','$this->apellido_cliente','$this->telefono_cliente','$this->estado_cliente','$this->observacion')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function listarClientesActivos()
	{
		$sql="SELECT id_cliente, nombre_cliente, apellido_cliente, telefono_cliente, estado_cliente, observacion FROM tb_cliente WHERE estado_cliente='Activo' ";
		return parent::ejecutar($sql);
	}

    public function actualizarCliente()
	{
		$sql="UPDATE tb_cliente SET nombre_cliente='$this->nombre_cliente', apellido_cliente='$this->apellido_cliente',telefono_cliente='$this->telefono_cliente',observacion='$this->observacion' where id_cliente='$this->id_cliente'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function DarBajaCliente()
	{
		$sql="UPDATE tb_cliente SET estado_cliente='$this->estado_cliente' where id_cliente='$this->id_cliente'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}
	

	

}
?>