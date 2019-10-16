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
function addClass(element , class_){
	if(!element || !class_)return false;
	let classes= class_.split(" ");
	classes.forEach(_class_ => {
		element.classList.add(_class_);
	});
	return true;
}
function removeClass(element , class_){
	if(!element || !class_)return false;
	let classes= class_.split(" ");
	classes.forEach(_class_ => {
		element.classList.remove(_class_);
	});
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

function getHTML(text){
	if(!text)return false;
	let dom=new DOMParser();
	let elementHTML = dom.parseFromString(text, "text/html");
	return elementHTML.querySelector("body").firstChild;
}
function addElementPanel(queryPanel, value){
	if(value.length==0)
	return;
	var element = document.querySelector(queryPanel);
	if(element!=null && element!=undefined) {
		element.appendChild(createElement("p",null, value));
	}
}





window.onscroll = function() {
	if(!nav) return;
	if(window.scrollY>100){
		nav.style.background="white";
	}else{
		nav.style.background="transparent";
	}
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
		removeClass(buttons,"step-1 step-0 step-3 step-2 activate");
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
	removeClass(buttons,"step-1 step-0 step-3 step-2");
	addClass(buttons, "activate");
	buttons.classList.add("step-" + curStep);  

}



// Animations Load

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
function loading_1(elementContainer ) {
	if(!element)return false;
    element.setAttribute('disabled','disabled');
	element.innerHTML=
		`
		<div class="load-1">
			<div class="line"></div>
			<div class="line"></div>
			<div class="line"></div>
        </div>
		`;
	  return true;
}
function loading_1_close(elementContainer , content) {
	if(!element)return false;
    element.removeAttribute('disabled');
	element.innerHTML=content
	return true;
}
function loading_2(elementContainer ) {
	if(!element)return false;
    element.setAttribute('disabled','disabled');
	element.innerHTML=
		`
		<div class="load-2">
			<div class="line"></div>
			<div class="line"></div>
			<div class="line"></div>
		</div>
		`;
	  return true;
}
function loading_2_close(elementContainer , content) {
	if(!element)return false;
    element.removeAttribute('disabled');
	element.innerHTML=content
	return true;
}

function loading_3(elementContainer ) {
	if(!element)return false;
    element.setAttribute('disabled','disabled');
	element.innerHTML=
		`
		<div class="load-3">
			<div class="line"></div>
			<div class="line"></div>
			<div class="line"></div>
		</div>
		`;
	  return true;
}
function loading_3_close(elementContainer , content) {
	if(!elementContainer)return false;
    elementContainer.removeAttribute('disabled');
	elementContainer.innerHTML=content
	return true;
}
function loading_4(elementContainer ) {
	if(!elementContainer)return false;
    elementContainer.setAttribute('disabled','disabled');
	elementContainer.innerHTML=
		`
		<div class="load-4">
			<div class="ring-1"></div>
		</div>
		`;
	return true;
}
function loading_4_close(elementContainer , content) {
	if(!elementContainer)return false;
    elementContainer.removeAttribute('disabled');
	elementContainer.innerHTML=content
	return true;
}
function loading_5(elementContainer ) {
	if(!elementContainer)return false;
    elementContainer.setAttribute('disabled','disabled');
	elementContainer.innerHTML=
		`
		<div class="load-5">
			<div class="ring-2">
				<div class="ball-holder">
					<div class="ball"></div>
				</div>
			</div>
		</div>
		`;
	return true;
}
function loading_5_close(elementContainer , content) {
	if(!elementContainer)return false;
    elementContainer.removeAttribute('disabled');
	elementContainer.innerHTML=content
	return true;
}
function loading_6(elementContainer ) {
	if(!elementContainer)return false;
    elementContainer.setAttribute('disabled','disabled');
	elementContainer.innerHTML=
		`
		<div class="load-6">
			<div class="letter-holder">
				<div class="l-1 letter">L</div>
				<div class="l-2 letter">o</div>
				<div class="l-3 letter">a</div>
				<div class="l-4 letter">d</div>
				<div class="l-5 letter">i</div>
				<div class="l-6 letter">n</div>
				<div class="l-7 letter">g</div>
				<div class="l-8 letter">.</div>
				<div class="l-9 letter">.</div>
				<div class="l-10 letter">.</div>
			</div>
		</div>
		`;
	  return true;
}
function loading_6_close(elementContainer , content) {
	if(!elementContainer)return false;
    elementContainer.removeAttribute('disabled');
	elementContainer.innerHTML=content
	return true;
}
function loading_7(elementContainer ) {
	if(!elementContainer)return false;
    elementContainer.setAttribute('disabled','disabled');
	elementContainer.innerHTML=
		`
		<div class="load-7">
			<div class="square-holder">
				<div class="square"></div>
			</div>
		</div>
		`;
	  return true;
}
function loading_7_close(elementContainer , content) {
	if(!elementContainer)return false;
    elementContainer.removeAttribute('disabled');
	elementContainer.innerHTML=content
	return true;
}

function loading_8(elementContainer ) {
	if(!elementContainer)return false;
    elementContainer.setAttribute('disabled','disabled');
	elementContainer.innerHTML=
		`
		<div class="load-8">
			<div class="line"></div>
		</div>
		`;
	  return true;
}
function loading_8_close(elementContainer , content) {
	if(!elementContainer)return false;
    elementContainer.removeAttribute('disabled');
	elementContainer.innerHTML=content
	return true;
}
function loading_9(elementContainer ) {
	if(!elementContainer)return false;
    elementContainer.setAttribute('disabled','disabled');
	elementContainer.innerHTML=
	`
	<div class="load-9">
		<div class="spinner">
			<div class="bubble-1"></div>
			<div class="bubble-2"></div>
			</div>
	</div>
	`;
	return true;
}
function loading_9_close(elementContainer , content) {
	if(!elementContainer)return false;
    elementContainer.removeAttribute('disabled');
	elementContainer.innerHTML=content
	return true;
}
function loading_10(elementContainer ) {
	if(!elementContainer)return false;
    elementContainer.setAttribute('disabled','disabled');
	elementContainer.innerHTML=
		`
		<div class="load-10">
			<div class="bar"></div>
		</div>
		`;
	  return true;
}
function loading_10_close(elementContainer , content) {
	if(!elementContainer)return false;
    elementContainer.removeAttribute('disabled');
	elementContainer.innerHTML=content
	return true;
}

// Modal
function activeModal(element){
	if(!element)return false;
	let body = panelModal.querySelector("._body");
	body.innerHTML=element;
	panelModal.classList.remove("hidden");
	// addClass(panelModal, "animated zoomIn");
	return true;
}
function removeModal() {
	// addClass(panelModal,"animated zoomOut");
	toggle('#windowModal','hidden');
	return true;
}


viewImage= (url)=>{
	activeModal(`<img src="${url}">`);
}