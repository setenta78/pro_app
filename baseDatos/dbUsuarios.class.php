<?
Class dbUsuarios extends Conexion{
	
	function validaUsuario($login, $password, $aplicacion, $usuario){
		
		$sql = "SELECT 
					FUNCIONARIO.ESC_CODIGO,
					FUNCIONARIO.GRA_CODIGO,
					GRADO.GRA_DESCRIPCION,
					USUARIO.UNI_CODIGO,
					UNIDAD.UNI_DESCRIPCION,
					UNIDAD.UNI_PLANCUADRANTE,
					USUARIO.FUN_CODIGO,
					FUNCIONARIO.FUN_APELLIDOPATERNO,
					FUNCIONARIO.FUN_APELLIDOMATERNO,
					FUNCIONARIO.FUN_NOMBRE,
					USUARIO.TUS_CODIGO,
					USUARIO.US_FECHACREACION,
					TIPO_USUARIO.TUS_DESCRIPCION,
					UNIDAD1.UNI_CODIGO AS COD_UNIDADPADRE,
					UNIDAD1.UNI_DESCRIPCION AS DES_UNIDADPADRE,
					UNIDAD1.UNI_TIPOUNIDAD AS TIPO_UNIDADPADRE,
					UNIDAD.UNI_BLOQUEO,
					UNIDAD.UNI_TIPOUNIDAD,
				 	UNIDAD.UNI_CONTIENEHIJOS,
					UNIDAD.UNI_CODIGO_ESPECIALIDAD,
					UNIDAD.UNI_ESPECIALIDAD,
					UNIDAD.UNI_ACTIVO,
					IFNULL(UNIDAD.TCU_CODIGO, 0) TIPO_UNIDAD,
					IFNULL(UNIDAD.TESPC_CODIGO, 0) ESPECIALIDAD_UNIDAD,
					CARGO_FUNCIONARIO.CAR_CODIGO,
					IFNULL(UNIDAD.TUNI_CODIGO, 0) TUNI_CODIGO,
					CONFIG_SYS.FECHA_LIMITE,
					TIPO_USUARIO.VALIDAR,
					TIPO_USUARIO.REGISTRAR,
					TIPO_USUARIO.CONSULTAR_UNIDAD,
					TIPO_USUARIO.CONSULTAR_PERFIL
				FROM USUARIO
				JOIN TIPO_USUARIO ON (USUARIO.TUS_CODIGO = TIPO_USUARIO.TUS_CODIGO)
				JOIN FUNCIONARIO ON (USUARIO.FUN_CODIGO = FUNCIONARIO.FUN_CODIGO)
				JOIN GRADO ON (FUNCIONARIO.ESC_CODIGO = GRADO.ESC_CODIGO) AND (FUNCIONARIO.GRA_CODIGO = GRADO.GRA_CODIGO)
				JOIN UNIDAD ON (USUARIO.UNI_CODIGO = UNIDAD.UNI_CODIGO)
				LEFT JOIN UNIDAD UNIDAD1 ON (UNIDAD.UNI_PADRE = UNIDAD1.UNI_CODIGO)
				LEFT JOIN CARGO_FUNCIONARIO ON (USUARIO.FUN_CODIGO = CARGO_FUNCIONARIO.FUN_CODIGO)
				JOIN CONFIG_SYS ON CONFIG_SYS.ACTIVO = 1
				WHERE USUARIO.US_LOGIN = '{$login}' AND USUARIO.US_PASSWORD = '{$password}' AND CARGO_FUNCIONARIO.FECHA_HASTA IS NULL";
	    	
			//echo $sql;
			$result = $this->execstmt($this->Conecta(),$sql);
			mysql_close();
			if(mysql_num_rows($result) > 0){
			$myrow = mysql_fetch_array($result);
	  	
		 	$escalafon = new escalafon;
		 	$escalafon->setCodigo($myrow["ESC_CODIGO"]);
		 	$escalafon->setDescripcion("");
		 	
		 	$grado = new grado;
		 	$grado->setEscalafon($escalafon);
		 	$grado->setCodigo($myrow["GRA_CODIGO"]);
		 	$grado->setDescripcion($myrow["GRA_DESCRIPCION"]);
		 	
		 	$unidadPadre = new unidad;
		 	$unidadPadre->setCodigoUnidad($myrow["COD_UNIDADPADRE"]);
		 	$unidadPadre->setDescripcionUnidad($myrow["DES_UNIDADPADRE"]);
		 	$unidadPadre->setTipoUnidad($myrow["TIPO_UNIDADPADRE"]);
		 	
		 	$unidad = new unidad;
		 	$unidad->setCodigoUnidad($myrow["UNI_CODIGO"]);
		 	$unidad->setPadreUnidad($unidadPadre);
		 	$unidad->setDescripcionUnidad($myrow["UNI_DESCRIPCION"]);
		 	$unidad->setTienePlanCuadrante($myrow["UNI_PLANCUADRANTE"]);
		 	$unidad->setBloqueada($myrow["UNI_BLOQUEO"]);
		 	$unidad->setEspecialidad($myrow["UNI_CODIGO_ESPECIALIDAD"]);
		 	$unidad->setEspecialidadOld($myrow["UNI_ESPECIALIDAD"]);
		 	$unidad->setTipoUnidad($myrow["UNI_TIPOUNIDAD"]);
		 	$unidad->setContieneHijos($myrow["UNI_CONTIENEHIJOS"]);
		 	$unidad->setUnidadTipo($myrow["TUNI_CODIGO"]);
		 	$unidad->setTipoUnidadPadre($unidadPadre);
		 	$unidad->setTipoUnidadNew($myrow["TIPO_UNIDAD"]);
		 	$unidad->setEspecialidadUnidadNew($myrow["ESPECIALIDAD_UNIDAD"]);
		 	
		 	$funcionario = new funcionario;
		 	$funcionario->setCodigoFuncionario($myrow["FUN_CODIGO"]);
		 	$funcionario->setApellidoPaterno($myrow["FUN_APELLIDOPATERNO"]);
		 	$funcionario->setApellidoMaterno($myrow["FUN_APELLIDOMATERNO"]);
		 	$funcionario->setPNombre($myrow["FUN_NOMBRE"]);
		 	$funcionario->setGrado($grado);
		 	$funcionario->setCargo($myrow["CAR_CODIGO"]);
		 	
		 	$perfil = new perfil;
		 	$perfil->setCodigoPerfil($myrow["TUS_CODIGO"]);
		 	$perfil->setDescripcionPerfil($myrow["TUS_DESCRIPCION"]);
		 	$perfil->setPermisoValidar($myrow["VALIDAR"]);
		 	$perfil->setPermisoRegistrar($myrow["REGISTRAR"]);
		 	$perfil->setPermisoConsultarUnidad($myrow["CONSULTAR_UNIDAD"]);
		 	$perfil->setPermisoConsultarPerfil($myrow["CONSULTAR_PERFIL"]);
		 	
		 	$usuario = new usuario;
		 	$usuario->setUnidad($unidad);
		 	$usuario->setFuncionario($funcionario);
	 		$usuario->setUserName($login);
		 	$usuario->setClave($password);
		 	$usuario->setPerfil($perfil);
		 	$usuario->setFechaLimite($myrow["FECHA_LIMITE"]);
		 	$usuario->setPermisoActualizar("");
	 	}
	}
	
	function validaUsuarioExterior($login, $aplicacion, $usuario){
			
		$sql = "SELECT 
					FUNCIONARIO.ESC_CODIGO,
					FUNCIONARIO.GRA_CODIGO,
					GRADO.GRA_DESCRIPCION,
					USUARIO.UNI_CODIGO,
					UNIDAD.UNI_DESCRIPCION,
					UNIDAD.UNI_PLANCUADRANTE,
					USUARIO.FUN_CODIGO,
					FUNCIONARIO.FUN_APELLIDOPATERNO,
					FUNCIONARIO.FUN_APELLIDOMATERNO,
					FUNCIONARIO.FUN_NOMBRE,
					USUARIO.TUS_CODIGO,
					TIPO_USUARIO.TUS_DESCRIPCION,
					UNIDAD1.UNI_CODIGO AS COD_UNIDADPADRE,
					UNIDAD1.UNI_DESCRIPCION AS DES_UNIDADPADRE,
					UNIDAD.UNI_BLOQUEO,
					UNIDAD.UNI_ESPECIALIDAD
				FROM USUARIO
				JOIN TIPO_USUARIO ON (USUARIO.TUS_CODIGO = TIPO_USUARIO.TUS_CODIGO)
				JOIN FUNCIONARIO ON (USUARIO.FUN_CODIGO = FUNCIONARIO.FUN_CODIGO)
				JOIN GRADO ON (FUNCIONARIO.ESC_CODIGO = GRADO.ESC_CODIGO) AND (FUNCIONARIO.GRA_CODIGO = GRADO.GRA_CODIGO)
				JOIN UNIDAD ON (USUARIO.UNI_CODIGO = UNIDAD.UNI_CODIGO)
				LEFT JOIN UNIDAD UNIDAD1 ON (UNIDAD.UNI_PADRE = UNIDAD1.UNI_CODIGO)
			  	WHERE ((USUARIO.US_LOGIN = '{$login}'))";
			
	  // AND (USUARIO.US_PASSWORD = '".$password."'))";     
	  //if ($password != "MAESTRO10") $sql .= " AND (USUARIO.US_PASSWORD = '".$password."')";
	         
	  //echo $sql;
		$result = $this->execstmt($this->Conecta(),$sql);
		mysql_close();
		if(mysql_num_rows($result) > 0){
			$myrow = mysql_fetch_array($result);
			
			$escalafon = new escalafon;
			$escalafon->setCodigo($myrow["ESC_CODIGO"]);
			$escalafon->setDescripcion("");
			
			$grado = new grado;
			$grado->setEscalafon($escalafon);
			$grado->setCodigo($myrow["GRA_CODIGO"]);
			$grado->setDescripcion($myrow["GRA_DESCRIPCION"]);
			
			$unidadPadre = new unidad;
			$unidadPadre->setCodigoUnidad($myrow["COD_UNIDADPADRE"]);
			$unidadPadre->setDescripcionUnidad($myrow["DES_UNIDADPADRE"]);
			
			$unidad = new unidad;
			$unidad->setCodigoUnidad($myrow["UNI_CODIGO"]);
			$unidad->setPadreUnidad($unidadPadre);
			$unidad->setDescripcionUnidad($myrow["UNI_DESCRIPCION"]);
			$unidad->setTienePlanCuadrante($myrow["UNI_PLANCUADRANTE"]);
			$unidad->setBloqueada($myrow["UNI_BLOQUEO"]);
			$unidad->setEspecialidad($myrow["UNI_ESPECIALIDAD"]);
			
			$funcionario = new funcionario;
			$funcionario->setCodigoFuncionario($myrow["FUN_CODIGO"]);
			$funcionario->setApellidoPaterno($myrow["FUN_APELLIDOPATERNO"]);
			$funcionario->setApellidoMaterno($myrow["FUN_APELLIDOMATERNO"]);
			$funcionario->setPNombre($myrow["FUN_NOMBRE"]);
			$funcionario->setGrado($grado);
			
			$perfil = new perfil;
			$perfil->setCodigoPerfil($myrow["TUS_CODIGO"]);
			$perfil->setDescripcionPerfil($myrow["TUS_DESCRIPCION"]);
			
			$usuario = new usuario;
			$usuario->setUnidad($unidad);
			$usuario->setFuncionario($funcionario);
			$usuario->setUserName($login);
			$usuario->setClave($password);
			$usuario->setPerfil($perfil);
			$usuario->setPermisoActualizar("");
		} 
	}
	
	//BITACORA DE USUARIOS
	function insertBitacoraUsuario($userID,$unidad,$hra_inicio,$ip,$perfil){
		
		$sql = "INSERT INTO BITACORA_USUARIO(FUN_CODIGO,UNI_CODIGO,US_FECHAHORA_INICIO,US_DIRECCION_IP,TUS_CODIGO)
				VALUES ('{$userID}',{$unidad},'{$hra_inicio}','{$ip}',{$perfil});";
		
		//echo $sql;	
		$result = $this->execstmt($this->Conecta(),$sql);
		mysql_close();
		return $result;
	}
  //FIN BITACORA
        
  	//MODIFICA FIN SESION
  	function modificaBitacoraUsuario($userID,$unidad,$hra_inicio,$hra_termino,$perfil,$evento){
		
		$sql = "UPDATE BITACORA_USUARIO 
				SET BITACORA_USUARIO.US_FECHAHORA_TERMINO = '{$hra_termino}', BITACORA_USUARIO.US_EVENTO = '{$evento}' 
				WHERE BITACORA_USUARIO.FUN_CODIGO = '{$userID}' 
				AND BITACORA_USUARIO.US_FECHAHORA_INICIO = '{$hra_inicio}' 
				AND BITACORA_USUARIO.TUS_CODIGO = {$perfil};";
		
		//echo $sql;
		$result = $this->execstmt($this->Conecta(),$sql);
		mysql_close();
		return $result;
	}
	//FIN SESION
	
	function modificaClaveUsuario($userID, $claveActual, $nuevaClave){
		
		$sql = "UPDATE USUARIO
				SET USUARIO.US_PASSWORD = '{$nuevaClave}'
				WHERE
				USUARIO.FUN_CODIGO = '{$userID}' AND USUARIO.US_PASSWORD = '{$claveActual}'";
		
		//echo $sql;
		$result = $this->execstmt($this->Conecta(),$sql);
		mysql_close();
		return $result;
	}
	
	function obtieneClaveUsuario($userID, $claveActual){
		
		$sql = "SELECT USUARIO.US_PASSWORD FROM USUARIO
				WHERE USUARIO.FUN_CODIGO = '{$userID}'";
		
		//echo $sql;
		$result = $this->execstmt($this->Conecta(),$sql);
		mysql_close();
		$myrow = mysql_fetch_array($result);
		$claveActual = $myrow["US_PASSWORD"];
	}
	
	function eliminaUsuario($userID){
		
		$sql = "DELETE FROM USUARIO
				WHERE USUARIO.FUN_CODIGO = '{$userID}'
				AND USUARIO.TUS_CODIGO NOT IN (90,100)";
		
		//echo $sql;
		$result = $this->execstmt($this->Conecta(),$sql);
		mysql_close();
		return $result;
	}
	
	function CrearUsuario($funcionario){
		
		$password = substr($funcionario->getCodigoFuncionario(), 0, 4);
		
		$sql = "INSERT INTO USUARIO (FUN_CODIGO, UNI_CODIGO, US_LOGIN, US_PASSWORD, TUS_CODIGO, US_FECHACREACION)
				VALUES ('{$funcionario->getCodigoFuncionario()}',{$funcionario->getUnidad()->getCodigoUnidad()},'{$funcionario->getCodigoFuncionario()}','{$password}','{$funcionario->getPerfil()->getCodigoPerfil()}',CURDATE())";
		
		//echo $sql;
		$result = $this->execstmt($this->Conecta(),$sql);
		mysql_close();
		return $result;
	}
	
	function modificaUsuario($funcionario){
		
		$sql = "UPDATE USUARIO
				SET TUS_CODIGO = '{$funcionario->getPerfil()->getCodigoPerfil()}'
				WHERE USUARIO.FUN_CODIGO = '{$funcionario->getCodigoFuncionario()}'";
		
		//echo $sql;
		$result = $this->execstmt($this->Conecta(),$sql);
		mysql_close();
		return $result;
	}
	
	function GrabaUsuario($Unidad, $Funcionario, $Password, $tipoUsuario){
		$sql = "INSERT INTO usuarios (Fun_Codigo, Un_Id, Us_Password, UsTipo_Codigo) 
				VALUES ('{$Funcionario}','{$Unidad}','{$Password}',{$tipoUsuario});";
		$result = $this->execstmt($this->Conecta(),$sql);
	}
	
	function GrabaModificacionUsuario($CodigoFuncionario, $TextContrasena, $Sel_TipoUsuario){
		$sql = "UPDATE usuarios SET Us_Password = '{$TextContrasena}', UsTipo_Codigo = {$Sel_TipoUsuario} 
				WHERE Fun_Codigo = '{$CodigoFuncionario}'";
		$result = $this->execstmt($this->Conecta(),$sql);
	}
	
	function BorraUsuario($CodigoFuncionario){
		$sql = "DELETE FROM usuarios WHERE Fun_Codigo = '{$CodigoFuncionario}'";
		$result = $this->execstmt($this->Conecta(),$sql);
	}
	
	function ListaUsuarios($Unidad){
			$sql = "SELECT 
						usuarios.Fun_Codigo,
						funcionarios.Fun_APaterno,
						funcionarios.Fun_AMaterno,
						funcionarios.Fun_Nombres,
						grados.Gr_Descripcion,
						unidades.Un_Descripcion,
						tipo_usuario.USTipo_Descripcion
					FROM tipo_usuario
					JOIN usuarios ON (tipo_usuario.USTipo_Codigo = usuarios.UsTipo_Codigo)
					JOIN unidades ON (usuarios.Un_Id = unidades.Un_Id)
					LEFT JOIN funcionarios ON (usuarios.Fun_Codigo = funcionarios.Fun_Codigo)
					LEFT JOIN grados ON (funcionarios.Fun_Escalafon = grados.Esc_Id AND funcionarios.Fun_Grado = grados.Gr_Id)";
		
		if($Unidad != "0") $sql .= " WHERE usuarios.Un_Id = '{$Unidad}'";
		$sql .= " ORDER BY usuarios.Un_Id";
		
		$result = $this->execstmt($this->Conecta(),$sql);
		if(mysql_num_rows($result) > 0){
			while($myrow = mysql_fetch_array($result)){
			  $i++;
			  if ($cont == 1){
      		$ColorFondo = "#F2F2F2";
      		$cont=0;
      	}
      	else{
      		$ColorFondo = "#E9E9E0";
      		$cont=1;
      	}
			echo "<tr>\n";
			echo "<td class='TextoNegroVehiculosBold10' bgcolor='{$ColorFondo}' width='10%' align='center'>\n";
			echo "{$myrow['Fun_Codigo']}<br>\n";
			echo "</td>\n";
			echo "<td class='TextoNegroVehiculosBold10' bgcolor='{$ColorFondo}' width='47%'>\n";
			echo "&nbsp;{$myrow['Fun_APaterno']} {$myrow['Fun_AMaterno']} {$myrow['Fun_Nombres']}<br>\n";
			echo "&nbsp;{$myrow['Gr_Descripcion']}<br>\n";
			echo "</td>\n";
			echo "<td class='TextoNegroVehiculosBold10' bgcolor='{$ColorFondo}' width='20%' align='center'>\n";
			echo STRTOUPPER($myrow['USTipo_Descripcion'])."<br>\n";
			echo "</td>\n";
			if ($Unidad == "0"){
				echo "<td class='TextoNegroVehiculosBold10' bgcolor= '{$ColorFondo}' width='23%' align='center'>\n";
				echo "{$myrow['Un_Descripcion']}<br>\n";
				echo "</td>\n";
			}
			echo "</tr>\n";
		  }
		}
	}
	
	function ListaCodigoUsuarios($Unidad, $CodigoSeleccionado){
		$sql = "SELECT Fun_Codigo
				FROM usuarios
				WHERE Un_Id = '{$Unidad}'
				ORDER BY Fun_Codigo";
		
		//echo $sql;	
		$result = $this->execstmt($this->Conecta(),$sql);
		if(mysql_num_rows($result) > 0){
			while( $myrow = mysql_fetch_array($result) ){
    		echo "<option ";
    		if ($CodigoSeleccionado == $myrow["Fun_Codigo"]) echo "Selected";
	   		echo " value= \"{$myrow['Fun_Codigo']}\">{$myrow['Fun_Codigo']}</option>";
	    }
	  }
	}
		
	function ObtieneDatosUsuario($CodigoFuncionario, $APaterno, $AMaterno, $Nombres, $GradoDescripcion, $TipoCodigo, $Password, $Desc_TipoUsuario){
		$sql = "SELECT 
					usuarios.Us_Password,
					usuarios.UsTipo_Codigo,
					funcionarios.Fun_APaterno,
					funcionarios.Fun_AMaterno,
					funcionarios.Fun_Nombres,
					grados.Gr_Descripcion,
					tipo_usuario.USTipo_Descripcion
				FROM usuarios
				JOIN funcionarios ON (usuarios.Fun_Codigo = funcionarios.Fun_Codigo)
				JOIN grados ON (funcionarios.Fun_Escalafon = grados.Esc_Id AND funcionarios.Fun_Grado = grados.Gr_Id)
				JOIN tipo_usuario ON (usuarios.UsTipo_Codigo = tipo_usuario.USTipo_Codigo)
				WHERE usuarios.Fun_Codigo = '{$CodigoFuncionario}'";
		//echo $sql;
		$result = $this->execstmt($this->Conecta(),$sql);
		if(mysql_num_rows($result) > 0){
			$myrow = mysql_fetch_array($result);	
			$APaterno 			= $myrow["Fun_APaterno"];
			$AMaterno 			= $myrow["Fun_AMaterno"];
			$Nombres 			= $myrow["Fun_Nombres"];
			$GradoDescripcion	= $myrow["Gr_Descripcion"];
			$TipoCodigo 		= $myrow["UsTipo_Codigo"];
			$Password 			= $myrow["Us_Password"];
			$Desc_TipoUsuario	= $myrow["USTipo_Descripcion"];
		}
	}
	
	function cambioUnidad($unidad, $usuario){
		
		$sql = "SELECT 
					UNIDAD.UNI_CODIGO,
					UNIDAD.UNI_DESCRIPCION,
					UNIDAD.UNI_PLANCUADRANTE,
					UNIDAD1.UNI_CODIGO AS COD_UNIDADPADRE,
					UNIDAD1.UNI_DESCRIPCION AS DES_UNIDADPADRE,
					UNIDAD1.UNI_TIPOUNIDAD AS TIPO_UNIDADPADRE,
					UNIDAD.UNI_BLOQUEO,
					IF(UNIDAD.TCU_CODIGO = 120,50,UNIDAD.UNI_TIPOUNIDAD) UNI_TIPOUNIDAD,
				 	UNIDAD.UNI_CONTIENEHIJOS,
					UNIDAD.UNI_CODIGO_ESPECIALIDAD,
					UNIDAD.UNI_ESPECIALIDAD,
					UNIDAD.UNI_ACTIVO,
					IFNULL(UNIDAD.TCU_CODIGO, 0) TIPO_UNIDAD,
					IFNULL(UNIDAD.TESPC_CODIGO, 0) ESPECIALIDAD_UNIDAD,
					IF(UNIDAD.TUNI_CODIGO IS NULL,0,UNIDAD.TUNI_CODIGO) TUNI_CODIGO
				FROM UNIDAD
				LEFT JOIN UNIDAD UNIDAD1 ON (UNIDAD.UNI_PADRE = UNIDAD1.UNI_CODIGO)
         		WHERE UNIDAD.UNI_CODIGO = '{$unidad}'";
		//echo $sql;
		$result = $this->execstmt($this->Conecta(),$sql);
		mysql_close();
		if(mysql_num_rows($result) > 0){
		$myrow = mysql_fetch_array($result);
			
			$unidadPadre = new unidad;
			$unidadPadre->setCodigoUnidad($myrow["COD_UNIDADPADRE"]);
			$unidadPadre->setDescripcionUnidad($myrow["DES_UNIDADPADRE"]);
			$unidadPadre->setTipoUnidad($myrow["TIPO_UNIDADPADRE"]);
			
			$unidad = new unidad;
			$unidad->setCodigoUnidad($myrow["UNI_CODIGO"]);
			$unidad->setPadreUnidad($unidadPadre);
			$unidad->setDescripcionUnidad($myrow["UNI_DESCRIPCION"]);
			$unidad->setTienePlanCuadrante($myrow["UNI_PLANCUADRANTE"]);
			$unidad->setBloqueada($myrow["UNI_BLOQUEO"]);
			$unidad->setEspecialidad($myrow["UNI_CODIGO_ESPECIALIDAD"]);
			$unidad->setEspecialidadOld($myrow["UNI_ESPECIALIDAD"]);
			$unidad->setTipoUnidad($myrow["UNI_TIPOUNIDAD"]);
			$unidad->setContieneHijos($myrow["UNI_CONTIENEHIJOS"]);
			$unidad->setUnidadTipo($myrow["TUNI_CODIGO"]);
			$unidad->setTipoUnidadPadre($unidadPadre);
			$unidad->setTipoUnidadNew($myrow["TIPO_UNIDAD"]);
			$unidad->setEspecialidadUnidadNew($myrow["ESPECIALIDAD_UNIDAD"]);
			
			$usuario = new usuario;
			$usuario->setUnidad($unidad);
		}
	}
	
	function cambioUsuario($codUsuario, $usuario){
		
		$sql = "SELECT 
					FUNCIONARIO.ESC_CODIGO,
					FUNCIONARIO.GRA_CODIGO,
					GRADO.GRA_DESCRIPCION,
					USUARIO.UNI_CODIGO,
					UNIDAD.UNI_DESCRIPCION,
					UNIDAD.UNI_PLANCUADRANTE,
					USUARIO.FUN_CODIGO,
					FUNCIONARIO.FUN_APELLIDOPATERNO,
					FUNCIONARIO.FUN_APELLIDOMATERNO,
					FUNCIONARIO.FUN_NOMBRE,
					USUARIO.TUS_CODIGO,
					USUARIO.US_FECHACREACION,
					TIPO_USUARIO.TUS_DESCRIPCION,
					UNIDAD1.UNI_CODIGO AS COD_UNIDADPADRE,
					UNIDAD1.UNI_DESCRIPCION AS DES_UNIDADPADRE,
					UNIDAD1.UNI_TIPOUNIDAD AS TIPO_UNIDADPADRE,
					UNIDAD.UNI_BLOQUEO,
					UNIDAD.UNI_TIPOUNIDAD,
				 	UNIDAD.UNI_CONTIENEHIJOS,
					UNIDAD.UNI_CODIGO_ESPECIALIDAD,
					UNIDAD.UNI_ESPECIALIDAD,
					UNIDAD.UNI_ACTIVO,
					CARGO_FUNCIONARIO.CAR_CODIGO,
					IFNULL(UNIDAD.TUNI_CODIGO, 0) TUNI_CODIGO,
					CONFIG_SYS.FECHA_LIMITE,
					TIPO_USUARIO.VALIDAR,
					TIPO_USUARIO.REGISTRAR,
					TIPO_USUARIO.CONSULTAR_UNIDAD,
					TIPO_USUARIO.CONSULTAR_PERFIL
				FROM USUARIO
				JOIN TIPO_USUARIO ON (USUARIO.TUS_CODIGO = TIPO_USUARIO.TUS_CODIGO)
				JOIN FUNCIONARIO ON (USUARIO.FUN_CODIGO = FUNCIONARIO.FUN_CODIGO)
				JOIN GRADO ON (FUNCIONARIO.ESC_CODIGO = GRADO.ESC_CODIGO) AND (FUNCIONARIO.GRA_CODIGO = GRADO.GRA_CODIGO)
				JOIN UNIDAD ON (USUARIO.UNI_CODIGO = UNIDAD.UNI_CODIGO)
				JOIN CONFIG_SYS ON CONFIG_SYS.ACTIVO = 1
				LEFT JOIN UNIDAD UNIDAD1 ON (UNIDAD.UNI_PADRE = UNIDAD1.UNI_CODIGO)
				LEFT JOIN CARGO_FUNCIONARIO ON (USUARIO.FUN_CODIGO = CARGO_FUNCIONARIO.FUN_CODIGO)
				WHERE USUARIO.US_LOGIN = '{$codUsuario}' AND CARGO_FUNCIONARIO.FECHA_HASTA IS NULL";
	    
		$result = $this->execstmt($this->Conecta(),$sql);
		mysql_close();
		if(mysql_num_rows($result) > 0){
			$myrow = mysql_fetch_array($result);
	  	
		 	$escalafon = new escalafon;
		 	$escalafon->setCodigo($myrow["ESC_CODIGO"]);
		 	$escalafon->setDescripcion("");
		 	
		 	$grado = new grado;
		 	$grado->setEscalafon($escalafon);
		 	$grado->setCodigo($myrow["GRA_CODIGO"]);
		 	$grado->setDescripcion($myrow["GRA_DESCRIPCION"]);
		 	
		 	$unidadPadre = new unidad;
		 	$unidadPadre->setCodigoUnidad($myrow["COD_UNIDADPADRE"]);
		 	$unidadPadre->setDescripcionUnidad($myrow["DES_UNIDADPADRE"]);
		 	$unidadPadre->setTipoUnidad($myrow["TIPO_UNIDADPADRE"]);
		 	
		 	$unidad = new unidad;
		 	$unidad->setCodigoUnidad($myrow["UNI_CODIGO"]);
		 	$unidad->setPadreUnidad($unidadPadre);
		 	$unidad->setDescripcionUnidad($myrow["UNI_DESCRIPCION"]);
		 	$unidad->setTienePlanCuadrante($myrow["UNI_PLANCUADRANTE"]);
		 	$unidad->setBloqueada($myrow["UNI_BLOQUEO"]);
		 	$unidad->setEspecialidad($myrow["UNI_CODIGO_ESPECIALIDAD"]);
		 	$unidad->setEspecialidadOld($myrow["UNI_ESPECIALIDAD"]);
		 	$unidad->setTipoUnidad($myrow["UNI_TIPOUNIDAD"]);
		 	$unidad->setContieneHijos($myrow["UNI_CONTIENEHIJOS"]);
		 	$unidad->setUnidadTipo($myrow["TUNI_CODIGO"]);
		 	$unidad->setTipoUnidadPadre($unidadPadre);
		 	
		 	$funcionario = new funcionario;
		 	$funcionario->setCodigoFuncionario($myrow["FUN_CODIGO"]);
		 	$funcionario->setApellidoPaterno($myrow["FUN_APELLIDOPATERNO"]);
		 	$funcionario->setApellidoMaterno($myrow["FUN_APELLIDOMATERNO"]);
		 	$funcionario->setPNombre($myrow["FUN_NOMBRE"]);
		 	$funcionario->setGrado($grado);
		 	$funcionario->setCargo($myrow["CAR_CODIGO"]);
		 	
		 	$perfil = new perfil;
		 	$perfil->setCodigoPerfil($myrow["TUS_CODIGO"]);
		 	$perfil->setDescripcionPerfil($myrow["TUS_DESCRIPCION"]);
		 	$perfil->setPermisoValidar($myrow["VALIDAR"]);
		 	$perfil->setPermisoRegistrar($myrow["REGISTRAR"]);
		 	$perfil->setPermisoConsultarUnidad($myrow["CONSULTAR_UNIDAD"]);
		 	$perfil->setPermisoConsultarPerfil($myrow["CONSULTAR_PERFIL"]);
		 	
		 	$usuario = new usuario;
		 	$usuario->setUnidad($unidad);
		 	$usuario->setFuncionario($funcionario);
	 		$usuario->setUserName($login);
		 	$usuario->setClave($password);
		 	$usuario->setPerfil($perfil);
		 	$usuario->setFechaLimite($myrow["FECHA_LIMITE"]);
		 	$usuario->setPermisoActualizar("");
	 	}
	}
}
?>