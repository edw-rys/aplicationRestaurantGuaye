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
function validarUsuarionuevo(){
	var mensaje=[];
	removeErr("#panelErr");
	var nombre=document.querySelector("input[name='name']");
	var apellido=document.querySelector("input[name='lastname']");
	var nombUsuario=document.querySelector("input[name='username']");
	var contrasenia=document.querySelector("input[name='password']");
	var telf=document.querySelector("input[name='numtelf']");
	if(!nombre.value){
		mensaje.push("Debe ingresar su nombre.");
	}else
	if(!letrasNumEspacio.test(nombre.value)){
		mensaje.push("Debe ingresar su nombre.");
		if (!sololetras.test(nombre.value)) {
			mensaje.push("Debe ingresar un nombre válido.");
		}
	}
	if(!apellido.value){
		mensaje.push("Debe ingresar su apellido.");
	}else
	if(!letrasNumEspacio.test(apellido.value)){
		mensaje.push("Debe ingresar su apellido.");
		if (!sololetras.test(apellido.value)) {
			mensaje.push("Debe ingresar un apellido válido.");
		}
	}
	if(!nombUsuario.value){
		mensaje.push("Debe ingresar su nombre de usuario.");
	}else
	if(!expUsername.test(nombUsuario.value)){
		mensaje.push("Nombre de usuario: letras y números, rago de caracteres [3-15], símbolos permitidos [ _ ü ], no se admiten espacios");
	}
	if(!contrasenia.value){
		mensaje.push("Debe ingresar su contraseña.");
	}else{
		if(!regexp_password.test(contrasenia.value)){
			mensaje.push("La contraseña debe tener al entre 6 y 16 caracteres, al menos un dígito, al menos una minúscula, al menos una mayúscula y al menos un caracter no alfanumérico.");
		}
	}
	if(!telf.value){
		mensaje.push("Debe ingresar su número de teléfono");
	}else{
		if(!soloNum.test(telf.value)){
		mensaje.push("Debe ingresar un número de teléfono válido.");
		}else{
			if(telf.value.length!==10 && telf.value.length!==7)
				mensaje.push("El número de teléfono debe tener 10 dígitos para móvil y 7 para fijos.");
		// console.log(typeof(telf.value))
		}
	}
	errorMessage("#panelErr", mensaje);
	if(mensaje.length==0 || !mensaje)
		return true;
		addClass("#error","active");
	return false;
}



function validaFormBlog(data) {
	var nombre = data.get("nombre");
	var img    = data.get("imagen");
	var preparacion=data.get("preparacion");
	var ingredients=data.getAll("ingrediente[]");
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

	if(!img.name || img.name.length==0)
		mensaje.push("Inserte una imagen");
	else if(!imgFormat.test(img.name))
		mensaje.push("Formato de archivo no es correcto");


	if(mensaje.length==0 || !mensaje)
		return true;
	return mensaje;
}

function validaFormEventos() {
	var asunto=document.querySelector("input[name='asunto']");
	var fecha=document.querySelector("input[name='fecha']");
	var inHour=document.querySelector("input[name='inHour']");
	var outHour=document.querySelector("input[name='outHour']");
	var comentario=document.querySelector("textarea[name='comentarios']");
	removeErr("#panelErr");
	var mensaje=[];
	queryScheduleEvent(fecha.value, inHour.value, outHour.value)
	if(fecha){
		fecha=fecha.value.split("-");
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
	if(comentario.value!=""){
		if(!regexobj.test(comentario.value))
			mensaje.push("Sólo se permiten letras, números y espacios en el campo de comentario, cantidad de letras [4-30], o puede dejar el campo vacío.");
	}
	if(inHour.value==outHour.value){
		mensaje.push("La hora de entrada no puede ser la misma de la salida.");
	}
	if(!soloNum.test(inHour.value)){
		mensaje.push("La hora de entrada tiene que ser numérica");
	}else if(inHour.value<7){
		mensaje.push("La hora de entrada no puede ser menor a 7");
	}
	if(!soloNum.test(outHour.value)){
		mensaje.push("La hora de salida tiene que ser numérica");
	}else if(outHour.value>17){
		mensaje.push("La hora de salida no puede ser mayor a 5");
	}

	if(!letrasNumEspacio.test(asunto.value))
		mensaje.push("Nombre del asunto no es válido");

	errorMessage("#panelErr", mensaje);

	errPanel=document.querySelector("#panelErr");
	if(errPanel.children.length<1){
		console.log("Valido");
		return true;
	}
	console.log("NO Valido");
	addClass("#error","active");

	return false;
}

function validarMenu(){
	removeErr("#panelErr");
	var mensaje=[];
	var ctg=document.querySelector("select[name='ctg']");
	var type_food=document.querySelector("select[name='type_food']");
	var nombre=document.querySelector("input[name='nombre']");
	var precio=document.querySelector("input[name='precio']");
	var horario=document.querySelectorAll("input[name='horario']");
	var descripcion=document.querySelector("textarea[name='descripcion']");
	
	if(!nombre.value)
		mensaje.push("Ingrese el nombre");
	else if(!regexobj.test(nombre.value))
		mensaje.push("El nombre tiene caracteres no permitidos o excede los 15 caracteres permitidos");

	if(descripcion.value=="")
		mensaje.push("Ingrese la descripción");
	else
	if(!regexobj.test(descripcion.value))
		mensaje.push("La descripción tiene caracteres no permitidos o excede los 30 caracteres permitidos");
	
	if(ctg.value==0)
		mensaje.push("Seleccione la categoría");

	if(type_food.value==0)
		mensaje.push("Seleccione un tipo de comida");
	if(!horario[0].checked && !horario[1].checked)
		mensaje.push("Marque una casilla del horario");
	
	if(!numDecimal.test(precio.value))
		mensaje.push("Valor no está permitido");
	else{
		if(precio.value>1000){
			mensaje.push("No exceda el precio!!");
		}
	}
	errorMessage("#panelErr", mensaje);
	 if(mensaje.length==0 || !mensaje)
	 	return true;
		 addClass("#error","active");
	 return false;
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

function logInNotNull() {
	username=document.querySelector("input[name='user']");
	password=document.querySelector("input[name='password']");
	var mensaje=[];
	if(!username.value)
		mensaje.push("* Ingrese su nombre usuario");
	if(!password.value)
		mensaje.push("* Ingrese su contraseña");
	if(mensaje.length==0 || !mensaje)
	 	return true;
	errorMessage("#panelErr", mensaje);
	addClass("#error","active");
	 return false;
}

