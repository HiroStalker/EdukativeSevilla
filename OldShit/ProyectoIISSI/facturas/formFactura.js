function procesarFactura(){
	var res=true;
	var rmid = document.getElementById("rm_id").value;
	var preciototal = document.getElementById("preciototal").value;
	
	var error= validarRmid("", rmid);
	
	if(error!=""){
		document.getElementById("erroresrmidfactura").className="error";
		document.getElementById("erroresrmidfactura").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresrmidfactura").className="";
		document.getElementById("erroresrmidfactura").innerHTML="";
	}

	error= validarPrecioTotal("", preciototal);
	if(error!=""){
		document.getElementById("errorespreciototalfactura").className="error";
		document.getElementById("errorespreciototalfactura").innerHTML=error;
        res=false;
	}else{
		document.getElementById("errorespreciototalfactura").className="";
		document.getElementById("errorespreciototalfactura").innerHTML="";
	}

	return res;
}

function validarRmid(error,rmid){
	if(rmid=="-1"){
		error=error+"Debe seleccionar una reparación para poder continuar";
	}
	return error;
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
