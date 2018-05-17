function edicionVehiculo(){
	var res=true;
	var matricula = document.getElementById("MATRICULA").value;
	var marca = document.getElementById("MARCA").value;
	var modelo = document.getElementById("MODELO").value;
	var chasis = document.getElementById("CHASIS").value;
	var color = document.getElementById("COLOR").value;
	var kms = document.getElementById("KMS").value;
  var error="";
	error= validarMatricula(error, matricula);
  error= validarMarca(error, marca);
	error= validarModelo(error, modelo);
  error= validarChasis(error, chasis);
	error= validarColor(error, color);
	error= validarKms(error, kms);
	if(error!=""){
		document.getElementById("erroresedicionvehiculo").className="error";
		document.getElementById("erroresedicionvehiculo").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresedicionvehiculo").className="";
		document.getElementById("erroresedicionvehiculo").innerHTML="";
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
    if(error!=""){
			error=error+"<br>";
		}
		error=error+"La marca no puede estar vacía";
	}
	return error;
}

function validarModelo(error, modelo){
	if(modelo==""){
    if(error!=""){
			error=error+"<br>";
		}
		error=error+"El modelo no puede estar vacío";
	}
	return error;
}

function validarChasis(error, chasis){
	if(chasis==""){
    if(error!=""){
			error=error+"<br>";
		}
		error=error+"El chasis no puede estar vacío";
	}
	return error;
}

function validarColor(error, color){
	if(color==""){
    if(error!=""){
			error=error+"<br>";
		}
		error=error+"El color no puede estar vacío";
	}
	return error;
}

function validarKms(error, kms){
	if(kms==""){
    if(error!=""){
			error=error+"<br>";
		}
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
