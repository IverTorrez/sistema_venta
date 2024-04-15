<?php  
include_once('conexion.php');
class Categoria extends Conexion{
	private $id_categoria;
	private $nombre_categoria;
	private $estado_cat;
	

	public function Categoria()
	{
		parent::Conexion();
		$this->id_categoria=0;
		$this->nombre_categoria="";
		$this->estado_cat="";
		
	}

	public function setid_categoria($valor)
	{
		$this->id_categoria=$valor;
	}
	public function getid_categoria()
	{
		return $this->id_categoria;
	}
	public function set_nombreCategoria($valor)
	{
		$this->nombre_categoria=$valor;
	}
	public function get_nombreCategoria()
	{
		return $this->nombre_categoria;
	}
	public function set_estadoCategoria($valor)
	{
		$this->estado_cat=$valor;
	}
	public function get_estadoCategoria()
	{
		return $this->estado_cat;
	}



	public function guardarCategoria()
	{
		$sql="INSERT INTO tb_categoria(nombre_categoria,estado_cat) VALUES('$this->nombre_categoria','$this->estado_cat')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function listarCategoriasActivos()
	{
		$sql="SELECT id_categoria, nombre_categoria,estado_cat FROM tb_categoria WHERE estado_cat='Activo' ";
		return parent::ejecutar($sql);
	}

    public function actualizarCategoria()
	{
		$sql="UPDATE tb_categoria SET nombre_categoria='$this->nombre_categoria' WHERE id_categoria='$this->id_categoria'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function DarBajaCategoria()
	{
		$sql="UPDATE tb_categoria SET estado_cat='$this->estado_cat' where id_categoria='$this->id_categoria'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}
	

	
	

	

	

}
?>