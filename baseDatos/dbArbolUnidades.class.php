<?
Class dbUnidad extends Conexion{	
	/*---Filtro de especialidades--------------------------------------*/
	
	function Especialidad($perfil){
		$filtro = "";
		/* FFEE */
		if($perfil==140){
			$filtro = " AND (UNI_CODIGO_ESPECIALIDAD = 30) ";
			}
		/* TRANSITO */	
		else if($perfil==130){
			$filtro = " AND (UNI_CODIGO_ESPECIALIDAD IN (10,90)) ";
			}
		/* ESUCAR */
		else if($perfil==120){
			$filtro = " AND (UNI_CODIGO_ESPECIALIDAD = 50) ";
			}
		/* FRONTERIZA */
		else if($perfil==110){
			$filtro = " AND (UNI_CODIGO_ESPECIALIDAD = 80) ";
			}

		return $filtro;
		}
	//echo $perfil;
	/*-----------------------------------------------------------------*/
	
	/* Crea la base del arbol a partir de la unidad indicada como base */	
	function PrimerArbolUnidades($codPadre,$perfil,$unidades){
				  
		$sql = "SELECT UNI_TIPOUNIDAD
				FROM UNIDAD
				WHERE UNI_CODIGO=".$codPadre;
		
		$result = $this->execstmt($this->Conecta(),$sql);
		$myrow = mysql_fetch_array($result);
		$Jerarquia = $myrow["UNI_TIPOUNIDAD"];
		
		$filtro = $this->Especialidad($perfil);
		
		if($Jerarquia==10){
			//Nacional
			$filtro = " WHERE 1=1 ".$filtro;
						$sql = "SELECT 
							IF(UNI_TIPOUNIDAD = 150,UNI_CODIGO,ZONA_CODIGO) AS UNI_CODIGO,
							IF(UNI_TIPOUNIDAD = 150,UNI_DESCRIPCION,ZONA_DESCRIPCION) AS UNI_DESCRIPCION,
							20 AS UNI_PADRE,
							IF(UNI_TIPOUNIDAD = 150,UNI_TIPOUNIDAD,ZONA_TIPOUNIDAD) AS UNI_TIPO,
							IF(UNI_TIPOUNIDAD = 150,21,ZONA_ORDEN) AS ORDEN_CENCO
				FROM VISTA_ARBOL_UNIDADES_NACIONAL
				".$filtro."
				GROUP BY ZONA_CODIGO, ZONA_DESCRIPCION
				ORDER BY ORDEN_CENCO";
			$Jerarquia=1;
			//echo $sql;
		}
		
		elseif($Jerarquia==20){
			//Zona
			$sql = "SELECT 
					PREFECTURA_CODIGO AS UNI_CODIGO, 
					PREFECTURA_DESCRIPCION AS UNI_DESCRIPCION, 
					ZONA_CODIGO AS UNI_PADRE, 
					if((PREFECTURA_TIPOUNIDAD = 30 OR PREFECTURA_TIPOUNIDAD = 120 OR PREFECTURA_TIPOUNIDAD = 90),PREFECTURA_TIPOUNIDAD,0) AS UNI_TIPO, 
					PREFECTURA_ESPECIALIDAD AS UNI_ESPECIALIDAD 
				FROM VISTA_ARBOL_UNIDADES_NACIONAL
				WHERE ZONA_CODIGO = ".$codPadre." ".$filtro."
				GROUP BY PREFECTURA_CODIGO, PREFECTURA_DESCRIPCION
				ORDER BY ZONA_ORDEN";
			$Jerarquia=2;
		}
		elseif($codPadre==9650 || $codPadre==10580){
			//Prefectura Transito y Carreteras
			$sql = "SELECT PREFECTURA_CODIGO AS UNI_CODIGO, PREFECTURA_DESCRIPCION AS UNI_DESCRIPCION, ZONA_CODIGO AS UNI_PADRE, ZONA_TIPOUNIDAD AS UNI_TIPO, UNI_ESPECIALIDAD 
				FROM VISTA_ARBOL_UNIDADES_NACIONAL
				WHERE ZONA_CODIGO = ".$codPadre." ".$filtro."
				GROUP BY PREFECTURA_CODIGO, PREFECTURA_DESCRIPCION
				ORDER BY ZONA_ORDEN";
			$Jerarquia=2;
			//echo $sql;
		}
		elseif($Jerarquia==30 || $Jerarquia==120 || $Jerarquia==90){
			//Prefectura
			$sql = "SELECT DEPENDIENTE_CODIGO AS UNI_CODIGO, DEPENDIENTE_DESCRIPCION AS UNI_DESCRIPCION, PREFECTURA_CODIGO AS UNI_PADRE, if((DEPENDIENTE_TIPOUNIDAD = UNI_TIPOUNIDAD),DEPENDIENTE_TIPOUNIDAD,0) AS UNI_TIPO, UNI_ESPECIALIDAD
				FROM VISTA_ARBOL_UNIDADES_NACIONAL
				WHERE PREFECTURA_CODIGO = ".$codPadre." ".$filtro."
				GROUP BY DEPENDIENTE_CODIGO, DEPENDIENTE_DESCRIPCION
				ORDER BY ZONA_ORDEN";
			$Jerarquia=3;
			//echo $sql;
		}	
		elseif($Jerarquia==40){
				$sql = "SELECT UNI_CODIGO AS UNI_CODIGO, UNI_DESCRIPCION AS UNI_DESCRIPCION, DEPENDIENTE_CODIGO AS UNI_PADRE, UNI_TIPOUNIDAD AS UNI_TIPO, UNI_ESPECIALIDAD 
				FROM VISTA_ARBOL_UNIDADES_NACIONAL
				WHERE DEPENDIENTE_CODIGO = ".$codPadre." ".$filtro."
			
				GROUP BY UNI_CODIGO, UNI_DESCRIPCION
				ORDER BY ZONA_ORDEN";
			$Jerarquia=3;
		}
	 elseif($Jerarquia==60){
				$sql = "SELECT UNI_CODIGO AS UNI_CODIGO, UNI_DESCRIPCION AS UNI_DESCRIPCION, COMISARIA_CODIGO AS UNI_PADRE, UNI_TIPOUNIDAD AS UNI_TIPO, UNI_ESPECIALIDAD, UNI_PLANCUADRANTE 
				FROM VISTA_ARBOL_UNIDADES_NACIONAL
				WHERE COMISARIA_CODIGO = ".$codPadre." ".$filtro." AND UNI_TIPOUNIDAD NOT IN(60) 
				GROUP BY UNI_CODIGO, UNI_DESCRIPCION
				ORDER BY ZONA_ORDEN";
			$Jerarquia=5;
			//echo $sql;


		}else{
			//Comisaria
			$sql = "SELECT UNI_CODIGO AS UNI_CODIGO, UNI_DESCRIPCION AS UNI_DESCRIPCION, COMISARIA_CODIGO AS UNI_PADRE, UNI_TIPOUNIDAD AS UNI_TIPO, UNI_ESPECIALIDAD, UNI_PLANCUADRANTE 
				FROM VISTA_ARBOL_UNIDADES_NACIONAL
				WHERE COMISARIA_CODIGO = ".$codPadre." ".$filtro."
				GROUP BY UNI_CODIGO, UNI_DESCRIPCION
				ORDER BY ZONA_ORDEN";
			$Jerarquia=4;
			//echo $sql;
		}
    //echo $sql;
				$i=0;
				$result = $this->execstmt($this->Conecta(),$sql);
				mysql_close();
				while($myrow = mysql_fetch_array($result)){
					
					$unidad = new ArboUnidad;
					$unidad->setCodigoUnidad(STRTOUPPER($myrow["UNI_CODIGO"]));
					$unidad->setNombreUnidad(STRTOUPPER($myrow["UNI_DESCRIPCION"]));
					$unidad->setCodigoPadre(STRTOUPPER($myrow["UNI_PADRE"]));
					$unidad->setCodigoTipo(STRTOUPPER($myrow["UNI_TIPO"]));
					$unidad->setEspecialidad(STRTOUPPER($myrow["UNI_ESPECIALIDAD"]));
					$unidad->setCuadrante(STRTOUPPER($myrow["UNI_PLANCUADRANTE"]));
					$unidad->setJerarquia(STRTOUPPER($Jerarquia));

					$unidades[$i] = $unidad;			
					$i++;
				}	
	}
	/* ------------------------------------------------------------------------- */
	
	/* Crea los nodos del arbol a partir de la unidad seleccionada */
	function ArbolUnidades($codPadre,$jerarquia,$perfil,$unidades){
		
		$filtro = $this->Especialidad($perfil);
		
		if($jerarquia==1){
			//Zona
			$sql = "SELECT 
					PREFECTURA_CODIGO AS UNI_CODIGO, 
					PREFECTURA_DESCRIPCION AS UNI_DESCRIPCION, 
					ZONA_CODIGO AS UNI_PADRE, if((PREFECTURA_TIPOUNIDAD = 30 OR PREFECTURA_TIPOUNIDAD = 120),PREFECTURA_TIPOUNIDAD,0) AS UNI_TIPO, 
					PREFECTURA_ESPECIALIDAD AS UNI_ESPECIALIDAD 
				FROM VISTA_ARBOL_UNIDADES_NACIONAL
				WHERE ZONA_CODIGO = ".$codPadre." ".$filtro."
				GROUP BY PREFECTURA_CODIGO, PREFECTURA_DESCRIPCION
				ORDER BY ZONA_ORDEN";
		}elseif($jerarquia==2){
			//Dependiente
			$sql = "SELECT 
					DEPENDIENTE_CODIGO AS UNI_CODIGO, 
					DEPENDIENTE_DESCRIPCION AS UNI_DESCRIPCION, 
					PREFECTURA_CODIGO AS UNI_PADRE, 
					if((DEPENDIENTE_TIPOUNIDAD = UNI_TIPOUNIDAD),DEPENDIENTE_TIPOUNIDAD,0) AS UNI_TIPO, 
					UNI_ESPECIALIDAD
				FROM VISTA_ARBOL_UNIDADES_NACIONAL
				WHERE PREFECTURA_CODIGO = ".$codPadre." ".$filtro."
				GROUP BY DEPENDIENTE_CODIGO, DEPENDIENTE_DESCRIPCION
				ORDER BY ZONA_ORDEN";
				//echo $sql;
		}elseif($jerarquia==3){
			//Prefectura
			$sql = "SELECT 
					COMISARIA_CODIGO AS UNI_CODIGO, 
					COMISARIA_DESCRIPCION AS UNI_DESCRIPCION, 
					DEPENDIENTE_CODIGO AS UNI_PADRE, 
					if((COMISARIA_TIPOUNIDAD = UNI_TIPOUNIDAD),COMISARIA_TIPOUNIDAD,0) AS UNI_TIPO, 
					UNI_ESPECIALIDAD
				FROM VISTA_ARBOL_UNIDADES_NACIONAL
				WHERE DEPENDIENTE_CODIGO = ".$codPadre." ".$filtro."
				GROUP BY COMISARIA_CODIGO, COMISARIA_DESCRIPCION
				ORDER BY ZONA_ORDEN";
				//echo $sql;
				
		}else{
			//Comisaria
			$sql = "SELECT 
					UNI_CODIGO AS UNI_CODIGO, 
					UNI_DESCRIPCION AS UNI_DESCRIPCION, 
					COMISARIA_CODIGO AS UNI_PADRE, 
					UNI_TIPOUNIDAD AS UNI_TIPO, 
					UNI_ESPECIALIDAD, 
					UNI_PLANCUADRANTE 
				FROM VISTA_ARBOL_UNIDADES_NACIONAL
				WHERE COMISARIA_CODIGO = ".$codPadre." ".$filtro." 
				GROUP BY UNI_CODIGO, UNI_DESCRIPCION
				ORDER BY ZONA_ORDEN";
				//echo $sql;
		}		  
		
		/*$sql = "SELECT UNI_CODIGO,
									UNI_DESCRIPCION,
									UNI_PADRE
						FROM UNIDAD
						WHERE UNI_PADRE=".$codPadre." AND (UNI_TIPOUNIDAD IN (30,40) OR UNI_CODIGO_ESPECIALIDAD = 80)
						ORDER BY UNI_ORDEN";*/	  
							
				$i=0;
				$result = $this->execstmt($this->Conecta(),$sql);
				mysql_close();
				while($myrow = mysql_fetch_array($result)){
					
					$unidad = new ArboUnidad;
					$unidad->setCodigoUnidad(STRTOUPPER($myrow["UNI_CODIGO"]));
					$unidad->setNombreUnidad(STRTOUPPER($myrow["UNI_DESCRIPCION"]));
					$unidad->setCodigoPadre(STRTOUPPER($myrow["UNI_PADRE"]));
					$unidad->setCodigoTipo(STRTOUPPER($myrow["UNI_TIPO"]));
					$unidad->setEspecialidad(STRTOUPPER($myrow["UNI_ESPECIALIDAD"]));
					$unidad->setCuadrante(STRTOUPPER($myrow["UNI_PLANCUADRANTE"]));
					$unidad->setJerarquia(STRTOUPPER($jerarquia+1));
					
					$unidades[$i] = $unidad;			
					$i++;
				}	
	}
	/* ----------------------------------------------------------------------------- */
	
	/* Determina el tipo de unidad segun la unidad */	
	function TipoUnidad($codUnidad,$tipo){
		
		$sql = "SELECT UNI_TIPOUNIDAD
						FROM UNIDAD
						WHERE UNI_CODIGO=".$codUnidad;
		
		$result = $this->execstmt($this->Conecta(),$sql);
		$myrow = mysql_fetch_array($result);
		$tipo = $myrow["UNI_TIPOUNIDAD"];
		/*
		if($tipo==10){$tipo=0;}
		elseif($tipo==20){$tipo=1;}
		elseif($tipo==30){$tipo=2;}
		elseif($tipo==40){$tipo=3;}
		else{$tipo=4;}
		*/
	}
	
	function unidadesPorNombre($nombre,$unidades){
		$sql = "SELECT 
					U.UNI_CODIGO,
					U.UNI_DESCRIPCION
				FROM UNIDAD U
				WHERE U.UNI_DESCRIPCION LIKE '%".$nombre."%'
				AND U.UNI_SELECCIONABLE = 1
				ORDER BY U.UNI_DESCRIPCION ASC";
		$i=0;
		$result = $this->execstmt($this->Conecta(),$sql);
		mysql_close();
		while($myrow = mysql_fetch_array($result)){
			$unidad = new ArboUnidad;
			$unidad->setCodigoUnidad(STRTOUPPER($myrow["UNI_CODIGO"]));
			$unidad->setNombreUnidad(STRTOUPPER($myrow["UNI_DESCRIPCION"]));
			$unidades[$i] = $unidad;
			$i++;
		}
	}
}

?>