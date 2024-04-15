 <?php  
include_once('conexion.php');
class VentaProducto extends Conexion{
	private $id_venta_producto;
	private $codigo_prod;
	private $subtotal_venta;
	private $cantidad_prod;
	private $ventaP_facturada;
	private $precio_factura;
	private $id_compra_producto;
	private $id_venta;
	private $precio_unitario_venta;
	private $precio_compra_prod;
	private $precio_venta_establecido;
	private $estado;


	public function VentaProducto()
	{
		parent::Conexion();
		$this->id_venta_producto=0;
		$this->codigo_prod="";
		$this->subtotal_venta="";
		$this->cantidad_prod="";
		$this->ventaP_facturada=0;
		$this->precio_factura="";
		$this->id_compra_producto=0;
		$this->id_venta=0;
		$this->precio_unitario_venta=0;
		$this->precio_compra_prod=0;
		$this->precio_venta_establecido=0;
		$this->estado="";

	}

	public function setid_ventaProducto($valor)
	{
		$this->id_venta_producto=$valor;
	}
	public function getid_ventaProducto()
	{
		return $this->id_venta_producto;
	}
	public function set_codigoProducto($valor)
	{
		$this->codigo_prod=$valor;
	}
	public function get_codigoProducto()
	{
		return $this->codigo_prod;
	}
	public function set_subtotal($valor)
	{
		$this->subtotal_venta=$valor;
	}
	public function get_subtotal()
	{
		return $this->subtotal_venta;
	}

	public function set_cantidadProd($valor)
	{
		$this->cantidad_prod=$valor;
	}
	public function get_cantidadProd()
	{
		return $this->cantidad_prod;
	}

	public function set_ventaPfacturado($valor)
	{
		$this->ventaP_facturada=$valor;
	}
	public function get_ventaPfacturado()
	{
		return $this->ventaP_facturada;
	}

	public function set_precioFactura($valor)
	{
		$this->precio_factura=$valor;
	}
	public function get_precioFactura()
	{
		return $this->precio_factura;
	}

	public function set_idCompraProducto($valor)
	{
		$this->id_compra_producto=$valor;
	}
	public function get_idCompraProducto()
	{
		return $this->id_compra_producto;
	}

	public function set_idVenta($valor)
	{
		$this->id_venta=$valor;
	}
	public function get_idVenta()
	{
		return $this->id_venta;
	}
	public function set_PrecioUniTarioVenta($valor)
	{
		$this->precio_unitario_venta=$valor;
	}
	public function get_PrecioUnitarioVenta()
	{
		return $this->precio_unitario_venta;
	}
	public function set_PrecioCompraProd($valor)
	{
		$this->precio_compra_prod=$valor;
	}
	public function get_PrecioCompraProd()
	{
		return $this->precio_compra_prod;
	}

	public function set_PrecioVentaEstablecido($valor)
	{
		$this->precio_venta_establecido=$valor;
	}
	public function get_PrecioVentaEstablecido()
	{
		return $this->precio_venta_establecido;
	}

	public function set_estadoVentaProd($valor)
	{
		$this->estado=$valor;
	}
	public function get_estadoVentaProd()
	{
		return $this->estado;
	}
	


	public function guardarVentaProducto()
	{
		$sql="INSERT INTO tb_venta_producto(codigo_prod,subtotal_venta,cantidad_prod,ventaP_facturada,precio_factura,id_compra_producto,id_venta,precio_unitario_venta,precio_compra_prod,precio_venta_establecido,estado) VALUES('$this->codigo_prod','$this->subtotal_venta','$this->cantidad_prod','$this->ventaP_facturada','$this->precio_factura','$this->id_compra_producto','$this->id_venta','$this->precio_unitario_venta','$this->precio_compra_prod','$this->precio_venta_establecido','$this->estado')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function mostrarPrecioVentadeProducto($idprod)
	{
		$sql="SELECT stok_facturado,stock_simple,precio_venta,precio_compra,precio_facturado  FROM tb_producto WHERE id_compra_producto=$idprod";
		return parent::ejecutar($sql);

	}

	public function verificadorCompraFacturada($idcompraProd)
	{
		$sql="SELECT (tb_compra.compra_facturada)as switFacturado 
		        FROM tb_compra,tb_compra_producto 
		       WHERE tb_compra.id_compra=tb_compra_producto.id_compra 
		        AND tb_compra_producto.id_compra_producto=$idcompraProd
		        AND tb_compra_producto.estado='Activo' ";
		return parent::ejecutar($sql);
	}

	public function mostrarDetallesDeCompraProducto($idcompraProd)
	{
		$sql="SELECT precio_unit_compra,
		             precio_unit_compraFacturado,
		             stock_actual,
		             precio_venta_prod,
		             precio_venta_prod_Fact 
		        FROM tb_compra_producto 
		       WHERE tb_compra_producto.id_compra_producto=$idcompraProd
		         and tb_compra_producto.estado='Activo'";
		return parent::ejecutar($sql);
	}
    /*MUESTRA LA CANTIDAD DE ITEM DE UNA VENTA*/
	public function cantidadItemVenta($idventa)
	{
		$sql="SELECT COUNT(id_venta_producto)as cantidad 
		        FROM tb_venta_producto 
		       WHERE id_venta=$idventa 
		         and estado='Activo'";
        return parent::ejecutar($sql);
	}
	 /*LISTA TODOS LOS ITEM DE VENTA PRODUCTO DE UNA VENTA*/
	public function listarVentaProdDeVenta($idventa)
	{
		$sql="SELECT id_venta_producto,
                     id_compra_producto,
                     cantidad_prod 
                FROM tb_venta_producto 
               WHERE id_venta=$idventa
                 and estado='Activo' ";
           return parent::ejecutar($sql);
	}
    /*DA DE BAJA UN REGISTRO DE VENTA PRODUCTO*/
	public function darBajaVentaProducto($id_venta_producto)
	{
		$sql="UPDATE tb_venta_producto 
		         set estado='Inactivo'
		       WHERE id_venta_producto=$id_venta_producto
		         and estado='Activo' ";
		 if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function mostrarCantidadVentasDeCodCompra($idcompraProd)
   {
   	$sql="SELECT COUNT(id_venta_producto) as cantidad_ventas 
   	        FROM tb_venta_producto 
   	       WHERE id_compra_producto=$idcompraProd
   	         and estado='Activo'";
   	      return parent::ejecutar($sql);
   }

   public function mostrarVentaQueEstaEncierre($idventa)
   {
   	$sql="SELECT count(a.id_venta) as id_venta 
            FROM tb_venta as a
      inner join tb_cierre_caja_venta as b 
              on a.id_venta=b.id_venta
             and b.estado='Activo'
           WHERE a.estado='Activo'
             and a.id_venta=$idventa";
             return parent::ejecutar($sql);
   }

	

    
		

}
?>