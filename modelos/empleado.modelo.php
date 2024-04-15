<?php  
include_once('conexion.php');
class Empleado extends Conexion{
	private $id_empleado;
	private $nombre_empleado;
	private $apellido_empleado;
	private $telefono_empleado;
	private $user_name_emp;
	private $password_emp;
	private $estado_empleado;
	private $observacion_emp;
	private $permiso_especial;

	public function Empleado()
	{
		parent::Conexion();
		$this->id_empleado=0;
		$this->nombre_empleado="";
		$this->apellido_empleado="";
		$this->telefono_empleado=0;
		$this->user_name_emp="";
		$this->password_emp="";
		$this->estado_empleado="";
		$this->observacion_emp="";
		$this->permiso_especial=0;

	}

	public function setid_empleado($valor)
	{
		$this->id_empleado=$valor;
	}
	public function getid_empleado()
	{
		return $this->id_empleado;
	}
	public function set_nombreEmplado($valor)
	{
		$this->nombre_empleado=$valor;
	}
	public function get_nombreEmpleado()
	{
		return $this->nombre_empleado;
	}
	public function set_apellidoEmpleado($valor)
	{
		$this->apellido_empleado=$valor;
	}
	public function get_apellidoEmpleado()
	{
		return $this->apellido_empleado;
	}

	public function set_TelefonoEmpleado($valor)
	{
		$this->telefono_empleado=$valor;
	}
	public function get_TelefonoEmpleado()
	{
		return $this->telefono_empleado;
	}


	public function set_userNameEmpl($valor)
	{
		$this->user_name_emp=$valor;
	}
	public function get_userNameEmpleado()
	{
		return $this->user_name_emp;
	}
	public function set_passwordEmpleado($valor)
	{
		$this->password_emp=$valor;
	}
	public function get_passwordEmpleado()
	{
		return $this->password_emp;
	}
	public function set_estadoEmpleado($valor)
	{
		$this->estado_empleado=$valor;
	}
	public function get_estadoEmpleado()
	{
		return $this->estado_empleado;
	}

	public function set_observacionEmpleado($valor)
	{
		$this->observacion_emp=$valor;
	}
	public function get_observacionEmpleado()
	{
		return $this->observacion_emp;
	}

	public function set_PermisoEspecial($valor)
	{
		$this->permiso_especial=$valor;
	}
	public function get_permisoEspecial()
	{
		return $this->permiso_especial;
	}
	


	public function guardarEmpleado()
	{
		$sql="INSERT INTO tb_empleado(nombre_empleado,
			                          apellido_empleado,
			                          telefono_empleado,
			                          user_name_emp,
			                          password_emp,
			                          estado_empleado,
			                          observacion_emp,
			                          permiso_especial) 
		                        VALUES('$this->nombre_empleado',
		                        	   '$this->apellido_empleado',
		                        	   '$this->telefono_empleado',
		                        	   '$this->user_name_emp',
		                        	   '$this->password_emp',
		                        	   '$this->estado_empleado',
		                        	   '$this->observacion_emp',
		                        	   '$this->permiso_especial')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function listarEmpleadosActivos()
	{
		$sql="SELECT id_empleado, 
		             nombre_empleado, 
		             apellido_empleado, 
		             telefono_empleado ,
		             user_name_emp, 
		             password_emp, 
		             estado_empleado,
		             observacion_emp,
		             permiso_especial 
		        FROM tb_empleado 
		       WHERE estado_empleado='Activo' ";
		return parent::ejecutar($sql);
	}

    public function actualizarEmpleado()
	{
		$sql="UPDATE tb_empleado 
		         SET nombre_empleado='$this->nombre_empleado', 
		             apellido_empleado='$this->apellido_empleado',
		             telefono_empleado='$this->telefono_empleado',
		             user_name_emp='$this->user_name_emp',
		             password_emp='$this->password_emp',
		             observacion_emp='$this->observacion_emp',
		             permiso_especial='$this->permiso_especial'
		       where id_empleado='$this->id_empleado'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function DarBajaEmpleado()
	{
		$sql="UPDATE tb_empleado 
		         SET estado_empleado='$this->estado_empleado' 
		       where id_empleado='$this->id_empleado'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}
	

	public function loginEmpleado()
	{
		$sql="SELECT * from tb_empleado 
		              where user_name_emp='$this->user_name_emp' 
		                and password_emp='$this->password_emp' 
		                and estado_empleado='Activo'";
		return parent::ejecutar($sql);
	}

	public function mostarUnEmpleadosActivos($idemp)
	{
		$sql="SELECT id_empleado, 
		             nombre_empleado, 
		             apellido_empleado, 
		             telefono_empleado ,
		             user_name_emp, 
		             password_emp, 
		             estado_empleado,
		             observacion_emp 
		        FROM tb_empleado 
		       WHERE estado_empleado='Activo' 
		         and id_empleado=$idemp";
		return parent::ejecutar($sql);
	}

	

}
?>