const index=this;
var toggle=(_selector, _class)=>{
	var element=document.querySelector(_selector);
	if(!element)return false;
	
	element.classList.toggle(_class);
	return true;
}
function addClass(_selector, _class){
	var element=document.querySelector(_selector);
	if(!element)return false;
	
	element.classList.add(_class);
	return true;
}
function removeClass(_selector, _class){
	var element=document.querySelector(_selector);
	if(!element)return false;
	
	element.classList.remove(_class);
	return true;
}

const nav=document.querySelector('.navigation')
const btnScollUp=document.querySelector('.btn-up');


//crea elementos( nombre del elemento, arreglo atributos, text)
function createElement(_name,_atr, inner) {
	var node=document.createElement(_name);
	//compureba si el atributo tiene valores
	if(_atr)
		for(var a of _atr)
			node.setAttribute(a[0],a[1]);
	//comprueba si el atriuto tiene valores
	if(inner)
		node.innerHTML=inner;
	return node;
}




function errorMessage(_element, message){
	if(message.length==0)
	return;
	var element=document.querySelector(_element);

	if(_element!=null && _element!=undefined) {
		element.appendChild(createElement("p",[["class","txt-center err-tittle"]], "Hay errores en los  datos ingresados"));
		for(var value of message){
			var p =createElement("p",null, value);
			element.appendChild(p);
		}
	}
}
function addElementPanel(queryPanel, value){
	if(value.length==0)
	return;
	var element = document.querySelector(queryPanel);
	if(element!=null && element!=undefined) {
		element.appendChild(createElement("p",null, value));
	}
}
function removeErr(_element){
	var element=document.querySelector(_element);
	if(element.children==0) return false;
	while(element.hasChildNodes())
		element.removeChild(element.firstChild);
}


function panelClose(_query,_class,_queryChildren){
	removeClass(_query,_class);
	removeErr(_queryChildren);
}



window.onscroll = function() {
	if(!nav) return;
	if(window.scrollY>100){
		nav.style.background="white";
	}else{
		nav.style.background="transparent";
	}
}
