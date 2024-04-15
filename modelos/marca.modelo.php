<?php  
include_once('conexion.php');
class Marca extends Conexion{
	private $id_marca;
	private $nombre_marca;
	private $estado_marca;
	

	public function Marca()
	{
		parent::Conexion();
		$this->id_marca=0;
		$this->nombre_marca="";
		$this->estado_marca="";
		
	}

	public function setid_marca($valor)
	{
		$this->id_marca=$valor;
	}
	public function getid_marca()
	{
		return $this->id_marca;
	}
	public function set_nombreMarca($valor)
	{
		$this->nombre_marca=$valor;
	}
	public function get_nombreMarca()
	{
		return $this->nombre_marca;
	}
	public function set_estadoMarca($valor)
	{
		$this->estado_marca=$valor;
	}
	public function get_estadoMarca()
	{
		return $this->estado_marca;
	}



	public function guardarMarca()
	{
		$sql="INSERT INTO tb_marca(nombre_marca,estado_marca) VALUES('$this->nombre_marca','$this->estado_marca')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function listarMarcasActivos()
	{
		$sql="SELECT id_marca, nombre_marca,estado_marca FROM tb_marca WHERE estado_marca='Activo' ";
		return parent::ejecutar($sql);
	}

    public function actualizarMarca()
	{
		$sql="UPDATE tb_marca SET nombre_marca='$this->nombre_marca' WHERE id_marca='$this->id_marca'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function DarBajaMarca()
	{
		$sql="UPDATE tb_marca SET estado_marca='$this->estado_marca' where id_marca='$this->id_marca'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}
	

	
	

	

	

}
?>