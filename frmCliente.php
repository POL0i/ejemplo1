<?php
 ob_start();
 session_start();
 include_once('clsCliente.php');
 $valor=$_POST['txtBuscar'];
?>

<html>
<head>
<title>Registro de Clientes</title>

<!-- Llamada a la CSS -->
<link rel="stylesheet" href="estilo.css" type="text/css"/>
</head>
<body>

<center><form id="form1" name="form1" method="post" action="frmCliente.php">
<fieldset id="form">
<legend>REGISTRO DE CLIENTES</legend>
  <table width="325" border="0">
    <tr>
      <td>&nbsp;</td>
      <td><?php $cod=$_GET['cod']; ?>
    <input name="txtIdCliente" type="text" value="<?php echo $cod; ?>" id="txtIdCliente" />
    <label></label></td>
    </tr>
    <tr>
      <td width="79"><label>Nombre</label></td>
      <td width="227"><label>
	  <?php $nom=$_GET['nom']; ?>	  
        <input name="txtNombre" type="text"  value="<?php echo $nom; ?>" id="txtNombre" />
      </label></td>
    </tr>
    <tr>
      <td><label>Apellidos</label></td>
      <td><label>
  	  <?php $ape=$_GET['ape']; ?>	  
        <input name="txtApellidos" type="text" value="<?php echo $ape; ?>" id="txtApellidos" />
      </label></td>
    </tr>
    <tr>
      <td><label>Empresa</label></td>
      <td><label>
      <?php $emp=$_GET['emp']; ?>	  
      <input name="txtEmpresa" type="text" value="<?php echo $emp; ?>" id="txtEmpresa" />
      </label></td>
    </tr>
    <tr>
      <td><label>Telefono</label></td>
      <td><label>
  	  <?php $tel=$_GET['tel']; ?>	  
        <input name="txtTelefono" type="text" value="<?php echo $tel; ?>" id="txtTelefono" />
      </label></td>
    </tr>
    <tr>
      <td><label>Direccion</label></td>
      <td><label>
  	  <?php $dir=$_GET['dir']; ?>	  
        <input name="txtDireccion" type="text" value="<?php echo $dir; ?>" id="txtDireccion" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label></label></td>
    </tr>
    <tr>
      <td colspan="2">
	  <label>
	  <input type="submit" name="bot" class="btn" value="Nuevo" />
      <input type="submit" name="bot" class="btn" value="Guardar" />
      <input type="submit" name="bot" class="btn" value="Modificar" />
      <input type="submit" name="bot" class="btn" value="Eliminar" />
      </label>
	  </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;<br>
	 <?php
	 if(!isset($_SESSION['nuevocliente']))
	  {
		echo "Buscar por ";
	  ?>
        <label>
        <input name="grupo" type="radio"  value="1" checked="checked" <?php if ($_POST['grupo']=="1") echo "checked"; ?> />
          Apellidos</label>
          <label>
          <input type="radio" name="grupo" <?php if ($_POST['grupo']=="2") echo "checked"; ?> value="2" />
          Empresa</label>
          <label>
          <input name="txtBuscar" type="text" id="txtBuscar" value="<?php echo $valor; ?>" size="33" />
          </label>
          <label></label>
          <input name="bot" type="submit" id="botones" class="btn" value="Buscar" />
          <br />
      </p>
	  <?php
	  	}
		else
		{
		echo "<center><a href='frmBuscarCliente.php'> Volver </a></center>";
		}
	  ?>
	  
	  </td>
    </tr>
	
	<tr>
	<td></td>
	</tr>
  </table>
</form></center>

<?php
function guardar()
{
	if($_POST['txtNombre'] && $_POST['txtApellidos'])
	{
		$obj= new Cliente();
		$obj->setNombre($_POST['txtNombre']);
		$obj->setApellidos($_POST['txtApellidos']);
		$obj->setEmpresa($_POST['txtEmpresa']);
		$obj->setTelefono($_POST['txtTelefono']);
		$obj->setDireccion($_POST['txtDireccion']);		
		if ($obj->guardar())
		{
			echo "Cliente Guardado..!!!";
			if($_SESSION['nuevocliente'])
			{
				$aux=$obj->ultimo_codigo();
				header("Location: http://localhost/maestro-detalle2/frmBuscarCliente.php? pnuevocli=$aux");
			}
		}
		else
			echo"Error al guardar el Cliente";
	}
	else
		echo"El nombre y el Apellido son obligatorios";
}	

function modificar()
{
	if($_POST['txtNombre'] && $_POST['txtApellidos'])
	{
		$obj= new Cliente();
		$obj->setIdCliente($_POST['txtIdCliente']);
		$obj->setNombre($_POST['txtNombre']);
		$obj->setApellidos($_POST['txtApellidos']);
		$obj->setEmpresa($_POST['txtEmpresa']);
		$obj->setTelefono($_POST['txtTelefono']);
		$obj->setDireccion($_POST['txtDireccion']);		
		if ($obj->modificar())
			echo "Cliente modificado..!!!";
		else
			echo "Error al modificar el cliente..!!!";		
	}
	else
		echo "El nombre, apellidos son obligatorios...!!!";
}

function eliminar()
{
	if($_POST['txtIdCliente'])
	{
		$obj= new Cliente();
		$obj->setIdCliente($_POST['txtIdCliente']);		
		if ($obj->eliminar())
			echo"Cliente eliminado";
		else
			echo"Error al eliminar el cliente";		
	}
	else	
		echo "para eliminar el producto, debe introducir el codigo del cliente..!!!";	
}

function buscar()
{
	$obj= new Cliente();	
	$valor=$_POST['txtBuscar'];
	switch ($_POST['grupo']) {
    case 1:{
	      $resultado=$obj->buscarPorApellidos($_POST['txtBuscar']);
              mostrarRegistros($resultado);		 		
      	   }; break;
    case 2:{
	 	$resultado=$obj->buscarPorEmpresa($_POST['txtBuscar']);
     		mostrarRegistros($resultado);	
	   }; break;
    }	
}

 function mostrarRegistros($registros)
 {
	echo "<center><table border='1' align='center'>";
	echo "<tr bgcolor='black' align='center'><td><font color='white'>Codigo</font></td>
	       <td><font color='white'> Nombre</font></td>
		   <td><font color='white'> Apellidos</font></td>
		   <td><font color='white'> Empresa</font></td>
		   <td><font color='white'> Telefono</font></td>		   
		   <td><font color='white'> Direccion</font></td>
		   <td><font color='white'>*</font></td></tr>";
	while($fila=mysqli_fetch_object($registros))
	{
		echo "<tr >";
		echo "<td>$fila->id_cliente</td>";
		echo "<td>$fila->nombre</td>";
		echo "<td>$fila->apellidos</td>";
		echo "<td>$fila->empresa</td>";
		echo "<td>$fila->telefono</td>";
		echo "<td>$fila->direccion</td>";		
		echo "<td><a href='frmCliente.php? cod=$fila->id_cliente&nom=$fila->nombre&ape=$fila->pellidos&emp=$fila->empresa&tel=$fila->telefono&dir=$fila->direccion' > Editar </a> </td>";
		echo "</tr>";
	}
	echo "</table></center>";
 }   

//hasta aqui el programa principal
  switch($_POST['bot'])
  {
	case "Nuevo":{
	}break;

	case "Guardar":{
    guardar();
	}break;

	case "Modificar":{
    modificar();
	}break;

	case "Eliminar":{
     eliminar();
	}break;

	case "Buscar":{
     buscar();
	}break;

  }
?>  
</body>
</html>
