var cargaListadoFuncionarios;
var idCargaListadoFuncionarios;
var idAsignaCargoFichaPersonal;

function leeFuncionarios(unidad, campo, sentido){
	cargaListadoFuncionarios = 0;
	var nombreBuscar = eliminarBlancos(document.getElementById("textBuscar").value);
	var tipoUnidadNew = document.getElementById("tipoUnidadNew").value;
	var especialidadUnidadNew = document.getElementById("especialidadUnidadNew").value;
	if(document.getElementById('contieneHijos') !== null){
		var contieneHijos = document.getElementById("contieneHijos").value;
	}
	else{
		var contieneHijos = 0;
	}
	var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	var div	= document.getElementById("listadoFuncionarios");
	div.innerHTML = "<table><tr><td><img src='./img/ajax_loader.gif'></td><td>&nbsp;Cargando Funcionarios ......</td>";
	objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlListaFuncionarios.php",true);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//console.log("codigoUnidad="+unidad+"&nombreBuscar="+nombreBuscar+"&campo="+campo+"&sentido="+sentido+"&tipoUnidadNew="+tipoUnidadNew+"&especialidadUnidadNew="+especialidadUnidadNew);
	objHttpXMLFuncionarios.send(encodeURI("codigoUnidad="+unidad+"&nombreBuscar="+nombreBuscar+"&campo="+campo+"&sentido="+sentido+"&tipoUnidadNew="+tipoUnidadNew+"&especialidadUnidadNew="+especialidadUnidadNew));
	objHttpXMLFuncionarios.onreadystatechange=function(){
		//alert(objHttpXMLFuncionarios.readyState);
		if(objHttpXMLFuncionarios.readyState == 4){
			//console.log(objHttpXMLFuncionarios.responseText);
			if (objHttpXMLFuncionarios.responseText != "VACIO"){
				//alert(objHttpXMLFuncionarios.responseText);
				var xml 				= objHttpXMLFuncionarios.responseXML.documentElement;
				var codigo	 			= "";
				var apellidoPaterno		= "";
				var apellidoMaterno 	= "";
				var nombre2				= "";
				var nombre	 			= "";
				var nombreCompleto		= "";
				var grado		 		= "";
				var cargo		 		= "";
				var cuadrante			= "";
				var unidadAgregado		= "";
				var seccion				= "";
				var sw 				 	= 0;
				var fondoLinea		 	= "";
				var resaltarLinea 	 	= "";
				var lineaSinResaltar 	= "";
				var listadoFuncionarios	= "";
				listadoFuncionarios = "<table width='100%' cellspacing='1' cellpadding='1'>";
				//alert(xml.getElementsByTagName('funcionario').length);
				for(i=0;i<xml.getElementsByTagName('funcionario').length;i++){
					if (sw==0) {fondoLinea = "linea1";sw =1}
					else {fondoLinea = "linea2";sw=0}
					
					codigo	 		= (xml.getElementsByTagName('codigo')[i].text||xml.getElementsByTagName('codigo')[i].textContent||"");
					apellidoPaterno = (xml.getElementsByTagName('apellidoPaterno')[i].text||xml.getElementsByTagName('apellidoPaterno')[i].textContent||"");
					apellidoMaterno	= (xml.getElementsByTagName('apellidoMaterno')[i].text||xml.getElementsByTagName('apellidoMaterno')[i].textContent||"");
					nombre			= (xml.getElementsByTagName('nombre')[i].text||xml.getElementsByTagName('nombre')[i].textContent||"");
					nombre2			= (xml.getElementsByTagName('nombre2')[i].text||xml.getElementsByTagName('nombre2')[i].textContent||"");
					nombreCompleto	= (apellidoPaterno+" "+apellidoMaterno+", "+nombre+" "+nombre2);
					grado		 	= (xml.getElementsByTagName('grado')[i].text||xml.getElementsByTagName('grado')[i].textContent||"");
					cargo		 	= (xml.getElementsByTagName('cargo')[i].text||xml.getElementsByTagName('cargo')[i].textContent||"");
					categoriaCargo	= (xml.getElementsByTagName('grupoCargo')[i].text||xml.getElementsByTagName('grupoCargo')[i].textContent||"");
					cuadrante		= (xml.getElementsByTagName('cuadrante')[i].text||xml.getElementsByTagName('cuadrante')[i].textContent||"");
					unidadAgregado	= (xml.getElementsByTagName('unidadAgregado')[i].text||xml.getElementsByTagName('unidadAgregado')[i].textContent||"");
					seccion	 		= (xml.getElementsByTagName('seccion')[i].text||xml.getElementsByTagName('seccion')[i].textContent||"");
					
					resaltarLinea 	 = "cambiarClase(this, 'lineaMarcada')";
					lineaSinResaltar = "cambiarClase(this, '"+fondoLinea+"')";
					
					var nroLinea = i + 1;
					var dblClick = "javascript:abrirVentana('FUNCIONARIO', '800', '400','fichaPersonal.php?codigoFuncionario="+codigo+"&subMenu=Dotacion','"+nroLinea+"','','5','5')";
					
					if (cargo == "TRASLADADO") cargo = "";
					if (cuadrante != "") cargo += " "+cuadrante;
					if (unidadAgregado != "") cargo += ", "+unidadAgregado;
					
					if (cargo.length > 39) {
						var cargoMuestra = cargo.substr(0,37) + " ...";
						var mostrarEtiqueta = " title='"+cargo+"'";
					} else {
						var cargoMuestra = cargo;
						var mostrarEtiqueta = "";
					}
					
					if(contieneHijos == 1){
						listadoFuncionarios += "<tr id='"+nroLinea+"' OnMouseOver=\""+resaltarLinea+"\" OnMouseOut=\""+lineaSinResaltar+"\" class='"+fondoLinea+"' onDblClick=\""+dblClick+"\">";
						listadoFuncionarios += "<td width='4%' align='center'><div id='valorColumna'>"+(i+1)+"</div></td>";
						listadoFuncionarios += "<td width='10%' align='center'><div id='valorColumna'>"+codigo+"</div></td>";
						listadoFuncionarios += "<td width='25%'><div id='valorColumna'>"+nombreCompleto+"</div></td>";
						listadoFuncionarios += "<td width='13%' align='left'><div id='valorColumna'>"+grado+"</div></td>";
						listadoFuncionarios += "<td width='13%' align='left'><div id='valorColumna'>"+seccion+"</div></td>";
						listadoFuncionarios	+= "<td width='15%' align='left'"+mostrarEtiqueta+"><div id='valorColumna'>"+categoriaCargo+"</div></td>";
						listadoFuncionarios	+= "<td width='20%' align='left'"+mostrarEtiqueta+"><div id='valorColumna'>"+cargoMuestra+"</div></td>";
						listadoFuncionarios += "</tr>";
					}else{
						listadoFuncionarios += "<tr id='"+nroLinea+"' OnMouseOver=\""+resaltarLinea+"\" OnMouseOut=\""+lineaSinResaltar+"\" class='"+fondoLinea+"' onDblClick=\""+dblClick+"\">";
						listadoFuncionarios += "<td width='4%' align='center'><div id='valorColumna'>"+(i+1)+"</div></td>";
						listadoFuncionarios += "<td width='10%' align='center'><div id='valorColumna'>"+codigo+"</div></td>";
						listadoFuncionarios += "<td width='34%'><div id='valorColumna'>"+nombreCompleto+"</div></td>";
						listadoFuncionarios += "<td width='16%' align='left'><div id='valorColumna'>"+grado+"</div></td>";
						listadoFuncionarios	+= "<td width='15%' align='left'"+mostrarEtiqueta+"><div id='valorColumna'>"+categoriaCargo+"</div></td>";
						listadoFuncionarios	+= "<td width='21%' align='left'"+mostrarEtiqueta+"><div id='valorColumna'>"+cargoMuestra+"</div></td>";
						listadoFuncionarios += "</tr>";
					}
				}
				listadoFuncionarios += "</table>";
				div.innerHTML = listadoFuncionarios;
				cargaListadoFuncionarios = 1;
			}
		}
	}
}

var cargaListadoFuncionarios;
var idCargaListadoFuncionarios;

function leeFuncionariosA(unidad, campo, sentido){
	cargaListadoFuncionarios = 0;
	var nombreBuscar = eliminarBlancos(document.getElementById("textBuscar").value);
	var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	var div	= document.getElementById("listadoFuncionarios");
	div.innerHTML = "<table><tr><td><img src='./img/ajax_loader.gif'></td><td>&nbsp;Cargando Funcionarios ......</td>";
	objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlListaFuncionariosAgregados.php",true);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionarios.send(encodeURI("codigoUnidad="+unidad+"&nombreBuscar="+nombreBuscar+"&campo="+campo+"&sentido="+sentido));
	objHttpXMLFuncionarios.onreadystatechange=function(){
		//alert(objHttpXMLFuncionarios.readyState);
		if(objHttpXMLFuncionarios.readyState == 4){
			//alert(objHttpXMLFuncionarios.responseText);
			if (objHttpXMLFuncionarios.responseText != "VACIO"){
				//alert(objHttpXMLFuncionarios.responseText);
				var xml 				= objHttpXMLFuncionarios.responseXML.documentElement;
				var codigo	 			= "";
				var apellidoPaterno		= "";
				var apellidoMaterno 	= "";
				var nombre2				= "";
				var nombre	 			= "";
				var nombreCompleto		= "";
				var grado		 		= "";
				var cargo		 		= "";
				var cuadrante			= "";
				var unidadAgregado		= "";
				var sw 					= 0;
				var fondoLinea			= "";
				var resaltarLinea 	 	= "";
				var lineaSinResaltar 	= "";
				var listadoFuncionarios	= "";
				
				listadoFuncionarios = "<table width='100%' cellspacing='1' cellpadding='1'>";
				//alert(xml.getElementsByTagName('funcionario').length);
				for(i=0;i<xml.getElementsByTagName('funcionario').length;i++){
					if (sw==0) {fondoLinea = "linea1";sw =1}
					else {fondoLinea = "linea2";sw=0}
					
					codigo	 		 = (xml.getElementsByTagName('codigo')[i].text||xml.getElementsByTagName('codigo')[i].textContent||"");
					apellidoPaterno  = (xml.getElementsByTagName('apellidoPaterno')[i].text||xml.getElementsByTagName('apellidoPaterno')[i].textContent||"");
					apellidoMaterno	 = (xml.getElementsByTagName('apellidoMaterno')[i].text||xml.getElementsByTagName('apellidoMaterno')[i].textContent||"");
					nombre			 = (xml.getElementsByTagName('nombre')[i].text||xml.getElementsByTagName('nombre')[i].textContent||"");
					nombre2			 = (xml.getElementsByTagName('nombre2')[i].text||xml.getElementsByTagName('nombre2')[i].textContent||"");
					nombreCompleto	 = (apellidoPaterno+" "+apellidoMaterno+", "+nombre+" "+nombre2);
					grado		 	 = (xml.getElementsByTagName('grado')[i].text||xml.getElementsByTagName('grado')[i].textContent||"");
					cargo		 	 = (xml.getElementsByTagName('cargo')[i].text||xml.getElementsByTagName('cargo')[i].textContent||"");
					cuadrante		 = (xml.getElementsByTagName('cuadrante')[i].text||xml.getElementsByTagName('cuadrante')[i].textContent||"");
					unidadAgregado	 = (xml.getElementsByTagName('unidadAgregado')[i].text||xml.getElementsByTagName('unidadAgregado')[i].textContent||"");
					
					resaltarLinea 	 = "cambiarClase(this, 'lineaMarcada')";
					lineaSinResaltar = "cambiarClase(this, '"+fondoLinea+"')";

					var nroLinea = i + 1;
					var dblClick = "javascript:abrirVentana('FUNCIONARIO', '800', '400','fichaPersonal.php?codigoFuncionario="+codigo+"&subMenu=Agregado','"+nroLinea+"','','5','5')";
					
					if (cargo.length > 35) {
						var cargoMuestra = cargo.substr(0,33) + " ... ";
					} else {
						var cargoMuestra = cargo;
					}
					
					if (unidadAgregado != "") cargoMuestra += ", "+unidadAgregado;
					listadoFuncionarios += "<tr id='"+nroLinea+"' OnMouseOver=\""+resaltarLinea+"\" OnMouseOut=\""+lineaSinResaltar+"\" class='"+fondoLinea+"' onDblClick=\""+dblClick+"\">";
					listadoFuncionarios += "<td width='4%' align='center'><div id='valorColumna'>"+(i+1)+"</div></td>";
					listadoFuncionarios += "<td width='16%' align='center'><div id='valorColumna'>"+codigo+"</div></td>";
					listadoFuncionarios += "<td width='30%'><div id='valorColumna'>"+nombreCompleto+"</div></td>";
					listadoFuncionarios += "<td width='20%' align='left'><div id='valorColumna'>"+grado+"</div></td>";
					listadoFuncionarios += "<td width='30%' align='left'><div id='valorColumna'>"+cargoMuestra+"</div></td>";
					listadoFuncionarios += "</tr>";
   			
				}
				listadoFuncionarios += "</table>";
				div.innerHTML = listadoFuncionarios;
				cargaListadoFuncionarios = 1;
			}
		}
	}
}

