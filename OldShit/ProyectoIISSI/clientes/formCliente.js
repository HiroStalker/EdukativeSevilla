function procesarCliente(){
	var res=true;
	var nombre = document.getElementById("nombre").value;
	var apellidos = document.getElementById("apellidos").value;
	var dni = document.getElementById("dni").value;
	var direccion = document.getElementById("direccion").value;
	var poblacion = document.getElementById("poblacion").value;
	var codigopostal = document.getElementById("codigopostal").value;
	var telefono = document.getElementById("telefono").value;
	var numerocuenta = document.getElementById("numerocuenta").value;
	var tipocliente = document.getElementById("tipocliente").value;
	var edad = document.getElementById("edad").value;
	
	var error= validarNombre("", nombre);
	if(error!=""){
		document.getElementById("erroresnombrecliente").className="error";
		document.getElementById("erroresnombrecliente").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresnombrecliente").className="";
		document.getElementById("erroresnombrecliente").innerHTML="";
	}
	
	error= validarApellidos("", apellidos);
	if(error!=""){
		document.getElementById("erroresapellidoscliente").className="error";
		document.getElementById("erroresapellidoscliente").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresapellidoscliente").className="";
		document.getElementById("erroresapellidoscliente").innerHTML="";
	}
	
	error= validarDni("", dni);
	if(error!=""){
		document.getElementById("erroresdnicliente").className="error";
		document.getElementById("erroresdnicliente").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresdnicliente").className="";
		document.getElementById("erroresdnicliente").innerHTML="";
	}
	
	error= validarDireccion("", direccion);
	if(error!=""){
		document.getElementById("erroresdireccioncliente").className="error";
		document.getElementById("erroresdireccioncliente").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresdireccioncliente").className="";
		document.getElementById("erroresdireccioncliente").innerHTML="";
	}
	
	error= validarPoblacion("", poblacion);
	if(error!=""){
		document.getElementById("errorespoblacioncliente").className="error";
		document.getElementById("errorespoblacioncliente").innerHTML=error;
        res=false;
	}else{
		document.getElementById("errorespoblacioncliente").className="";
		document.getElementById("errorespoblacioncliente").innerHTML="";
	}
	
	error= validarCodigoPostal("", codigopostal);
	if(error!=""){
		document.getElementById("errorescodigopostalcliente").className="error";
		document.getElementById("errorescodigopostalcliente").innerHTML=error;
        res=false;
	}else{
		document.getElementById("errorescodigopostalcliente").className="";
		document.getElementById("errorescodigopostalcliente").innerHTML="";
	}
	
	error= validarTelefono("", telefono);
	if(error!=""){
		document.getElementById("errorestelefonocliente").className="error";
		document.getElementById("errorestelefonocliente").innerHTML=error;
        res=false;
	}else{
		document.getElementById("errorestelefonocliente").className="";
		document.getElementById("errorestelefonocliente").innerHTML="";
	}
	
	error= validarNumeroCuenta("", numerocuenta, tipocliente);
	if(error!=""){
		document.getElementById("erroresnumerocuentacliente").className="error";
		document.getElementById("erroresnumerocuentacliente").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresnumerocuentacliente").className="";
		document.getElementById("erroresnumerocuentacliente").innerHTML="";
	}
	
	error= validarEdad("", edad);
	if(error!=""){
		document.getElementById("erroresedadcliente").className="error";
		document.getElementById("erroresedadcliente").innerHTML=error;
        res=false;
	}else{
		document.getElementById("erroresedadcliente").className="";
		document.getElementById("erroresedadcliente").innerHTML="";
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
		error=error+"Los apellidos no pueden estar vacíos";
	}
	return error;
}

function validarDni(error, dni){
	if(dni==""){
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
		error=error+"La direccion no puede estar vacía";
	}
	return error;
}

function validarPoblacion(error, poblacion){
	if(poblacion==""){
		error=error+"La poblacion no puede estar vacía";
	}
	return error;
}

function validarCodigoPostal(error, codigopostal){
	if(codigopostal==""){
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
	if(!edad.match(/^\d+$/)){
		return false;
	}else{
		if(parseInt(edad)>=18){
			return true;
		}else{
			return false;
		}
	}
}

