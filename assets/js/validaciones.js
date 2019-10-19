const letrasNumEspacio = new RegExp(/^[\w\-\s]+$/ );
const validaUrl = new RegExp(/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/ );
const imgFormat=new RegExp(/\.(jpg|png|gif)$/i);
const soloNum=new RegExp(/^[0-9]+$/);
//k
const sololetras = new RegExp(/^[\u00F1A-Za-z _]*[\u00F1A-Za-z][\u00F1A-Za-z _]*$/);

const numDecimal=new RegExp(/^(0|[1-9]\d*)(\.\d+)?$/ );
const alphareg = /^[A-Za-z]*\s()[A-Za-z]*$/g;
const emailreg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
const expUsername=/^[a-z0-9ü][a-z0-9ü_]{3,15}$/;
const regexp_password = /^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{6,16}$/;
const regexobj=/^[a-zA-Z0-9üáéíóú][a-zA-Z0-9ü+ _áéíóú-]{3,30}$/;
const regexobjPrepare=/^[a-zA-Z0-9üáéíóú][a-zA-Z0-9ü+ _.,:;áéíóú-]{3,900}$/;

//k
function validarUsuarionuevo(data){
	let mensaje=[];
	let nombre= data.get("name");
	let apellido= data.get("lastname");
	let nombUsuario= data.get("username");
	let contrasenia= data.get("password");
	let telf= data.get("numtelf");
	let gender = data.get("gender");
	if(!nombre){
		mensaje.push("Debe ingresar su nombre.");
	}else
	if(!letrasNumEspacio.test(nombre)){
		mensaje.push("Debe ingresar su nombre.");
		if (!sololetras.test(nombre)) {
			mensaje.push("Debe ingresar un nombre válido.");
		}
	}
	if(!apellido){
		mensaje.push("Debe ingresar su apellido.");
	}else
	if(!letrasNumEspacio.test(apellido)){
		mensaje.push("Debe ingresar su apellido.");
		if (!sololetras.test(apellido)) {
			mensaje.push("Debe ingresar un apellido válido.");
		}
	}
	if(!nombUsuario){
		mensaje.push("Debe ingresar su nombre de usuario.");
	}else
	if(!expUsername.test(nombUsuario)){
		mensaje.push("Nombre de usuario: letras y números, rago de caracteres [3-15], símbolos permitidos [ _ ü ], no se admiten espacios");
	}
	if(!contrasenia){
		mensaje.push("Debe ingresar su contraseña.");
	}else{
		// if(!regexp_password.test(contrasenia)){
		// 	mensaje.push("La contraseña debe tener al entre 6 y 16 caracteres, al menos un dígito, al menos una minúscula, al menos una mayúscula y al menos un caracter no alfanumérico.");
		// }
	}
	if(telf || telf.length>0){
		if(!soloNum.test(telf)){
			mensaje.push("Debe ingresar un número de teléfono válido.");
		}else{
			if(telf.length!==10 && telf.length!==7)
				mensaje.push("El número de teléfono debe tener 10 dígitos para móvil y 7 para fijos.");
		}
	}
	if(!gender){
		mensaje.push("Seleccione su género.");
	}
	if(mensaje.length==0 || !mensaje)
		return true;
	return mensaje;
}



function validaFormBlog(data) {
	var nombre = data.get("nombre");
	var img    = data.get("imagen");
	var preparacion=data.get("preparacion");
	var ingredients=data.getAll("ingrediente[]");
	let imageAut = data.get("imagen-edit");
	var mensaje=[];
	// Recolección de datos
	if(nombre.length==0){
		mensaje.push("Escriba el nombre.")
	}else{
		if(!regexobjPrepare.test(nombre)){
			mensaje.push("Nombre no es válido")
			
		}
	}

	if(ingredients.length <2)
		mensaje.push("Agrege por lo menos 2 ingredientes.")
	for(var ingredient of ingredients){
		if(ingredient==""){
			mensaje.push("Los campos de ingredientes no deben estar vacíos.")
			break;
		}
		if(!letrasNumEspacio.test(ingredient)){
			mensaje.push("Sólo se permite numeros letras y espacios en los campos de ingredientes.")
			break;
		}
	}
	var socialLink=data.getAll("input-social[]");
	for(var socialUrl of socialLink){
		if(!validaUrl.test(socialUrl)){
			mensaje.push("Los campos de redes sociales habilitadas no deben estar vacíos o deben tener una dirección de url pegada.")
			break;
		}
	}

	// Validaciones
	if(!regexobjPrepare.test(preparacion))
		mensaje.push("Preparación: Caracteres no permitidos o excede la su longitud (max->900)");
	if(!imageAut){
		if(!img.name || img.name.length==0)
			mensaje.push("Inserte una imagen");
		else if(!imgFormat.test(img.name))
			mensaje.push("Formato de archivo no es correcto");
	}


	if(mensaje.length==0 || !mensaje)
		return true;
	return mensaje;
}

