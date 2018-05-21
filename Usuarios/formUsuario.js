function procesarUsuario(){
	var res=true;
	var nombre= document.getElementByID("nombre").value;
	var apellidos = document.getElementByID("apellidos").value;
	var dni = document.getElementByID("dni").value;
	var direccion = document.getElementByID("direccion").value;
	var poblacion = document.getElementByID("poblacion").value;
	var numerodecuenta = document.getElementByID("numerodecuenta").value;
	var codigopostal = document.getElementByID("codigopostal").value;
	var telefono = document.getElementByID("telefono").value;
	var numerodeimpagos = document.getElementByID("numerodeimpagos").value;
	var tipousuario = document.getElementByID("tipousuario").value;
	var morosidad = document.getElementByID("morosidad").value;

	var error= validarNombre("", nombre);
	if(error!=""){
		document.getElementByID("erroresnombreusuario").className="error";
		document.getElementByID("erroresnombreusuario").innerHTML=error;
		res = false;
	}else{
		document.getElementByID("erroresnombreusuario").className="";
		document.getElementByID("erroresnombreusuario").innerHTML="";
	}
	 error= validarApellidos("", apellidos);
	if(error!=""){
		document.getElementByID("erroresapellidosusuario").className="error";
		document.getElementByID("erroresapelliodosusuario").innerHTML=error;
		res = false;
	}else{
		document.getElementByID("erroresapellidosusuario").className="";
		document.getElementByID("erroresapellidosusuario").innerHTML="";
	}
	 error= validarDni("", dni);
	if(error!=""){
		document.getElementByID("erroresdnisusuario").className="error";
		document.getElementByID("erroresdniusuario").innerHTML=error;
		res = false;
	}else{
		document.getElementByID("erroresdniusuario").className="";
		document.getElementByID("erroresdniusuario").innerHTML="";
	}
	error= validardireccion("",direccion);
	if(error!=""){
		document.getElementByID("erroresdireccionusuario").className="error";
		document.getElementByID("erroresdireccionusuario").innerHTML=error;
		res = false;
	}else{
		document.getElementByID("erroresdireccionusuario").className="";
		document.getElementByID("erroresdireccionusuario").innerHTML="";
	}
	 error= validarpoblacion("",poblacion);
	if(error!=""){
		document.getElementByID("errorespoblacionusuario").className="error";
		document.getElementByID("errorespoblacionusuario").innerHTML=error;
		res = false;
	}else{
		document.getElementByID("errorespoblacionusuario").className="";
		document.getElementByID("errorespoblacionusuario").innerHTML="";
	}
	 error= validarnumerodecuanta("",numerodecuenta, tipousuario);
	if(error!=""){
		document.getElementByID("erroresnumerodecuentausuario").className="error";
		document.getElementByID("erroresnumerodecuentausuario").innerHTML=error;
		res = false;
	}else{
		document.getElementByID("erroresnumerodecuentausuario").className="";
		document.getElementByID("erroresnumerodecuentausuario").innerHTML="";
	}
	 error= validarcodigopostal("",codigopostal);
	if(error!=""){
		document.getElementByID("errorescodigopostalusuario").className="error";
		document.getElementByID("errorescodigopostalusuario").innerHTML=error;
		res = false;
	}else{
		document.getElementByID("errorescodigopostalusuario").className="";
		document.getElementByID("errorescodigopostalusuario").innerHTML="";
	}
	error= validarTelefono("", telefono);
	if(error!=""){
		document.getElementById("errorestelefonousuario").className="error";
		document.getElementById("errorestelefonousuario").innerHTML=error;
        res=false;
	}else{
		document.getElementById("errorestelefonousuario").className="";
		document.getElementById("errorestelefonousuario").innerHTML="";
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
function validarNumeroDECuenta(error, numerodecuenta, tipousuario){
	if(numerodecuenta=="" && tipousuario=="EMPRESA"){
		error=error+"El número de cuenta bancaria no puede estar vacío si el usuario es una empresa";
	}
	if(!validar_numerocdeuenta(numerodecuenta, tipousuario)){
		if(error!=""){
			error=error+"<br>";
		}
		error=error+"El número de cuenta bancario debe estar formado 22 dígitos";
	}
	return error;
}

function validar_numerodecuenta(numerodecuenta, tipousuario){
	if((tipousuario=="PARTICULAR" && (numerodecuenta.length==22 || numerodecuenta.length==0)) || (tipousuario=="EMPRESA" && (numerodecuenta.length==22))){
		if(numerodecuenta.match(/^\d+$/) || numerodecuenta.length==0){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}