<?php  
include_once('conexion.php');
class Producto extends Conexion{
	private $id_producto;
	private $nombre_producto;
	private $codigo_producto;
	private $descripcion;
	private $stok_facturado;
	private $stock_simple;
	
	private $estado_producto;
	private $id_marca;
	private $id_categoria;
	private $tipo_reg;
	private $usuario_alta;
	private $fecha_alta;
	private $usuario_baja;
	private $fecha_baja;
	private $fecha_modificacion;
	private $id_almacen;

	public function Producto()
	{
		parent::Conexion();
		$this->id_producto=0;
		$this->nombre_producto="";
		$this->codigo_producto="";
		$this->descripcion="";
		$this->stok_facturado=0;
		$this->stock_simple=0;
		
		$this->estado_producto="";
		$this->id_marca=0;
		$this->id_categoria=0;
		$this->tipo_reg="";
		$this->usuario_alta=0;
		$this->fecha_alta="";
		$this->usuario_baja=0;
		$this->fecha_baja="";
		$this->fecha_modificacion="";
		$this->id_almacen=0;

	}

	public function setid_producto($valor)
	{
		$this->id_producto=$valor;
	}
	public function getid_producto()
	{
		return $this->id_producto;
	}
	public function set_nombreProducto($valor)
	{
		$this->nombre_producto=$valor;
	}
	public function get_nombreProducto()
	{
		return $this->nombre_producto;
	}
	public function set_CodigoProducto($valor)
	{
		$this->codigo_producto=$valor;
	}
	public function get_CodigoProducto()
	{
		return $this->codigo_producto;
	}

	public function set_Descripcion($valor)
	{
		$this->descripcion=$valor;
	}
	public function get_Descripcion()
	{
		return $this->descripcion;
	}


	public function set_StokFacturado($valor)
	{
		$this->stok_facturado=$valor;
	}
	public function get_StokFacturado()
	{
		return $this->stok_facturado;
	}
	public function set_StokSimple($valor)
	{
		$this->stock_simple=$valor;
	}
	public function get_StokSimple()
	{
		return $this->stock_simple;
	}
	
	public function set_estadoProducto($valor)
	{
		$this->estado_producto=$valor;
	}
	public function get_estadoProducto()
	{
		return $this->estado_producto;
	}
	public function set_idMarca($valor)
	{
		$this->id_marca=$valor;
	}
	public function get_idMarca()
	{
		return $this->id_marca;
	}
	public function set_idCategoria($valor)
	{
		$this->id_categoria=$valor;
	}
	public function get_idCategoria()
	{
		return $this->id_categoria;
	}
	public function set_tipo_reg($valor)
	{
		$this->tipo_reg=$valor;
	}
	public function get_tipo_reg()
	{
		return $this->tipo_reg;
	}
	public function set_usuario_alta($valor)
	{
		$this->usuario_alta=$valor;
	}
	public function get_usuarioAlta()
	{
		return $this->usuario_alta;
	}
	public function set_fecha_alta($valor)
	{
		$this->fecha_alta=$valor;
	}
	public function get_fecha_alta()
	{
		return $this->fecha_alta;
	}
	public function set_usuarioBaja($valor)
	{
		$this->usuario_baja=$valor;
	}
	public function get_usuarioBaja()
	{
		return $this->usuario_baja;
	}
	public function set_fecha_baja($valor)
	{
		$this->fecha_baja=$valor;
	}
	public function get_fecha_baja()
	{
		return $this->fecha_baja;
	}
	public function set_fecha_modificacion($valor)
	{
		$this->fecha_modificacion=$valor;
	}
	public function get_fecha_modificacion()
	{
		return $this->fecha_modificacion;
	}
	public function set_idalmacen($valor)
	{
		$this->id_almacen=$valor;
	}
	public function get_idalmacen()
	{
		return $this->id_almacen;
	}

	
	


	public function guardarProducto()
	{
		$sql="INSERT INTO tb_producto(nombre_producto,
			                          codigo_producto,
			                          descripcion,
			                          stok_facturado,
			                          stock_simple,
			                          estado_producto,
			                          id_marca,
			                          id_categoria,
			                          tipo_reg,
			                          usuario_alta,
			                          fecha_alta,
			                          usuario_baja,
			                          fecha_baja,
			                          fecha_modificacion,
			                          id_almacen) 
		                       VALUES('$this->nombre_producto',
		                       	      '$this->codigo_producto',
		                       	      '$this->descripcion',
		                       	      '$this->stok_facturado',
		                       	      '$this->stock_simple',
		                       	      '$this->estado_producto',
		                       	      '$this->id_marca',
		                       	      '$this->id_categoria',
		                       	      '$this->tipo_reg',
		                       	      '$this->usuario_alta',
		                       	      '$this->fecha_alta',
		                       	      '$this->usuario_baja',
		                       	      '$this->fecha_baja',
		                       	      '$this->fecha_modificacion',
		                       	      '$this->id_almacen')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function listarProductosActivos()
	{
		$sql="SELECT 
		            a.id_producto, 
		            a.nombre_producto, 
		            a.codigo_producto, 
		            a.descripcion ,
		            a.stok_facturado, 
		            a.stock_simple,
		            a.estado_producto,
		            (b.nombre_marca)AS marca_prod,
		            (c.nombre_categoria)AS cat_prod,
		            (a.id_marca)AS idmarca,
		            (a.id_categoria)AS idcategoria,
		            (CASE  WHEN a.tipo_reg= 'admin'
                           THEN (SELECT h.nombre_administrador 
                           	       FROM tb_administrador as h 
                           	      WHERE h.id_administrador=a.usuario_alta)
                            ELSE
                             (SELECT g.nombre_empleado 
                             	FROM tb_empleado as g 
                               WHERE g.id_empleado=a.usuario_alta)
                     END )AS Usuario,
		            a.fecha_alta,
		            a.fecha_modificacion,
		            d.id_almacen,
		            d.nombre_almacen
		        FROM tb_producto as a
		  inner join tb_marca as b
		          on a.id_marca=b.id_marca
		  inner join tb_categoria as c 
		          on a.id_categoria=c.id_categoria  
		  inner join tb_almacen as d
		          on a.id_almacen=d.id_almacen    
               WHERE a.estado_producto='Activo'
            order by a.nombre_producto asc ";
		return parent::ejecutar($sql);
	}

