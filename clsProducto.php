<?php
include_once('clsConexion.php');
class Producto extends Conexion
{
	//atributos
	private $id_producto;
	private $descripcion;
	private $precio;
	private $id_categoria;

	//construtor
	public function Producto()
	{   parent::Conexion();
		$this->id_producto=0;
		$this->descripcion="";
		$this->precio=0;
		$this->id_categoria=0;
	}
	//propiedades de acceso
	public function setIdProducto($valor)
	{
		$this->id_producto=$valor;
	}
	public function getIdProducto()
	{
		return $this->id_producto;
	}

	public function setDescripcion($valor)
	{
		$this->descripcion=$valor;
	}
	public function getDescripcion()
	{
		return $this->descripcion;
	}

	public function setPrecio($valor)
	{
		$this->precio=$valor;
	}
	public function getPrecio()
	{
		return $this->precio;
	}

	public function setIdCategoria($valor)
	{
		$this->id_categoria=$valor;
	}
	public function getIdCategoria()
	{
		return $this->id_categoria;
	}

	public function guardar()
	{
     $sql="insert into producto(descripcion,precio,id_categoria) values('$this->descripcion',$this->precio,$this->id_categoria)";		
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
	
	public function modificar()	{
	$sql="update producto set descripcion='$this->descripcion',precio=$this->precio
	where id_producto=$this->id_producto";		
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
	
	public function eliminar(){
		$sql="delete from producto where id_producto=$this->id_producto";		
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
	
	public function buscarPorDescripcion($criterio)
	{
	    //No se esta tomando en cuenta el decremento del stock de la tabla producto
		$sql="select id_producto, descripcion, precio, nombre from producto, categoria 
		 where producto.id_categoria=categoria.id_categoria and descripcion like '$criterio%'";
		return parent::ejecutar($sql);
	}										

	public function buscarPorCategoria($criterio)
	{
		$sql="select id_producto, descripcion, precio, nombre from producto, categoria 
		 where producto.id_categoria=categoria.id_categoria and nombre like '$criterio%'";
		return parent::ejecutar($sql);
	}

    public function buscarPorCategoriaDescripcion($criterio){
	 $sql="select id_producto, descripcion, precio, nombre from producto, categoria 
		where producto.id_categoria=categoria.id_categoria and (nombre like '%$criterio%' or descripcion like '%$criterio%')";
		return parent::ejecutar($sql);	
	}	


	public function buscar(){
		$sql="select id_producto, descripcion, precio, nombre from producto, categoria 
		 where producto.id_categoria=categoria.id_categoria order by id_producto";
		return parent::ejecutar($sql);
	}										
	
	public function buscarPorCodigo($criterio){
		$sql="select id_producto,descripcion, precio, nombre from producto, categoria 
		 where producto.id_producto='$criterio' and producto.id_categoria=categoria.id_categoria";
		return parent::ejecutar($sql);
	}

}    
?>