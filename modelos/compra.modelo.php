<?php  
include_once('conexion.php');
class Compra extends Conexion{
	private $id_compra;
	private $fecha_compra;
	private $monto_compra;
	private $compra_facturada;
	private $costo_factura;
	private $usuario_alta;
	private $id_proveedor;
	private $estado;
	private $tipo_reg;
	private $usuario_baja;
	private $fecha_baja;

	public function Compra()
	{
		parent::Conexion();
		$this->id_compra=0;
		$this->fecha_compra="";
		$this->monto_compra="";
		$this->compra_facturada=0;
		$this->costo_factura="";
		$this->usuario_alta=0;
		$this->id_proveedor=0;
		$this->estado="";
		$this->tipo_reg="";
		$this->usuario_baja=0;
		$this->fecha_baja=0;

	}

	public function setid_compra($valor)
	{
		$this->id_compra=$valor;
	}
	public function getid_compra()
	{
		return $this->id_compra;
	}
	public function set_fechaCompra($valor)
	{
		$this->fecha_compra=$valor;
	}
	public function get_fechaCompra()
	{
		return $this->fecha_compra;
	}
	public function set_montoCompra($valor)
	{
		$this->monto_compra=$valor;
	}
	public function get_montoCompra()
	{
		return $this->monto_compra;
	}

	public function set_CompraFacturada($valor)
	{
		$this->compra_facturada=$valor;
	}
	public function get_conpraFacturada()
	{
		return $this->compra_facturada;
	}


	public function set_CostoFactura($valor)
	{
		$this->costo_factura=$valor;
	}
	public function get_CostoFactura()
	{
		return $this->costo_factura;
	}
	public function set_idAdmin($valor)
	{
		$this->usuario_alta=$valor;
	}
	public function get_idAdmin()
	{
		return $this->usuario_alta;
	}
	public function set_idProveedor($valor)
	{
		$this->id_proveedor=$valor;
	}
	public function get_idProveedor()
	{
		return $this->id_proveedor;
	}

