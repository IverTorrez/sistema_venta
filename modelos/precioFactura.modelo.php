<?php  
include_once('conexion.php');
class Precio_Factura extends Conexion{
	private $id_precio_factura;
	private $porcentaje_p_nofacturado;
	private $porcentaje_p_facturado;
	private $id_administrador;

	public function Precio_Factura()
	{
		parent::Conexion();
		$this->id_precio_factura=0;
		$this->porcentaje_p_nofacturado=0;
		$this->porcentaje_p_facturado=0;
		$this->id_administrador=0;

	}

	public function setid_PrecioFactura($valor)
	{
		$this->id_precio_factura=$valor;
	}
	public function getid_PrecioFactura()
	{
		return $this->id_precio_factura;
	}
	public function set_PorcentajeProductNoFacturado($valor)
	{
		$this->porcentaje_p_nofacturado=$valor;
	}
	public function get_PorcentajeProductNoFacturado()
	{
		return $this->porcentaje_p_nofacturado;
	}
	public function set_PorcentajeProductFacturado($valor)
	{
		$this->porcentaje_p_facturado=$valor;
	}
	public function get_PorcentajeProductFacturado()
	{
		return $this->porcentaje_p_facturado;
	}

	public function set_idAdmin($valor)
	{
		$this->id_administrador=$valor;
	}
	public function get_idAdmin()
	{
		return $this->id_administrador;
	}

	

	public function guardarPrecioFactura()
	{
		$sql="INSERT INTO tb_precio_factura(porcentaje_p_nofacturado,porcentaje_p_facturado,id_administrador) VALUES('$this->porcentaje_p_nofacturado','$this->porcentaje_p_facturado','$this->id_administrador')";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;
	}

	public function modificarPrecioFactura()
	{
		$sql="UPDATE tb_precio_factura SET porcentaje_p_nofacturado='$this->porcentaje_p_nofacturado',porcentaje_p_facturado='$this->porcentaje_p_facturado',id_administrador='$this->id_administrador'";
		if (parent::ejecutar($sql)) 
			return true;
		else
			return false;

	}

	public function mostrarLosPreciosFactura()
	{
		$sql="SELECT id_precio_factura, porcentaje_p_nofacturado,porcentaje_p_facturado, FROM tb_precio_factura WHERE id_precio_factura=1";
		return parent::ejecutar($sql)
	}

	

    
		

}
?>