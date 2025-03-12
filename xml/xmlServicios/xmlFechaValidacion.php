<?
	header ('content-type: text/xml');
	include("../configuracionBD4.php"); 
	require("../../baseDatos/dbServicios.class.php");
	
	$fechaServicios  = $_POST['fechaServicios'];
	$unidadServicios = $_POST['unidadServicios'];
	
	$fechaPaso 	    	  = explode("-",$fechaServicios);                                         
    $fechaServiciosBuscar = $fechaPaso[2] . $fechaPaso[1] . $fechaPaso[0];                
				
	$objServicios = new dbServicios;
	$objServicios->buscaFechaValidacion($unidadServicios, $fechaServiciosBuscar, &$fechaValidacion);
		
  	echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
  	echo "<root>";
   	echo "<fechaValidacion>".$fechaValidacion."</fechaValidacion>";
	echo "</root>";
 ?>