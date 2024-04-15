 <?php  
include_once('conexion.php');
class Sucursal extends Conexion{
	private $id_sucursal;
	private $nombre_suc;
	private $descripcion_suc;
	private $contacto;
	private $estado_suc;
	

	public function Sucursal()
	{
		parent::Conexion();
		$this->id_sucursal=0;
		$this->nombre_suc="";
		$this->descripcion_suc="";
		$this->contacto="";
		$this->estado_suc="";
		

	}

	public function setid_sucursal($valor)
	{
		$this->id_sucursal=$valor;
	}
	public function getid_sucursal()
	{
		return $this->id_sucursal;
	}
	public function set_nombreSuc($valor)
	{
		$this->nombre_suc=$valor;
	}
	public function get_nombreSuc()
	{
		return $this->nombre_suc;
	}
	public function set_descripcionSuc($valor)
	{
		$this->descripcion_suc=$valor;
	}
	public function get_descripcionSuc()
	{
		return $this->descripcion_suc;
	}

	public function set_Contacto($valor)
	{
		$this->contacto=$valor;
	}
	public function get_contacto()
	{
		return $this->contacto;
	}

	public function set_estadoSuc($valor)
	{
		$this->estado_suc=$valor;
	}
	public function get_estadoSuc()
	{
		return $this->estado_suc;
	}

	
	public function guardarSucursal()
	{
		$sql="INSERT INTO tb_sucursal(nombre_suc,descripcion_suc,contacto,estado_suc) VALUES('$this->nombre_suc','$this->descripcion_suc','$this->contacto','$this->estado_suc')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

    public function actualizarSucursal($idsuc)
    {
    	$sql="UPDATE tb_sucursal SET nombre_suc='$this->nombre_suc', descripcion_suc='$this->descripcion_suc',contacto='$this->contacto' WHERE id_sucursal=$idsuc ";
    	if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
    }
    public function DarBajaSucursal($idsuc)
    {
    	$sql="UPDATE tb_sucursal set estado_suc='Inactivo' WHERE id_sucursal=$idsuc ";
    	if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
    }

    public function listarSucursalesActivas()
    {
    	$sql="SELECT id_sucursal,nombre_suc,descripcion_suc,contacto FROM tb_sucursal WHERE estado_suc='Activo'";
    	return parent::ejecutar($sql);
    }
	

}
?>