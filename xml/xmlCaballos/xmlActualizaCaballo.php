<?
	header ('content-type: text/xml');
	include("../configuracionBD2.php"); 
	require("../../baseDatos/dbCaballos.class.php");
	require("../../objetos/caballos.class.php");
	require("../../objetos/estadoAnimal.class.php");
	require("../../objetos/unidad.class.php");
	require("../../objetos/tipoAnimal.class.php");

			
	$codigoVehiculo			= $_POST['codigoVehiculo'];			
	

	//$codigoTipoVehiculo 	= $_POST['tipoVehiculo'];
	
	$codigoEstado	  		= $_POST['estado'];
  $fechaNuevoEstado	  	= $_POST['fechaNuevoEstado'];

	$numeroBCU				= $_POST['numeroBCU'];
	
	$codigoUnidadAgregado	= $_POST['codigoUnidadAgregado'];
	
	$nombre			= $_POST['nombre'];
	$raza				= $_POST['raza'];
	$color			= $_POST['color'];
	$pelaje			= $_POST['pelaje'];
	$tipoAnimal       = $_POST['tipoAnimal'];
	
	$verificar     = $_POST['verificar'];  
	$verificaOculto = $_POST['verificaOculto'];  
	
	
	//$codigoUnidad			= "610040000000";
	session_start();                                                 
  $codigoUnidad			= $_SESSION['USUARIO_CODIGOUNIDAD'];   	 
    
	$unidad = new unidad;
	$unidad->setCodigoUnidad($codigoUnidad);
	$unidad->setDescripcionUnidad("");
	
	$unidadAgregado = new unidad;
	$unidadAgregado->setCodigoUnidad($codigoUnidadAgregado);
	$unidadAgregado->setDescripcionUnidad("");
                        
	
	$estado = new estadoAnimal;
	$estado->setCodigo($codigoEstado);
	$estado->setDescripcion("");
	

	
	$vehiculo = new caballo;
	$vehiculo->setCodigoCaballo($codigoVehiculo);
	$vehiculo->setEstadoVehiculo($estado);
	$vehiculo->setUnidad($unidad);
	$vehiculo->setUnidadAgregado($unidadAgregado);
	$vehiculo->setNumeroBCU($numeroBCU);
  $vehiculo->setNombreCaballo($nombre);
  $vehiculo->setRaza($raza);
  $vehiculo->setColor($color);
  $vehiculo->setPelaje($pelaje);
  $vehiculo->setTipoAnimal($tipoAnimal);
  $vehiculo->setVerifica($verificar);


	
	$objDBVehiculos = new dbCaballos;
	$resultado = $objDBVehiculos->updateAnimal($vehiculo);

	
	
	
	if ($fechaNuevoEstado != ""){
		$fechaPaso 		= explode("-",$fechaNuevoEstado);
   		$fechaIngresar  = $fechaPaso[2] . "-" . $fechaPaso[1] . "-" . $fechaPaso[0];
		$resultado = $objDBVehiculos->updateEstadoAnimal($vehiculo, $fechaIngresar);
		$resultado = $objDBVehiculos->insertEstadoAnimal($vehiculo, $fechaIngresar);
	}elseif($fechaNuevoEstado == "" && $verificaOculto == "NO"){
		$resultado = $objDBVehiculos->updateAnimal($vehiculo);
	}			
			
	echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
  	echo "<root>";
   	echo "<resultado>".$resultado."</resultado>";
   	echo "</root>";
 ?>