function leeFuncionariosD(unidad, campo, sentido){
	cargaListadoFuncionarios = 0;
	var nombreBuscar = eliminarBlancos(document.getElementById("textBuscar").value);
	var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	var div	= document.getElementById("listadoFuncionarios");
	div.innerHTML = "<table><tr><td><img src='./img/ajax_loader.gif'></td><td>&nbsp;Cargando Funcionarios ......</td>";
	objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlListaFuncionariosDestinados.php",true);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionarios.send(encodeURI("codigoUnidad="+unidad+"&nombreBuscar="+nombreBuscar+"&campo="+campo+"&sentido="+sentido));
	objHttpXMLFuncionarios.onreadystatechange=function(){
		//alert(objHttpXMLFuncionarios.readyState);
		if(objHttpXMLFuncionarios.readyState == 4){
			//alert(objHttpXMLFuncionarios.responseText);
			if (objHttpXMLFuncionarios.responseText != "VACIO"){
				//alert(objHttpXMLFuncionarios.responseText);
				var xml 				= objHttpXMLFuncionarios.responseXML.documentElement;
				var codigo	 			= "";
				var apellidoPaterno		= "";
				var apellidoMaterno 	= "";
				var nombre2				= "";
				var nombre	 			= "";
				var nombreCompleto		= "";
				var grado		 		= "";
				var cargo		 		= "";
				var cuadrante			= "";
				var unidadAgregado		= "";
				var sw 				 	= 0;
				var fondoLinea		 	= "";
				var resaltarLinea 	 	= "";
				var lineaSinResaltar 	= "";
				var listadoFuncionarios	= "";
				
				listadoFuncionarios = "<table width='100%' cellspacing='1' cellpadding='1'>";
				//alert(xml.getElementsByTagName('funcionario').length);
				for(i=0;i<xml.getElementsByTagName('funcionario').length;i++){
					if (sw==0) {fondoLinea = "linea1";sw =1}
					else {fondoLinea = "linea2";sw=0}
					
					codigo	 		 = (xml.getElementsByTagName('codigo')[i].text||xml.getElementsByTagName('codigo')[i].textContent||"");
					apellidoPaterno  = (xml.getElementsByTagName('apellidoPaterno')[i].text||xml.getElementsByTagName('apellidoPaterno')[i].textContent||"");
					apellidoMaterno	 = (xml.getElementsByTagName('apellidoMaterno')[i].text||xml.getElementsByTagName('apellidoMaterno')[i].textContent||"");
					nombre			 = (xml.getElementsByTagName('nombre')[i].text||xml.getElementsByTagName('nombre')[i].textContent||"");
					nombre2			 = (xml.getElementsByTagName('nombre2')[i].text||xml.getElementsByTagName('nombre2')[i].textContent||"");
					nombreCompleto	 = (apellidoPaterno+" "+apellidoMaterno+", "+nombre+" "+nombre2);
					grado		 	 = (xml.getElementsByTagName('grado')[i].text||xml.getElementsByTagName('grado')[i].textContent||"");
					cargo		 	 =  (xml.getElementsByTagName('cargo')[i].text||xml.getElementsByTagName('cargo')[i].textContent||"");
					cuadrante		 = (xml.getElementsByTagName('cuadrante')[i].text||xml.getElementsByTagName('cuadrante')[i].textContent||"");
					unidadAgregado	 = (xml.getElementsByTagName('unidadAgregado')[i].text||xml.getElementsByTagName('unidadAgregado')[i].textContent||"");
					resaltarLinea 	 = "cambiarClase(this, 'lineaMarcada')";
					lineaSinResaltar = "cambiarClase(this, '"+fondoLinea+"')";

					var nroLinea = i + 1;
					var dblClick = "javascript:abrirVentana('FUNCIONARIO', '800', '400','fichaPersonal.php?codigoFuncionario="+codigo+"&subMenu=Destinados','"+nroLinea+"','','5','5')";
					
					if (cargo.length > 35) {
						var cargoMuestra = cargo.substr(0,33) + " ... ";
					} else {
						var cargoMuestra = cargo;
					}
					
					if (unidadAgregado != "") cargoMuestra += ", "+unidadAgregado;
					listadoFuncionarios += "<tr id='"+nroLinea+"' OnMouseOver=\""+resaltarLinea+"\" OnMouseOut=\""+lineaSinResaltar+"\" class='"+fondoLinea+"' onDblClick=\""+dblClick+"\">";
					listadoFuncionarios += "<td width='4%' align='center'><div id='valorColumna'>"+(i+1)+"</div></td>";
					listadoFuncionarios += "<td width='16%' align='center'><div id='valorColumna'>"+codigo+"</div></td>";
					listadoFuncionarios += "<td width='30%'><div id='valorColumna'>"+nombreCompleto+"</div></td>";
					listadoFuncionarios += "<td width='20%' align='left'><div id='valorColumna'>"+grado+"</div></td>";
					listadoFuncionarios += "<td width='30%' align='left'><div id='valorColumna'>"+cargoMuestra+"</div></td>";
					listadoFuncionarios += "</tr>";
					
				}
				listadoFuncionarios += "</table>";
				div.innerHTML = listadoFuncionarios;
				cargaListadoFuncionarios = 1;
			}
		}
	}
}

function cambiaOrdenLista(columna, atributo, sentido, unidad){
	var nuevoSentido = "";  
	if (sentido == "desc") nuevoSentido = "asc"; 
	if (sentido == "asc")  nuevoSentido = "desc";
	cambiarClase(columna,'nombreColumna_Click');

	if(document.getElementById("labColUnidad")!=null){
		leeFuncionariosA(unidad, atributo, sentido);
	}else{
		leeFuncionarios(unidad, atributo, sentido);
	}
	
	switch(atributo){
		case "grado": 
			document.getElementById("labColNombre").innerHTML = "NOMBRE";
			document.getElementById("labColCodigo").innerHTML = "CODIGO";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML = "SECCI\u00D3N";
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML = "CARGO";
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML = "GRUPO";
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML = "UNIDAD ORIGEN";
			}
			document.getElementById("labColGrado").innerHTML  = "GRADO&nbsp;<img src='./img/"+sentido+"_order.gif'>";
			document.getElementById("colGrado").onmousedown   = function(){cambiaOrdenLista(columna, atributo, nuevoSentido, unidad)};  
			break;
			
		case "nombre": 
			document.getElementById("labColGrado").innerHTML  = "GRADO";
			document.getElementById("labColCodigo").innerHTML = "CODIGO";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML = "SECCI\u00D3N";
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML = "CARGO";
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML = "GRUPO";
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML = "UNIDAD ORIGEN";
			}
			document.getElementById("labColNombre").innerHTML = "NOMBRE&nbsp;<img src='./img/"+sentido+"_order.gif'>";
			document.getElementById("colNombre").onmousedown  = function(){cambiaOrdenLista(columna, atributo, nuevoSentido, unidad)};  
			break;
			
		case "codigo":                                   
			document.getElementById("labColGrado").innerHTML  = "GRADO";
			document.getElementById("labColNombre").innerHTML = "NOMBRE";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML = "SECCI\u00D3N";
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML = "CARGO";
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML = "GRUPO";
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML = "UNIDAD ORIGEN";
			}
			document.getElementById("labColCodigo").innerHTML = "CODIGO&nbsp;<img src='./img/"+sentido+"_order.gif'>";
			document.getElementById("colCodigo").onmousedown  = function(){cambiaOrdenLista(columna, atributo, nuevoSentido, unidad)};  
			break;
		
		case "cargo":                                   
			document.getElementById("labColGrado").innerHTML  = "GRADO";
			document.getElementById("labColNombre").innerHTML = "NOMBRE";
			document.getElementById("labColCodigo").innerHTML = "CODIGO";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML = "SECCI\u00D3N";
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML  = "CARGO&nbsp;<img src='./img/"+sentido+"_order.gif'>";
				document.getElementById("colCargo").onmousedown   = function(){cambiaOrdenLista(columna, atributo, nuevoSentido, unidad)};			
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML = "GRUPO";
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML = "UNIDAD ORIGEN";
			}
			break;
			
		case "seccion":
			document.getElementById("labColGrado").innerHTML  = "GRADO";
			document.getElementById("labColNombre").innerHTML = "NOMBRE";
			document.getElementById("labColCodigo").innerHTML = "CODIGO";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML  = "SECCI\u00D3N&nbsp;<img src='./img/"+sentido+"_order.gif'>";
				document.getElementById("colSeccion").onmousedown   = function(){cambiaOrdenLista(columna, atributo, nuevoSentido, unidad)}; 
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML = "CARGO";
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML = "GRUPO";
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML = "UNIDAD ORIGEN";
			}
			break;
			
		case "unidad":
			document.getElementById("labColGrado").innerHTML  = "GRADO";
			document.getElementById("labColNombre").innerHTML = "NOMBRE";
			document.getElementById("labColCodigo").innerHTML = "CODIGO";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML = "SECCI\u00D3N";
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML = "CARGO";
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML = "GRUPO";
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML  = "UNIDAD ORIGEN&nbsp;<img src='./img/"+sentido+"_order.gif'>";
				document.getElementById("colUnidad").onmousedown   = function(){cambiaOrdenLista(columna, atributo, nuevoSentido, unidad)};		
			}
			break;
			
		case "grupo":
			document.getElementById("labColGrado").innerHTML  = "GRADO";
			document.getElementById("labColNombre").innerHTML = "NOMBRE";
			document.getElementById("labColCodigo").innerHTML = "CODIGO";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML = "SECCI\u00D3N";
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML = "CARGO";
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML  = "GRUPO&nbsp;<img src='./img/"+sentido+"_order.gif'>";
				document.getElementById("colGrupo").onmousedown   = function(){cambiaOrdenLista(columna, atributo, nuevoSentido, unidad)};		
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML = "UNIDAD ORIGEN";
			}
			break;
	}
	idCargaListadoFuncionarios = setInterval("tituloColumnaNormal("+columna.id+")",500);	
}

function cambiaOrdenListaD(columna, atributo, sentido, unidad){
	var nuevoSentido = "";  
	if (sentido == "desc") nuevoSentido = "asc"; 
	if (sentido == "asc")  nuevoSentido = "desc";
	cambiarClase(columna,'nombreColumna_Click');

		if(document.getElementById("labColUnidad")!=null){
		leeFuncionariosD(unidad, atributo, sentido);
	}else{
	 leeFuncionarios(unidad, atributo, sentido);
	}
	
	switch(atributo){
		case "grado": 
			document.getElementById("labColNombre").innerHTML = "NOMBRE";
			document.getElementById("labColCodigo").innerHTML = "CODIGO";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML = "SECCI\u00D3N";
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML = "CARGO";
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML = "GRUPO";
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML = "UNIDAD ORIGEN";
			}
			document.getElementById("labColGrado").innerHTML  = "GRADO&nbsp;<img src='./img/"+sentido+"_order.gif'>";
			document.getElementById("colGrado").onmousedown   = function(){cambiaOrdenListaD(columna, atributo, nuevoSentido, unidad)};  
			break;
			
		case "nombre": 
			document.getElementById("labColGrado").innerHTML  = "GRADO";
			document.getElementById("labColCodigo").innerHTML = "CODIGO";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML = "SECCI\u00D3N";
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML = "CARGO";
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML = "GRUPO";
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML = "UNIDAD ORIGEN";
			}
			document.getElementById("labColNombre").innerHTML = "NOMBRE&nbsp;<img src='./img/"+sentido+"_order.gif'>";
			document.getElementById("colNombre").onmousedown  = function(){cambiaOrdenListaD(columna, atributo, nuevoSentido, unidad)};  
			break;
			
		case "codigo":                                   
			document.getElementById("labColGrado").innerHTML  = "GRADO";
			document.getElementById("labColNombre").innerHTML = "NOMBRE";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML = "SECCI\u00D3N";
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML = "CARGO";
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML = "GRUPO";
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML = "UNIDAD ORIGEN";
			}
			document.getElementById("labColCodigo").innerHTML = "CODIGO&nbsp;<img src='./img/"+sentido+"_order.gif'>";
			document.getElementById("colCodigo").onmousedown  = function(){cambiaOrdenListaD(columna, atributo, nuevoSentido, unidad)};  
			break;
		
		case "cargo":                                   
			document.getElementById("labColGrado").innerHTML  = "GRADO";
			document.getElementById("labColNombre").innerHTML = "NOMBRE";
			document.getElementById("labColCodigo").innerHTML = "CODIGO";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML = "SECCI\u00D3N";
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML  = "CARGO&nbsp;<img src='./img/"+sentido+"_order.gif'>";
				document.getElementById("colCargo").onmousedown   = function(){cambiaOrdenListaD(columna, atributo, nuevoSentido, unidad)};			
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML = "GRUPO";
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML = "UNIDAD ORIGEN";
			}
			break;
			
		case "seccion":
			document.getElementById("labColGrado").innerHTML  = "GRADO";
			document.getElementById("labColNombre").innerHTML = "NOMBRE";
			document.getElementById("labColCodigo").innerHTML = "CODIGO";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML  = "SECCI\u00D3N&nbsp;<img src='./img/"+sentido+"_order.gif'>";
				document.getElementById("colSeccion").onmousedown   = function(){cambiaOrdenListaD(columna, atributo, nuevoSentido, unidad)}; 
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML = "CARGO";
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML = "GRUPO";
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML = "UNIDAD ORIGEN";
			}
			break;
			
		case "unidad":
			document.getElementById("labColGrado").innerHTML  = "GRADO";
			document.getElementById("labColNombre").innerHTML = "NOMBRE";
			document.getElementById("labColCodigo").innerHTML = "CODIGO";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML = "SECCI\u00D3N";
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML = "CARGO";
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML = "GRUPO";
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML  = "UNIDAD ORIGEN&nbsp;<img src='./img/"+sentido+"_order.gif'>";
				document.getElementById("colUnidad").onmousedown   = function(){cambiaOrdenListaD(columna, atributo, nuevoSentido, unidad)};		
			}
			break;
			
		case "grupo":
			document.getElementById("labColGrado").innerHTML  = "GRADO";
			document.getElementById("labColNombre").innerHTML = "NOMBRE";
			document.getElementById("labColCodigo").innerHTML = "CODIGO";
			if(document.getElementById("labColSeccion")!=null){
				document.getElementById("labColSeccion").innerHTML = "SECCI\u00D3N";
			}
			if(document.getElementById("labColCargo")!=null){
				document.getElementById("labColCargo").innerHTML = "CARGO";
			}
			if(document.getElementById("labColGrupo")!=null){
				document.getElementById("labColGrupo").innerHTML  = "GRUPO&nbsp;<img src='./img/"+sentido+"_order.gif'>";
				document.getElementById("colGrupo").onmousedown   = function(){cambiaOrdenListaD(columna, atributo, nuevoSentido, unidad)};		
			}
			if(document.getElementById("labColUnidad")!=null){
				document.getElementById("labColUnidad").innerHTML = "UNIDAD ORIGEN";
			}
			break;
	}
	idCargaListadoFuncionarios = setInterval("tituloColumnaNormal("+columna.id+")",500);	
}

