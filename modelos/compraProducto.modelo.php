<?php  
include_once('conexion.php');
class Compra_Producto extends Conexion{
	private $id_compra_producto;
	private $subtotal_compra;
	private $cantidad_compra;
	private $id_compra;
	private $id_producto;
	private $precio_unit_compra;
	private $precio_unit_compraFacturado;
	private $precio_venta_prod;
	private $precio_venta_prod_Fact;
	private $stock_actual;
	private $precio_tope;
	private $estado;

	
	public function Compra_Producto()
	{
		parent::Conexion();
		$this->id_compra_producto=0;
		$this->subtotal_compra=0;
		$this->cantidad_compra=0;
		$this->id_compra=0;
		$this->id_producto=0;
		$this->precio_unit_compra=0;
		$this->precio_unit_compraFacturado=0;
		$this->precio_venta_prod=0;
		$this->precio_venta_prod_Fact=0;
		$this->stock_actual=0;
		$this->precio_tope=0;
		$this->estado="";

	}

	public function setid_compraProducto($valor)
	{
		$this->id_compra_producto=$valor;
	}
	public function getid_compraProducto()
	{
		return $this->id_compra_producto;
	}
	public function set_subtotalCompra($valor)
	{
		$this->subtotal_compra=$valor;
	}
	public function get_subtotalCompra()
	{
		return $this->subtotal_compra;
	}
	public function set_cantidadCompra($valor)
	{
		$this->cantidad_compra=$valor;
	}
	public function get_cantidadCompra()
	{
		return $this->cantidad_compra;
	}

	public function set_idCompra($valor)
	{
		$this->id_compra=$valor;
	}
	public function get_idCompra()
	{
		return $this->id_compra;
	}


	public function set_idProducto($valor)
	{
		$this->id_producto=$valor;
	}
	public function get_idProducto()
	{
		return $this->id_producto;
	}
	
	public function set_precioUnitCompra($valor)
	{
		$this->precio_unit_compra=$valor;
	}
	public function get_precioUnitCompra()
	{
		return $this->precio_unit_compra;
	}

	public function set_precioUnitCompraFactu($valor)
	{
		$this->precio_unit_compraFacturado=$valor;
	}
	public function get_precioUnitCompraFact()
	{
		return $this->precio_unit_compraFacturado;
	}
	public function set_precioVentaProd($valor)
	{
		$this->precio_venta_prod=$valor;
	}
	public function get_precioVentaProd()
	{
		return $this->precio_venta_prod;
	}
	public function set_precioVentaProduFact($valor)
	{
		$this->precio_venta_prod_Fact=$valor;
	}
	public function get_precioVentaProduFact()
	{
		return $this->precio_venta_prod_Fact;
	}
	public function set_stockActual($valor)
	{
		$this->stock_actual=$valor;
	}
	public function get_stockActual()
	{
		return $this->stock_actual;
	}


	public function set_precioTope($valor)
	{
		$this->precio_tope=$valor;
	}
	public function get_precioTope()
	{
		return $this->precio_tope;
	}

	public function set_estadoCompProd($valor)
	{
		$this->estado=$valor;
	}
	public function get_estadoCompProd()
	{
		return $this->estado;
	}