	public function set_estadoCompra($valor)
	{
		$this->estado=$valor;
	}
	public function get_estadoCompra()
	{
		return $this->estado;
	}
	public function set_tipoReg($valor)
	{
		$this->tipo_reg=$valor;
	}
	public function get_tipoReg()
	{
		return $this->tipo_reg;
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
	


	public function guardarCompra()
	{
		$sql="INSERT INTO tb_compra(fecha_compra,
			                        monto_compra,
			                        compra_facturada,
			                        costo_factura,
			                        usuario_alta,
			                        id_proveedor,
			                        estado,
			                        tipo_reg,
			                        usuario_baja,
			                        fecha_baja) 
		                      VALUES('$this->fecha_compra',
		                      	     '$this->monto_compra',
		                      	     '$this->compra_facturada',
		                      	     '$this->costo_factura',
		                      	     '$this->usuario_alta',
		                      	     '$this->id_proveedor',
		                      	     '$this->estado',
		                      	     '$this->tipo_reg',
		                      	     '$this->usuario_baja',
		                      	     '$this->fecha_baja')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function listarCompras()
	{
		$sql="SELECT (a.id_compra)AS idcompra,
		             a.compra_facturada,
		             a.id_proveedor,
		             b.precio_venta_prod,
		             b.precio_venta_prod_Fact,
		             b.precio_tope,
		             (b.cantidad_compra)AS cantidad,
		             a.monto_compra,
		             b.precio_unit_compra,
		             b.precio_unit_compraFacturado, 
		             a.fecha_compra,
		             (c.nombre_producto)AS nameProducto,       
		             a.costo_factura,
		             (d.nombre_proveedor)AS nameProveedor,
		             (c.id_producto)AS idproducto,
		             b.id_compra_producto,
		             e.nombre_almacen 
		        FROM tb_compra as a,
		             tb_compra_producto as b,
		             tb_producto as c,
		             tb_proveedor as d,
		             tb_almacen as e
		       WHERE a.id_proveedor=d.id_proveedor 
		         AND a.id_compra=b.id_compra 
		         AND b.id_producto=c.id_producto
		         and c.id_almacen=e.id_almacen
		         AND a.estado='Activo'
		         AND b.estado='Activo' 
		    GROUP BY a.id_compra 
		    ORDER BY a.id_compra ASC";
		return parent::ejecutar($sql);
	}

	public function mostrarUltimaCompra()
	{
		$sql="SELECT MAX(id_compra)AS idultimacompra  FROM tb_compra ";
		return parent::ejecutar($sql);
	}

	public function eliminarCompra()
	{
		$sql="UPDATE tb_compra 
		         SET estado='$this->estado',
		             usuario_baja='$this->usuario_baja',
		             fecha_baja='$this->fecha_baja'
		       WHERE id_compra='$this->id_compra' ";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;

	}

	public function editarCompra($idcompra)
	{
	  $sql="UPDATE tb_compra
		    set monto_compra     ='$this->monto_compra',
		        compra_facturada ='$this->compra_facturada',
		        usuario_alta     ='$this->usuario_alta',
		        id_proveedor     ='$this->id_proveedor'
		        WHERE id_compra  = $idcompra";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;

	}
	public function ReporteComprasActivas($fechaini,$fechafin)
	{
		$sql="SELECT (a.id_compra)AS idcompra,
		             a.compra_facturada,
		             a.id_proveedor,
		             b.precio_venta_prod,
		             b.precio_venta_prod_Fact,
		             b.precio_tope,
		             (b.cantidad_compra)AS cantidad,
                     b.stock_actual,
		             a.monto_compra,
		             b.precio_unit_compra,
		             b.precio_unit_compraFacturado, 
		             a.fecha_compra,
		             (c.nombre_producto)AS nameProducto,       
		             a.costo_factura,
		             (d.nombre_proveedor)AS nameProveedor,
		             (c.id_producto)AS idproducto,
		             b.id_compra_producto,
		             (CASE  WHEN a.tipo_reg= 'admin'
                            THEN (SELECT h.nombre_administrador 
                           	       FROM tb_administrador as h 
                           	      WHERE h.id_administrador=a.usuario_alta)
                            ELSE
                             (SELECT g.nombre_empleado 
                             	FROM tb_empleado as g 
                               WHERE g.id_empleado=a.usuario_alta)
                     END )AS Usuario,
                 e.nombre_almacen 
		        FROM tb_compra as a,
		             tb_compra_producto as b,
		             tb_producto as c,
		             tb_proveedor as d,
		             tb_almacen as e
		       WHERE a.id_proveedor=d.id_proveedor 
		         AND a.id_compra=b.id_compra 
		         AND b.id_producto=c.id_producto
		         AND c.id_almacen=e.id_almacen
		         AND a.estado='Activo'
		         AND b.estado='Activo'

		         AND cast(a.fecha_compra as date) BETWEEN '$fechaini' AND '$fechafin'
		    GROUP BY a.id_compra 
		    ORDER BY a.id_compra DESC";
		return parent::ejecutar($sql);
	}

	public function ReporteComprasActivasDeAlmacen($fechaini,$fechafin,$idalmacen)
	{
		$sql="SELECT (a.id_compra)AS idcompra,
		             a.compra_facturada,
		             a.id_proveedor,
		             b.precio_venta_prod,
		             b.precio_venta_prod_Fact,
		             b.precio_tope,
		             (b.cantidad_compra)AS cantidad,
                     b.stock_actual,
		             a.monto_compra,
		             b.precio_unit_compra,
		             b.precio_unit_compraFacturado, 
		             a.fecha_compra,
		             (c.nombre_producto)AS nameProducto,       
		             a.costo_factura,
		             (d.nombre_proveedor)AS nameProveedor,
		             (c.id_producto)AS idproducto,
		             b.id_compra_producto,
		             (CASE  WHEN a.tipo_reg= 'admin'
                            THEN (SELECT h.nombre_administrador 
                           	       FROM tb_administrador as h 
                           	      WHERE h.id_administrador=a.usuario_alta)
                            ELSE
                             (SELECT g.nombre_empleado 
                             	FROM tb_empleado as g 
                               WHERE g.id_empleado=a.usuario_alta)
                     END )AS Usuario,
                 e.nombre_almacen 
		        FROM tb_compra as a,
		             tb_compra_producto as b,
		             tb_producto as c,
		             tb_proveedor as d,
		             tb_almacen as e
		       WHERE a.id_proveedor=d.id_proveedor 
		         AND a.id_compra=b.id_compra 
		         AND b.id_producto=c.id_producto
		         AND c.id_almacen=e.id_almacen
		         AND a.estado='Activo'
		         AND b.estado='Activo' 
		         AND cast(a.fecha_compra as date) BETWEEN '$fechaini' AND '$fechafin'
		         AND c.id_almacen=$idalmacen
		         
		    GROUP BY a.id_compra 
		    ORDER BY a.id_compra DESC";
		return parent::ejecutar($sql);
	}


}
?>