function tituloColumnaNormal(columna){
	if (cargaListadoFuncionarios == 1){
		clearInterval(idCargaListadoFuncionarios);
		cambiarClase(columna,'nombreColumna');
	}		
}

function listaFuncionarios(unidad, nombreObjeto, multiple, campo, sentido){
	var tipoUnidadNew = document.getElementById("tipoUnidadNew").value;
	var especialidadUnidadNew = document.getElementById("especialidadUnidadNew").value;
	cargaListadoFuncionarios = 0;
	
	document.getElementById(nombreObjeto).length = null;
	if (multiple == false ){
		var datosOpcion = new Option("SELECCIONE FUNCIONARIO ... ", 0, "", "");
		document.getElementById(nombreObjeto).options[0] = datosOpcion;
	}
	
	var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlListaFuncionariosConsulta.php",true);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionarios.send(encodeURI("codigoUnidad="+unidad+"&campo="+campo+"&sentido="+sentido+"&tipoUnidadNew="+tipoUnidadNew+"&especialidadUnidadNew="+especialidadUnidadNew));
	objHttpXMLFuncionarios.onreadystatechange=function(){
		//alert(objHttpXMLFuncionarios.readyState);
		if(objHttpXMLFuncionarios.readyState == 4){
			//console.log(objHttpXMLFuncionarios.responseText);
			if(objHttpXMLFuncionarios.responseText != "VACIO"){
				//alert(objHttpXMLFuncionarios.responseText);
				var xml 			= objHttpXMLFuncionarios.responseXML.documentElement;
				var codigo	 		= "";
				var apellidoPaterno	= "";
				var apellidoMaterno =	"";
				var nombre2			= "";
				var nombre	 		= "";
				var nombreCompleto	= "";
				var grado		 	= "";
				var cargo		 	= "";
				var sw 				= 0;

				//alert(xml.getElementsByTagName('funcionario').length);
				for(i=0;i<xml.getElementsByTagName('funcionario').length;i++){
					if (sw==0) {fondoLinea = "linea1";sw =1}
					else {fondoLinea = "linea2";sw=0}
					
					codigo	 		= (xml.getElementsByTagName('codigo')[i].text||xml.getElementsByTagName('codigo')[i].textContent||"");
					apellidoPaterno = (xml.getElementsByTagName('apellidoPaterno')[i].text||xml.getElementsByTagName('apellidoPaterno')[i].textContent||"");
					apellidoMaterno	= (xml.getElementsByTagName('apellidoMaterno')[i].text||xml.getElementsByTagName('apellidoMaterno')[i].textContent||"");
					nombre			= (xml.getElementsByTagName('nombre')[i].text||xml.getElementsByTagName('nombre')[i].textContent||"");
					nombre2			= (xml.getElementsByTagName('nombre2')[i].text||xml.getElementsByTagName('nombre2')[i].textContent||"");
					nombreCompleto	= (apellidoPaterno+" "+apellidoMaterno+", "+nombre+" "+nombre2);
					grado		 	= (xml.getElementsByTagName('grado')[i].text||xml.getElementsByTagName('grado')[i].textContent||"");
					cargo		 	= (xml.getElementsByTagName('cargo')[i].text||xml.getElementsByTagName('cargo')[i].textContent||"");
					
					var descripcion = nombreCompleto + " ("+grado+")";
					var puntero;
					if (!multiple) puntero = i+1;
					else puntero = i;
					
					var datosOpcion = new Option(descripcion, codigo, "", "");
					document.getElementById(nombreObjeto).options[puntero] = datosOpcion;
				}
				cargaListadoFuncionarios = 1;
			}
		}
	}
}

function buscaDatosFuncionario(){
	
	var codigoFuncionario	= eliminarBlancos(document.getElementById("textCodigoFuncionario").value.toUpperCase());
	
	if (codigoFuncionario == ""){
		alert("DEBE INDICAR EL CODIGO DE FUNCIONARIO ...... 	     ");
		document.getElementById("textCodigoFuncionario").value="";
		document.getElementById("textCodigoFuncionario").focus();
		return false;
	}
	
	var regExCodigoFun = /^[0-9]{6,6}[A-Z]{1,1}$/;
	var codigoValido = codigoFuncionario.match(regExCodigoFun);
	
	if (!codigoValido){
		alert("EL CODIGO DE FUNCIONARIO INGRESADO NO TIENE UNA ESTRUCTURA VALIDA...... 	     ");
		document.getElementById("textCodigoFuncionario").focus();
		return false;
	}
	
	document.getElementById("btnBuscar").value = "BUSCANDO ...";
	document.getElementById("btnBuscar").disabled = "true";
	leedatosFuncionario(codigoFuncionario, 1);
}

function buscaDatosFuncionario2(){
	var codigoFuncionario	= eliminarBlancos(document.getElementById("textCodigoFuncionario").value);
	if (codigoFuncionario != "") leedatosFuncionario(codigoFuncionario, 1);
}

var idAsignaCategoriaCargoFichaPersonal;
var idAsignaCategoriaTipoCargoFichaPersonal;
var idAsignaCargoFichaPersonal;
var idAsignaGradoFichaPersonal;
var idAsignaFichaPersonal;
function leedatosFuncionario(codigoFuncionario, tipo){
	document.getElementById("mensajeCargando").style.display = "";
	document.getElementById("mensajeCargando").style.left = "100px";
	document.getElementById("mensajeCargando").style.top  = "120px";
	var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlDatosFuncionario.php",true);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionarios.send(encodeURI("codigoFuncionario="+codigoFuncionario));
	objHttpXMLFuncionarios.onreadystatechange=function(){
		//alert(objHttpXMLFuncionarios.readyState);
		if(objHttpXMLFuncionarios.readyState == 4){
			//console.log(objHttpXMLFuncionarios.responseText);
			if (objHttpXMLFuncionarios.responseText != "VACIO"){
				//alert(objHttpXMLFuncionarios.responseText);
				var xml 				  	= objHttpXMLFuncionarios.responseXML.documentElement;
				var codigo	 			  	= "";
				var apellidoPaterno		  	= "";
				var apellidoMaterno		  	= "";
				var primerNombre	 	  	= "";
				var segundoNombre	 	  	= "";
				var escalafon	 		  	= "";
				var grado		 		  	= "";
				var cargo		 		  	= "";
				var desCargo			  	= "";
				var categoriaCargo			= "";
				var cuadranteCargo		  	= "";
				var unidadFuncionario	  	= "";
				var unidadUsuario		  	= "";
				var descUnidadFuncionario 	= "";
				var cargoFechaDesde		  	= "";
				var codigoUnidadAgregado  	= "";
				var desUnidadAgregado  	  	= "";
				var dias  	              	= "";
				var seccion  	          	= "";
				var desSeccion 	          	= "";
				var rut 					= "";
				
				for(i=0;i<xml.getElementsByTagName('funcionario').length;i++){
					codigo	 		  		= (xml.getElementsByTagName('codigo')[i].text||xml.getElementsByTagName('codigo')[i].textContent||"");
					apellidoPaterno	  		= (xml.getElementsByTagName('apellidoPaterno')[i].text||xml.getElementsByTagName('apellidoPaterno')[i].textContent||"");
					apellidoMaterno   		= (xml.getElementsByTagName('apellidoMaterno')[i].text||xml.getElementsByTagName('apellidoMaterno')[i].textContent||"");
					primerNombre 	  		= (xml.getElementsByTagName('nombre')[i].text||xml.getElementsByTagName('nombre')[i].textContent||"");
					segundoNombre 	  		= (xml.getElementsByTagName('nombre2')[i].text||xml.getElementsByTagName('nombre2')[i].textContent||"");
					escalafon		  		= (xml.getElementsByTagName('codigoEscalafon')[i].text||xml.getElementsByTagName('codigoEscalafon')[i].textContent||"");
					grado		 	  		= (xml.getElementsByTagName('codigoGrado')[i].text||xml.getElementsByTagName('codigoGrado')[i].textContent||"");
					cargo		 	  		= (xml.getElementsByTagName('codigoCargo')[i].text||xml.getElementsByTagName('codigoCargo')[i].textContent||"");
					desCargo				= (xml.getElementsByTagName('cargo')[i].text||xml.getElementsByTagName('cargo')[i].textContent||"");
					categoriaCargo			= (xml.getElementsByTagName('categoriaCargo')[i].text||xml.getElementsByTagName('categoriaCargo')[i].textContent||"");
					cuadranteCargo		 	= (xml.getElementsByTagName('codigoCuadranteCargo')[i].text||xml.getElementsByTagName('codigoCuadranteCargo')[i].textContent||"");
					unidadFuncionario 		= (xml.getElementsByTagName('codigoUnidad')[i].text||xml.getElementsByTagName('codigoUnidad')[i].textContent||"");
					descUnidadFuncionario	= (xml.getElementsByTagName('unidad')[i].text||xml.getElementsByTagName('unidad')[i].textContent||"");
					cargoFechaDesde 		= (xml.getElementsByTagName('fechaCargo')[i].text||xml.getElementsByTagName('fechaCargo')[i].textContent||"");
					codigoUnidadAgregado 	= (xml.getElementsByTagName('codigoUnidadAgregado')[i].text||xml.getElementsByTagName('codigoUnidadAgregado')[i].textContent||"");
					desUnidadAgregado 		= (xml.getElementsByTagName('unidadAgregado')[i].text||xml.getElementsByTagName('unidadAgregado')[i].textContent||"");
					dias 	            	= null;
					unidadUsuario 			= document.getElementById("unidadUsuario").value;
					seccion 		        = (xml.getElementsByTagName('codigoSeccion')[i].text||xml.getElementsByTagName('codigoSeccion')[i].textContent||"");
					desSeccion 		        = (xml.getElementsByTagName('seccion')[i].text||xml.getElementsByTagName('seccion')[i].textContent||"");
					rut	 		  		    = (xml.getElementsByTagName('rut')[i].text||xml.getElementsByTagName('rut')[i].textContent||"");
					
					if (cuadranteCargo == "") cuadranteCargo = 0;
					if (cargo == "" || cargo == 3500) cargo = 0;
					if (seccion == "") seccion = 0;
					
					document.getElementById("fotoFuncionario").src 				= "./img/sinFoto.png"; /*"http://fototipcar.carabineros.cl/"+codigo+".jpg";*/
					document.getElementById("idFuncionario").value				= codigo;
					document.getElementById("textCodigoFuncionario").value		= codigo;
					document.getElementById("textApellidoPaterno").value 		= apellidoPaterno;
					document.getElementById("textApellidoMaterno").value 		= apellidoMaterno;
					document.getElementById("textPrimerNombre").value 	 		= primerNombre;
					document.getElementById("textSegundoNombre").value 	 		= segundoNombre;
					document.getElementById("codigoUnidadAgregado").value 		= codigoUnidadAgregado;
					document.getElementById("textUnidadAgregado").value 	 	= desUnidadAgregado;
					document.getElementById("codUnidadAgregadoBaseDatos").value = codigoUnidadAgregado;
					document.getElementById("desUnidadAgregadoBaseDatos").value = desUnidadAgregado;
					document.getElementById("codCuadranteBaseDatos").value 		= cuadranteCargo;
					document.getElementById("gradoBaseDatos").value 			= grado;
					document.getElementById("escalafonBaseDatos").value 		= escalafon;
					
					document.getElementById("textRutFuncionario").value	= rut;
					//document.getElementById("subMenu").value = "Dotacion";
					
					if(document.body.contains(document.getElementById("contieneHijos")))	document.getElementById("seccionBaseDatos").value	= seccion;
					if (tipo == 0) {
						document.getElementById("ultimaFecha").value = cargoFechaDesde;
						if (cargoFechaDesde != "--") var muestraFechaCargo = cargoFechaDesde;
						else var muestraFechaCargo = "NO REGISTRA CARGOS EN EL SISTEMA";
						document.getElementById("labFechaCargoDesde").innerHTML = "FECHA DESDE QUE REGISTRA CARGO ACTUAL : " + muestraFechaCargo;
					} else {
						document.getElementById("ultimaFecha").value = cargoFechaDesde;
						if (cargoFechaDesde != "--") var muestraFechaCargo = cargoFechaDesde + " ("+desCargo+")";
						else var muestraFechaCargo = "NO REGISTRA CARGOS EN EL SISTEMA";
						document.getElementById("labFechaCargoDesde").innerHTML = "FECHA DESDE QUE REGISTRA \u00DALTIMO MOVIMIENTO : " + muestraFechaCargo;
					}
					
					if (unidadFuncionario == "") var habilitarBotones = false;
					else var habilitarBotones = true;
					
					var valoresAsignar = "'"+escalafon+"','" + grado + "','" + cargo + "','" + categoriaCargo + "','" + desUnidadAgregado + "'," + habilitarBotones +",'"+cuadranteCargo+"','"+dias+"','"+seccion+"',"+tipo;
					idAsignaFichaPersonal = setInterval("asignaValoresFichaFuncionario("+valoresAsignar+")",1000);
					
					if (tipo == "1"){
						document.getElementById("btnBuscar").value = "BUSCAR";
						document.getElementById("btnBuscar").disabled = "";
						document.getElementById('btnGuardar').disabled = "";
						
						if (unidadUsuario == unidadFuncionario){
							alert("ESTE FUNCIONARIO YA PERTENECE A ESTA UNIDAD ...          ");
							cerrarVentanaFicha();
						}
						
						if (unidadUsuario != unidadFuncionario && unidadFuncionario != ""){
							alert("NO PUEDE AGREGAR A ESTE FUNCIONARIO,\nYA QUE PERTENECE A LA " +descUnidadFuncionario+ ", Y A\u00DAN NO HA SIDO DESPACHADO ... ");
							cerrarVentanaFicha();
						} 
					}
				}
			} else {
				buscaFuncionarioPersonal(codigoFuncionario);
				document.getElementById("mensajeCargando").style.display = "none";
				document.getElementById("btnBuscar").value = "BUSCAR";
				document.getElementById('btnBuscar').disabled = "";
			}
		}
	}
}