	public function guardarCompraProducto()
	{
		$sql="INSERT INTO tb_compra_producto(subtotal_compra,cantidad_compra,id_compra,id_producto,precio_unit_compra,precio_unit_compraFacturado,precio_venta_prod,precio_venta_prod_Fact,stock_actual,precio_tope,estado) VALUES('$this->subtotal_compra','$this->cantidad_compra','$this->id_compra','$this->id_producto','$this->precio_unit_compra','$this->precio_unit_compraFacturado','$this->precio_venta_prod','$this->precio_venta_prod_Fact','$this->stock_actual','$this->precio_tope','$this->estado' )";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function eliminarCompraProductoDeCompra()
	{
		$sql="UPDATE tb_compra_producto
		         SET estado='Inactivo'
		       WHERE id_compra='$this->id_compra'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;

	}

	public function listarProductosParaVenta()
	{
		$sql="SELECT (tb_compra_producto.id_compra_producto)as idcompraprod, (tb_producto.nombre_producto)as mombreProducto,(tb_producto.codigo_producto)as codigoProducto,(tb_producto.descripcion)as prodDescripsion,(tb_marca.nombre_marca)as marcaProd,(tb_categoria.nombre_categoria)as catProd,(tb_compra_producto.stock_actual)as stokactual,(tb_compra_producto.precio_venta_prod)as precioVentaprod,(tb_compra_producto.precio_venta_prod_Fact)as precioVentaprodFact FROM tb_compra_producto,tb_producto,tb_marca,tb_categoria WHERE tb_marca.id_marca=tb_producto.id_marca AND tb_categoria.id_categoria=tb_producto.id_categoria AND tb_producto.id_producto=tb_compra_producto.id_producto AND tb_compra_producto.stock_actual>0 GROUP BY tb_compra_producto.id_producto";
		return parent::ejecutar($sql);
	}

	public function listarProductosActivosParaVenta()
	{
		$sql="SELECT (tb_compra_producto.id_compra_producto)as idcompraprod, 
		             (tb_producto.nombre_producto)as mombreProducto,
		             (tb_producto.codigo_producto)as codigoProducto,
		             (tb_producto.descripcion)as prodDescripsion,
		             (tb_marca.nombre_marca)as marcaProd,
		             (tb_categoria.nombre_categoria)as catProd,
		             (tb_compra_producto.stock_actual)as stokactual,
		             (tb_compra_producto.precio_venta_prod)as precioVentaprod,
		             (tb_compra_producto.precio_venta_prod_Fact)as precioVentaprodFact 
		        FROM tb_compra_producto,
		             tb_producto,
		             tb_marca,
		             tb_categoria 
		       WHERE tb_marca.id_marca=tb_producto.id_marca 
		         AND tb_categoria.id_categoria=tb_producto.id_categoria 
		         AND tb_producto.id_producto=tb_compra_producto.id_producto 
		         AND tb_compra_producto.stock_actual>0 
		         AND tb_compra_producto.estado='Activo'
		    -- GROUP BY tb_compra_producto.id_producto
		    ";
		return parent::ejecutar($sql);
	}

	public function mostrarIdProductoDeCompra($idcompra)
	{
		$sql="SELECT id_producto FROM tb_compra_producto WHERE id_compra_producto=$idcompra";
		return parent::ejecutar($sql);
	}

	public function mostrarDetallesDeProductoDeUnaCOmpra($idcompra)
	{
		$sql="SELECT id_compra_producto, (tb_producto.nombre_producto)AS nombrePrduct,(tb_producto.codigo_producto)AS codProduct,(tb_compra_producto.precio_venta_prod)AS precioVentaprod, (tb_compra_producto.precio_venta_prod_Fact)AS precioVentaProdFact, (tb_compra_producto.stock_actual)AS stockActual 
FROM tb_compra_producto,tb_producto
WHERE tb_producto.id_producto=tb_compra_producto.id_producto AND tb_compra_producto.id_compra_producto=$idcompra";
   return parent::ejecutar($sql);
	}

	public function actualizarStockDeLoteProd($stockActual,$idCompraProducto)
	{
		$sql="UPDATE tb_compra_producto SET stock_actual=$stockActual WHERE id_compra_producto=$idCompraProducto ";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;

	}
	public function mostrarStockActualDeCompraProd($idCompraProducto)
	{
		$sql="SELECT stock_actual FROM tb_compra_producto WHERE id_compra_producto=$idCompraProducto";
		return parent::ejecutar($sql);
	}

	public function reporteInventario()
	{
		$sql="SELECT b.id_compra_producto, 
		             a.nombre_producto,
		             a.codigo_producto,
		             a.descripcion,
		             c.nombre_marca,
		             d.nombre_categoria,
		             b.stock_actual,
		             b.precio_unit_compra,
		             b.precio_venta_prod,
                     b.precio_venta_prod_Fact 
			FROM tb_producto as a 
			    INNER JOIN tb_compra_producto as b ON  a.id_producto=b.id_producto 
			    INNER JOIN tb_marca as c ON c.id_marca= a.id_marca
			    INNER JOIN tb_categoria as d ON a.id_categoria=d.id_categoria
			WHERE 
             b.stock_actual>0
             and b.estado='Activo'";
             return parent::ejecutar($sql);
	}

	public function listadoProductosDisponiblesConStock()
	{
		$sql="SELECT b.id_compra_producto, 
		             a.nombre_producto,
		             a.codigo_producto,
		             a.descripcion,
		             c.nombre_marca,
		             d.nombre_categoria,
		             b.stock_actual,
		             b.precio_unit_compra,
		             b.precio_venta_prod,
                     b.precio_venta_prod_Fact 
			FROM tb_producto as a 
			    INNER JOIN tb_compra_producto as b ON  a.id_producto=b.id_producto 
			    INNER JOIN tb_marca as c ON c.id_marca= a.id_marca
			    INNER JOIN tb_categoria as d ON a.id_categoria=d.id_categoria
			WHERE 
                 b.stock_actual>0
             and a.estado_producto='Activo'
             order by a.nombre_producto asc";
             return parent::ejecutar($sql);
	}


	public function listadoProductosDisponiblesActivos()
	{
		$sql="SELECT b.id_compra_producto, 
		             a.nombre_producto,
		             a.codigo_producto,
		             a.descripcion,
		             c.nombre_marca,
		             d.nombre_categoria,
		             b.stock_actual,
		             b.precio_unit_compra,
		             b.precio_venta_prod,
                     b.precio_venta_prod_Fact 
			FROM tb_producto as a 
			    INNER JOIN tb_compra_producto as b ON  a.id_producto=b.id_producto 
			    INNER JOIN tb_marca as c ON c.id_marca= a.id_marca
			    INNER JOIN tb_categoria as d ON a.id_categoria=d.id_categoria
			WHERE 
             a.estado_producto='Activo'
             order by a.nombre_producto asc ";
             return parent::ejecutar($sql);
	}

	public function editarCompraProducto($idcompra)
	{
		$sql="UPDATE tb_compra_producto
		        set subtotal_compra='$this->subtotal_compra',
		            cantidad_compra ='$this->cantidad_compra',
		            id_producto ='$this->id_producto',
		            precio_unit_compra='$this->precio_unit_compra',
		            precio_unit_compraFacturado='$this->precio_unit_compraFacturado',
		            precio_venta_prod='$this->precio_venta_prod',
		            precio_venta_prod_Fact='$this->precio_venta_prod_Fact',
		            stock_actual='$this->stock_actual',
		            precio_tope='$this->precio_tope'
            WHERE id_compra=$idcompra ";
            
       if (parent::ejecutar($sql)) 
			 return true;
		 else
			 return false;

	}
	public function obtenerProductoPorCodigoBarra($codigoBarra)
	{
		$sql="SELECT (tb_compra_producto.id_compra_producto)as idcompraprod, 
						(tb_producto.nombre_producto)as mombreProducto,
						(tb_producto.codigo_producto)as codigoProducto,
						(tb_producto.descripcion)as prodDescripsion,
						(tb_marca.nombre_marca)as marcaProd,
						(tb_categoria.nombre_categoria)as catProd,
						(tb_compra_producto.stock_actual)as stokactual,
						(tb_compra_producto.precio_venta_prod)as precioVentaprod,
						(tb_compra_producto.precio_venta_prod_Fact)as precioVentaprodFact 
				FROM tb_compra_producto,
						tb_producto,
						tb_marca,
						tb_categoria 
				WHERE tb_marca.id_marca=tb_producto.id_marca 
					AND tb_categoria.id_categoria=tb_producto.id_categoria 
					AND tb_producto.id_producto=tb_compra_producto.id_producto 
					AND tb_compra_producto.stock_actual>0 
					AND tb_compra_producto.estado='Activo'
					AND tb_producto.codigo_producto=$codigoBarra";
		return parent::ejecutar($sql);
	}
	public function mostrarDetallesDeProductoDeUnaCOmpraPorCodigoBarra($idcompra)
	{
		$sql="SELECT id_compra_producto, 
		             (tb_producto.nombre_producto)AS nombrePrduct,
					 (tb_producto.codigo_producto)AS codProduct,
					 (tb_compra_producto.precio_venta_prod)AS precioVentaprod, 
					 (tb_compra_producto.precio_venta_prod_Fact)AS precioVentaProdFact,
					 (tb_compra_producto.stock_actual)AS stockActual 
                FROM tb_compra_producto,
				     tb_producto
               WHERE tb_producto.id_producto=tb_compra_producto.id_producto 
			     AND tb_compra_producto.id_compra_producto=$idcompra";
         return parent::ejecutar($sql);
	}

	

}
?>