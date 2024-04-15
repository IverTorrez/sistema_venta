 <?php  
include_once('conexion.php');
class Trans_Stock_recibido extends Conexion{
	private $id_transferencia_recibido;
	private $fecha_trn_recibido;
	private $id_compra_producto;
	private $cantidad_recibida;
	private $estado_recibida;
	private $descripcion_recibido;
	private $id_sucursal_origen;
	private $codigo_de_envio;
	

	public function Trans_Stock_recibido()
	{
		parent::Conexion();
		$this->id_transferencia_recibido=0;
		$this->fecha_trn_recibido="";
		$this->id_compra_producto=0;
		$this->cantidad_recibida=0;
		$this->estado_recibida="";
		$this->descripcion_recibido="";
		$this->id_sucursal_origen=0;
		$this->codigo_de_envio=0;
		

	}

	public function setid_trn_stock_recibido($valor)
	{
		$this->id_transferencia_recibido=$valor;
	}
	public function getid_trn_stock_recibido()
	{
		return $this->id_transferencia_recibido;
	}
	public function set_fecha_trn_recibido($valor)
	{
		$this->fecha_trn_recibido=$valor;
	}
	public function get_fecha_trn_recibido()
	{
		return $this->fecha_trn_recibido;
	}

	public function set_idCompraProducto($valor)
	{
		$this->id_compra_producto=$valor;
	}
	public function get_idCompraProducto()
	{
		return $this->id_compra_producto;
	}

	public function set_cantidad_recibido($valor)
	{
		$this->cantidad_recibida=$valor;
	}
	public function get_cantidad_recibido()
	{
		return $this->cantidad_recibida;
	}

	public function set_estado_trn_recibido($valor)
	{
		$this->estado_recibida=$valor;
	}
	public function get_estado_trn_recibido()
	{
		return $this->estado_recibida;
	}

	
	public function set_descripTrnRecibido($valor)
	{
		$this->descripcion_recibido=$valor;
	}
	public function get_descripTrnRecibido()
	{
		return $this->descripcion_recibido;
	}

	public function set_idSucursalOrigen($valor)
	{
		$this->id_sucursal_origen=$valor;
	}
	public function get_idSucursalOrigen()
	{
		return $this->id_sucursal_origen;
	}

	public function set_cod_envio($valor)
	{
		$this->codigo_de_envio=$valor;
	}
	public function get_cod_envio()
	{
		return $this->codigo_de_envio;
	}


	
	public function guardarTrnStockRecibido()
	{
		$sql="INSERT INTO tb_transferencia_stock_recibido(fecha_trn_recibido,id_compra_producto,cantidad_recibida,estado_recibida,descripcion_recibido,id_sucursal_origen,codigo_de_envio) VALUES('$this->fecha_trn_recibido','$this->id_compra_producto','$this->cantidad_recibida','$this->estado_recibida','$this->descripcion_recibido','$this->id_sucursal_origen','$this->codigo_de_envio')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

    public function listarTrnStock_recibidas()
    {
      $sql="SELECT a.id_transferencia_recibido,
			       a.fecha_trn_recibido,
			       a.cantidad_recibida,
			       a.estado_recibida, 
			       c.nombre_producto,
			       c.codigo_producto,
			       d.nombre_suc,
			       b.id_compra_producto,
			       a.descripcion_recibido,
			       a.codigo_de_envio
			FROM  tb_transferencia_stock_recibido as a, 
			      tb_compra_producto as b, 
			      tb_producto as c, 
			      tb_sucursal as d
			WHERE b.id_compra_producto=a.id_compra_producto
			  and b.id_producto=c.id_producto
			  and a.id_sucursal_origen=d.id_sucursal
			  and a.estado_recibida='recibido' ";
    	return parent::ejecutar($sql);
    }

    public function mostrarDetalleDeUnRecibido($idtrnrecibido)
    {
    	$sql="SELECT cantidad_recibida, 
    	             id_compra_producto 
    	        FROM tb_transferencia_stock_recibido 
    	       WHERE id_transferencia_recibido=$idtrnrecibido
    	         and estado_recibida='recibido' ";
    	return parent::ejecutar($sql);
    }

    public function DarBajaRecibido($idtrnrecibido)
    {
    	$sql="UPDATE tb_transferencia_stock_recibido set estado_recibida='cancelado' WHERE id_transferencia_recibido=$idtrnrecibido ";
    	if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
    }

    
	

}
?>