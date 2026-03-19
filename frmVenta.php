<?php
ob_start();
include_once('clsCarro.php');
session_start();
?>
<?php
include_once('clsVenta.php');
include_once('clsDetalleVenta.php');
include_once('clsCliente.php');
include_once('clsProducto.php');
?>
<?php
if(!$_SESSION['carrito'])
{
  $_SESSION['carrito']=new Carrito();
}
if(!isset($_SESSION['nombrecli'])){$_SESSION['nombrecli']=$_POST['txtBuscarCli'];}
if(!isset($_SESSION['idcliente'])){$_SESSION['idcliente']=$_POST['txtIdCliente'];}
if(!isset($_SESSION['idventa'])){$_SESSION['idventa']=$_POST['txtIdVenta'];}
if(!isset($_SESSION['nuevocliente'])){$_SESSION['nuevocliente']="existe";}

if($_POST['botones']=="Nuevo")
{nuevo();}

function nuevo(){
	$_SESSION['nombrecli']="";
	$_SESSION['idcliente']="";
	$_SESSION['idventa']="";
	$_SESSION['carrito']=new Carrito();
}
?>

<html>
<head>
<title>Registro de Ventas</title>
<script> 
var miPopup 
function abreBuscarCliente(){ 
    miPopup = window.open("frmBuscarCliente.php","miwin","width=600,height=400,scrollbars=yes")
     miPopup.focus() 
} 

function abreBuscarProducto(){ 
    miPopup = window.open("frmBuscarProducto.php","miwin","width=600,height=350,scrollbars=yes")
     miPopup.focus() 
}

function abreBuscarVenta(){ 
    miPopup = window.open("frmBuscarVenta.php","miwin","width=600,height=350,scrollbars=yes")
     miPopup.focus() 
}  
</script> 

<!-- Llamada a la CSS -->
<link rel="stylesheet" href="estilo.css" type="text/css" />
</head>
<body>
<center> <form id="form1" name="form1" method="post" action="frmVenta.php">
<fieldset id="form">
<legend>REGISTRO DE VENTAS </legend>
  <table width="342" border="0">
  <tr>
   <td>   </td>
    <td>
	 <?php
	 if($_GET['pid_ven']){
	   $id_ven=$_GET['pid_ven']; 
	   $_SESSION['idventa']=$id_ven;
	 }
	 ?>
    <input name="txtIdVenta" type="hidden" readonly="false" value="<?php echo $_SESSION['idventa']; ?>" id="txtIdVenta" />
    </td>
    </tr>
    <tr>
      <td width="79"><label>Fecha</label></td>
      <td width="253"><label>
	  <?php
	   if($_GET['pfecha']){
	     $fecha=$_GET['pfecha'];
	  }
	  ?>
	   <input name="txtFecha" type="date" maxlength="8" size="8" value="<?php echo $fecha ?>" 
	   id="txtFecha" />
	   </label>
	  </td>
    </tr>
    <tr>
      <td><label>Cliente</label></td>
      <td><label>
  	  <?php
	  if($_GET['pnom_cli']){
	   $nom_cli=$_GET['pnom_cli']; 
	   $_SESSION['nombrecli']=$nom_cli;
	  }	  
	  ?>	 
	 
      <input name="txtNombreCli" type="text" value="<?php echo $_SESSION['nombrecli']; ?>" 
      id="txtNombreCli" />
	  <a href="#" onClick="abreBuscarCliente()">Buscar</a>
	  <?php
	   if($_GET['pid_cli']){
	   $id_cli=$_GET['pid_cli'];
	   $_SESSION['idcliente']=$id_cli; 
	  }
	  ?>
      <input name="txtIdCliente" type="text" readonly="true" size="3" value="<?php echo $_SESSION['idcliente']; ?>" id="txtIdCliente"/>
      </label></td>
     </tr>
	
      <tr>
      <td colspan="2">
	  <a href="#" onClick="abreBuscarProducto()"><b>Agregar productos<b></a>
	 	  
	 <?php
		if($_GET['pelim']){
			$_SESSION["carrito"]->Eliminar($_GET['pelim']-1);
		}
		
		echo "<table border='1' align='left' width='500'>";
		echo "<tr bgcolor='black' align='center'>
		<td width='520'><font color='white'>Descripcion del producto</font></td>			   	   
		<td><font color='white'> Precio</font></td>
		<td><font color='white'> Cantidad</font></td>
		<td><font color='white'> Subtotal</font></td>
		<td><font color='white'>*</font></td></tr>";
			   
		if($_SESSION['carrito']->getDim()>0)
	 	{
		    $total=0;
			for($k=1;$k<=$_SESSION['carrito']->getDim();$k++)
			{
			 $aux=new Producto();
			 $productos=$aux->buscarPorCodigo($_SESSION['carrito']->getProducto($k-1));
			while($fila=mysqli_fetch_object($productos))
			{
				$cant=$_SESSION['carrito']->getCantidad($k-1);
				$prec=$_SESSION['carrito']->getPrecio($k-1);
				$subt=$cant*$prec;
				$total=$total+$subt;
				echo "<tr bgcolor='44BB77'>";
				echo "<td>$fila->descripcion</td>";	
				echo "<td>$prec</td>";					
				echo "<td>$cant</td>";	
				echo "<td>$subt</td>";
				echo "<td><a href='frmVenta.php? pelim=$k'> [X] </a> </td>";
				echo "</tr>";
			}
		 }
				echo "<tr><td colspan='4'>TOTAL</td><td>$total</td></tr>";
		}
				echo "</table>";
			
    ?>  </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label></label></td>
    </tr>
      <tr>
      <td colspan="2">
	 <center> <label>
	  <input type="submit" name="botones" class="btn" value="Nuevo" />
      <input type="submit" name="botones" class="btn" value="Guardar" />
      <input type="submit" name="botones" class="btn" value="Modificar" />     
	  <input type="button" name="botones" class="btn" value="Buscar" onClick="abreBuscarVenta()" />
      </label></center>	  </td>
    </tr>
  </table>
