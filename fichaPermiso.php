<?
include("version.php");
include("session.php");
include("tiempo.php");
$codigoFuncionario 	= $_GET["codigoFuncionario"];
$codigoFolio		= $_GET["codFolio"];
$unidadUsuario	   	= $_SESSION['USUARIO_CODIGOUNIDAD']; 
$tienePlanCuadrante	= $_SESSION['USUARIO_UNIDADPLANCUADRANTE'];
$unidadPadre		= $_SESSION['USUARIO_CODIGOPADREUNIDAD'];
$fechaCierre		= $_GET["fechaCierre"];
$tipoUnidad		= $_SESSION['USUARIO_TIPOUNIDAD'];
$ip			= $_SESSION['DIRECCION_IP'];
$codPerfil	 	= $_SESSION['USUARIO_CODIGOPERFIL'];
$codPerfilOrigen	= $_SESSION['USUARIO_CODIGOPERFIL_ORIGEN'];
$usuario		= $_SESSION['USUARIO_CODIGOFUNCIONARIO'];
$permisoRegistrar	= ($_SESSION['PERMISO_REGISTRAR']==1);
$fecha                	= date("Y-m-d");
?>
<html>
<head>
<title>FERIADOS Y PERMISOS ...</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="./js/creaObjeto.js?v=<?echo version?>"></script>
<script type="text/javascript" src="./js/aplicacion.js?v=<?echo version?>"></script>
<script type="text/javascript" src="./js/ferper.js?v=<?echo version?>" charset="utf-8"></script>
<script type="text/javascript" src="./js/usuario.js?v=<?echo version?>"></script>
<link href="./css/aplicacion.css" rel="stylesheet" type="text/css">
<link href="./css/fichaServicio.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./ventana/js/prototype.js"> </script>
<script type="text/javascript" src="./ventana/js/window.js"> </script>
<script type="text/javascript" src="./ventana/js/effects.js"> </script>
<script type="text/javascript" src="./ventana/js/window_effects.js"> </script>
<script type="text/javascript" src="./ventana/js/debug.js"> </script>
<script type="text/javascript" src="./calendario/dhtmlgoodies_calendar.js"></script>
<link href="./calendario/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css">
<link href="./ventana/css/default.css" 	rel="stylesheet" type="text/css"></link>
<link href="./ventana/css/debug.css" 	rel="stylesheet" type="text/css"></link>
<link href="./ventana/css/mac_os_x.css" rel="stylesheet" type="text/css"></link>
</head>
<body style="margin-top:10; margin-left:10; background-color:#f5fbf3" scroll="no" onload="rutUsuario(); tipoFicha('<? echo $codigoFuncionario."','".$codigoFolio; ?>');">
<input id="idFuncionario"  type="hidden" readonly="yes">
<input id="unidadUsuario"  type="hidden" readonly="yes" value="<?echo $unidadUsuario?>">
<input type="hidden" id="origenBaseDatos">
<input type="hidden" id="IpFuncionario" name="IpFuncionario" value="<? echo $ip; ?>">
<input type="hidden" id="unidadFuncionario" name="unidadFuncionario" value="">
<input type="hidden" id="usuario" name="usuario" value="<?echo $usuario?>">
<input type="hidden" id="codigoFuncionario" name="codigoFuncionario" value="">
<input type="hidden" id="correlativo" name="correlativo" value="">
<input id="fecha"  type="hidden" readonly="yes" value="<?echo $fecha?>">
<input type="hidden" id="rutUsuario" name="rutUsuario" value="">
<input type="hidden" id="FechaCierre" name="FechaCierre" value="<? echo $fechaCierre; ?>">
<input type="hidden" id="FechaRegistro" name="FechaRegistro" value="">
<input type="hidden" id="UltimoEstado" name="UltimoEstado" value="">
<input id="perfil"  type="hidden" readonly="yes" value="<?echo $codPerfilOrigen?>">
<input id="permisoRegistrar" type="hidden" readonly="yes" value="<?echo $permisoRegistrar?>">
<div id="mensajeCargando" style="display:none;">
<table width="100%"><tr><td align="right" width="35%"><img src='./img/ajax_loader.gif' width="20" height="20"></td><td width="65%" align="left">&nbsp;CARGANDO DATOS, ESPERE POR FAVOR ......</td></table>
</div>
<div id="mensajeGuardando" style="display:none;">
<table width="100%"><tr><td align="right" width="35%"><img src='./img/ajax_loader.gif' width="20" height="20"></td><td width="65%" align="left">&nbsp;GUARDANDO DATOS, ESPERE POR FAVOR ......</td></table>
</div>
<div id="marcoLevantado">
<br>
<div id="seccion2">
<u><b>USO Y RESPONSABILIDAD EXCLUSIVA DEL PROFESIONAL</b></u>
<div id="seccion1" align="right">
<table id="tabla1" border="0" >
<tr>
<td align="right"><b><? echo (!$codigoFolio) ? "(*)" : ""; ?> FOLIO:</b></td>	
<td></td>
<td><input type="text" id="txtfolio" name="txtfolio" maxlength="10" value="" onKeypress="return solo_num(event)" onblur="validarSubir();"></td>
</tr>
</table>
</div>
<fieldset>
<legend><b>IDENTIFICACION DEL TRABAJADOR</b></legend>
<br>
<table id="tabla2" width="90%" border="0">
<tr>
<td align="center"><input type="text" id="txtape1" name="txtape1" size="15" value="" readonly="yes"></td>
<td align="center"><input type="text" id="txtape2" name="txtape2" size="15" value="" readonly="yes"></td>
<td align="center"><input type="text" id="txtnom" name="txtnom" size="20" value="" readonly="yes"></td>
<td align="center"><input type="text" id="txtrut" name="txtrut" value="" size="15" maxlength="9" onKeypress="return solo_rut(event)" onblur="formato_rut(this);"></td>
<td><img src="img/busqueda.png"  width="23" height="23" alt="Consultar Datos ..."/></td>
<td rowspan="4"><img id="fotoFuncionario" width="121" height="119" align="left" src="./img/sinFoto.png" onerror="this.src='./img/sinFoto.png'"></td>
</tr>
<tr>
<td align="center">PRIMER APELLIDO</td>
<td align="center">SEGUNDO APELLIDO</td>
<td align="center">NOMBRES</td>
<td align="center"><? echo (!$codigoFolio) ? "(*)" : ""; ?> RUN </td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<tr>
<td align="center"><input type="text" id="txtfec1" name="txtfec1" size="10" value="" readonly="yes">&nbsp;<input id="idFechaServicio1" name="idFechaServicio1" type="image" src="./img/calendarIconVerde.gif" width="15" height="13" onClick="displayCalendar(txtfec1,'dd-mm-yyyy',this,-100,-75);"></td>
<td align="center"><input type="text" id="txtfec2" name="txtfec2" size="10" value="" readonly="yes">&nbsp;<input id="idFechaServicio2" name="idFechaServicio2" type="image" src="./img/calendarIconVerde.gif" width="15" height="13" onClick="displayCalendar(txtfec2,'dd-mm-yyyy',this,-100,-75);"></td>
<td align="center"><? echo ($codigoFolio) ? '<input type="text" id="txtFechaTerminoReal" name="txtFechaTerminoReal" size="10" value="" readonly="yes">&nbsp;<input id="idFechaTerminoReal" name="idFechaTerminoReal" type="image" src="./img/calendarIconVerde.gif" width="15" height="13" onClick="displayCalendar(txtFechaTerminoReal,\'dd-mm-yyyy\',this,-100,-75);"></td>' : ''; ?>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td align="center"><? echo (!$codigoFolio) ? "(*)" : ""; ?> FECHA INICIO</td>
<td align="center"><? echo (!$codigoFolio) ? "(*)" : ""; ?> FECHA TERMINO</td>
<td align="center"><? echo ($codigoFolio) ? "(*) NUEVA FECHA TERMINO" : ""; ?></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>
</fieldset>
<br>
</div>
<br>
<div id="seccion3">
<fieldset>
<legend><b>FERIADO O PERMISO</b></legend>
<br>
<table id="tabla4" border="0">
<tr>
<td>&nbsp;</td>
<td><select id="cboPermiso" onchange="" >
  <option value="0">SELECCIONE UNA OPCION ...</option>
  <optgroup label="Feriados">
	  <option value="130">Feriado</option>
	  <option value="799">Feriado zona extrema</option>
  </optgroup>
  <optgroup label="Permisos">
	  <option value="722">Permiso administrativo</option>
	  <option value="723">Permiso especial Digcar</option>
	  <option value="726">Permiso muerte de hijo</option>
	  <option value="727">Permiso muerte hijo periodo gestaci&oacute;n</option>
	  <option value="728">Permiso muerte hermano, madre o padre</option>
	  <option value="725">Permiso nacimiento de hijo o adopci&oacute;n</option>
	  <option value="713">Permiso Postnatal-Parental</option>
	  <option value="724">Permiso por Matrimonio o Uni&oacute;n Civil</option>
	  <option value="864">Permiso accidente o enfermedad grave hijo menor 18 A&ntilde;os</option>
	  <option value="882">Permiso Representativas Deportivas</option>
	  <option value="726">Permiso muertes de c&oacute;nyuge o conviviente civil</option>
	  <option value="869">Permiso descanso reparatorio Personal de la Salud</option>
  </optgroup>
