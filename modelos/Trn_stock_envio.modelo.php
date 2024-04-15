 <?php  
include_once('conexion.php');
class Trans_Stock_envio extends Conexion{
	private $id_transferencia_envio;
	private $fecha_transferencia_enviada;
	private $cantidad_envio;
	private $estado;
	private $id_compra_producto;
	private $descripcion_trans_envio;
	private $id_sucursal_destino;
	

	public function Trans_Stock_envio()
	{
		parent::Conexion();
		$this->id_transferencia_envio=0;
		$this->fecha_transferencia_enviada="";
		$this->cantidad_envio=0;
		$this->estado="";
		$this->id_compra_producto=0;
		$this->descripcion_trans_envio="";
		$this->id_sucursal_destino=0;
		

	}

	public function setid_trn_stock_envio($valor)
	{
		$this->id_transferencia_envio=$valor;
	}
	public function getid_trn_stock_envio()
	{
		return $this->id_transferencia_envio;
	}
	public function set_fecha_trn_envio($valor)
	{
		$this->fecha_transferencia_enviada=$valor;
	}
	public function get_fecha_trn_envio()
	{
		return $this->fecha_transferencia_enviada;
	}
	public function set_cantidad_envio($valor)
	{
		$this->cantidad_envio=$valor;
	}
	public function get_cantidad_envio()
	{
		return $this->cantidad_envio;
	}

	public function set_estado_trn_envio($valor)
	{
		$this->estado=$valor;
	}
	public function get_estado_trn_envio()
	{
		return $this->estado;
	}

	public function set_idCompraProducto($valor)
	{
		$this->id_compra_producto=$valor;
	}
	public function get_idCompraProducto()
	{
		return $this->id_compra_producto;
	}

	public function set_descripTrnEnvio($valor)
	{
		$this->descripcion_trans_envio=$valor;
	}
	public function get_descripTrnEnvio()
	{
		return $this->descripcion_trans_envio;
	}

	public function set_idSucursalDestino($valor)
	{
		$this->id_sucursal_destino=$valor;
	}
	public function get_idSucursalDestino()
	{
		return $this->id_sucursal_destino;
	}


	
	public function guardarTrnStockEnvio()
	{
		$sql="INSERT INTO tb_transferencia_stock_envio(fecha_transferencia_enviada,cantidad_envio,estado,id_compra_producto,descripcion_trans_envio,id_sucursal_destino) VALUES('$this->fecha_transferencia_enviada','$this->cantidad_envio','$this->estado','$this->id_compra_producto','$this->descripcion_trans_envio','$this->id_sucursal_destino')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

    public function listarTrnStock_enviadas()
    {
      $sql="SELECT a.id_transferencia_envio,
			       a.fecha_transferencia_enviada,
			       a.cantidad_envio,
			       a.estado, 
			       c.nombre_producto,
			       c.codigo_producto,
			       d.nombre_suc,
			       b.id_compra_producto,
			       a.descripcion_trans_envio 
			FROM  tb_transferencia_stock_envio as a, 
			      tb_compra_producto as b, 
			      tb_producto as c, 
			      tb_sucursal as d
			WHERE b.id_compra_producto=a.id_compra_producto
			  and b.id_producto=c.id_producto
			  and a.id_sucursal_destino=d.id_sucursal
			  and a.estado='enviado' ";
    	return parent::ejecutar($sql);
    }

    public function mostrarDetalleDeUnEnvio($idtrnenvio)
    {
    	$sql="SELECT cantidad_envio, 
    	             id_compra_producto 
    	        FROM tb_transferencia_stock_envio 
    	       WHERE id_transferencia_envio=$idtrnenvio
    	         and estado='enviado' ";
    	return parent::ejecutar($sql);
    }
    
    public function darBajarTrnEnvio($idtrnenvio)
    {
    	$sql="UPDATE tb_transferencia_stock_envio set estado='cancelada' WHERE id_transferencia_envio=$idtrnenvio";
    	if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
    }
	

}
?>