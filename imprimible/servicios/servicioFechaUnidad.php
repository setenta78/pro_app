<?
	//header ('content-type: text/xml');
	include("../../xml/configuracionBD4.php");
	require("../../baseDatos/dbServicios.class.php");
	require("../../objetos/servicio.class.php");
	require("../../objetos/unidad.class.php");
	require("../../objetos/tipoServicio.class.php");
	require("../../objetos/tipoServicioExtraordinario.class.php");
	require("../../objetos/escalafon.class.php");
	require("../../objetos/grado.class.php");
	require("../../objetos/funcionario.class.php");
	require("../../objetos/medioVigilancia.class.php");
	require("../../objetos/tipoVehiculo.class.php");
	require("../../objetos/vehiculo.class.php");
	require("../../objetos/cuadrante.class.php");
	require("../../objetos/tipoAccesorio.class.php");
	require("../../objetos/tipoArma.class.php");
	require("../../objetos/arma.class.php");
	require("../../objetos/tipoAnimal.class.php");
	require("../../objetos/fechaHora.class.php");
	require("../../objetos/factor.class.php");
	require("../../objetos/animal.class.php");
	require("../../objetos/camara.class.php");

//--- CONTENIDO COMUN INICIO PDF
include ('./../imprimible.class/class.ezpdf.php');
$pdf =new Cezpdf();
$pdf->selectFont('./../imprimible.class/fonts/Helvetica.afm');

$pdf->ezSetMargins(30,30,70,30);
$pdf->ezImage("../../img/logo_carabineros.jpg", 0, 80, 'none', 'left');
$pdf->ezText("<b>CARABINEROS DE CHILE</b>",10);
$pdf->ezText("<b>PROSERVIPOL V3.9</b>",10);
$pdf->ezText("",10);
//------------------------------

	$unidad 		= $_GET['codigoUnidad'];
	$fecha1 		= $_GET['fecha1'];
	$fecha2			= $_GET['fecha2'];
	$tipoServicios	= $_GET['servicios'];
	
	$fechaMostrar = $fecha1;
	
	if ($fecha2 == "") $fecha2 = $fecha1;
	
	$fechaPaso 		= explode("-",$fecha1);
   	$fechaBuscar1   = $fechaPaso[2] . $fechaPaso[1] . $fechaPaso[0];
   	
   	$fechaPaso 		= explode("-",$fecha2);
   	$fechaBuscar2   = $fechaPaso[2] . $fechaPaso[1] . $fechaPaso[0];
	
	$sql = "SELECT 
				GRADO.GRA_DESCRIPCION,
				FUNCIONARIO.FUN_NOMBRE,
				FUNCIONARIO.FUN_APELLIDOPATERNO,
				FUNCIONARIO.FUN_APELLIDOMATERNO
			FROM SERVICIOS_CERTIFICADO
			JOIN FUNCIONARIO ON (SERVICIOS_CERTIFICADO.FUN_CODIGO = FUNCIONARIO.FUN_CODIGO)
			JOIN GRADO ON (FUNCIONARIO.ESC_CODIGO = GRADO.ESC_CODIGO AND FUNCIONARIO.GRA_CODIGO = GRADO.GRA_CODIGO)	
			WHERE SERVICIOS_CERTIFICADO.FECHA_SERVICIOS = '{$fechaBuscar1}' 
			AND SERVICIOS_CERTIFICADO.UNI_CODIGO='{$unidad}';";

$gradoValidador="";
$nombreValidador="";

$CONECT = @mysql_connect(HOST,DB_USER,DB_PASS);
mysql_select_db(DB);

$result = mysql_query($sql,$CONECT);

