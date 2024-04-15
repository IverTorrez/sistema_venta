<?php  
include_once('conexion.php');
class Administrador extends Conexion{
	private $id_administrador;
	private $nombre_administrador;
	private $apellido_administrador;
	private $telefono_administrador;
	private $user_admin;
	private $password_admin;
	private $estado_admin;
	private $observacion_admin;

	public function Administrador()
	{
		parent::Conexion();
		$this->id_administrador=0;
		$this->nombre_administrador="";
		$this->apellido_administrador="";
		$this->telefono_administrador=0;
		$this->user_admin="";
		$this->password_admin="";
		$this->estado_admin="";
		$this->observacion_admin="";

	}

	public function setid_admin($valor)
	{
		$this->id_administrador=$valor;
	}
	public function getid_admin()
	{
		return $this->id_administrador;
	}
	public function set_nombreAdmin($valor)
	{
		$this->nombre_administrador=$valor;
	}
	public function get_nombreAdmin()
	{
		return $this->nombre_administrador;
	}
	public function set_apellidoAdmin($valor)
	{
		$this->apellido_administrador=$valor;
	}
	public function get_apellidoAdmin()
	{
		return $this->apellido_administrador;
	}

	public function set_TelefonoAdmin($valor)
	{
		$this->telefono_administrador=$valor;
	}
	public function get_TelefonoAdmin()
	{
		return $this->telefono_administrador;
	}


	public function set_userNameAdmin($valor)
	{
		$this->user_admin=$valor;
	}
	public function get_userNameAdmin()
	{
		return $this->user_admin;
	}
	public function set_passwordAdmin($valor)
	{
		$this->password_admin=$valor;
	}
	public function get_passwordAdmin()
	{
		return $this->password_admin;
	}
	public function set_estadoAdmin($valor)
	{
		$this->estado_admin=$valor;
	}
	public function get_estadoAdmin()
	{
		return $this->estado_admin;
	}
	

	public function set_observacionAdmin($valor)
	{
		$this->observacion_admin=$valor;
	}
	public function get_observacionAdmin()
	{
		return $this->observacion_admin;
	}


	public function guardarAdmin()
	{
		$sql="INSERT INTO tb_administrador(nombre_administrador,apellido_administrador,telefono_administrador,user_admin,password_admin,estado_admin,observacion_admin) VALUES('$this->nombre_administrador','$this->apellido_administrador','$this->telefono_administrador','$this->user_admin','$this->password_admin','$this->estado_admin','$this->observacion_admin')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function loginAdmin()
	{
		$sql="SELECT * from tb_administrador where user_admin='$this->user_admin' and password_admin='$this->password_admin' and estado_admin='Activo'";
		return parent::ejecutar($sql);
	}
	public function listarAdmin()
	{
		$sql="SELECT *FROM tb_administrador";
		return parent::ejecutar($sql);
	}
	

	public function listarAdminActivos()
	{
		$sql="SELECT id_administrador, nombre_administrador, apellido_administrador, telefono_administrador ,user_admin, password_admin, estado_admin,observacion_admin FROM tb_administrador WHERE estado_admin='Activo' ";
		return parent::ejecutar($sql);
	}

    public function actualizarAdmin()
	{
		$sql="UPDATE tb_administrador SET nombre_administrador='$this->nombre_administrador', apellido_administrador='$this->apellido_administrador',telefono_administrador='$this->telefono_administrador',user_admin='$this->user_admin',password_admin='$this->password_admin',observacion_admin='$this->observacion_admin' where id_administrador='$this->id_administrador'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function DarBajaAdmin()
	{
		$sql="UPDATE tb_administrador SET estado_admin='$this->estado_admin' WHERE id_administrador='$this->id_administrador' ";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}
	

	

}
?>