<?
include("version.php");
include("session.php");
include("tiempo.php");
$perfil = $_SESSION['USUARIO_PROSERVIPOLPERFIL'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="./css/arbolUnidad.css?v=<?echo version?>" rel="stylesheet" type="text/css" />
<link href="./css/aplicacion.css?v=<?echo version?>" rel="stylesheet" type="text/css">
<link href="./css/menuPrincipal.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="./js/crearArbolFiscalizador.js?v=<?echo version?>"> </script>
<script type="text/javascript" src="./js/creaObjeto.js?v=<?echo version?>"></script>
<script type="text/javascript" src="./js/aplicacion.js?v=<?echo version?>"></script>
<script type="text/javascript" src="./js/usuario.js?v=<?echo version?>"></script>
<script type="text/javascript" src="./ventana/js/prototype.js"> </script>
<script type="text/javascript" src="./ventana/js/window.js"> </script>
<script type="text/javascript" src="./ventana/js/effects.js"> </script>
<script type="text/javascript" src="./ventana/js/window_effects.js"> </script>
<script type="text/javascript" src="./ventana/js/debug.js"> </script>
<link href="./ventana/css/default.css" 	rel="stylesheet" type="text/css"></link>
<link href="./ventana/css/debug.css" 	rel="stylesheet" type="text/css"></link>
<link href="./ventana/css/mac_os_x.css" rel="stylesheet" type="text/css"></link>
<title>PROSERVIPOL - Programaci&oacuten de Servicios Policiales ...</title>
<?include("header.php");?>
</head>
<body onload="actualizarTamanoLista('listado');" onresize="actualizarTamanoLista('listado');">
	<div id="cubreFondo" style="display:none;"></div>
	<input id="unidadOrigen" type="hidden" readonly="yes" value="<?echo $codOrigen?>">
	<input id="codigoPerfilOrigen" type="hidden" readonly="yes" value="<?echo $codigoPerfilOrigen?>">
	<? if($permisoConsultarPerfil){ ?>
	<div style="margin-left:10px; margin-right:10px; margin-top:10px;" >
		<div style="height:10px"></div>
		<table><tr>
		<td width="120px"><div id="titulo">Entrar como:</div></td>
		<td width="150px"><input id="codFuncionario" type="text" maxlength="7" value="" /></td>
		<td width="150px"><input type="button" value="Entrar" onclick="cambiarUsuario(document.getElementById('codFuncionario').value)" /></td>
		</tr></table>
		<div style="height:10px"></div>
		<table width="100%"><tr class="linea"><td></td></tr></table>
	</div>
	<? } ?>
	<? if($permisoConsultarUnidad){ ?>
	<div style="margin-left:10px; margin-right:10px; margin-top:10px;" >
		<div style="height:10px"></div>
		<table><tr>
		<td width="120px"><div id="titulo">Buscar Unidad:</div></td>
		<td width="150px"><input id="textUnidad" type="text" style="text-transform:uppercase" onKeyup="buscarUnidad(this.value)" /></td>
		</tr></table>
		<div style="height:10px"></div>
		<table width="100%"><tr class="linea"><td></td></tr></table>
	</div>
	<? } ?>
	<div style="margin-left:10px; margin-right:10px; margin-top:10px;">
		<div style="height:2px"></div>
		<div id="listado">
			<div class="arbol" id="arbol" >
				<div id="TipoBase" onclick="cambiar('<? echo $codOrigen; ?>')" onmouseover="cambiarClase(this,'resaltar')" OnMouseOut="cambiarClase(this,'arbol')">
				<img src='img/base.gif' /><a><? if($codOrigen==20){echo "NIVEL NACIONAL ";}else{echo $desOrigen;} ?></a></div>
				<div id="NodosBase"></div>
			</div>
			<div style="height:2px"></div>
			</div>
	</div>
	<table width="100%"><tr class="linea"><td></td></tr></table>
<? include("modal-popup.php"); ?>
</body>
</html>
<script type="text/javascript" >
	if(<? echo $tipoCuartelOrigen; ?>==120) CrearPrimerArbol(<? echo "'".$codigoUnidadPadre."','".$codigoPerfilOrigen."'"; ?>);
	else CrearPrimerArbol(<? echo "'".$codOrigen."','".$codigoPerfilOrigen."'"; ?>);

	//max-age por milisegundos, 86400 24 horas, 3600 1 hora, 600 10 minutos, 60 1 minuto, 1 1 segundo
	//setCookie('token', 'galletica', {'max-age': 3600});
	//console.log(getCookie('token'));

</script>