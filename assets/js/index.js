// "use strict";
// https://codepen.io/darielnoel/full/EdueI/  notificacion
// https://codepen.io/darielnoel/full/qvGEb/
const url="http://127.0.0.1:81/aplicationRestaurantGuaye/";
const panelModal=document.getElementById("windowModal");
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
function createElement(_name,_attributes, inner) {
	var node=document.createElement(_name);
	//compureba si el atributo tiene valores
	if(_attributes){
		let keys=Object.keys(_attributes);
		let values=Object.values(_attributes);
		for (let index = 0; index < keys.length; index++) {
			node.setAttribute(keys[index],values[index]);
		}
	}
	//comprueba si el atriuto tiene valores
	if(inner)
		node.innerHTML=inner;
	return node;
}

// function errorMessage(_element, message){
// 	if(message.length==0)
// 	return;
// 	var element=document.querySelector(_element);

// 	if(_element!=null && _element!=undefined) {
// 		element.appendChild(createElement("p",[["class","txt-center err-tittle"]], "Hay errores en los  datos ingresados"));
// 		for(var value of message){
// 			var p =createElement("p",null, value);
// 			element.appendChild(p);
// 		}
// 	}
// }
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



// Load animations
function animationCharge(element) {
	if(!element)return false;
    element.setAttribute('disabled','disabled');
	element.innerHTML=
		`
    		<div class="dot dot1"></div>
			<div class="dot dot2"></div>
			<div class="dot dot3"></div>`;
	  return true;
}

function animationChargeRemove(element,content) {
	if(!element)return false;
    element.removeAttribute('disabled');
	element.innerHTML=content
	return true;
}

function animationLoad(element, w, h) {
	if(!element)return false;
	element.setAttribute('disabled','disabled');
	element.style.border="1px solid var(--color-btn)";
	element.style.background="white";

	element.innerHTML= `<div class="load" style="whith:${w};height=${h}">
		<hr class="load-c"/><hr class="load-c"/><hr class="load-c"/><hr class="load-c"/>
	  </div>`;
	  return true;
}
function animationLoadRemove(element,content) {
	if(!element)return false;
	element.style.border="initial";
	element.style.background="var(--color-btn)";
    element.removeAttribute('disabled');
	element.innerHTML=content
	return true;
}

// 

var videoEl = document.querySelector('video');
if(videoEl){
	document.querySelector('.video-button').addEventListener('click', 
																function(){
	  if(this.dataset.aperture === 'open') {
		this.dataset.aperture = 'closed';
		videoEl.pause();
		videoEl.progress = 0;
	  } else {
		this.dataset.aperture = 'open';
		videoEl.play();
	  }
	});
}




let delay = 200;
activeOptionsBlogBtn=(btnToggle)=>{
	if(!btnToggle.curStep)btnToggle.curStep=0;
	if(!btnToggle.open)btnToggle.open=false;
	
	let buttons=btnToggle.parentNode;

	if (!btnToggle.open) animate(btnToggle,buttons);
	else {
		buttons.classList.remove("step-1");
		buttons.classList.remove("step-0");
		buttons.classList.remove("step-3");
		buttons.classList.remove("step-2");
		buttons.classList.remove("activate" );  
		clearTimeout(btnToggle.lastTimeout);
		btnToggle.open = false;
		btnToggle.curStep = 0;
	}
}

function animate(btnToggle,buttons) {
    if (btnToggle.curStep >= 4) {
		btnToggle.curStep = 0;
      return;
    }
    btnToggle.open = true;
    setStep( buttons, btnToggle.curStep);    
    btnToggle.curStep++;
    btnToggle.lastTimeout = setTimeout(animate(btnToggle,buttons), delay);
}

function setStep(buttons, curStep) {    
	buttons.classList.remove("step-1");
	buttons.classList.remove("step-0");
	buttons.classList.remove("step-3");
	buttons.classList.remove("step-2");
	buttons.classList.add("activate" );  
	buttons.classList.add("step-" + curStep);  

}


// $('.allRecipes').masonry({
// 	// options
// 	itemSelector: '.recipe-item',
// 	columnWidth: 200
// });