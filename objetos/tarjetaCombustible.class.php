<?
Class tarjetaCombustible{	
	var $codigoVehiculo;
	var $nroTarjeta;
	var $nroTarjetaDV;
	var $archivo;
	var $validado;
	var $fechaDesde;
	var $fechaHasta;
	
	function setCodigoVehiculo($codigoVehiculo){
		$this->codigoVehiculo = $codigoVehiculo;
	}
	
	function setNroTarjeta($nroTarjeta){
		$this->nroTarjeta = $nroTarjeta;
	}
	
	function setNroTarjetaDV($nroTarjetaDV){
		$this->nroTarjetaDV = $nroTarjetaDV;
	}
	
	function setArchivo($archivo){
		$this->archivo = $archivo;
	}
	
	function setValidado($validado){
		$this->validado = $validado;
	}

	function setFechaDesde($fechaDesde){
		$this->fechaDesde = $fechaDesde;
	}
	
	function setFechaHasta($fechaHasta){
		$this->fechaHasta = $fechaHasta;
	}

	function getCodigoVehiculo(){
		return $this->codigoVehiculo;
	}
	
	function getNroTarjeta(){
		return $this->nroTarjeta;
	}
	
	function getNroTarjetaDV(){
		return $this->nroTarjetaDV;
	}
	
	function getArchivo(){
		return $this->archivo;
	}

	function getValidado(){
		return $this->validado;
	}

	function getFechaDesde(){
		return $this->fechaDesde;
	}

	function getFechaHasta(){
		return $this->fechaHasta;
	}

}//end class   
?>