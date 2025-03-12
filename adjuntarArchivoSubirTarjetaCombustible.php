<?

$ruta		= $_POST['rutaArchivo'];
$extension	= $_POST['extension'];

$nombre		= $ruta.$extension;

if(copy($_FILES['archivo']['tmp_name'], 'archivoTarjetaCombustible/'.$nombre)){
	echo "<script>";
	echo "window.open('','_parent','');\n";
	echo "alert('ARCHIVO SUBIDO AL SERVIDOR ...');\n";
	echo "window.close()";
	echo "</script>";
}else{
	echo "alert('ERROR ...');\n";
}
?>