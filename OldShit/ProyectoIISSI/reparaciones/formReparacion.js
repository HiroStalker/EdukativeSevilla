function procesarReparacion(){
	var res=true;
	var vid = document.getElementById("vid").value;
	var horas = document.getElementById("horas").value;
	
	var error= validarVid("", vid);
	if(error!=""){
		document.getElementById("erroresvidreparacion").className="error";
		document.getElementById("erroresvidreparacion").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresvidreparacion").className="";
		document.getElementById("erroresvidreparacion").innerHTML="";
	}
	
	error= validarHoras("", horas);
	if(error!=""){
		document.getElementById("erroreshorasreparacion").className="error";
		document.getElementById("erroreshorasreparacion").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroreshorasreparacion").className="";
		document.getElementById("erroreshorasreparacion").innerHTML="";
	}
	
	return res;
}

function validarVid(error,vid){
	if(vid=="-1"){
		error=error+"No se puede crear una reparación ya que no se ha seleccionado un vehículo.";
	}
	return error;
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