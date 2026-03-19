<?php
include_once('clsConexion.php');
class DetalleVenta extends Conexion
{
	//atributos
	private $id_venta;
	private $id_producto;
	private $preciov;
	private $cantidad;

	//construtor
	public function DetalleVenta()
	{   parent::Conexion();
		$this->id_venta=0;
		$this->id_producto=0;
		$this->cantidad=0;		
		$this->preciov=0;
	}
	//propiedades de acceso
	public function setIdVenta($valor){
		$this->id_venta=$valor;
	}
	public function getIdVenta(){
		return $this->id_venta;
	}

	public function setIdProducto($valor){
		$this->id_producto=$valor;
	}
	public function getIdProducto()	{
		return $this->id_producto;
	}

    public function setPreciov($valor){
		$this->preciov=$valor;
	}
	
	public function getPreciov(){
		return $this->preciov;
	}

	public function setCantidad($valor){
		$this->cantidad=$valor;
	}
	public function getCantidad(){
		return $this->cantidad;
	}

	public function guardar(){
     $sql="insert into detalle_venta(id_venta,id_producto,preciov,cantidad) values($this->id_venta,$this->id_producto,$this->preciov,$this->cantidad)";		
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
	
	public function modificar(){
	$sql="update detalle_venta set preciov=$this->preciov , cantidad=$this->cantidad where id_venta=$this->id_venta and id_producto=$this->id_producto";		
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
	
	public function eliminar()	{
		$sql="delete from detalle_venta where id_venta=$this->id_venta and id_producto=$this->id_producto";
		
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
	
	public function eliminardetalle(){
		$sql="delete from detalle_venta where id_venta=$this->id_venta";		
		if(parent::ejecutar($sql))
			return true;
		else
			return false;
	}
	
	public function buscar($criterio) {
	$sql="select * from detalle_venta where id_venta=$criterio";
		return parent::ejecutar($sql);
	}
}    
?>