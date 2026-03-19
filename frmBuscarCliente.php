<?php
ob_start();
session_start();
include_once('clsCliente.php');
?>
<html>
<head>
<title></title>
<script> 
function Insertar(){ 
    opener.document.location.reload() 
    window.close() 
} 
</script> 
<!-- Llamada a la CSS -->
<link rel="stylesheet" href="estilo.css" type="text/css" />

</head>
<body>
<center><form id="form1" method="POST" action="frmBuscarCliente.php">
<fieldset id="form">
<legend>BUSQUEDA DE CLIENTES</legend>
<table width="342" border="0">
	<tr>
		<td>
		<label>Busqueda</label>
		</td>
		<td>
		 <input name="txtBuscarCli" type="text" size="20" value="" id="txtBuscarCli" />
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<center>
		<input type="submit" name="botones" class="btn" value="Buscar" />    
		<input type="submit" class="btn" name="botones"  value="Volver" /></center>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<center><label>
		<input type="radio" checked="checked" name="grupo" value="Nombre">Por cliente  
		<input type="radio" name="grupo" value="Empresa">Por Empresa
		</label></center>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		 <?php
		  if($_POST['botones']=="Buscar" || $_GET['pnuevo_cli'])
		  {
		  	$aux=new Cliente();
			if($_GET['pnuevo_cli'])
			{
				 	$clientes=$aux->buscarPorCodigo($_GET['pnuevo_cli']);
			}
			else
			{
			  if($_POST['grupo']=="Nombre")
			  {
			    $clientes=$aux->buscarPorNombreApellidos($_POST['txtBuscarCli']);
			  }
			  if($_POST['grupo']=="Empresa")
			  {
			    $clientes=$aux->buscarPorEmpresa($_POST['txtBuscarCli']);
			  }
		  }
				  
		   echo "<table border='1' align='left' width='520' >";
		   echo "<tr bgcolor='black' align='center'><td><font color='white'>Codigo</font></td>
		   <td><font color='white'> Nombre</font></td>
		   <td><font color='white'> Apellidos</font></td>
		   <td><font color='white'> Empresa</font></td>
		   <td><font color='white'> Telefono</font></td>		   
		   <td><font color='white'> Direccion</font></td>
		   <td><font color='white'>*</font></td></tr>";
		   while($f=mysqli_fetch_object($clientes))
		   {
			echo "<tr>";
			echo "<td>$f->id_cliente</td>";
			echo "<td>$f->nombre</td>";
			echo "<td>$f->apellidos</td>";
			echo "<td>$f->empresa</td>";
			echo "<td>$f->telefono</td>";
			echo "<td>$f->direccion</td>";		
			echo "<td><a href='frmBuscarCliente.php? pnom_cli=$f->nombre $f->apellidos&pid_cli=$f->id_cliente' > << </a> </td>";
			echo "</tr>";
		   }
				echo "</table>";
		  }
		  if($_POST['botones']=="Volver")
		  {
		  	echo "<script>window.close()</script>";
		  }
	  ?>
		</td>
	</tr>
	<tr>
	<td colspan="2"><center><a href='frmCliente.php' > Nuevo Cliente </a></center> </td>
	</tr>
</table>
</form></center>
<?php
if($_GET['pnom_cli'])
{
 $_SESSION['nombrecli']=$_GET['pnom_cli']; //manda al formulario Venta el nombre y apellidos
 $_SESSION['idcliente']=$_GET['pid_cli'];
 
echo "<script> 
     opener.document.location.reload() 
     window.close() 
     </script>";
}

?>
</body>
</html>