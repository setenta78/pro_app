<?php
	include("session.php");
	include("./inc/configV4.inc.php");
	include("./baseDatos/Conexion.class.php");      
	require("./baseDatos/dbUsuarios.class.php");
	require("./objetos/usuario.class.php");
	require("./objetos/perfil.class.php");
	require("./objetos/funcionario.class.php");
	require("./objetos/unidad.class.php");

	$codigoFuncionarioUsuario	= $_SESSION['USUARIO_CODIGOFUNCIONARIO']; 
	$unidadUsuario				= $_SESSION['USUARIO_CODIGOUNIDAD'];
	$fecha_hra_inicio			= $_SESSION['HORA_INICIO'];
	$hra_termino				= date("Y/m/d H:i:s"); 
	$codigoPerfil				= $_SESSION['USUARIO_CODIGOPERFIL_ORIGEN'];
	$evento						= (!$_GET['inactividad']) ? "CIERRE DE SESION: EXITOSO" : "CIERRE DE SESION: INACTIVIDAD";
	
	$objDBUsuarios = new dbUsuarios;
	$objDBUsuarios->modificaBitacoraUsuario($codigoFuncionarioUsuario,$unidadUsuario,$fecha_hra_inicio,$hra_termino,$codigoPerfil,$evento);

	setcookie("access_token", "", time() - 3600);
	session_start();
	session_unset();
	session_destroy();
?>
<script>
	sessionStorage.removeItem('access_token');
	sessionStorage.removeItem('session_datetime');
	sessionStorage.removeItem('token_type');
	self.location.replace('indexAuth.php');
	//logoutAutentificaTic();
</script>