<?
	header ('content-type: text/xml');
	include("../configuracionBD4.php"); 
	require("../../baseDatos/dbRequerimientos.php");
	require("../../objetos/funcionario.class.php");
	require("../../objetos/grado.class.php");
	require("../../objetos/cargo.class.php");
  require("../../objetos/unidad.class.php");
	require("../../objetos/usuario.class.php");
	require("../../objetos/listaSolicitud.class.php");
	require("../../objetos/estadoRecurso.class.php");
		
	$unidad 	   = $_POST['codigoUnidad'];
	$nombreBuscar  = utf8_decode($_POST['nombreBuscar']);
	
	$sentidoOrden  = $_POST['sentido'];
	$camporOrden   = $_POST['campo'];
	
	$escalafon    = $_POST['escalafon'];
	$grado   	  = $_POST['grado'];
	
	$codigo	= $_POST['codigo'];
	
	//$unidad = "2495"; 
	//$nombreBuscar = "4";

	$objFuncionarios = new dbRequerimiento;
	$objFuncionarios->listaTotalRequerimiento2($unidad, $codigo, &$funcionarios);
	$cantidad = count($funcionarios);
  	echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
  	echo "<root>";
   	for ($i=0; $i<$cantidad; $i++){
   		echo "<requerimiento>";
   		echo "<codigo>".$funcionarios[$i]->getCodigoSolicitud()."</codigo>";
   		echo "<problema>".$funcionarios[$i]->getUnidad()."</problema>";
   		echo "<fecha>".$funcionarios[$i]->getFechaSolicitud()."</fecha>";
   		echo "<tipo>".$funcionarios[$i]->getProblema()."</tipo>";
   		echo "<fechaInicio>".$funcionarios[$i]->getSubProblema()."</fechaInicio>";
   		echo "<estado>".$funcionarios[$i]->getTipoMovimiento()."</estado>";
   		echo "<unidad>".$funcionarios[$i]->getUnidadOrigen()."</unidad>";
   		echo "<ide>".$funcionarios[$i]->getIdentificadores()."</ide>";
   		echo "<dif>".$funcionarios[$i]->getDiferenciaDias()."</dif>";
   		echo "<implicado>".$funcionarios[$i]->getImplicado()."</implicado>";
   		echo "<corr>".$funcionarios[$i]->getCorrelativoMov()."</corr>";
   		echo "<text>".$funcionarios[$i]->getMovimientoTexto()."</text>";
   		echo "<fInicio>".$funcionarios[$i]->getFechaInicio()."</fInicio>";
   		echo "<archivo>".$funcionarios[$i]->getArchivoSolicitud()."</archivo>";
   		echo "<fechaArchivo>".$funcionarios[$i]->getfechaArchivo()."</fechaArchivo>";
	 	  echo "</requerimiento>";
 	}
	echo "</root>";
 ?>