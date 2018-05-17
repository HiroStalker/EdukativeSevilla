function edicionFactura(){
	var res=true;
	var fechainicio = document.getElementById("FECHAINICIO").value;
	var preciototal = document.getElementById("PRECIOTOTAL").value;
	var abonado = document.getElementById("ABONADO").value;
	var fechafin = document.getElementById("FECHAFIN").value;
	
	var error="";
	
	error= validarPrecioTotal(error, preciototal);
	error = validarFechaFin(error, fechafin, abonado, fechainicio);
	if(error!=""){
		document.getElementById("erroresedicionfactura").className="error";
		document.getElementById("erroresedicionfactura").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresedicionfactura").className="";
		document.getElementById("erroresedicionfactura").innerHTML="";
	}

	return res;
}

function validarPrecioTotal(error, preciototal){
	if(preciototal==""){
		error=error+"El precio total no puede estar vacío";
	}
	if(!validar_precio(preciototal)){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"El precio total debe estar formado por dígitos y ser decimal (X,Y)";
	}
	return error;
}

function validar_precio(preciototal){
	if(preciototal.match(/^\d+,\d+$/)){
		return true;
	}else{
		return false;
	}
}

function validarFechaFin(error, fechafin, abonado, fechainicio){
	if(fechafin=="" && abonado=="1"){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"La fecha fin no puede estar vacía si la factura está abonada";
	}
	if(!fechaValida(fechafin) && fechafin!=""){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"La fecha fin no es válida (dd/mm/aa)";
	}
	if(!esMayor(fechafin,fechainicio) && fechafin!=""){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"La fecha fin debe ser superior o igual a la fecha inicio";
	}
	return error;
}

function fechaValida(fechafin){
	//var patron = new RegExp("\\b(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/]\\d\\d\\b");
	if(!fechafin.match(/^(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/]\d\d$/)){
		return false;
	}else{
		var array = fechafin.split("/");
		if(array[0]=="31" && (array[1]=="04" || array[1]=="06" || array[1]=="09" || array[1]=="11")){
			return false;
		}else if(30<=Number(array[0]) && array[1]=="02"){
			return false;
		}else if(array[1]=="02" && array[0]=="29" && !(Number(array[2]) % 4 == 0 && (Number(array[2]) %100 != 0 || Number(array[2]) %400 == 0))){
			return false;
		}else{
			return true;
		}
	}
}

function esMayor(fechafin,fechainicio){
	//var patron = new RegExp("\\b(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/]\\d\\d\\b");
	if(!fechafin.match(/^(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/]\d\d$/) && !fechainicio.match(/^(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/]\d\d$/)){
		return false;
	}else{
		var arrayfin= fechafin.split("/");
		var arrayinicio = fechainicio.split("/");
		var inicio = 1000*Number(arrayinicio[2])+ 100*Number(arrayinicio[1]) + Number(arrayinicio[0]);
		var fin = 1000*Number(arrayfin[2])+ 100*Number(arrayfin[1]) + Number(arrayfin[0]);
		if(fin>=inicio){
			return true;
		}else{
			return false;
		}
	}	
}