function llenaGradoFichaPersonal(grado){
	if (cargaGrados == 1) {
		clearInterval(idAsignaGradoFichaPersonal);
		document.getElementById("selGrado").value = grado;
		document.getElementById('btnCerrarFicha').disabled = "";
		document.getElementById("mensajeCargando").style.display = "none";
		activarBotones();
	}
}

function llenaCargoFichaPersonal(cargo){
	clearInterval(idAsignaCategoriaCargoFichaPersonal);
	document.getElementById("selCargo").value = cargo;
}

function asignaValoresFichaFuncionario(escalafon, grado, cargo, categoriaCargo, desUnidadAgregado, habilitarBotones, cuadranteCargo, dias, seccion, tipo){
	if(cargaEscalafon == 1){
		clearInterval(idAsignaFichaPersonal);
		leeCategoriaCargos('selCategoriaCargo',escalafon,grado);
		if(tipo == 0){
			idAsignaTipoGradoFichaPersonal = setInterval(() => {clearInterval(idAsignaTipoGradoFichaPersonal);
																document.getElementById("selCategoriaCargo").value = categoriaCargo;},1000);
			document.getElementById("cargoBaseDatos").value = cargo;
			document.getElementById("selCuadrante").value = cuadranteCargo;
			if(document.getElementById('contieneHijos') !== null){
				document.getElementById("selSeccion").value = seccion;
				document.getElementById("seccionBaseDatos").value = seccion;
			}
		}
		document.getElementById("selEscalafon").value = escalafon;
		leeGrados('selGrado', escalafon, document.getElementById("selEscalafon")[document.getElementById("selEscalafon").selectedIndex].text);
		document.getElementById("selCargo").disabled = "";
		idAsignaGradoFichaPersonal = setInterval("llenaGradoFichaPersonal("+grado+")",1000);
		leeCargos('selCargo',categoriaCargo,escalafon,grado);
		document.getElementById("selCargo").value = cargo;
		idAsignaCategoriaCargoFichaPersonal = setInterval("llenaCargoFichaPersonal("+cargo+")",1000);
		activaFechaNuevoCargo();
	}
}

function buscaFuncionarioPersonal(codigoFuncionario){
	var objHttpXMLFuncionario = new AJAXCrearObjeto();
	objHttpXMLFuncionario.open("POST","./xml/xmlFuncionarios/xmlBuscaFuncionario.php",true);
	objHttpXMLFuncionario.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionario.send(encodeURI("codigoFuncionario="+codigoFuncionario));
	objHttpXMLFuncionario.onreadystatechange=function(){
		if(objHttpXMLFuncionario.readyState == 4){
			//console.log(objHttpXMLFuncionario.responseText);
			if (objHttpXMLFuncionario.responseText != "VACIO"){
				//alert(objHttpXMLFuncionario.responseText);
				var xml 				= objHttpXMLFuncionario.responseXML.documentElement;
				var codigo	 			= "";
				var rut				 	= "";
				var apellidoPaterno		= "";
				var apellidoMaterno		= "";
				var primerNombre	 	= "";
				var segundoNombre	 	= "";
				var escalafon	 		= "";
				var grado		 		= "";
				
				for(i=0;i<xml.getElementsByTagName('funcionario').length;i++){
					rut	 		 	= (xml.getElementsByTagName('rut')[i].text||xml.getElementsByTagName('rut')[i].textContent||"");
					codigo	 		= (xml.getElementsByTagName('codigo')[i].text||xml.getElementsByTagName('codigo')[i].textContent||"");
					apellidoPaterno	= (xml.getElementsByTagName('apellidoPaterno')[i].text||xml.getElementsByTagName('apellidoPaterno')[i].textContent||"");
					apellidoMaterno	= (xml.getElementsByTagName('apellidoMaterno')[i].text||xml.getElementsByTagName('apellidoMaterno')[i].textContent||"");
					primerNombre	= (xml.getElementsByTagName('nombre')[i].text||xml.getElementsByTagName('nombre')[i].textContent||"");
					segundoNombre	= (xml.getElementsByTagName('nombre2')[i].text||xml.getElementsByTagName('nombre2')[i].textContent||"");
					escalafon	 	= (xml.getElementsByTagName('codigoEscalafon')[i].text||xml.getElementsByTagName('codigoEscalafon')[i].textContent||"");
					grado	 		= (xml.getElementsByTagName('codigoGrado')[i].text||xml.getElementsByTagName('codigoGrado')[i].textContent||"");
					
					document.getElementById("fotoFuncionario").src = "./img/sinFoto.png"; /*"http://fototipcar.carabineros.cl/fototipcar/"+codigo+".jpg"; */
					document.getElementById("textCodigoFuncionario").value	= codigo;
					document.getElementById("textRutFuncionario").value		= rut;
					document.getElementById("textApellidoPaterno").value 	= apellidoPaterno;
					document.getElementById("textApellidoMaterno").value 	= apellidoMaterno;
					document.getElementById("textPrimerNombre").value 	 	= primerNombre;
					document.getElementById("textSegundoNombre").value 	 	= segundoNombre;
					
					//var valoresAsignar = "'"+escalafon+"','" + grado + "','',false,'',1,'',1";
					document.getElementById('btnGuardar').disabled = "";
					var valoresAsignar = "'"+escalafon+"','" + grado + "','','','',true,'','','',";
					idAsignaFichaPersonal = setInterval("asignaValoresFichaFuncionario("+valoresAsignar+")",1000);
					return true;
				}
			} else {
				alert("FUNCIONARIO NO ENCONTRADO EN LA BASE DE DATOS.");
				cerrarVentanaFicha();
				return false;
			}
		} 
	}
}

function actualizarFuncionario(){
	
	var codigoFuncionario		= document.getElementById("textCodigoFuncionario").value.toUpperCase();
	var codigoEscalafon 		= document.getElementById("selEscalafon").value;
	var codigoGrado				= document.getElementById("selGrado").value;
	var codigoCargo				= document.getElementById("selCargo").value;
	var codigoCuadrante			= document.getElementById("selCuadrante").value;
	var codigoUnidadAgregado	= document.getElementById("codigoUnidadAgregado").value;
	var unidadUsuario			= document.getElementById("unidadUsuario").value;
	var fechaCargo				= document.getElementById("textFechaUltimoCargo").value;
	
	if(document.getElementById('contieneHijos').value != 0){
		var seccion	= document.getElementById("selSeccion").value;
	}
	else{
		var seccion	= null;
	}
	
	if(codigoUnidadAgregado!='') eliminarUsuario(codigoFuncionario);
  	var dias = null;
	var parametros = "";
	parametros += "codigoFuncionario="+codigoFuncionario+"&codigoEscalafon="+codigoEscalafon+"&codigoGrado="+codigoGrado;
	parametros += "&codigoCargo="+codigoCargo+"&unidadUsuario="+unidadUsuario+"&fechaCargo="+fechaCargo+"&codigoCuadrante="+codigoCuadrante;
	parametros += "&codigoUnidadAgregado="+codigoUnidadAgregado+"&seccion="+seccion+"&dias="+dias;
	//console.log(parametros);
	var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlActualizaFuncionario.php",true);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionarios.send(encodeURI(parametros));
	objHttpXMLFuncionarios.onreadystatechange=function(){
		if(objHttpXMLFuncionarios.readyState == 4){     
			//console.log(objHttpXMLFuncionarios.responseText);  
			if(objHttpXMLFuncionarios.responseText != "VACIO"){
				var xml = objHttpXMLFuncionarios.responseXML.documentElement;
				for(i=0;i<xml.getElementsByTagName('resultado').length;i++){
					var codigo = (xml.getElementsByTagName('resultado')[i].text||xml.getElementsByTagName('resultado')[i].textContent||"");
					if (codigo == 1){
						alert('SE REALIZO EL CAMBIO EXITOSAMENTE EN EL SISTEMA ......        ');
						top.leeFuncionarios(unidadUsuario,'','');
						idCargaListadoFuncionarios = setInterval("cerrarVentanaFicha()",1000);
					}
					else alert('OCURRIO UN PROBLEMA AL REALIZAR EL CAMBIO ....		\nCODIGO RECIBIDO : ' + codigo);
				}
			}
		}
	}
}

function actualizarFuncionarioPaso(){
	
	var codigoFuncionario		= document.getElementById("textCodigoFuncionario").value.toUpperCase();
	var codigoEscalafon 		= document.getElementById("selEscalafon").value;
	var codigoGrado				= document.getElementById("selGrado").value;
	var apellidoPaterno			= document.getElementById("textApellidoPaterno").value.toUpperCase();
	var apellidoMaterno			= document.getElementById("textApellidoMaterno").value.toUpperCase();
	var primerNombre			= document.getElementById("textPrimerNombre").value.toUpperCase();
	var segundoNombre			= document.getElementById("textSegundoNombre").value.toUpperCase();
	var codigoCargo				= document.getElementById("selCargo").value;
	var codigoCuadrante			= document.getElementById("selCuadrante").value;
	var codigoUnidadAgregado	= document.getElementById("codigoUnidadAgregado").value;
	var unidadUsuario			= document.getElementById("unidadUsuario").value;
	var fechaCargo				= document.getElementById("textFechaUltimoCargo").value;
	
	if(document.getElementById('contieneHijos') !== null){
  		var seccion				= document.getElementById("selSeccion").value;
  	}
  	else{
  		var seccion				= 0;
  	}
	var parametros = "";
	parametros += "codigoFuncionario="+codigoFuncionario+"&codigoEscalafon="+codigoEscalafon+"&codigoGrado="+codigoGrado;
	parametros += "&apellidoPaterno="+apellidoPaterno+"&apellidoMaterno="+apellidoMaterno+"&primerNombre="+primerNombre;
	parametros += "&segundoNombre="+segundoNombre+"&codigoCargo="+codigoCargo+"&unidadUsuario="+unidadUsuario+"&fechaCargo="+fechaCargo;
	parametros += "&codigoCuadrante="+codigoCuadrante+"&codigoUnidadAgregado="+codigoUnidadAgregado+"&seccion="+seccion;
	//alert(parametros);
	var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlActualizaFuncionarioPaso.php",true);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionarios.send(encodeURI(parametros));
	objHttpXMLFuncionarios.onreadystatechange=function(){
		if(objHttpXMLFuncionarios.readyState == 4){ 
			if (objHttpXMLFuncionarios.responseText != "VACIO"){
				//alert(objHttpXMLFuncionarios.responseText);
				var xml = objHttpXMLFuncionarios.responseXML.documentElement;
				for(i=0;i<xml.getElementsByTagName('resultado').length;i++){
					var codigo = (xml.getElementsByTagName('resultado')[i].text||xml.getElementsByTagName('resultado')[i].textContent||"");
					if (codigo == 1){
						//alert('LOS DATOS FUERON INGRESADOS CON EXITO A LA BASE DE DATOS ......        ');
						top.leeFuncionarios(unidadUsuario,'','');
						idCargaListadoFuncionarios = setInterval("cerrarVentanaFicha()",1000);
					}
					else alert('LOS DATOS NO FUERON INGRESADOS A LA BASE DE DATOS ....		\nCODIGO RECIBIDO : ' + codigo)
				}
			}
		}
	}
}

