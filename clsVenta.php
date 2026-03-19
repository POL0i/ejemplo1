<?php
include_once('clsConexion.php');

class Venta extends Conexion{
	//atributos
	private $id_venta;
	private $fecha;
	private $id_cliente;

	//construtor
	public function Venta()
	{   parent::Conexion();
		$this->id_venta=0;
		$this->fecha="";
		$this->id_cliente=0;
	}
	
	//propiedades de acceso
	public function setIdVenta($valor){
		$this->id_venta=$valor;
	}
	
	public function getIdVenta(){
		return $this->id_venta;
	}

	public function setFecha($valor){
		$this->fecha=$valor;
	}
	public function getFecha(){
		return $this->fecha;
	}

	public function setIdCliente($valor){
		$this->id_cliente=$valor;
	}
	public function getIdCliente(){
		return $this->id_cliente;
	}

	public function ultimo_codigo()	{
	  $s="select max(id_venta) as maximo from venta";	  
	  $reg = parent::ejecutar($s);	
	  $row =mysqli_fetch_array($reg);
	  $ultimo=$row['maximo'];
	  $ultimo=$ultimo;
      return $ultimo;
	}
	
	public function guardar(){
     $sql="insert into venta(fecha,id_cliente) values('$this->fecha',$this->id_cliente)";		
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}	
	
	public function modificar() {
	  $sql="update venta set id_cliente='$this->id_cliente',fecha='$this->fecha' 
	  where id_venta=$this->id_venta";		
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
	
	/*public function modificar2(){
	$sql="update venta set fecha='$this->fecha' where id_venta=$this->id_venta";		
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}*/

	public function eliminar(){
		$sql="delete from venta where id_venta=$this->id_venta";
	
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
	
	public function buscarCliente($criterio){
		$sql="select *from cliente where nombre like '%$criterio%'";
		return parent::ejecutar($sql);
	}	
	
	public function buscarVenta($criterio){
	 $sql="select c.id_cliente, c.nombre, c.apellidos, v.id_venta, v.fecha from cliente c, venta v where c.id_cliente=v.id_cliente and (c.nombre like '%$criterio%' or c.apellidos like '%$criterio%')";
		return parent::ejecutar($sql);	
	}					
}    
?>