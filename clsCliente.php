<?php
include_once('clsConexion.php');
class Cliente extends Conexion
{
	//atributos
	private $id_cliente;
	private $nombre;
	private $apellidos;
	private $empresa;
	private $telefono;
	private $direccion;

	//construtor
	public function Cliente()
	{   parent::Conexion();
		$this->id_cliente=0;
		$this->nombre="";
		$this->apellidos="";
		$this->empresa="";
		$this->telefono="";
		$this->direccion="";
	}
	//propiedades de acceso
	public function setIdCliente($valor)
	{
		$this->id_cliente=$valor;
	}
	public function getIdCliente()
	{
		return $this->id_cliente;
	}

	public function setNombre($valor)
	{
		$this->nombre=$valor;
	}
	public function getNombre()
	{
		return $this->nombre;
	}

	public function setApellidos($valor)
	{
		$this->apellidos=$valor;
	}
	public function getApellidos()
	{
		return $this->apellidos;
	}

	public function setEmpresa($valor)
	{
		$this->empresa=$valor;
	}
	public function getEmpresa()
	{
		return $this->empresa;
	}

	public function setTelefono($valor)
	{
		$this->telefono=$valor;
	}
	public function getTelefono()
	{
		return $this->telefono;
	}

	public function setDireccion($valor)
	{
		$this->direccion=$valor;
	}
	public function getDireccion()
	{
		return $this->direccion;
	}

	public function ultimo_codigo()	{
	  $s="select max(id_cliente) as maximo from cliente";	  
	  $reg = parent::ejecutar($s);	
	  $row =mysqli_fetch_array($reg);
	  $ultimo=$row['maximo'];
	  $ultimo=$ultimo;
      return $ultimo;
	}
	
	public function guardar()
	{
     $sql="insert into cliente(nombre,apellidos,empresa,telefono,direccion) 
	 values('$this->nombre','$this->apellidos','$this->empresa','$this->telefono','$this->direccion')";
		
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
	
	public function modificar()	{
	$sql="update cliente set nombre='$this->nombre',apellidos='$this->apellidos',empresa='$this->empresa',telefono='$this->telefono',
	direccion='$this->direccion' where id_cliente=$this->id_cliente";		
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
	
	public function eliminar()
	{
		$sql="delete from cliente where id_cliente=$this->id_cliente";
		
		if(parent::ejecutar($sql))
			return true;
		else
			return false;	
	}
		
	
	public function buscarPorApellidos($criterio)
	{
		$sql="select *from cliente where apellidos like '$criterio%'";
		return parent::ejecutar($sql);
	}										

	/*public function buscar()
	{
		$sql="select *from cliente";
		return parent::ejecutar($sql);
	}*/										

	public function buscarPorNombreApellidos($criterio)
	{
		$sql="select *from cliente where nombre like '%$criterio%' or apellidos like '%$criterio%'";
		return parent::ejecutar($sql);
	}					

	public function buscarPorEmpresa($criterio)
	{
		$sql="select *from cliente where empresa like '%$criterio%'";
		return parent::ejecutar($sql);
	}
	public function buscarPorCodigo($criterio)
	{
		$sql="select *from cliente where id_cliente='$criterio'";
		return parent::ejecutar($sql);
	}
}    
?>