	public function listarProductosDisponiblesEnVenta()
	{
		$sql="SELECT (tb_compra_producto.id_compra_producto)AS codigo_lote,
                       nombre_producto,
				       codigo_producto,
				       descripcion,
				       nombre_marca,
				       nombre_categoria,
				       stock_actual,
				       precio_venta_prod,
				       precio_venta_prod_Fact 
                  FROM tb_producto
            inner join tb_marca
                    on tb_producto.id_marca=tb_marca.id_marca
            inner join tb_categoria
                    on tb_producto.id_categoria=tb_categoria.id_categoria
            left join tb_compra_producto
                    on tb_producto.id_producto=tb_compra_producto.id_producto
                    and tb_compra_producto.estado='Activo'   
                 where estado_producto='Activo'";
		return parent::ejecutar($sql);
	}

	public function listarProductosActivosConStock()
	{
		$sql="SELECT id_producto, nombre_producto, codigo_producto, descripcion ,stok_facturado, stock_simple,estado_producto,(tb_marca.nombre_marca)AS marca_prod,(tb_categoria.nombre_categoria)AS cat_prod,(tb_producto.id_marca)AS idmarca,(tb_producto.id_categoria)AS idcategoria FROM tb_producto,tb_marca,tb_categoria 
WHERE tb_marca.id_marca=tb_producto.id_marca AND tb_categoria.id_categoria=tb_producto.id_categoria AND estado_producto='Activo' AND (stok_facturado >0 OR stock_simple >0 )";
		return parent::ejecutar($sql);
	}

    public function actualizarProducto()
	{
		$sql="UPDATE tb_producto 
		         SET nombre_producto   ='$this->nombre_producto', 
		             codigo_producto   ='$this->codigo_producto',
		             descripcion       ='$this->descripcion',
		             id_marca          ='$this->id_marca',
		             id_categoria      ='$this->id_categoria',
		             fecha_modificacion='$this->fecha_modificacion',
		             id_almacen        ='$this->id_almacen'
		       WHERE id_producto='$this->id_producto'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function DarBajaProducto()
	{
		$sql="UPDATE tb_producto 
		         SET estado_producto='$this->estado_producto',
		             fecha_baja='$this->fecha_baja'
		       WHERE id_producto='$this->id_producto' 
		         and estado_producto='Activo'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	/*public function ponerPreciosAProducto()
	{
		$sql="UPDATE tb_producto SET precio_compra='$this->precio_compra', precio_venta='$this->precio_venta', precio_facturado='$this->precio_facturado', precio_tope='$this->precio_tope',precio_compra_fact='$this->precio_compra_fact' WHERE id_producto='$this->id_producto'  ";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}*/

	public function mostrarStockSimpleYFacturadorDeProducto($idprod)
	{
		$sql="SELECT stock_simple,stok_facturado FROM tb_producto WHERE id_producto=$idprod";
		return parent::ejecutar($sql);
	}

	public function actualizarStokSimple()
	{
		$sql="UPDATE tb_producto SET stock_simple='$this->stock_simple' WHERE id_producto='$this->id_producto' ";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function actualizarStokFacturado()
	{
		$sql="UPDATE tb_producto SET stok_facturado ='$this->stok_facturado' WHERE id_producto='$this->id_producto' ";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function mostrarUnProducto($idprod)
	{
		$sql="SELECT nombre_producto,codigo_producto,descripcion, stok_facturado,stock_simple,usuario_alta,usuario_baja,estado_producto FROM tb_producto WHERE id_producto=$idprod ";
		return parent::ejecutar($sql);
	}
	public function mostrarProductoPorCodigoBarra($codigoBarra){
		$sql="SELECT p.id_producto,
		             p.codigo_producto
		        FROM tb_producto as p
			   WHERE p.codigo_producto='$codigoBarra'
			     AND p.estado_producto='Activo' ";
		return parent::ejecutar($sql);

	}
	public function mostrarProductoPorCodigoBarraId($codigoBarra,$id){
		$sql="SELECT p.id_producto,
		             p.codigo_producto
		        FROM tb_producto as p
			   WHERE p.codigo_producto='$codigoBarra'
			   AND p.id_producto<>$id
			   AND p.estado_producto='Activo' ";
		return parent::ejecutar($sql);

	}
	

	

}
?>