if($myrow = mysql_fetch_array($result)){
	$gradoValidador=$myrow[GRA_DESCRIPCION];
	$nombreValidador=$myrow[FUN_NOMBRE]." ".$myrow[FUN_APELLIDOPATERNO]." ".$myrow[FUN_APELLIDOMATERNO];
	$pdf->ezText("<b>CERTIFICADO SERVICIOS</b>",10,array('justification'=>'center'));
}
else{
	$pdf->setColor(255,0,0);
	$pdf->ezText("<b>SERVICIOS NO VALIDADOS</b>",10,array('justification'=>'center'));
	$pdf->setColor(0,0,0);
}

$pdf->ezText("",10);
	$objServiciosTotal = new dbServicios;
	$objServiciosTotal->listaServiciosUnidad($unidad, $fechaBuscar1, $fechaBuscar2, $tipoServicios, &$serviciosTotal);
	$cantidad = count($serviciosTotal);
$filasEncabezado[]=array("<b>Unidad</b>","<b>:</b>","<b>".$serviciosTotal[0]->getUnidad()->getDescripcionUnidad()."</b>");
$filasEncabezado[]=array("<b>Fecha Servicios</b>","<b>:</b>","<b>".$fechaMostrar."</b>");
$filasEncabezado[]=array("<b>Fecha de Impresión</b>","<b>:</b>","<b>".date("d-m-Y \a \l\a\s H:i:s")."</b>");

$pdf->ezTable($filasEncabezado,'','',array('colGap'=>2,'fontSize'=>8,'width'=>510,'showHeadings'=>0,'shaded'=>0,'showLines'=>0,'xPos'=>'left','xOrientation'=>'right','rowGap' =>1,'cols'=>array(array('width'=>90),array('width'=>10))));
unset($filasEncabezado);

