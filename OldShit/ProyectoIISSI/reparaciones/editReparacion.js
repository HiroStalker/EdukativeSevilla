function edicionReparacion(){
	var res=true;
	var horas = document.getElementById("HORAS").value;
	var error = "";
	error= validarHoras(error, horas);
	if(error!=""){
		document.getElementById("erroresedicionreparacion").className="error";
		document.getElementById("erroresedicionreparacion").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresedicionreparacion").className="";
		document.getElementById("erroresedicionreparacion").innerHTML="";
	}
	
	return res;
}

function validarHoras(error,horas){
	if(horas==""){
		error=error+"Las horas no pueden estar vacías";
	}
	if(!validar_horas(horas)){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"El valor de las horas no es válido, debe ser estrictamente mayor a 0";
	}
	return error;
}

function validar_horas(horas){
	if(horas.match(/^\d+$/)){
		return true;
	}else{
		return false;
	}
}