</form></center>

<?php

function guardar()
{
	if($_POST['txtIdCliente'] && $_POST['txtNombreCli']&& $_POST['txtFecha'])
	{
	$v1= new Venta();
	$v1->setFecha($_POST['txtFecha']);
	$v1->setIdCliente($_POST['txtIdCliente']);					
	if ($v1->guardar())
	{	  
	  for($i=1;$i<=$_SESSION['carrito']->getDim();$i++)
	  {
		 $det=new DetalleVenta();
		 $det->setIdVenta($v1->ultimo_codigo());
		 $det->setIdProducto($_SESSION['carrito']->getProducto($i-1));
		 $det->setPreciov($_SESSION['carrito']->getPrecio($i-1));
		 $det->setCantidad($_SESSION['carrito']->getCantidad($i-1));
		 $det->guardar();
	  }		
	  echo "Venta Guardada..!!!";			
	}
		else
			echo "Error al guardar la Venta";			
	}
	else
		echo "Guardar:Campos obligatorios";
}	

function modificar()
{
	if($_POST['txtIdCliente'] && $_POST['txtNombreCli']&& $_POST['txtFecha'] && $_POST['txtIdVenta'])
	{
		$det=new DetalleVenta();
		$det->setIdVenta($_POST['txtIdVenta']);
		$det->eliminardetalle();
		for($k=1;$k<=$_SESSION['carrito']->getDim();$k++)
		{
	  	  $det->setIdProducto($_SESSION['carrito']->getProducto($k-1));
		  $det->setPreciov($_SESSION['carrito']->getPrecio($k-1));
		  $det->setCantidad($_SESSION['carrito']->getCantidad($k-1));
		  $det->guardar();
		}	
		$ven= new Venta();
		$ven->setIdVenta($_POST['txtIdVenta']);
		$ven->setIdCliente($_POST['txtIdCliente']);
		$ven->setFecha($_POST['txtFecha']);
		if ($ven->modificar()){	  
			echo "Venta Modificada..!!!";			
		}
		else
			echo "Error al Modificar la Venta";
	}
	else
		echo "Modificar::Campos obligatorios";
}

function eliminar()
{
	if($_POST['txtIdCliente'] && $_POST['txtNombreCli']&& $_POST['txtFecha'] && $_POST['txtIdVenta'])
	{
		$obj2=new DetalleVenta();
		$obj2->setIdVenta($_POST['txtIdVenta']);
		$obj2->eliminardetalle();
		$obj= new Venta();
		$obj->setIdVenta($_POST['txtIdVenta']);
		if ($obj->eliminar()){		  
			echo "Venta Eliminada..!!!";			
		}
		else
			echo "Error al Eliminar la Venta";
	}
	else
		echo "Eliminar::Campos obligatorios";	
}  
 
//hasta aqui el programa principal
  switch($_POST['botones'])
  {
	case "Guardar":{
    guardar();
	}break;

	case "Modificar":{
    modificar();
	}break;

	case "Eliminar":{
     eliminar();
	}break;
  }
?>  

</body>
</html>
<?php
ob_end_flush();
?>
