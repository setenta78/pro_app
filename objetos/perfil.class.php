<?
Class perfil {
	var $codigoPerfil;
	var $descripcionPerfil;
	var $permisoValidar;
	var $permisoRegistrar;
	var $permisoConsultarUnidad;
	var $permisoConsultarPerfil;
	
	function setCodigoPerfil($codigoPerfil){
		$this->codigoPerfil = $codigoPerfil;
	}
	
	function setDescripcionPerfil($descripcionPerfil){
		$this->descripcionPerfil = $descripcionPerfil;
	}
	
	function setPermisoValidar($permisoValidar){
		$this->permisoValidar = $permisoValidar;
	}

	function setPermisoRegistrar($permisoRegistrar){
		$this->permisoRegistrar = $permisoRegistrar;
	}

	function setPermisoConsultarUnidad($permisoConsultarUnidad){
		$this->permisoConsultarUnidad = $permisoConsultarUnidad;
	}

	function setPermisoConsultarPerfil($permisoConsultarPerfil){
		$this->permisoConsultarPerfil = $permisoConsultarPerfil;
	}
	
	function getCodigoPerfil(){
		return $this->codigoPerfil;
	}
	
	function getDescripcionPerfil(){
		return $this->descripcionPerfil;
	}		
	
	function getPermisoValidar(){
		return $this->permisoValidar;
	}
	
	function getPermisoRegistrar(){
		return $this->permisoRegistrar;
	}
	
	function getPermisoConsultarUnidad(){
		return $this->permisoConsultarUnidad;
	}
	
	function getPermisoConsultarPerfil(){
		return $this->permisoConsultarPerfil;
	}
}
?>