</select></td>
</tr>
</table>
<br>
</fieldset>
</div>
<br>
<table>
<tr align="left">
<form name="formSubeArchivo" action="adjuntarArchivoSubirPermiso.php" method="post" enctype="multipart/form-data" target="frameSubirArchivo">
	<td><div id="formArchivo"><input type="file" size="20" name="archivo" id="archivo" disabled/></div></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td>
		<input type="button" value="SUBIR" id="btnSubir" name="btnSubir" onClick="subirArchivo(this)"/>
		<input type="hidden" id="archivoServidor" value="">
		<input type="hidden" id="archivoLoad" value=0>
		<input type="hidden" id="rutArchi" name="rutArchi" value="">
	</td>
</form>
<td width="10%">&nbsp;</td>
<td width="10%">&nbsp;</td>
<td width="17%"><input name="btnSuspenderPermiso" type="button" id="btnSuspenderPermiso" value="SUSPENDER" onClick="suspenderPermiso()"></td>
<td width="20%">
	<input name="btnGuardarOrganizacion" type="button" id="btnGuardarOrganizacion" value="GUARDAR" onClick="guardarPermiso()">
	<input name="btnAnularPermiso" type="button" id="btnAnularPermiso" value="ANULAR" onClick="anularPermiso()">
</td>
<td width="14%"><input name="btnCerrarFichaFuncionario" type="button" id="btnCerrarFichaFuncionario" value="CERRAR" onClick="top.cerrarVentana();"></td>
</tr>	
</table>
<div id="seccionMensaje">
<b><p id='Mensaje'></p></b>
</div>
</body>
</html>