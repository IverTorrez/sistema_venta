 <?php  
include_once('conexion.php');
class Venta_Clienta extends Conexion{
	private $id_venta_cliente;
	private $id_cliente;
	private $id_venta;

	public function Venta_Clienta()
	{
		parent::Conexion();
		$this->id_venta_cliente=0;
		$this->id_cliente=0;
		$this->id_venta=0;

	}

	public function setid_ventaClienta($valor)
	{
		$this->id_venta_cliente=$valor;
	}
	public function getid_ventaClienta()
	{
		return $this->id_venta_cliente;
	}
	public function set_idCliente($valor)
	{
		$this->id_cliente=$valor;
	}
	public function get_idClienta()
	{
		return $this->id_cliente;
	}
	public function set_idVenta($valor)
	{
		$this->id_venta=$valor;
	}
	public function get_idVenta()
	{
		return $this->id_venta;
	}

	

	public function guardarVentaClienta()
	{
		$sql="INSERT INTO tb_venta_cliente(id_cliente,id_venta) VALUES('$this->id_cliente','$this->id_venta')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	

    
		

}
?>