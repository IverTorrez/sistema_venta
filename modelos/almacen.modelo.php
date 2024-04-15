<?php  
include_once('conexion.php');
class Almacen extends Conexion{
	private $id_almacen;
	private $nombre_almacen;
	private $usuario_alta;
	private $fecha_alta;
	private $estado;
	private $usuario_baja;
	private $fecha_baja;
	

	public function Almacen()
	{
		parent::Conexion();
		$this->id_almacen=0;
		$this->nombre_almacen="";
		$this->usuario_alta=0;
		$this->fecha_alta="";
		$this->estado="";
		$this->usuario_baja=0;
		$this->fecha_baja="";
		
	}

	public function setid_almacen($valor)
	{
		$this->id_almacen=$valor;
	}
	public function getid_almacen()
	{
		return $this->id_almacen;
	}
	public function set_nombreAlmacen($valor)
	{
		$this->nombre_almacen=$valor;
	}
	public function get_nombreAlmacen()
	{
		return $this->nombre_almacen;
	}
	public function set_usuarioAlta($valor)
	{
		$this->usuario_alta=$valor;
	}
	public function get_usuarioAlta()
	{
		return $this->usuario_alta;
	}

	public function set_fechaAlta($valor)
	{
		$this->fecha_alta=$valor;
	}
	public function get_fechaAlta()
	{
		return $this->fecha_alta;
	}

	public function set_estado($valor)
	{
		$this->estado=$valor;
	}
	public function get_estado()
	{
		return $this->estado;
	}
	public function set_usuarioBaja($valor)
	{
		$this->usuario_baja=$valor;
	}
	public function get_usuarioBaja()
	{
		return $this->usuario_baja;
	}
	public function set_fechaBaja($valor)
	{
		$this->fecha_baja=$valor;
	}
	public function get_fechaBaja()
	{
		return $this->fecha_baja;
	}



	public function guardarAlmacen()
	{
		$sql="INSERT INTO tb_almacen
		                     (nombre_almacen,
		                      usuario_alta,
		                      fecha_alta,
		                      estado,
		                      usuario_baja,
		                      fecha_baja
		                      ) 
		                 VALUES('$this->nombre_almacen',
		                 	    '$this->usuario_alta',
		                 	    '$this->fecha_alta',
		                 	    '$this->estado',
		                 	    '$this->usuario_baja',
		                 	    '$this->fecha_baja'
		                 	     )";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function listarAlmacenActivos()
	{
		$sql="SELECT id_almacen, 
		             nombre_almacen,
		             usuario_alta,
		             fecha_alta,
		             estado,
		             usuario_baja,
		             fecha_baja
		        FROM tb_almacen 
		       WHERE estado='Activo'
		    order by nombre_almacen asc ";
		return parent::ejecutar($sql);
	}
	public function mostarUnAlmacen($idalmacen)
	{
		$sql="SELECT id_almacen, 
		             nombre_almacen,
		             usuario_alta,
		             fecha_alta,
		             estado,
		             usuario_baja,
		             fecha_baja
		        FROM tb_almacen 
		       WHERE estado='Activo'
		         and id_almacen=$idalmacen
		    order by nombre_almacen asc ";
		return parent::ejecutar($sql);
	}

    public function actualizarAlmacen()
	{
		$sql="UPDATE tb_almacen 
		         SET nombre_almacen='$this->nombre_almacen' 
		       WHERE id_almacen='$this->id_almacen'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function DarBajaAlmacen()
	{
		$sql="UPDATE tb_almacen 
		         SET estado='$this->estado',
		             fecha_baja='$this->fecha_baja',
		             usuario_baja='$this->usuario_baja'
		       where id_almacen='$this->id_almacen'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}
	

	
	

	

	

}
?>