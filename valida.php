<?
include("./inc/configV4.inc.php");
include("./baseDatos/Conexion.class.php");
require("./baseDatos/dbUsuarios.class.php");
require("./objetos/usuario.class.php");
require("./objetos/perfil.class.php");
require("./objetos/funcionario.class.php");
require("./objetos/unidad.class.php");
require("./objetos/escalafon.class.php");
require("./objetos/grado.class.php");

$userName 			= $_POST['textUsuario'];
$clave 		 		= $_POST['textClave'];
$aplicacion	 		= 10;
$ip         		= $_SERVER['REMOTE_ADDR'];
$fecha_hra_inicio	= date("Y/m/d H:i:s");

$msjCargo = "";
$msjCargo .= "ATENCION :\\n\\n";
$msjCargo .= "EL USUARIO NO REGISTRA EL CARGO DE ENCARGADO DE PROSERVIPOL, ";
$msjCargo .= "SE SOLICITA REGULARIZAR ESTA SITUACION A LA BREVEDAD \\n";
$msjCargo .= "CONSULTAS REALIZARLAS AL CORREO: correo.proservipol@carabineros.cl.";

$msjAUsuarios = "";
$msjAUsuarios .= "ATENCION!! \\n\\n";
$msjAUsuarios .= "AL MOMENTO DE SOLICITAR ALGUN REQUERIMIENTO VIA CORREO ELECTR�NICO ";
$msjAUsuarios .= "PARA LA SOLUCI�N DE PROBLEMAS CON EL SISTEMA PROSERVIPOL V3.9, USTED ";
$msjAUsuarios .= "DEBER� INCLUIR LOS SIGUIENTES DATOS: \\n\\n";
$msjAUsuarios .= "1.- PARA HABILITAR FUNCIONARIOS REINTEGRADOS: DEBE INDICAR EL C�DIGO DEL FUNCIONARIO.\\n\\n";
$msjAUsuarios .= "2.- PARA HABILITACI�N DE VEHICULOS: DEBE INDICAR EL C�DIGO B.C.U.\\n\\n";
$msjAUsuarios .= "3.- PARA HABILITACI�N DE ARMAS: DEBE INDICAR EL N�MERO DE SERIE DEL ARMAMENTO.";
$msjAUsuarios .= "\\n CONSULTAS REALIZARLAS A : correo.proservipol@carabineros.cl.";

$objDBUsuarios = new dbUsuarios;
$objDBUsuarios->validaUsuario($userName, $clave, $aplicacion, &$usuario);

