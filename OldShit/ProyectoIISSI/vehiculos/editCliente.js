function edicionCliente(){
	var res=true;
	var nombre = document.getElementById("NOMBRE").value;
	var apellidos = document.getElementById("APELLIDOS").value;
	var dni = document.getElementById("DNI").value;
	var direccion = document.getElementById("DIRECCION").value;
	var poblacion = document.getElementById("POBLACION").value;
	var codigopostal = document.getElementById("CODIGOPOSTAL").value;
	var telefono = document.getElementById("TELEFONO").value;
	var numerocuenta = document.getElementById("NUMEROCUENTA").value;
	var tipocliente=document.getElementById("TIPOCLIENTE").value;
	var edad = document.getElementById("EDAD").value;
 	var numeroimpagos= document.getElementById("NUMEROIMPAGOS").value;

  	var error="";
	error= validarNombre(error, nombre);
	error= validarApellidos(error, apellidos);
	error= validarDni(error, dni);
	error= validarDireccion(error, direccion);
	error= validarPoblacion(error, poblacion);
	error= validarCodigoPostal(error, codigopostal);
	error= validarTelefono(error, telefono);
	error= validarNumeroCuenta(error, numerocuenta, tipocliente);
	error= validarEdad(error, edad);

	if(error!=""){
		document.getElementById("erroresedicioncliente").className="error";
		document.getElementById("erroresedicioncliente").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresedicioncliente").className="";
		document.getElementById("erroresedicioncliente").innerHTML="";
	}

	return res;
}

function validarNombre(error,nombre){
	if(nombre==""){
		error=error+"El nombre no puede estar vacío";
	}
	return error;
}

function validarApellidos(error, apellidos){
	if(apellidos==""){
    	if(error!=""){
			error=error+"<br>";
		}
		error=error+"Los apellidos no pueden estar vacíos";
	}
	return error;
}

function validarDni(error, dni){
	if(dni==""){
    	if(error!=""){
			error=error+"<br>";
		}
		error=error+"El dni no puede estar vacío";
	}
	if(!validar_dni(dni)){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"El dni no es válido";
	}
	return error;
}

function validar_dni(dni){
	if(dni.length!=9){
		return false;
	}else{
		var tabla = new Array("T","R","W","A","G","M","Y","F","P","D","X","B","N","J","Z","S","Q","V","H","L","C","K","E");
		var numeros= dni.substring(0,8);
		var letra= dni.substring(8,9);
		var modulo = numeros % 23;
		var lr = tabla[modulo];
		if(letra==lr){
			return true;
		}else{
			return false;
		}
	}
}

function validarDireccion(error, direccion){
	if(direccion==""){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"La direccion no puede estar vacía";
	}
	return error;
}

function validarPoblacion(error, poblacion){
	if(poblacion==""){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"La poblacion no puede estar vacía";
	}
	return error;
}

function validarCodigoPostal(error, codigopostal){
	if(codigopostal==""){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"El código postal no puede estar vacío";
	}
	if(!validar_codigopostal(codigopostal)){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"El código postal debe estar formado 5 dígitos";
	}
	return error;
}

function validar_codigopostal(codigopostal){
	if(codigopostal.length!=5){
		return false;
	}else{
		if(codigopostal.match(/^\d+$/)){
			return true;
		}else{
			return false;
		}
	}
}

function validarTelefono(error, telefono){
	if(telefono==""){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"El teléfono no puede estar vacío";
	}
	if(!validar_telefono(telefono)){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"El teléfono debe estar formado por 9 dígitos";
	}
	return error;
}

function validar_telefono(telefono){
	if(telefono.length!=9){
		return false;
	}else{
		if(telefono.match(/^\d+$/)){
			return true;
		}else{
			return false;
		}
	}
}

function validarNumeroCuenta(error, numerocuenta, tipocliente){
	if(numerocuenta=="" && tipocliente=="EMPRESA"){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"El número de cuenta bancaria no puede estar vacío si el cliente es una empresa";
	}
	if(!validar_numerocuenta(numerocuenta, tipocliente)){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"El número de cuenta bancario debe estar formado 22 dígitos";
	}
	return error;
}

function validar_numerocuenta(numerocuenta, tipocliente){
	if((tipocliente=="PARTICULAR" && (numerocuenta.length==22 || numerocuenta.length==0)) || (tipocliente=="EMPRESA" && (numerocuenta.length==22))){
		if(numerocuenta.match(/^\d+$/) || numerocuenta.length==0){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

function validarEdad(error, edad){
	if(edad==""){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"La edad no puede estar vacía";
	}
	if(!validar_edad(edad)){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"La edad debe estar formada únicamente por números y debe ser mayor de edad (+18 años)";
	}
	return error;
}

function validar_edad(edad){
	//if(!edad.match(/^\d+$/)){
	if(Number(edad)==NaN){
		return false;
	}else{
		if(Number(edad)>=18){
			return true;
		}else{
			return false;
		}
	}
}

function incrementaImpagos(){
  var impagos = document.getElementById("NUMEROIMPAGOS").value;
  //document.getElementById("NUMEROIMPAGOS").value="";
  var imp= parseInt(impagos)+1;
  document.getElementById("NUMEROIMPAGOS").value=imp;
  document.getElementById("imp").innerHTML=imp;
}

function incrementaVisitas(){
  var visitas = document.getElementById("VISITAS").value;
  //document.getElementById("VISITAS").value="";
  var vis= parseInt(visitas)+1;
  document.getElementById("VISITAS").value=vis;
  document.getElementById("vis").innerHTML=vis;
}