function nuevoFuncionario(){

	var codigoFuncionario	= document.getElementById("textCodigoFuncionario").value.toUpperCase();
	var codigoEscalafon 	= document.getElementById("selEscalafon").value;
	var codigoGrado			= document.getElementById("selGrado").value;
	var apellidoPaterno		= document.getElementById("textApellidoPaterno").value.toUpperCase();
	var apellidoMaterno		= document.getElementById("textApellidoMaterno").value.toUpperCase();
	var primerNombre		= document.getElementById("textPrimerNombre").value.toUpperCase();
	var segundoNombre		= document.getElementById("textSegundoNombre").value.toUpperCase();
	var codigoCargo			= document.getElementById("selCargo").value;
	var codigoCuadrante		= document.getElementById("selCuadrante").value;
	var unidadUsuario		= document.getElementById("unidadUsuario").value;
	var fechaCargo			= document.getElementById("textFechaUltimoCargo").value;
  	var rutFuncionario 		= document.getElementById("textRutFuncionario").value;
	var dias				= null;

  	if(document.getElementById("contieneHijos") !== null){  
  		var seccion	= document.getElementById("selSeccion").value;
	}
	else {
		var seccion	= 0;
	}
	
	var parametros = "";
	parametros += "codigoFuncionario="+codigoFuncionario+"&codigoEscalafon="+codigoEscalafon+"&codigoGrado="+codigoGrado;
	parametros += "&apellidoPaterno="+apellidoPaterno+"&apellidoMaterno="+apellidoMaterno+"&primerNombre="+primerNombre;
	parametros += "&segundoNombre="+segundoNombre+"&codigoCargo="+codigoCargo+"&unidadUsuario="+unidadUsuario+"&fechaCargo="+fechaCargo;
	parametros += "&codigoCuadrante="+codigoCuadrante+"&dias="+dias+"&rutFuncionario="+rutFuncionario+"&seccion="+seccion;
	
	var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlNuevoFuncionario.php",true);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionarios.send(encodeURI(parametros));
	objHttpXMLFuncionarios.onreadystatechange=function(){
		if(objHttpXMLFuncionarios.readyState == 4){
			if (objHttpXMLFuncionarios.responseText != "VACIO"){
				//alert(objHttpXMLFuncionarios.responseText);
				var xml = objHttpXMLFuncionarios.responseXML.documentElement;
				for(i=0;i<xml.getElementsByTagName('resultado').length;i++){
					var codigo = (xml.getElementsByTagName('resultado')[i].text||xml.getElementsByTagName('resultado')[i].textContent||"");
					if (codigo == 1){
						 alert('LOS DATOS FUERON INGRESADOS CON EXITO A LA BASE DE DATOS ......        ');
						 top.leeFuncionarios(unidadUsuario, '', '');
						 idCargaListadoFuncionarios = setInterval("cerrarVentanaFicha()",1000);
					}
					else alert('LOS DATOS NO FUERON INGRESADOS A LA BASE DE DATOS ....		\nCODIGO RECIBIDO : ' + codigo);
				}
			}
		}
	}
}

function validarFichaFuncionario(){
	var codigoFuncionario		= eliminarBlancos(document.getElementById("textCodigoFuncionario").value.toUpperCase());
	var codigoEscalafon 		= document.getElementById("selEscalafon").value;
	var codigoGrado				= document.getElementById("selGrado").value;
	var codigoCargo				= document.getElementById("selCargo").value;
	var codigoCuadrante			= document.getElementById("selCuadrante").value;
	var codigoCuadranteActual	= document.getElementById("codCuadranteBaseDatos").value;
	var fechaCargo				= document.getElementById("textFechaUltimoCargo").value;
	var ultimaFechaCargo		= document.getElementById("ultimaFecha").value;
	var codigoUnidadAgregado 	= document.getElementById("codigoUnidadAgregado").value;
	var fechaLimite 			= top.document.getElementById("textFechaLimite").value;
	var unidadBloqueada			= top.document.getElementById("textUnidadBloqueada").value;
	var codigoCargoActual	 	= document.getElementById("cargoBaseDatos").value
	var diferencia 				= restaFechas(ultimaFechaCargo,fechaCargo);
	var codigoGradoActual	 	= document.getElementById("gradoBaseDatos").value
	var codigoEscalafonActual	= document.getElementById("escalafonBaseDatos").value
	
	if(document.getElementById("contieneHijos").value==1){
		var seccion			= document.getElementById("selSeccion").value;
		var contieneHijos	= document.getElementById("contieneHijos").value;
	}
	else {
		var seccion			= 0;
		var contieneHijos	= 0;
	}
	
	if(codigoCargoActual==9200){
		if(diferencia != 0){
			alert("LA FECHA PARA REGULARIZAR EL NUEVO CARGO DEBE SER EL MISMO D\u00CDA DE LA FECHA DE INGRESO DEL \u00DALTIMO CARGO: "+ultimaFechaCargo);
			document.getElementById("selCargo").focus();
			return false;
		}
	}
	
	if (codigoFuncionario == ""){
		alert("DEBE INDICAR EL CODIGO DE FUNCIONARIO ...... 	     ");
		document.getElementById("textCodigoFuncionario").focus();
		return false;
	}
	
	var regExCodigoFun = /^[0-9]{6,6}[A-Z]{1,1}$/;
	var codigoValido = codigoFuncionario.match(regExCodigoFun);
	
	if (!codigoValido){
		alert("EL CODIGO DE FUNCIONARIO INGRESADO NO TIENE UNA ESTRUCTURA VALIDA...... 	     ");
		document.getElementById("textCodigoFuncionario").focus();
		return false;
	}
	
	if (codigoEscalafon == 0) {
		alert("DEBE INDICAR EL ESCALAFON DEL FUNCIONARIO ...... 	     ");
		document.getElementById("selEscalafon").focus();
		return false;
	}
	
	if (codigoGrado == 0) {
		alert("DEBE INDICAR EL GRADO DEL FUNCIONARIO ...... 	     ");
		document.getElementById("selGrado").focus();
		return false;
	}
	
	if (codigoCargo == 0) {
		alert("DEBE INDICAR EL CARGO DEL FUNCIONARIO ...... 	     ");
		document.getElementById("selCargo").focus();
		return false;
	}
	
	if (seccion == 0 && contieneHijos==1) {
		alert("DEBE INDICAR LA SECCION ...... 	     ");
		document.getElementById("selSeccion").focus();
		return false;
	}
	
	if ((codigoCargo == 180 || codigoCargo == 310) && document.getElementById("tienePlanCuadrante").value == 1){
		if (codigoCuadrante == 0) {
			alert("DEBE INDICAR EL CUADRANTE DEL FUNCIONARIO ...... 	     ");
			document.getElementById("selCuadrante").focus();
			return false;
		}
	}
	
	var cargoAgregado = [3000,3001,3002,3003,3004,3006,3100,6000,8520,9340,9350,9360,9370,9380,9390,9400,9410,9420,9430,9440,9460];
	if (tofindIndexByKeyValue(cargoAgregado,codigoCargo)>0&&codigoUnidadAgregado == ""){
		alert("DEBE INDICAR UNIDAD A LA QUE EL FUNCIONARIO SE FUE AGREGADO...... 	     ");
		return false;
	}
	
	if(document.getElementById("seccionBaseDatos").value!=""){
		var seccionBaseDatos = document.getElementById("seccionBaseDatos").value;
	}
	else{
		var seccionBaseDatos = "";
	}
	
	if((codigoGrado==codigoGradoActual && codigoEscalafon==codigoEscalafonActual) && (codigoCuadrante==codigoCuadranteActual)){
		if(codigoCargoActual==codigoCargo){
  			alert("EL NUEVO CARGO NO DEBE SER IGUAL AL CARGO ACTUAL ...... 	     ");
  			document.getElementById("selCargo").focus();
			return false;
   		}
 	}
	
	if (document.getElementById("selCargo").value != document.getElementById("cargoBaseDatos").value ||
		document.getElementById("selCuadrante").value != document.getElementById("codCuadranteBaseDatos").value ||
		document.getElementById("codigoUnidadAgregado").value != document.getElementById("codUnidadAgregadoBaseDatos").value||
    	seccion != seccionBaseDatos){
		if (fechaCargo == ""){
			alert("DEBE INDICAR FECHA DEL MOVIMIENTO ...... 	     ");
			return false;
		}
		if(controlValidacionServicio(document.getElementById("unidadUsuario").value, fechaCargo, false)) return false;

		if(document.getElementById("codigoUnidadAgregado").value!=""){
			if(controlValidacionServicio(document.getElementById("codigoUnidadAgregado").value, fechaCargo,true)) return false;
		}
		
		var comparaFechaLimite = comparaFecha(fechaLimite,fechaCargo);
		if (unidadBloqueada == 1 && comparaFechaLimite == 1){
			alert("LA FECHA NO PUEDE SER INFERIOR A LA FECHA DE BLOQUEO, QUE CORRESPONDE AL " + fechaLimite);
			return false;
		}
		
		var fechaMayor = comparaFecha(ultimaFechaCargo,fechaCargo);
		if (fechaMayor == 1){
			alert("LA FECHA NO PUEDE SER INFERIOR AL " + ultimaFechaCargo);
			return false;
		}
		
		var cantidadServicio = controlCargoFuncionario(codigoFuncionario,fechaCargo,'01-01-3000');
		if(cantidadServicio == 1){
			return false;
		}
	}
	return true;
}

function guardarFichaFuncionario(){
	desactivarBotones();
	var validaOk = validarFichaFuncionario();
	var codigoFuncionario = document.getElementById("idFuncionario").value;
	if (validaOk){
		if (codigoFuncionario != "") {
			var msj=confirm("ATENCI\u00D3N :\nSE MODIFICAR\u00C1N LOS DATOS DE ESTE FUNCIONARIO EN LA BASE DE DATOS.          \n\u00BFDESEA CONTINUAR?");
			if (msj){
				actualizarFuncionario();
			} else {
				activarBotones();
				return false;
			}
		} else {
			var msj=confirm("ATENCI\u00D3N :\nSE INGRESAR\u00C1N LOS DATOS DE ESTE FUNCIONARIO EN LA BASE DE DATOS.          \n\u00BFDESEA CONTINUAR?");
			if (msj) {
				nuevoFuncionario();
			} else {
				activarBotones();
				return false;
			}
		}
	} else {
		activarBotones();
	}
}

function activaVentanaIngresoFecha(boton){
	desactivarBotones();
	document.getElementById("textTipo").value = boton;
	document.getElementById("cubreVentana").style.display = "";
	document.getElementById("ventanaIngresoFecha").style.display	= "";
	document.getElementById("textFechaVentanaFecha").value = "";
	document.getElementById("selCuadrante").disabled = "";
	if (boton == 1) document.getElementById("textTipoMovimentoVentanaFecha").innerHTML = "Indique fecha en que se hace efectivo el Traslado de este Funcionario :"
	if (boton == 2) document.getElementById("textTipoMovimentoVentanaFecha").innerHTML = "Indique fecha en que se hace efectivo el Retiro de este Funcionario :"
	if (boton == 3) document.getElementById("textTipoMovimentoVentanaFecha").innerHTML = "Indique fecha en que se hace efectivo la Baja de este Funcionario :"
}

function desactivaVentanaIngresoFecha(){
	activarBotones();
	document.getElementById("cubreVentana").style.display = "none";
	document.getElementById("ventanaIngresoFecha").style.display  = "none";
}

