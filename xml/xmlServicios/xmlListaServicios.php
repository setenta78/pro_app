<?
	header ('content-type: text/xml');
	include("../configuracionBD4.php");
	require("../../baseDatos/dbServicios.class.php");
	require("../../objetos/servicio.class.php");
	require("../../objetos/unidad.class.php");
	require("../../objetos/tipoServicio.class.php");
	require("../../objetos/tipoServicioExtraordinario.class.php");
	
	$unidad 		= $_POST['codigoUnidad'];
	$fecha1 		= $_POST['fecha1'];
	$fecha2			= $_POST['fecha2'];
	$tipoServicios	= $_POST['servicios'];
		
	if ($fecha2 == "") $fecha2 = $fecha1;
	
	$fechaPaso 		= explode("-",$fecha1);
   	$fechaBuscar1   = $fechaPaso[2] . $fechaPaso[1] . $fechaPaso[0];
   	
   	$fechaPaso 		= explode("-",$fecha2);
   	$fechaBuscar2   = $fechaPaso[2] . $fechaPaso[1] . $fechaPaso[0];
   	
	$objServicios = new dbServicios;
	$objServicios->listaServiciosUnidad($unidad, $fechaBuscar1, $fechaBuscar2, $tipoServicios, &$servicios);
	$cantidad = count($servicios);
	if ($servicios != ""){		
	  	echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
	  	echo "<root>";
	   	for ($i=0; $i<$cantidad; $i++){
	   		$fechaPaso 		= explode("-",$servicios[$i]->getFecha());
	   		$fechaMostrar   = $fechaPaso[2] . "-" . $fechaPaso[1] . "-" . $fechaPaso[0];
	   		
	   		echo "<servicio>";
	   		echo "<codUnidad>".$servicios[$i]->getUnidad()->getCodigoUnidad()."</codUnidad>";
	   		echo "<desUnidad>".$servicios[$i]->getUnidad()->getDescripcionUnidad()."</desUnidad>";
	   		echo "<correlativoServicio>".$servicios[$i]->getCorrelativo()."</correlativoServicio>";
	   		echo "<fecha>".$fechaMostrar."</fecha>";
	   		echo "<codServicio>".$servicios[$i]->getTipoServicio()->getCodigo()."</codServicio>";
	   		echo "<desServicio>".$servicios[$i]->getTipoServicio()->getDescripcion()."</desServicio>";
	   		echo "<claseServicio>".$servicios[$i]->getTipoServicio()->getTipo()."</claseServicio>";
	   		echo "<codServicioExtraordinario>".$servicios[$i]->getServicioExtraordinario()->getCodigo()."</codServicioExtraordinario>";
	   		echo "<desServicioExtraordinario>".$servicios[$i]->getServicioExtraordinario()->getDescripcion()."</desServicioExtraordinario>";
	   		echo "<horaInicio>".$servicios[$i]->getHoraInicio()."</horaInicio>";
	   		echo "<horaTermino>".$servicios[$i]->getHoraTermino()."</horaTermino>";
	   		echo "<fechaValidacion>".$servicios[$i]->getFechaValidacion()."</fechaValidacion>";
	   		echo "</servicio>";
	 	}
		echo "</root>";
	} else {
		echo "VACIO";
	}
	
 ?>