for($contador=0;$contador<$cantidad;$contador++){
	unset($mediosVigilancia);
	unset($servicio);
	//unset($tieneHojaRuta);
	$correlativo=$serviciosTotal[$contador]->getCorrelativo();
	$objServicios = new dbServicios;
	$objServicios->buscaDatosServicio($unidad, $correlativo, &$servicio);
	$objServicios->buscaMedioVigilancia($unidad, $correlativo, &$mediosVigilancia);
	$objServicios->buscaCuadrantesAsignados($unidad, $correlativo, &$mediosVigilancia);
	$objServicios->buscaAccesoriosAsignados($unidad, $correlativo, &$mediosVigilancia);
	$objServicios->buscaArmasAsignadas($unidad, $correlativo, &$mediosVigilancia);
	//$objServicios->buscaAnimalesAsignados($unidad, $correlativo, &$mediosVigilancia);
	//$objServicios->buscaHojaDeRuta($unidad, $correlativo, &$tieneHojaRuta);
	$objServicios->buscaAnimalAsignado($unidad, $correlativo, &$mediosVigilancia);
	$objServicios->buscaCamarasAsignadas($unidad, $correlativo, &$mediosVigilancia);
	$objServicios->buscadestinosAsignados($unidad, $correlativo, &$mediosVigilancia);
	
	$cantidadFuncionarios = count($funcionarios);
	$cantidadMediosVigilancia = count($mediosVigilancia);
	$tipoServicioPdf = $servicio->getTipoServicio()->getTipo();
	$pdf->ezText("",10);
	$pdf->ezText("",10);
	$pdf->ezText("",10);

	$filasEncabezado[]=array("<b>Servicio</b>","<b>:</b>","<b>".$servicio->getTipoServicio()->getDescripcion()."</b>");
	if($servicio->getServicioExtraordinario()->getDescripcion()!=""){
		$filasEncabezado[]=array("<b>Servicio Extraordinario</b>","<b>:</b>","<b>".$servicio->getServicioExtraordinario()->getDescripcion()."</b>");
	}
	if($servicio->getDescripcionServicioOtroExtraordinario()!=""){
		$filasEncabezado[]=array("<b>Otro Extraordinario</b>","<b>:</b>","<b>".$servicio->getDescripcionServicioOtroExtraordinario()."</b>");
	}
	$filasEncabezado[]=array("<b>Inicio</b>","<b>:</b>","<b>".$servicio->getHoraInicio()."</b>");
	$filasEncabezado[]=array("<b>Término</b>","<b>:</b>","<b>".$servicio->getHoraTermino()."</b>");
	$pdf->ezTable($filasEncabezado,'','',array('colGap'=>2,'shadeCol'=>array(0.8,0.8,0.8),'shadeCol2'=>array(0.8,0.8,0.8),'fontSize'=>8,'width'=>510,'showHeadings'=>0,'shaded'=>2,'showLines'=>0,'xPos'=>'left','xOrientation'=>'right','rowGap' =>1,'cols'=>array(array('width'=>90),array('width'=>10))));
	$pdf->ezText("",10);
	unset($filasEncabezado);

	$filasObservaciones[]=array($servicio->getObservaciones());
   	if($mediosVigilancia != ""){
   		for ($i=0; $i<$cantidadMediosVigilancia; $i++){
   			if ($mediosVigilancia[$i]->getVehiculo()->getCodigoVehiculo() == ""){
				$codigoVehiculo 	= 0;
				$patenteVehiculo 	= "INFANTERIA";
				$tipoVehiculo 		= "SIN VEHICULO";
			}
   			else {
				$codigoVehiculo 	= $mediosVigilancia[$i]->getVehiculo()->getCodigoVehiculo();
				$patenteVehiculo 	= $mediosVigilancia[$i]->getVehiculo()->getPatente();
				$tipoVehiculo 		= $mediosVigilancia[$i]->getVehiculo()->getTipoVehiculo()->getDescripcion();
   			}
			$pdf->ezText("<b>Medio de Vigilancia Nro. ".$mediosVigilancia[$i]->getNumeroMedio()."</b>",8);
			
			if($codigoVehiculo!=0){
				$filasVehiculo[]=array("<b>Vehículo</b>","<b>:</b>",$tipoVehiculo." (".$patenteVehiculo.")","<b>Kilometraje Inicial</b>","<b>:</b>",number_format($mediosVigilancia[$i]->getKmInicial(),0,'','.')." KMS.");
				$filasVehiculo[]=array("<b>Kilómetros Recorridos</b>","<b>:</b>",number_format($mediosVigilancia[$i]->getKmFinal()-$mediosVigilancia[$i]->getKmInicial(),0,'','.')." KMS.","<b>Kilometraje Final</b>","<b>:</b>",number_format($mediosVigilancia[$i]->getKmFinal(),0,'','.')." KMS.");
				$pdf->ezTable($filasVehiculo,'','',array('colGap'=>2,'shadeCol'=>array(0.9,0.9,0.9),'shadeCol2'=>array(0.9,0.9,0.9),'showHeadings'=>0,'shaded'=>2,'showLines'=>0,'xPos'=>'left','xOrientation'=>'right','rowGap' =>2,'fontSize'=>8,'width'=>510,
				'cols'=>array(array('width'=>90),array('width'=>10),'',array('width'=>75),array('width'=>10),array('width'=>130))));
				unset($filasVehiculo); 
			}
			
          	$filasMedio[]=array("<b>Factor</b>","<b>:</b>",$mediosVigilancia[$i]->getFactor()->getDescripcion());
			$contFuncionarios = 0;
	   		for($j=0; $j<$mediosVigilancia[$i]->getCantidadDeFuncionarios(); $j++){
				$descripcion = strtoupper($mediosVigilancia[$i]->getFuncionarios($j)->getApellidoPaterno())." ".strtoupper($mediosVigilancia[$i]->getFuncionarios($j)->getApellidoMaterno()).", ".strtoupper($mediosVigilancia[$i]->getFuncionarios($j)->getPNombre())." - ".strtoupper($mediosVigilancia[$i]->getFuncionarios($j)->getGrado()->getDescripcion())." (".$mediosVigilancia[$i]->getFuncionarios($j)->getCodigoFuncionario().")";
				if($mediosVigilancia[$i]->getFuncionarios($j)->getCantidadArmas() > 0 ){
					for ($k=0; $k<$mediosVigilancia[$i]->getFuncionarios($j)->getCantidadArmas(); $k++){
						$etiqueta = "";
						if ($contFuncionarios==0) $etiqueta = "<b>Personal";
						if ($k>0) $descripcion = "";
						$filasFuncionario[] = array($etiqueta, ($etiqueta!="") ? ":</b>" : "",
												$descripcion,
												$mediosVigilancia[$i]->getFuncionarios($j)->getArmas($k)->getTipo()->getDescripcion()." (".$mediosVigilancia[$i]->getFuncionarios($j)->getArmas($k)->getNumeroSerie().")");
						$contFuncionarios++;
					}
				} else {
					$etiqueta = "";
					if ($contFuncionarios==0) $etiqueta = "<b>Personal";
					$filasFuncionario[] = array($etiqueta, ":</b>",
											$descripcion, "");
					$contFuncionarios++;
				}
				
				if($mediosVigilancia[$i]->getFuncionarios($j)->getCantidadCamaras() > 0){
					for ($k=0; $k<$mediosVigilancia[$i]->getFuncionarios($j)->getCantidadCamaras(); $k++){
						$descripcionCamara = "<b>Camara (Nro:</b>".$mediosVigilancia[$i]->getFuncionarios($j)->getCamaras($k)->getNumeroSerie()."<b>)</b>";
						$filasFuncionario[] = array("", "", "",
												$descripcionCamara);
					}
				}
				
				if($mediosVigilancia[$i]->getFuncionarios($j)->getCantidadAccesorios() > 0){
					for ($k=0; $k<$mediosVigilancia[$i]->getFuncionarios($j)->getCantidadAccesorios(); $k++){
						$descripcionAccesorio = $mediosVigilancia[$i]->getFuncionarios($j)->getAccesorios($k)->getDescripcion();
						$filasFuncionario[] = array("", "", "",
												$descripcionAccesorio);
					}
				}

				$pdf->ezTable($filasFuncionario,'','',array('colGap'=>2,'shadeCol'=>array(0.9,0.9,0.9),'shadeCol2'=>array(0.9,0.9,0.9),'showHeadings'=>0,'shaded'=>2,'showLines'=>0,'xPos'=>'left','xOrientation'=>'right','rowGap' =>2,'fontSize'=>8,'width'=>510
                ,'cols'=>array(array('width'=>90),array('width'=>10),'',array('width'=>130))
                ));
				if($mediosVigilancia[$i]->getFuncionarios($j)->getAnimales()){
                    $filasAnimal[]=array("<b>Animal Asignado</b>","<b>:</b>",$mediosVigilancia[$i]->getFuncionarios($j)->getAnimales()->getCodigo()." ","<b>nombre Animal</b>","<b>:</b>",$mediosVigilancia[$i]->getFuncionarios($j)->getAnimales()->getDescripcion()." ");
                    $pdf->ezTable($filasAnimal,'','',array('colGap'=>2,'shadeCol'=>array(0.9,0.9,0.9),'shadeCol2'=>array(0.9,0.9,0.9),'showHeadings'=>0,'shaded'=>2,'showLines'=>0,'xPos'=>'left','xOrientation'=>'right','rowGap' =>2,'fontSize'=>8,'width'=>510,
                    'cols'=>array(array('width'=>90),array('width'=>10),'',array('width'=>75),array('width'=>10),array('width'=>130))));
                    unset($filasAnimal);
                }
                unset($filasFuncionario);
			}

			$cuadrantesMedio = "";
			for($j=0; $j<$mediosVigilancia[$i]->getCantidadDeCuadrantes(); $j++){
				if($j==0){
					$cuadrantesMedio=$mediosVigilancia[$i]->getCuadrantes($j)->getDescripcion();
				}
				else{
					$cuadrantesMedio=$cuadrantesMedio.", ".$mediosVigilancia[$i]->getCuadrantes($j)->getDescripcion();
				}
			}

			$filasMedio[]=array("<b>Cuadrante(s)</b>","<b>:</b>",$cuadrantesMedio);
			
			$pdf->ezTable($filasMedio,'','',array('colGap'=>2,'shadeCol'=>array(0.9,0.9,0.9),'shadeCol2'=>array(0.9,0.9,0.9),'showHeadings'=>0,'shaded'=>2,'showLines'=>0,'xPos'=>'left','xOrientation'=>'right','rowGap' =>2,'fontSize'=>8,'width'=>510
			,'cols'=>array(array('width'=>90),array('width'=>10))
			));

			$pdf->ezText("",10);

			unset($filasVehiculo);
			//unset($filasFuncionario); 
			unset($filasMedio); 

  		}
   	}

	if($servicio->getObservaciones()!=""){
		$filasObservaciones[]=array($servicio->getObservaciones());
		$pdf->ezText("<b>Observaciones</b>",8);
		$pdf->ezTable($filasObservaciones,'','',array('colGap'=>2,'shadeCol'=>array(0.9,0.9,0.9),'shadeCol2'=>array(0.9,0.9,0.9),'showHeadings'=>0,'shaded'=>2,'showLines'=>0,'xPos'=>'left','xOrientation'=>'right','rowGap' =>2,'fontSize'=>8,'width'=>510));
		unset($filasObservaciones);
	}

}