function aceptaFechaVentanaIngresoFecha(){
	
	var ultimaFechaCargo = document.getElementById("ultimaFecha").value;
	var tipo = document.getElementById("textTipo").value;
	var fecha = document.getElementById("textFechaVentanaFecha").value;
	
	var fechaLimite 		= top.document.getElementById("textFechaLimite").value;
	var unidadBloqueada		= top.document.getElementById("textUnidadBloqueada").value;
	
	if (fecha == ""){
		alert("DEBE INDICAR UNA FECHA ....");
		return false;
	}
	
	var comparaFechaLimite = comparaFecha(fechaLimite,fecha)
	if (unidadBloqueada == 1 && comparaFechaLimite == 1){
			alert("LA FECHA NO PUEDE SER INFERIOR A LA FECHA DE BLOQUEO, QUE CORRESPONDE AL " + fechaLimite);
			return false;
	}
	
	var fechaMayor = comparaFecha(ultimaFechaCargo,fecha);
	if (fechaMayor == 1){
		alert("LA FECHA NO PUEDE SER INFERIOR AL " + ultimaFechaCargo);
		return false;
	}
	
	var codigoFuncionario	= document.getElementById("textCodigoFuncionario").value;
  var cantidadServicio = controlCargoFuncionario(codigoFuncionario,fecha,'01-01-3000');
  
  if(cantidadServicio == 1){
  	return false;
  }
  
	document.getElementById("ventanaIngresoFecha").style.display  = "none";
	document.getElementById("cubreVentana").style.display = "none";
	if (tipo == 1) liberaFuncionario();
	if (tipo == 2) validarMovimiento(2);
	if (tipo == 3) validarMovimiento(3);
	eliminarUsuario(codigoFuncionario);
}

function liberaFuncionario(){
	var unidadUsuario = document.getElementById("unidadUsuario").value;
	var fechaCargo = document.getElementById("textFechaVentanaFecha").value;
	var codigoFuncionario	= document.getElementById("textCodigoFuncionario").value;
	var codigoEscalafon 		= document.getElementById("selEscalafon").value;
	var codigoGrado				= document.getElementById("selGrado").value;

	var msj=confirm("SACAR\u00C1 EST\u00C9 FUNCIONARIO DE LA OFERTA DE SU UNIDAD.                                       \n\u00BFDESEA CONTINUAR?...");
	if (msj){
		desactivarBotones();

		var parametros = "";
		parametros += "codigoFuncionario="+codigoFuncionario+"&codigoEscalafon="+codigoEscalafon+"&codigoGrado="+codigoGrado;
		parametros += "&codigoCargo=3500&unidadUsuario="+unidadUsuario+"&fechaCargo="+fechaCargo+"&codigoCuadrante=0";
		parametros += "&codigoUnidadAgregado=&seccion=null&dias=";
		
		var objHttpXMLFuncionarios = new AJAXCrearObjeto();
		objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlActualizaFuncionario.php",true);
		objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		objHttpXMLFuncionarios.send(encodeURI(parametros));
		objHttpXMLFuncionarios.onreadystatechange=function(){
			if(objHttpXMLFuncionarios.readyState == 4){
				//console.log(objHttpXMLFuncionarios.responseText);
				if (objHttpXMLFuncionarios.responseText != "VACIO"){
					var xml = objHttpXMLFuncionarios.responseXML.documentElement;
					for(i=0;i<xml.getElementsByTagName('resultado').length;i++){
						var codigo = (xml.getElementsByTagName('resultado')[i].text||xml.getElementsByTagName('resultado')[i].textContent||"");
						if (codigo == 1){
								top.leeFuncionarios(unidadUsuario, '', '');
								idCargaListadoFuncionarios = setInterval("cerrarVentanaFicha();",1000);
								alert('EL FUNCIONARIO FUE DEJADO DISPONIBLE PARA OTRA UNIDAD ......        ');
						}
						else alert('OCURRIO UN PROBLEMA AL REALIZAR EL MOVIMIENTO ....		\nCODIGO RECIBIDO : ' + codigo);
					}
				}
			}
		}
	} else {
		activarBotones();
	}
}

function bajaFuncionario(){
	desactivarBotones();
	var unidadUsuario = document.getElementById("unidadUsuario").value;
	var codigoFuncionario = document.getElementById("textCodigoFuncionario").value;
	var fechaCargo = document.getElementById("textFechaVentanaFecha").value;
	var codigoEscalafon 		= document.getElementById("selEscalafon").value;
	var codigoGrado				= document.getElementById("selGrado").value;
	var parametros 		  = "";
	parametros += "codigoFuncionario="+codigoFuncionario+"&codigoEscalafon="+codigoEscalafon+"&codigoGrado="+codigoGrado;
	parametros += "&codigoCargo=2000&unidadUsuario="+unidadUsuario+"&fechaCargo="+fechaCargo+"&codigoCuadrante=0";
	parametros += "&codigoUnidadAgregado=&seccion=null&dias=";
	var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlActualizaFuncionario.php",true);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionarios.send(encodeURI(parametros));
	objHttpXMLFuncionarios.onreadystatechange=function(){
		if(objHttpXMLFuncionarios.readyState == 4){
				//console.log(objHttpXMLFuncionarios.responseText);
				if (objHttpXMLFuncionarios.responseText != "VACIO"){
				//alert(objHttpXMLFuncionarios.responseText);
				var xml = objHttpXMLFuncionarios.responseXML.documentElement;
				for(i=0;i<xml.getElementsByTagName('resultado').length;i++){
					var codigo = (xml.getElementsByTagName('resultado')[i].text||xml.getElementsByTagName('resultado')[i].textContent||"");
					if (codigo == 1){
						 alert('EL FUNCIONARIO FUE DADO DE BAJA ......        ');
						 top.leeFuncionarios(unidadUsuario, '', '');
						 idCargaListadoFuncionarios = setInterval("cerrarVentanaFicha()",1000);
					}
					else alert('EL FUNCIONARIO NO PUEDO SER DADO BAJA ....		\nCODIGO RECIBIDO : ' + codigo);
				}
			}
		}
	}
}

function retiroFuncionario(){
	desactivarBotones();
	var unidadUsuario = document.getElementById("unidadUsuario").value;
	var codigoFuncionario = document.getElementById("textCodigoFuncionario").value;
	var fechaCargo = document.getElementById("textFechaVentanaFecha").value;
	var codigoEscalafon 		= document.getElementById("selEscalafon").value;
	var codigoGrado				= document.getElementById("selGrado").value;
	var parametros	= "";
	parametros += "codigoFuncionario="+codigoFuncionario+"&codigoEscalafon="+codigoEscalafon+"&codigoGrado="+codigoGrado;
	parametros += "&codigoCargo=1000&unidadUsuario="+unidadUsuario+"&fechaCargo="+fechaCargo+"&codigoCuadrante=0";
	parametros += "&codigoUnidadAgregado=&seccion=null&dias=";
	var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlActualizaFuncionario.php",true);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionarios.send(encodeURI(parametros));
	objHttpXMLFuncionarios.onreadystatechange=function(){
		if(objHttpXMLFuncionarios.readyState == 4){
			//console.log(objHttpXMLFuncionarios.responseText);
			if(objHttpXMLFuncionarios.responseText != "VACIO"){
				//alert(objHttpXMLFuncionarios.responseText);
				var xml = objHttpXMLFuncionarios.responseXML.documentElement;
				for(i=0;i<xml.getElementsByTagName('resultado').length;i++){
					var codigo = (xml.getElementsByTagName('resultado')[i].text||xml.getElementsByTagName('resultado')[i].textContent||"");
					if (codigo == 1){
						 alert('EL FUNCIONARIO FUE DADO ENVIADO A RETIRO ......        ');
						 top.leeFuncionarios(unidadUsuario, '', '');
						 idCargaListadoFuncionarios = setInterval("cerrarVentanaFicha()",1000);
					}
					else alert('EL FUNCIONARIO NO PUDO SER ENVIADO A RETIRO ....		\nCODIGO RECIBIDO : ' + codigo);
				}
			}
		}
	}
}

function validarMovimiento(tipo){
	switch (tipo){
		case 2:
			var msj=confirm("LO SACAR\u00C1 DE LA OFERTA PARA ESTA Y TODAS LAS UNIDADES DE CARABINEROS, POR RETIRO VOLUNTARIO.        \n\u00C1DESEA CONTINUAR?...");
		break;
		case 3:
			var msj=confirm("LO SACAR\u00C1 DE LA OFERTA PARA ESTA Y TODAS LAS UNIDADES DE CARABINEROS, POR BAJA.        \n\u00BFDESEA CONTINUAR?...");
		break;
		default:
			var msj=false;
	}
	if (msj){
		activaVentanaIngresoContrasena(tipo);		
	} else {
			activarBotones();
	}
}

function activaVentanaIngresoContrasena(tipo){
	desactivarBotones();
	document.getElementById("cubreVentana").style.display = "";
	document.getElementById("ventanaIngresoContrasena").style.display  = "";
	switch (tipo){
		case 2:
			document.getElementById("textTituloContrasena").innerHTML = "INGRESE SU CONTRASE\u00D1A PARA VALIDAR EL RETIRO DEL FUNCIONARIO:";
		break;
		case 3:
			document.getElementById("textTituloContrasena").innerHTML = "INGRESE SU CONTRASE\u00D1A PARA VALIDAR LA BAJA DEL FUNCIONARIO:";
		break;
	}
}

function validaContrasena(){
	var valida = document.getElementById("textContrasena").value;
	var contrasena = document.getElementById("contrasena").value;
	var tipo = document.getElementById("textTipo").value;
	
	if(valida == ""){
		document.getElementById("textContrasena").focus();
		alert("DEBE INGRESAR SU CLAVE DE USUARIO PROSERVIPOL");
		return false;
	}
	
	switch (tipo){
		case '2':
			if (valida == contrasena){
				retiroFuncionario();
			}
			else{
				document.getElementById("textTituloContrasena").innerHTML = "CONTRASE\u00D1A ERRONEA, VUELVA A INGRESARLA PARA VALIDAR EL RETIRO DEL FUNCIONARIO:";
				document.getElementById("textContrasena").value = "";
			}
		break;
		case '3':
			if (valida == contrasena){
				bajaFuncionario();
			}
			else{
				document.getElementById("textTituloContrasena").innerHTML = "CONTRASE\u00D1A ERRONEA, VUELVA A INGRESARLA PARA VALIDAR LA BAJA DEL FUNCIONARIO:";
				document.getElementById("textContrasena").value = "";
			}
		break;
	}
}

function desactivaVentanaIngresoContrasena(){
	activarBotones();
	document.getElementById("cubreVentana").style.display = "none";
	document.getElementById("ventanaIngresoContrasena").style.display  = "none";
}

function cerrarVentanaFicha(){
	if (top.cargaListadoFuncionarios == 1){
		clearInterval(idCargaListadoFuncionarios);
		top.document.getElementById("cubreFondo").style.display = "none";
		top.Windows.closeAll();
	}
}

function tofindIndexByKeyValue(arraytosearch,valuetosearch) {
    for(var i = 0; i < arraytosearch.length; i++) {
		if(arraytosearch[i] == valuetosearch) return i;
    }
    return -1;
}

function activaFechaNuevoCargo(){
	var unidadUsuario = document.getElementById("unidadUsuario").value;
	var unidadPadre = document.getElementById("unidadPadre").value;
	var cargo = (document.getElementById("selCargo").value||document.getElementById("cargoBaseDatos").value||"");
	var cargoAgregado = [3000,3001,3002,3003,3004,3006,3100,6000,8520,9340,9350,9360,9370,9380,9390,9400,9410,9420,9430,9440,9460];
	if (cargo != document.getElementById("cargoBaseDatos").value || (document.getElementById("selSeccion").value != document.getElementById("seccionBaseDatos").value)){
		if ((cargo == 180 || cargo == 310) && document.getElementById("tienePlanCuadrante").value == 1){
			document.getElementById("labCuadrante").disabled= "";
			document.getElementById("selCuadrante").disabled= "";
			document.getElementById("selCuadrante").style.backgroundColor = "";
		} else {
			document.getElementById("labCuadrante").disabled= "true";
			document.getElementById("selCuadrante").disabled= "true";
			document.getElementById("selCuadrante").style.backgroundColor = "#E6E6E6";
			document.getElementById("selCuadrante").value= 0;
		}
		if (tofindIndexByKeyValue(cargoAgregado,cargo)>0){
			document.getElementById("labUnidadAgregado").disabled= "";
			document.getElementById("btnUnidades").disabled= "";
			document.getElementById("textUnidadAgregado").style.backgroundColor = "";
			document.getElementById("textUnidadAgregado").disabled= "";
			if (document.getElementById("codUnidadAgregadoBaseDatos").value != ""){
				document.getElementById("codigoUnidadAgregado").value= document.getElementById("codUnidadAgregadoBaseDatos").value;
				document.getElementById("textUnidadAgregado").value= document.getElementById("desUnidadAgregadoBaseDatos").value;
			}
			listaUnidades(unidadPadre,unidadUsuario,'selectUnidad');
		} else {
			document.getElementById("labUnidadAgregado").disabled= "";
			document.getElementById("labUnidadAgregado").disabled= "true";
			document.getElementById("btnUnidades").disabled= "true";
			document.getElementById("textUnidadAgregado").style.backgroundColor = "#E6E6E6";
			document.getElementById("textUnidadAgregado").value= "";
			document.getElementById("textUnidadAgregado").disabled= "true";
			document.getElementById("codigoUnidadAgregado").value= "";
		}
		document.getElementById("labFechaCargo").disabled= "";
		document.getElementById("imagenCalendarioFichaFuncionario").style.visibility = "visible";
		document.getElementById("textFechaUltimoCargo").style.backgroundColor = "";
		document.getElementById("textFechaUltimoCargo").disabled= "";
	} else {
		if ((cargo == 180  || cargo == 310) && document.getElementById("tienePlanCuadrante").value == 1){
			document.getElementById("labCuadrante").disabled= "";
			document.getElementById("selCuadrante").disabled= "";
			document.getElementById("selCuadrante").style.backgroundColor = "";
		} else {
			document.getElementById("labCuadrante").disabled= "true";
			document.getElementById("selCuadrante").disabled= "true";
			document.getElementById("selCuadrante").style.backgroundColor = "#E6E6E6";
			document.getElementById("selCuadrante").value= 0;
		}
		if (tofindIndexByKeyValue(cargoAgregado,cargo)>0){
			document.getElementById("labUnidadAgregado").disabled= "";
			document.getElementById("btnUnidades").disabled= "";
			document.getElementById("textUnidadAgregado").style.backgroundColor = "";
			document.getElementById("textUnidadAgregado").disabled= "";
			if (document.getElementById("codUnidadAgregadoBaseDatos").value != ""){
				document.getElementById("codigoUnidadAgregado").value= document.getElementById("codUnidadAgregadoBaseDatos").value;
				document.getElementById("textUnidadAgregado").value= document.getElementById("desUnidadAgregadoBaseDatos").value;
			}
			listaUnidades(unidadPadre,unidadUsuario,'selectUnidad');
		} else {
			document.getElementById("labUnidadAgregado").disabled= "true";
			document.getElementById("btnUnidades").disabled= "true";
			document.getElementById("textUnidadAgregado").style.backgroundColor = "#E6E6E6";
			document.getElementById("textUnidadAgregado").value= "";
			document.getElementById("textUnidadAgregado").disabled= "true";
		}
		document.getElementById("labFechaCargo").disabled = "true";
		document.getElementById("imagenCalendarioFichaFuncionario").style.visibility = "hidden";
		document.getElementById("textFechaUltimoCargo").value = "";
		document.getElementById("textFechaUltimoCargo").style.backgroundColor = "#E6E6E6";
		document.getElementById("textFechaUltimoCargo").disabled= "true";
		
	}
}