if (is_object($usuario)){
	
	$userName 			 	= $usuario->getUserName();
	$clave 				 	= $usuario->getClave();
	
	$codigoFuncionario 		= $usuario->getFuncionario()->getCodigoFuncionario();
	$gradoUsuario 			= $usuario->getFuncionario()->getGrado()->getDescripcion();
	$nombreUsuario 		 	= $usuario->getFuncionario()->getNombreCompleto();
	
	$gradoUsuarioPadre	 	= $usuario->getFuncionario()->getGrado()->getDescripcion();
	$nombreUsuarioPadre	 	= $usuario->getFuncionario()->getNombreCompleto();
	$codigoFuncPadre	 	= $usuario->getFuncionario()->getCodigoFuncionario();
	$codigoUnidadUsuario 	= $usuario->getUnidad()->getCodigoUnidad();
	$descUnidadUsuario 	 	= $usuario->getUnidad()->getDescripcionUnidad();
	$tienePlanCuadrante	 	= $usuario->getUnidad()->getTienePlanCuadrante();
	$codigoPerfil 		 	= $usuario->getPerfil()->getCodigoPerfil();
	$perfil 			 	= $usuario->getPerfil()->getDescripcionPerfil();
	$codigoUnidadPadre 		= $usuario->getUnidad()->getPadreUnidad()->getCodigoUnidad();
	$unidadBloqueo		 	= $usuario->getUnidad()->getBloqueada();
	$unidadEspecialidad		= $usuario->getUnidad()->getEspecialidad();
	$unidadEspecialidadO	= $usuario->getUnidad()->getEspecialidadOld();
	$tipoUnidad				= $usuario->getUnidad()->getTipoUnidad();
	$contieneHijos			= $usuario->getUnidad()->getContieneHijos();
	$cargo 				 	= $usuario->getFuncionario()->getCargo();
	$UnidadTipo			 	= $usuario->getUnidad()->getUnidadTipo();
	$tipoUnidadNew			= $usuario->getUnidad()->getTipoUnidadNew();
	$especialidadUnidadNew	= $usuario->getUnidad()->getEspecialidadUnidadNew();
	$tipoUnidadPadre	 	= $usuario->getUnidad()->getTipoUnidadPadre()->getTipoUnidad();
	$fechaLimite		 	= $usuario->getFechaLimite();
	$permisoValidar			= $usuario->getPerfil()->getPermisoValidar();
	$permisoRegistrar		= $usuario->getPerfil()->getPermisoRegistrar();
	$permisoConsultarUnidad	= $usuario->getPerfil()->getPermisoConsultarUnidad();
	$permisoConsultarPerfil	= $usuario->getPerfil()->getPermisoConsultarPerfil();
	
	$arr1 		= array('CF1','CF2','CF3');
	$arr2 		= array('CUAD1','CUAD2');
	$arr3 		= array('DF1','DF2','DF3');
	$array1 	= array('1','VEH','KM_INICIAL','KM_FINAL',$arr1,$arr2, $arr3);
	$array2		= array('1','VEH','KM_INICIAL','KM_FINAL',$arr1,$arr2, $arr3);
	$arrFinla   = array($array1, $array1);
	
	session_start();
	$_SESSION['USUARIO_USERNAME'] 		  	 	 	= $userName;
	$_SESSION['USUARIO_CLAVE'] 		  	  	 	 	= $clave;
	$_SESSION['USUARIO_FECHALIMITE'] 	 	 		= $fechaHoy;
	$_SESSION['DIRECCION_IP']						= $ip;
	$_SESSION['HORA_INICIO'] 						= $fecha_hra_inicio;

	$_SESSION['USUARIO_CODIGOFUNCIONARIO']	 		= $codigoFuncionario;
	$_SESSION['USUARIO_CODIGOFUNCIONARIO_ORIGEN']	= $codigoFuncionario;

	$_SESSION['USUARIO_GRADO'] 				 		= $gradoUsuario;
	$_SESSION['USUARIO_GRADO_ORIGEN'] 		 		= $gradoUsuario;
	
	$_SESSION['USUARIO_NOMBRE'] 			 		= $nombreUsuario;
	$_SESSION['USUARIO_NOMBRE_ORIGEN']		 		= $nombreUsuario;
	
	$_SESSION['USUARIO_CODIGOPERFIL'] 		 	 	= $codigoPerfil;
	$_SESSION['USUARIO_CODIGOPERFIL_ORIGEN'] 		= $codigoPerfil;

	$_SESSION['USUARIO_PERFIL'] 		  	 		= $perfil;
	$_SESSION['USUARIO_PERFIL_ORIGEN']	  	 		= $perfil;
	
	$_SESSION['USUARIO_CODIGOUNIDAD'] 		 	 	= $codigoUnidadUsuario;
	$_SESSION['USUARIO_CODIGOUNIDAD_ORIGEN']		= $codigoUnidadUsuario;

	$_SESSION['USUARIO_TIPOUNIDAD']          		= $tipoUnidad;
	$_SESSION['USUARIO_TIPOUNIDAD_ORIGEN']     		= $tipoUnidad;
	
	$_SESSION['USUARIO_DESCRIPCIONUNIDAD'] 	 		= $descUnidadUsuario;
	$_SESSION['USUARIO_DESCRIPCIONUNIDAD_ORIGEN']	= $descUnidadUsuario;
	
	$_SESSION['USUARIO_CODIGOPADREUNIDAD'] 	 		= $codigoUnidadPadre;
	$_SESSION['USUARIO_CODIGOPADREUNIDAD_ORIGEN'] 	= $codigoUnidadPadre;
	
	$_SESSION['USUARIO_CONTIENEHIJOS']       		= $contieneHijos;
	$_SESSION['USUARIO_CONTIENEHIJOS_ORIGEN']      	= $contieneHijos;

	$_SESSION['USUARIO_UNIDADPLANCUADRANTE'] 		= $tienePlanCuadrante;
	$_SESSION['USUARIO_UNIDADPLANCUADRANTE_ORIGEN'] = $tienePlanCuadrante;
	
	$_SESSION['USUARIO_UNIDADBLOQUEO'] 	 	 	 	= $unidadBloqueo;
	$_SESSION['USUARIO_UNIDADBLOQUEO_ORIGEN'] 	 	= $unidadBloqueo;

	$_SESSION['USUARIO_UNIDADESPECIALIDAD']  		= $unidadEspecialidad;
	$_SESSION['USUARIO_UNIDADESPECIALIDAD_ORIGEN'] 	= $unidadEspecialidad;

	$_SESSION['USUARIO_UNIDADESPECIALIDAD_OLD']  		= $unidadEspecialidadO;
	$_SESSION['USUARIO_UNIDADESPECIALIDAD_OLD_ORIGEN'] 	= $unidadEspecialidadO;

	$_SESSION['USUARIO_UNIDADTIPO']					= $UnidadTipo;
	$_SESSION['USUARIO_UNIDADTIPO_ORIGEN']			= $UnidadTipo;
	
	$_SESSION['USUARIO_TIPO_UNIDAD']				= $tipoUnidadNew;
	$_SESSION['USUARIO_TIPO_UNIDAD_ORIGEN']			= $tipoUnidadNew;
	$_SESSION['USUARIO_ESPECIALIDAD_UNIDAD']		= $especialidadUnidadNew;
	$_SESSION['USUARIO_ESPECIALIDAD_UNIDAD_ORIGEN']	= $especialidadUnidadNew;

	$_SESSION['FECHA_LIMITE']						= date("d-m-Y", strtotime($fechaLimite));

	$_SESSION['PERMISO_VALIDAR']					= $permisoValidar;
	$_SESSION['PERMISO_REGISTRAR']					= $permisoRegistrar;
	$_SESSION['PERMISO_CONSULTAR_UNIDAD']			= $permisoConsultarUnidad;
	$_SESSION['PERMISO_CONSULTAR_PERFIL']			= $permisoConsultarPerfil;
	
	$objDBUsuarios = new dbUsuarios;
	$objDBUsuarios->insertBitacoraUsuario($codigoFuncionario,$codigoUnidadUsuario,$fecha_hra_inicio,$ip,$codigoPerfil);
	
	if(($permisoConsultarUnidad&& !$permisoValidar) || $permisoConsultarPerfil){
		$paginaInicio = "unidades.php?login=true";
	}
	else{
		if($permisoValidar){
			$paginaInicio = "certificacionServicio.php?login=true";
		}
		else if($permisoRegistrar && ($tipoUnidad == 30 || $tipoUnidad == 120)){
			$paginaInicio = "serviciosUnidadesEspecializadas.php?login=true";
		}
		else if($permisoRegistrar){
			$paginaInicio = "servicios.php?login=true";
		}
	}
	
	echo "<script>self.location.href='".$paginaInicio."'</script>";
}
else {
	echo "<script>";
		echo "sessionStorage.removeItem('access_token');";
		echo "sessionStorage.removeItem('expires_at');";
		echo "sessionStorage.removeItem('token_type');";
		echo "self.location.href='index.php?ctrl=1';";
	echo "</script>";
}
?>