function validaFormEventos(data) {
	var asunto = data.get("asunto");
	var fecha    = data.get("fecha");
	var inHour=data.get("inHour");
	var outHour=data.get("outHour");
	var comentario=data.get("comentario");
	var mensaje=[];
	if(fecha){
		fecha=fecha.split("-");
		var fechaCompare = new Date(parseInt(fecha[0])//año
								,parseInt(fecha[1]-1),//mes
								parseInt(fecha[2]));//dia

		//Comprobamos si existe la fecha
		if (isNaN(fechaCompare)){
			mensaje.push("La fecha es incorrecta");
		}else{
			if(fechaCompare<= new Date())
				mensaje.push("La reservación debe hacerce con anticipación");
			else if(fechaCompare.getDay()==0){
				mensaje.push("La reservación no puede hacerse los domingos.");
			}
		}
	}
	if(comentario!=""){
		if(!regexobj.test(comentario))
			mensaje.push("Sólo se permiten letras, números y espacios en el campo de comentario, cantidad de letras [4-30], o puede dejar el campo vacío.");
	}
	if(inHour==outHour){
		mensaje.push("La hora de entrada no puede ser la misma de la salida.");
	}
	if(!soloNum.test(inHour)){
		mensaje.push("La hora de entrada tiene que ser numérica");
	}else if(inHour<7){
		mensaje.push("La hora de entrada no puede ser menor a 7");
	}
	if(!soloNum.test(outHour)){
		mensaje.push("La hora de salida tiene que ser numérica");
	}else if(outHour>17){
		mensaje.push("La hora de salida no puede ser mayor a 5");
	}

	if(!letrasNumEspacio.test(asunto))
		mensaje.push("Nombre del asunto no es válido");

	if(mensaje.length==0 || !mensaje)
		return true;
	return mensaje;
}

function validarMenu(data){
	var ctg = data.get("ctg");
	var type_food    = data.get("type_food");
	var nombre=data.get("nombre");
	var precio=data.get("precio");
	var horario=data.get("horario");
	var descripcion=data.get("descripcion");
	var mensaje=[];
	
	if(!nombre)
		mensaje.push("Ingrese el nombre");
	else if(!regexobj.test(nombre))
		mensaje.push("El nombre tiene caracteres no permitidos o excede los 15 caracteres permitidos");

	if(descripcion=="")
		mensaje.push("Ingrese la descripción");
	else
	if(!regexobj.test(descripcion))
		mensaje.push("La descripción tiene caracteres no permitidos o excede los 30 caracteres permitidos");
	
	if(ctg==0)
		mensaje.push("Seleccione la categoría");

	if(type_food==0)
		mensaje.push("Seleccione un tipo de comida");
	if(!horario)
		mensaje.push("Marque una casilla del horario");
	
	if(!numDecimal.test(precio))
		mensaje.push("Valor no está permitido");
	else{
		if(precio>1000){
			mensaje.push("No exceda el precio!!");
		}
	}
	 if(mensaje.length==0 || !mensaje)
	 	return true;
	 return mensaje;
}

function validarContacto(){
	removeErr("#panelErr");
	var mensaje=[];
	var nombre=document.querySelector("input[name='nombre']");
	var mail=document.querySelector("input[name='mail']");
	var asunto=document.querySelector("input[name='asunto']");
	var mensaje__=document.querySelector("textarea[name='mensaje']");
	
	if(!letrasNumEspacio.test(nombre.value))
		mensaje.push("* Ingrese sólo caracteres válidos para el nombre y el apellido");

	
	if(!emailreg.test(mail.value))
		mensaje.push("* Correo erroneo");
	if(!letrasNumEspacio.test(asunto.value))
		mensaje.push("* Sólo se permite letras y espacios en el Asunto");
	if(mensaje__.value.length==0 || !mensaje__.value )
		mensaje.push("* Error en el mensaje a enviar");
	if(mensaje.length==0 || !mensaje)
	 	return true;
	errorMessage("#panelErr", mensaje);
	addClass("#error","active");
	 return false;

}