function modificaCuadranteFuncionario(){
	if ((document.getElementById("codCuadranteBaseDatos").value != document.getElementById("selCuadrante").value)||(document.getElementById("selCargo").value != document.getElementById("cargoBaseDatos").value)){
		document.getElementById("labFechaCargo").disabled= "";
		document.getElementById("imagenCalendarioFichaFuncionario").style.visibility = "visible";
		document.getElementById("textFechaUltimoCargo").style.backgroundColor = "";
		document.getElementById("textFechaUltimoCargo").disabled= "";
	} else {
		document.getElementById("labFechaCargo").disabled = "true";
		document.getElementById("imagenCalendarioFichaFuncionario").style.visibility = "hidden";
		document.getElementById("textFechaUltimoCargo").value = "";
		document.getElementById("textFechaUltimoCargo").style.backgroundColor = "#E6E6E6";
		document.getElementById("textFechaUltimoCargo").disabled= "true";
	}
}

function desactivarBotones(){
	document.getElementById("btnDejarDisponible").disabled = "true";
	document.getElementById("btnRetiro").disabled = "true";
	document.getElementById("btnBaja").disabled = "true";
	document.getElementById("btnGuardar").disabled = "true";
	document.getElementById("btnCerrarFicha").disabled = "true";
}

function activarBotones(){
	var permisoRegistrar = document.getElementById("permisoRegistrar").value;
	var subMenu = document.getElementById("subMenu").value;
	if(permisoRegistrar && subMenu == 'Dotacion'){
		if(cargoBaseDatos.value!=""){
			document.getElementById("btnDejarDisponible").disabled = "";
			document.getElementById("btnRetiro").disabled = "";
			document.getElementById("btnBaja").disabled = "";
		}
		document.getElementById("btnGuardar").disabled = "";
	}
	document.getElementById("btnCerrarFicha").disabled = "";
}

function leeFuncionariosPorGrado(unidad, tipoUnidad, escalafon, grado, desGrado, inicio){
	var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	var div	= document.getElementById("listadoServicios");
	var contenidoPaso = div.innerHTML;
	div.innerHTML = "<table><tr><td><img src='./img/ajax_loader.gif'></td><td>&nbsp;Cargando Funcionarios ......</td>";
	document.getElementById("totalPersonal").innerHTML 	= "-";
	objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlConsultaFuncionarios.php",true);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionarios.send(encodeURI("codigoUnidad="+unidad+"&tipoUnidad="+tipoUnidad+"&escalafon="+escalafon+"&grado="+grado+"&desGrado="+desGrado+"&inicio="+inicio));
	objHttpXMLFuncionarios.onreadystatechange=function(){
		//alert(objHttpXMLFuncionarios.readyState);
		if(objHttpXMLFuncionarios.readyState == 4){
			//alert(objHttpXMLFuncionarios.responseText);
			if (objHttpXMLFuncionarios.responseText != "VACIO"){
				//alert(objHttpXMLFuncionarios.responseText);
				var xml 			 	= objHttpXMLFuncionarios.responseXML.documentElement;
				var codigoUnidad		= "";
				var descripcionUnidad	= "";
				var codigoEscalafon	 	= "";
				var codigoGrado	 		= "";
				var descripcionGrado 	= "";
				var cantidadPersonal 	= "";
				var sw 				 	= 0;
				var fondoLinea		 	= "";
				var resaltarLinea 	 	= "";
				var lineaSinResaltar 	= "";
				var listadoServicios 	= "";
				var sumCantidadPersonal = 0;
				
				listadoServicios = "<table width='100%' cellspacing='1' cellpadding='1'>";
				for(i=0;i<xml.getElementsByTagName('funcionarios').length;i++){
					
					if (sw==0) {fondoLinea = "linea1";sw =1}
					else {fondoLinea = "linea2";sw=0}
					
					codigoUnidad	 	= (xml.getElementsByTagName('codUnidad ')[i].text||xml.getElementsByTagName('codUnidad ')[i].textContent||"");
					descripcionUnidad	= (xml.getElementsByTagName('desUnidad ')[i].text||xml.getElementsByTagName('desUnidad ')[i].textContent||"");
					codigoEscalafon	 	= (xml.getElementsByTagName('codEscalafon')[i].text||xml.getElementsByTagName('codEscalafon ')[i].textContent||"");
					codigoGrado			= (xml.getElementsByTagName('codGrado')[i].text||xml.getElementsByTagName('codGrado ')[i].textContent||"");
					descripcionGrado	= (xml.getElementsByTagName('desGrado')[i].text||xml.getElementsByTagName('desGrado ')[i].textContent||"");
					cantidadPersonal	= (xml.getElementsByTagName('cantidadFuncionarios')[i].text||xml.getElementsByTagName('cantidadFuncionarios ')[i].textContent||"");
					
					sumCantidadPersonal += cantidadPersonal*1;
					resaltarLinea 	 	= "cambiarClase(this, 'lineaMarcada')";
					lineaSinResaltar 	= "cambiarClase(this, '"+fondoLinea+"')";
					
					if (codigoUnidad == "") codigoUnidad = unidad;
					if (tipoUnidad == "nacional") var unidadHijo = "zona";
					if (tipoUnidad == "zona") var unidadHijo = "prefectura";
					if (tipoUnidad == "prefectura") var unidadHijo = "comisaria";
					if (tipoUnidad == "comisaria") var unidadHijo = "destacamento";
					
					inicio = 1;
					if (typeof (unidadHijo) == "undefined")var dblClick = "javascript:abrirVentana('LISTADO PERSONAL ...', '995', '500','muestraListaPersonal.php?unidad="+codigoUnidad+"&grado="+descripcionGrado+"', '','','0','0')";
					else var dblClick = "leeFuncionariosPorGrado('"+codigoUnidad+"','"+unidadHijo+"','"+codigoEscalafon+"','"+codigoGrado+"','"+descripcionGrado+"','"+inicio+"')";
					
					if (descripcionUnidad == "") descripcionUnidad = "NIVEL NACIONAL";
					
					listadoServicios += "<tr id='trNro"+i+"' OnMouseOver=\""+resaltarLinea+"\" OnMouseOut=\""+lineaSinResaltar+"\" class='"+fondoLinea+"' onDblClick=\""+dblClick+"\">";
					listadoServicios += "<td width='5%' align='center'><div id='valorColumna'>"+(i+1)+"</div></td>";
					listadoServicios += "<td width='30%'><div id='valorColumna'>"+descripcionUnidad+"</div></td>";
					listadoServicios += "<td width='45%'><div id='valorColumna'>"+descripcionGrado.toUpperCase()+"</div></td>";
					listadoServicios += "<td width='20%' align='right' style='padding:0px 7px 0px 0px;'><div id='valorColumna'>"+formato_numero(cantidadPersonal,0,',','.')+"</div></td>";
					listadoServicios += "</tr>";
				}
				listadoServicios += "</table>";
				
				div.innerHTML = listadoServicios;
				document.getElementById("totalPersonal").innerHTML = formato_numero(sumCantidadPersonal,0,',','.');
				
				cargaListadoServicios = 1;
			} else {
				div.innerHTML = contenidoPaso;
				eval("abrirVentana('LISTADO PERSONAL ...', '995', '500','muestraListaPersonal.php?unidad="+unidad+"&grado="+desGrado+"', '','','0','0')");
			}
		}
	}
}

function leeFuncionariosPorGrado2(unidad, tipoUnidad, tipoUnidadPadre, escalafon, grado, desGrado, inicio){	
	var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	var div	= document.getElementById("listadoServicios");
	var contenidoPaso = div.innerHTML;
	div.innerHTML = "<table><tr><td><img src='./img/ajax_loader.gif'></td><td>&nbsp;Cargando Funcionarios ......</td>";
	document.getElementById("totalPersonal").innerHTML 	= "-";
	objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlConsultaFuncionarios2.php",true);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionarios.send(encodeURI("codigoUnidad="+unidad+"&tipoUnidad="+tipoUnidad+"&tipoUnidadPadre="+tipoUnidadPadre+"&escalafon="+escalafon+"&grado="+grado+"&desGrado="+desGrado+"&inicio="+inicio));
	objHttpXMLFuncionarios.onreadystatechange=function(){
		//alert(objHttpXMLFuncionarios.readyState);
		if(objHttpXMLFuncionarios.readyState == 4){
			//alert(objHttpXMLFuncionarios.responseText);
			if (objHttpXMLFuncionarios.responseText != "VACIO"){
				//alert(objHttpXMLFuncionarios.responseText);
				var xml 			 			= objHttpXMLFuncionarios.responseXML.documentElement;
				var codigoUnidad				= "";
				var descripcionUnidad 			= "";
				var codigoEscalafon	 			= "";
				var codigoGrado	 				= "";
				var descripcionGrado 			= "";
				var cantidadPersonal 			= "";
				var cantidadPersonalAgregado 	= "";
				var sw 				 			= 0;
				var fondoLinea		 			= "";
				var resaltarLinea 	 			= "";
				var lineaSinResaltar 			= "";
				var listadoServicios 			= "";
				var sumCantidadPersonal 		= 0;
				var sumCantidadPersonalAgregado	= 0;
				
				listadoServicios = "<table width='100%' cellspacing='1' cellpadding='1'>";
				for(i=0;i<xml.getElementsByTagName('funcionarios').length;i++){
					
					if (sw==0) {fondoLinea = "linea1";sw =1}
					else {fondoLinea = "linea2";sw=0}
					
					codigoUnidad	 			= (xml.getElementsByTagName('codUnidad ')[i].text||xml.getElementsByTagName('codUnidad ')[i].textContent||"");
					descripcionUnidad			= (xml.getElementsByTagName('desUnidad ')[i].text||xml.getElementsByTagName('desUnidad ')[i].textContent||"");
					codigoEscalafon	 			= (xml.getElementsByTagName('codEscalafon')[i].text||xml.getElementsByTagName('codEscalafon ')[i].textContent||"");
					codigoGrado					= (xml.getElementsByTagName('codGrado')[i].text||xml.getElementsByTagName('codGrado ')[i].textContent||"");
					descripcionGrado			= (xml.getElementsByTagName('desGrado')[i].text||xml.getElementsByTagName('desGrado ')[i].textContent||"");
					cantidadPersonal			= (xml.getElementsByTagName('cantidadFuncionarios')[i].text||xml.getElementsByTagName('cantidadFuncionarios ')[i].textContent||"");
					cantidadPersonalAgregado	= (xml.getElementsByTagName('cantidadFuncionariosAgregados')[i].text||xml.getElementsByTagName('cantidadFuncionariosAgregados')[i].textContent||"");
					
					sumCantidadPersonal += cantidadPersonal*1;
					sumCantidadPersonalAgregado += cantidadPersonalAgregado*1;
					
					resaltarLinea 	 	= "cambiarClase(this, 'lineaMarcada')";
					lineaSinResaltar 	= "cambiarClase(this, '"+fondoLinea+"')";
					
					if (codigoUnidad == "") codigoUnidad = unidad;
					if (tipoUnidad == "nacional") var unidadHijo = "superZona";
					if (tipoUnidad == "superZona") var unidadHijo = "zona";
					if (tipoUnidad == "zona") var unidadHijo = "prefectura";
					if (tipoUnidad == "prefectura") var unidadHijo = "comisaria";
					if (tipoUnidad == "comisaria") var unidadHijo = "destacamento";
					
					inicio = 1;
					if (typeof (unidadHijo) == "undefined")var dblClick = "javascript:abrirVentana('LISTADO PERSONAL ...', '995', '500','muestraListaPersonal.php?unidad="+codigoUnidad+"&grado="+descripcionGrado+"', '','','0','0')";
					else var dblClick = "leeFuncionariosPorGrado2('"+codigoUnidad+"','"+unidadHijo+"','"+tipoUnidad+"','"+codigoEscalafon+"','"+codigoGrado+"','"+descripcionGrado+"','"+inicio+"')";
					
					if (descripcionUnidad == "") descripcionUnidad = "NIVEL NACIONAL";
					listadoServicios += "<tr id='trNro"+i+"' OnMouseOver=\""+resaltarLinea+"\" OnMouseOut=\""+lineaSinResaltar+"\" class='"+fondoLinea+"' onDblClick=\""+dblClick+"\">";
					listadoServicios += "<td width='5%' align='center'><div id='valorColumna'>"+(i+1)+"</div></td>";
					listadoServicios += "<td width='30%'><div id='valorColumna'>"+descripcionUnidad+"</div></td>";
					listadoServicios += "<td width='25%'><div id='valorColumna'>"+descripcionGrado.toUpperCase()+"</div></td>";
					listadoServicios += "<td width='20%' align='right' style='padding:0px 7px 0px 0px;'><div id='valorColumna'>"+formato_numero(cantidadPersonal,0,',','.')+"</div></td>";
					listadoServicios += "<td width='20%' align='right' style='padding:0px 7px 0px 0px;'><div id='valorColumna'>"+formato_numero(cantidadPersonalAgregado,0,',','.')+"</div></td>";
					listadoServicios += "</tr>";
				}
				listadoServicios += "</table>";
				div.innerHTML = listadoServicios;
				document.getElementById("totalPersonal").innerHTML = formato_numero(sumCantidadPersonal,0,',','.');
				document.getElementById("totalPersonalAgregado").innerHTML = formato_numero(sumCantidadPersonalAgregado,0,',','.');
				cargaListadoServicios = 1;
			} else {
				div.innerHTML = contenidoPaso;
				eval("abrirVentana('LISTADO PERSONAL ...', '995', '500','muestraListaPersonal.php?unidad="+unidad+"&grado="+desGrado+"', '','','0','0')");
			}
		}
	}
}

