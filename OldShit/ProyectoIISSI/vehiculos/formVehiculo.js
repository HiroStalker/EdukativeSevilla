function procesarVehiculo(){
	var res=true;
	var matricula = document.getElementById("matricula").value;
	var marca = document.getElementById("marca").value;
	var modelo = document.getElementById("modelo").value;
	var chasis = document.getElementById("chasis").value;
	var color = document.getElementById("color").value;
	var kms = document.getElementById("kms").value;

	var error= validarMatricula("", matricula);
	if(error!=""){
		document.getElementById("erroresmatriculavehiculo").className="error";
		document.getElementById("erroresmatriculavehiculo").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresmatriculavehiculo").className="";
		document.getElementById("erroresmatriculavehiculo").innerHTML="";
	}

	error= validarMarca("", marca);
	if(error!=""){
		document.getElementById("erroresmarcavehiculo").className="error";
		document.getElementById("erroresmarcavehiculo").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresmarcavehiculo").className="";
		document.getElementById("erroresmarcavehiculo").innerHTML="";
	}

	error= validarModelo("", modelo);
	if(error!=""){
		document.getElementById("erroresmodelovehiculo").className="error";
		document.getElementById("erroresmodelovehiculo").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresmodelovehiculo").className="";
		document.getElementById("erroresmodelovehiculo").innerHTML="";
	}

  error= validarChasis("", chasis);
	if(error!=""){
		document.getElementById("erroreschasisvehiculo").className="error";
		document.getElementById("erroreschasisvehiculo").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroreschasisvehiculo").className="";
		document.getElementById("erroreschasisvehiculo").innerHTML="";
	}

  error= validarColor("", color);
	if(error!=""){
		document.getElementById("errorescolorvehiculo").className="error";
		document.getElementById("errorescolorvehiculo").innerHTML=error;
        res=false;
	}else{
		document.getElementById("errorescolorvehiculo").className="";
		document.getElementById("errorescolorvehiculo").innerHTML="";
	}

  error= validarKms("", kms);
	if(error!=""){
		document.getElementById("erroreskmsvehiculo").className="error";
		document.getElementById("erroreskmsvehiculo").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroreskmsvehiculo").className="";
		document.getElementById("erroreskmsvehiculo").innerHTML="";
	}
	return res;
}

function validarMatricula(error,matricula){
	if(matricula==""){
		error=error+"La matrícula no puede estar vacía";
	}
	return error;
}

function validarMarca(error, marca){
	if(marca==""){
		error=error+"La marca no puede estar vacía";
	}
	return error;
}

function validarModelo(error, modelo){
	if(modelo==""){
		error=error+"El modelo no puede estar vacío";
	}
	return error;
}

function validarChasis(error, chasis){
	if(chasis==""){
		error=error+"El chasis no puede estar vacío";
	}
	return error;
}

function validarColor(error, color){
	if(color==""){
		error=error+"El color no puede estar vacío";
	}
	return error;
}

function validarKms(error, kms){
	if(kms==""){
		error=error+"El kilometraje no puede estar vacío";
	}
	if(!validar_kms(kms)){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"El kilometraje debe estar formado únicamente por números";
	}
	return error;
}

function validar_kms(kms){
	if(kms.match(/^\d+$/)){
		return true;
	}else{
		return false;
	}
}