$pdf->ezText("",20);
$filasEncabezado[]=array("<b>Servicio</b>","<b>:</b>","<b>Comisión de Servicio</b>");
$pdf->ezTable($filasEncabezado,'','',array('colGap'=>2,'shadeCol'=>array(0.8,0.8,0.8),'shadeCol2'=>array(0.8,0.8,0.8),'fontSize'=>8,'width'=>510,'showHeadings'=>0,'shaded'=>2,'showLines'=>0,'xPos'=>'left','xOrientation'=>'right','rowGap' =>1,'cols'=>array(array('width'=>90),array('width'=>10))));
$pdf->ezText("",10);
unset($funcionariosComision);
$objServicios->buscaComisionServicioDia($unidad, $fechaBuscar1, &$funcionariosComision);
for($i=0; $i<count($funcionariosComision); $i++){
	$filasFuncionarioComision[] = array(($i>0) ? "" : "<b>Personal</b>",($i>0) ? "" : "<b>:</b>",
					strtoupper($funcionariosComision[$i]->getApellidoPaterno())." ".strtoupper($funcionariosComision[$i]->getApellidoMaterno()).", ".strtoupper($funcionariosComision[$i]->getPNombre())." - ".strtoupper($funcionariosComision[$i]->getGrado()->getDescripcion())." (".$funcionariosComision[$i]->getCodigoFuncionario().")",
					""
				);
}
$pdf->ezTable($filasFuncionarioComision,'','',array('colGap'=>2,'shadeCol'=>array(0.9,0.9,0.9),'shadeCol2'=>array(0.9,0.9,0.9),'showHeadings'=>0,'shaded'=>2,'showLines'=>0,'xPos'=>'left','xOrientation'=>'right','rowGap' =>2,'fontSize'=>8,'width'=>510
,'cols'=>array(array('width'=>90),array('width'=>10),'',array('width'=>130))
));

	if($gradoValidador != "" && $nombreValidador != ""){
		$pdf->ezText("",20);
		$pdf->ezText("<b>SERVICIOS VALIDADOS POR</b>",10);
		$pdf->ezText("",20);
		$pdf->ezText("<b>".$nombreValidador."</b>",10,array('justification'=>'center'));
		$pdf->ezText("<b>".$gradoValidador." DE CARABINEROS</b>",10,array('justification'=>'center'));
	}
	else{
		$pdf->ezText("",20);
		$pdf->setColor(255,0,0);
		$pdf->ezText("<b>SERVICIOS NO VALIDADOS</b>",10,array('justification'=>'center'));
		$pdf->setColor(0,0,0);
    }
$pdf->ezStream();
?>