function muestraListaFuncionarios(unidad, escalafon, grado){
	var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	var div	= document.getElementById("kk");
	div.innerHTML = "<table><tr><td><img src='./img/ajax_loader.gif'></td><td>&nbsp;Cargando Funcionarios ......</td>";
	var campoOrden = "nombre";
	objHttpXMLFuncionarios.open("POST","./xml/xmlFuncionarios/xmlListaFuncionarios.php",true);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionarios.send(encodeURI("codigoUnidad="+unidad+"&escalafon="+escalafon+"&grado="+grado+"&campo="+campoOrden));
	objHttpXMLFuncionarios.onreadystatechange=function(){
		//alert(objHttpXMLFuncionarios.readyState);
		if(objHttpXMLFuncionarios.readyState == 4){
			//alert(objHttpXMLFuncionarios.responseText);
			if (objHttpXMLFuncionarios.responseText != "VACIO"){
				//alert(objHttpXMLFuncionarios.responseText);
				var xml 				= objHttpXMLFuncionarios.responseXML.documentElement;
				var codigo	 			= "";
				var apellidoPaterno		= "";
				var apellidoMaterno 	= "";
				var nombre2				= "";
				var nombre	 			= "";
				var nombreCompleto		= "";
				var grado		 		= "";
				var cargo		 		= "";
				var codigoCargo	 		= "";
				var unidadAgregado		= "";
				var sw 				 	= 0;
				var fondoLinea		 	= "";
				var resaltarLinea 	 	= "";
				var lineaSinResaltar 	= "";
				var listadoFuncionarios	= "";
				
				listadoFuncionarios = "<table width='98%' cellspacing='1' cellpadding='1'>";
				for(i=0;i<xml.getElementsByTagName('funcionario').length;i++){
					if (sw==0) {fondoLinea = "linea1";sw =1}
					else {fondoLinea = "linea2";sw=0}
					
					codigo	 		 	= (xml.getElementsByTagName('codigo')[i].text||xml.getElementsByTagName('codigo ')[i].textContent||"");
					apellidoPaterno 	= (xml.getElementsByTagName('apellidoPaterno')[i].text||xml.getElementsByTagName('apellidoPaterno')[i].textContent||"");
					apellidoMaterno		= (xml.getElementsByTagName('apellidoMaterno')[i].text||xml.getElementsByTagName('apellidoMaterno')[i].textContent||"");
					nombre				= (xml.getElementsByTagName('nombre')[i].text||xml.getElementsByTagName('nombre')[i].textContent||"");
					nombre2				= (xml.getElementsByTagName('nombre2')[i].text||xml.getElementsByTagName('nombre2')[i].textContent||"");
					nombreCompleto		= (apellidoPaterno+" "+apellidoMaterno+", "+nombre+" "+nombre2);
					grado		 	 	= (xml.getElementsByTagName('grado')[i].text||xml.getElementsByTagName('grado ')[i].textContent||"");
					cargo		 	 	= (xml.getElementsByTagName('cargo')[i].text||xml.getElementsByTagName('codigo ')[i].textContent||"");
					codigoCargo	 	 	= (xml.getElementsByTagName('codigoCargo')[i].text||xml.getElementsByTagName('codigoCargo ')[i].textContent||"");
					unidadAgregado		= (xml.getElementsByTagName('unidadAgregado')[i].text||xml.getElementsByTagName('unidadAgregado ')[i].textContent||"");
					resaltarLinea		= "cambiarClase(this, 'lineaMarcada2')";
					lineaSinResaltar	= "cambiarClase(this, '"+fondoLinea+"')";
					
					var nroLinea = i + 1;
					var dblClick = "";
					
					var cargoAgregado = [3000,3001,3002,3003,3004,3005,3006,3100,6000,8520,9340,9350,9360,9370,9380,9390,9400,9410,9420,9430,9440,9460];
					if(tofindIndexByKeyValue(cargoAgregado,codigoCargo)>0) cargo = cargo + " ("+unidadAgregado+")";
					listadoFuncionarios += "<tr id='"+nroLinea+"' OnMouseOver=\""+resaltarLinea+"\" OnMouseOut=\""+lineaSinResaltar+"\" class='"+fondoLinea+"' onDblClick=\""+dblClick+"\">";
					listadoFuncionarios += "<td width='4%' align='center'><div id='valorColumna'>"+(i+1)+"</div></td>";
					listadoFuncionarios += "<td width='10%' align='center'><div id='valorColumna'>"+codigo+"</div></td>";
					listadoFuncionarios += "<td width='45%'><div id='valorColumna'>"+nombreCompleto+"</div></td>";
					listadoFuncionarios += "<td width='20%' align='left'><div id='valorColumna'>"+grado+"</div></td>";
					listadoFuncionarios+= "<td width='21%' align='left'><div id='valorColumna'>"+cargo+"</div></td>";
					listadoFuncionarios += "</tr>";
				}
				listadoFuncionarios += "</table>";
				div.innerHTML = listadoFuncionarios;
				cargaListadoFuncionarios = 1;
			}
		}
	}
}

function activaBuscaUnidadAgregado(){
	var unidadUsuario = document.getElementById("unidadUsuario").value;
	var unidadPadre = document.getElementById("unidadPadre").value;
	desactivarBotones();
	document.getElementById("selCuadrante").disabled = "";
	document.getElementById("cubreVentana").style.display = "";
	document.getElementById("ventanaSeleccionaUnidad").style.display = "";
	listaUnidades(unidadUsuario,unidadPadre,'selectUnidad');
}

function controlCargoFuncionario(funcionario,fecha1,fecha2){
  var mensaje="";
  var objHttpXMLFuncionarios = new AJAXCrearObjeto();
	objHttpXMLFuncionarios.open("POST","./xml/xmlServicios/xmlListaServiciosPorFuncionario.php",false);
	objHttpXMLFuncionarios.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	objHttpXMLFuncionarios.send(encodeURI("codigoFuncionario="+funcionario+"&fecha1="+fecha1+"&fecha2="+fecha2));
  //alert(objHttpXMLFuncionarios.responseText);
  if (objHttpXMLFuncionarios.responseText != "VACIO"){
  	var xml = objHttpXMLFuncionarios.responseXML.documentElement;
		mensaje += "NO PUEDE MODIFICAR PORQUE TIENE LOS SIGUIENTES SERVICIOS ASIGNADOS:\n\n";
		if (xml.getElementsByTagName('servicio').length > 10) var cantidadServiciosMostar = 10;
		else var cantidadServiciosMostar = xml.getElementsByTagName('servicio').length;
		for(var i=0;i<cantidadServiciosMostar;i++){
			var fecha		= (xml.getElementsByTagName('fecha')[i].text||xml.getElementsByTagName('fecha')[i].textContent||"");
			var servicio	= (xml.getElementsByTagName('desServicio')[i].text||xml.getElementsByTagName('desServicio')[i].textContent||"");
			var unidad		= (xml.getElementsByTagName('desUnidad')[i].text||xml.getElementsByTagName('desUnidad')[i].textContent||"");
			mensaje += (i+1) +". " + fecha+" - SERVICIO "+servicio.toUpperCase()+"\n   ("+unidad.toUpperCase()+").\n";
		}
		if (cantidadServiciosMostar < xml.getElementsByTagName('servicio').length) mensaje += "...";
		alert(mensaje);
		return 1;
	}
}

function controlValidacionServicio(unidadServicios, fechaServicios, agregado){
	var mensaje="";
	var objHttpXMLFechaValidacion = new AJAXCrearObjeto();
	objHttpXMLFechaValidacion.open("POST","./xml/xmlServicios/xmlListaFechaValidacion.php",false);
	objHttpXMLFechaValidacion.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//console.log("unidad="+unidadServicios+"&fechaServicios="+fechaServicios);
	objHttpXMLFechaValidacion.send(encodeURI("unidad="+unidadServicios+"&fechaServicios="+fechaServicios));
	//console.log(objHttpXMLFechaValidacion.responseText);
	if (objHttpXMLFechaValidacion.responseText != "VACIO"){
		var xml = objHttpXMLFechaValidacion.responseXML.documentElement;
		if(agregado) mensaje += "NO PUEDE REALIZAR LA ACCI\u00D3N PORQUE LA UNIDAD DE DESTINO TIENE LOS SIGUIENTES D\u00CDAS VALIDADOS:\n\n";
		else mensaje += "NO PUEDE REALIZAR LA ACCI\u00D3N PORQUE TIENE LOS SIGUIENTES D\u00CDAS VALIDADOS:\n\n";
		
		if (xml.getElementsByTagName('servicio').length > 10) var cantidadDiasMostrar = 10;
		else var cantidadDiasMostrar = xml.getElementsByTagName('servicio').length;
		for(var i=0;i<cantidadDiasMostrar;i++){
			var fecha = (xml.getElementsByTagName('fecha')[i].text||xml.getElementsByTagName('fecha')[i].textContent||"");
			mensaje += (i+1) +". " + fecha+"\n";
		} 
		if (cantidadDiasMostrar < xml.getElementsByTagName('servicio').length) mensaje += "...";
		if(agregado) mensaje += "\n\nDEBE COMUNICARSE CON LA UNIDAD DE DESTINO\n";
		alert(mensaje);
		return true;
	}
	return false;
}

function validaNumeros(e){
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8){
        return true;
    }
    patron =/[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

function textoClic(){
  document.getElementById("labFechaCargo").innerHTML = "(*) TIPO DE LICENCIA &nbsp;:&nbsp;";
  document.getElementById("imagenCalendarioFichaFuncionario").style.visibility = "visible";
  document.getElementById("textFechaUltimoCargo").disabled= "false";
  document.getElementById("labFechaCargo").disabled= "";
  document.getElementById("imagenCalendarioFichaFuncionario").style.visibility = "visible";
  document.getElementById("textFechaUltimoCargo").style.backgroundColor = "";
  document.getElementById("textFechaUltimoCargo").disabled= "";
}

sumaFecha = function(d, fecha){
 var Fecha = new Date();
 var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
 var sep = sFecha.indexOf('/') != -1 ? '/' : '-'; 
 var aFecha = sFecha.split(sep);
 var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
 fecha= new Date(fecha);
 fecha.setDate(fecha.getDate()+parseInt(d));
 var anno=fecha.getFullYear();
 var mes= fecha.getMonth()+1;
 var dia= fecha.getDate();
 mes = (mes < 10) ? ("0" + mes) : mes;
 dia = (dia < 10) ? ("0" + dia) : dia;
 var fechaFinal = dia+sep+mes+sep+anno;
 return (fechaFinal);
}

restaFechas = function(f1,f2){
 var aFecha1 = f1.split('-');
 var aFecha2 = f2.split('-');
 var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
 var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
 var dif = fFecha2 - fFecha1;
 var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
 return dias;
}