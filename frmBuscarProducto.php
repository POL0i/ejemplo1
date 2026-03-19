<?php
ob_start();
include_once('clsCarro.php');
session_start();
?>

<?php
include_once('clsProducto.php');
?>
<html>
<head>
<!-- Llamada a la CSS -->
<link rel="stylesheet" href="estilo.css" type="text/css" />

</head>
<body>
<center><form id="form1" method="post" action="frmBuscarProducto.php">
<fieldset id="form">
<legend>BUSQUEDA DE PRODUCTOS</legend>
<table width="350" border="0">
   <tr>
    <td width="100"><label>Buscar por producto o categoria</label></td>
    <td width="50">
  	<?php $pro=$_GET['ppro']; ?>	          
    <input name="txtDescripcionCat" type="text" value="<?php echo $pro; ?>" id="txtDescripcionCat"/>
	<input type="submit" name="botones" class="btn" value="Buscar" />			
    </label></td>
   </tr>
      
   <tr>
	<td><label>Precio venta</label></td>
    <td>
	  <?php $pre=$_GET['ppre']; ?>	
	  <input name="txtPreciov" type="text" size="3" value="<?php echo $pre; ?>" id="txtPreciov" />
	  <label>Cantidad</label>
	  <input name="txtCantidad" type="text" size="3" value="1" id="txtCantidad" />
	</td>
   </tr>
	
   <tr>
      <td>  
      <?php $id_pro=$_GET['pid_producto']; ?>	  
      <input name="txtCodProducto" type="hidden" size="4" value="<?php echo $id_pro; ?>" id="txtCodigoProducto" /></td>
      <td><center><label>  
      <input type="submit" name="botones" class="btn" value="AgregarProducto" />
	  <input type="submit" name="botones" class="btn" value="Volver" />
      </label></center></td>
   </tr>	
   <tr>
      <td colspan="2">	     </td>
    </tr>
	<tr>
	<td colspan="2">
	 <?php
	   if($_POST['botones']=="Buscar")
	   {	
	      $p=new Producto();
	      $reg=$p->buscarPorCategoriaDescripcion($_POST['txtDescripcionCat']);
		  echo "<center><table border='1' align='left' width='480'>";
		  echo "<tr bgcolor='black' align='center'>
		  <td><font color='white'> Codigo</font></td>
		  <td><font color='white'> Descripcion</font></td>
		  <td><font color='white'> Precio</font></td>
		  <td><font color='white'> Categoria</font></td>
		  <td><font color='white'>*</font></td></tr>";
		  while($fila=mysqli_fetch_object($reg))
		  {
			echo "<tr>";
			echo "<td>$fila->id_producto</td>";
			echo "<td>$fila->descripcion</td>";
			echo "<td>$fila->precio</td>";
			echo "<td>$fila->nombre</td>";	
			echo "<td><a href='frmBuscarProducto.php? ppro=$fila->descripcion&pid_producto=$fila->id_producto&ppre=$fila->precio&pcat=$fila->nombre'> << </a> </td>";
			echo "</tr>";
		  }
			echo "</table></center>";
	     }		  
	  ?>
	</td>
	</tr>
 </table>
</form></center>
<?php
	if ($_POST['botones']=="AgregarProducto")
	{
		if($_POST['txtCodProducto'] && $_POST['txtCantidad']&& $_POST['txtPreciov'])
		{
			$_SESSION['carrito']->Insertar($_POST['txtCodProducto'],$_POST['txtCantidad'],
				$_POST['txtPreciov']);
			echo "<script>opener.document.location.reload() 
					window.close()</script>";
		}
		else
		{
			echo "Debe introducir todos los datos";
		}
	}
	
	if($_POST['botones']=="Volver")
	{
		header ("Location: http://localhost/maestro-detalle2/frmVenta.php");
	}
	
?>
</body>
</html>