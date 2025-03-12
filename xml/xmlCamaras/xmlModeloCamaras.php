<?
	header ('content-type: text/xml');
	include("../configuracionBD4.php"); 
	require("../../baseDatos/dbModeloCamaras.class.php");
	require("../../objetos/modeloCamara.class.php");

	$marca = $_POST["marca"];
	
	$objModelo = new dbModeloCamaras;
	$objModelo->listaModelosCamaras($marca, &$modelos);
	$cantidad = count($modelos);
	
  	echo "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>";
  	echo "<root>";
   	for ($i=0; $i<$cantidad; $i++){
   		echo "<modelo>";
   		echo "<codigoModelo>".$modelos[$i]->getCodigo()."</codigoModelo>";
   		echo "<descripcionModelo>".$modelos[$i]->getDescripcion()."</descripcionModelo>";
	 	echo "</modelo>";
 	}
	echo "</root>";
 ?>