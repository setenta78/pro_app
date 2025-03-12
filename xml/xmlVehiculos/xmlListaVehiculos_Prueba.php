<?
	header ('content-type: text/xml');
	include("../configuracionBD4.php"); 
	require("../../baseDatos/dbVehiculos.class.php");
	require("../../objetos/vehiculo.class.php");
	require("../../objetos/tipoVehiculo.class.php");
	require("../../objetos/marcaVehiculo.class.php");
	require("../../objetos/modeloVehiculo.class.php");
	require("../../objetos/procedenciaVehiculo.class.php");
	require("../../objetos/estadoVehiculo.class.php");
	require("../../objetos/unidad.class.php");
	require("../../objetos/seccion.class.php"); //Llamada agregada el 05-05-2015
		
	$unidad 	  	= $_POST['codigoUnidad'];
	$vehiculoBuscar = $_POST['vehiculoBuscar'];
	$tipoVehiculo 	= $_POST['tipoVehiculo'];
	
	//$sentidoOrden 	= $_POST['codigoUnidad'];
	//$camporOrden  	= $_POST['codigoUnidad'];
	$tipoEstado	  	= "0,1,4";
	
	//$unidad = "9560"; 
		
	$objVehiculos = new dbVehiculos;
	$objVehiculos->listaTotalVehiculosAgregados($unidad, $vehiculoBuscar, $tipoVehiculo, $camporOrden, $sentidoOrden, $tipoEstado, &$vehiculos);
	$cantidad = count($vehiculos);
	echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
  	echo "<root>";
   	for ($i=0; $i<$cantidad; $i++){
   		echo "<vehiculo>";
   		echo "<codigo>".$vehiculos[$i]->getCodigoVehiculo()."</codigo>";
   		echo "<tipo>".$vehiculos[$i]->getTipoVehiculo()->getDescripcion()."</tipo>";
   		echo "<marca>".$vehiculos[$i]->getModeloVehiculo()->getMarca()->getDescripcion()."</marca>";
   		echo "<modelo>".$vehiculos[$i]->getModeloVehiculo()->getDescripcion()."</modelo>";
   		echo "<estado>".$vehiculos[$i]->getEstadoVehiculo()->getDescripcion()."</estado>";
   		echo "<patente>".$vehiculos[$i]->getPatente()."</patente>";
   		echo "<numeroInstitucional>".$vehiculos[$i]->getNumeroInstitucional()."</numeroInstitucional>";
   		echo "<bcu>".$vehiculos[$i]->getNumeroBCU()."</bcu>";
   		echo "<procedencia>".$vehiculos[$i]->getProcedencia()->getDescripcion()."</procedencia>";
   		echo "<codigoUnidadAgregado>".$vehiculos[$i]->getUnidadAgregado()->getCodigoUnidad()."</codigoUnidadAgregado>";
   		echo "<desUnidadAgregado>".$vehiculos[$i]->getUnidadAgregado()->getDescripcionUnidad()."</desUnidadAgregado>";
      echo "<seccion>".$vehiculos[$i]->getSeccion()->getDescripcion()."</seccion>";
      echo "<unidadAgregado>".$vehiculos[$i]->getUnidadAgregado()->getDescripcionUnidad()."</unidadAgregado>";
	 	echo "</vehiculo>";
 	}
	echo "</root>";
 ?>