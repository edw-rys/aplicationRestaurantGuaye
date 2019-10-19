


function eliminarNodos(element){
	while(element.hasChildNodes){
		element.removeChild(element.firstChild);
	}
}


function addLiInput(_name){
	var li=document.createElement("li");
	var input=createElement("input",{"type":"text","class":"input-txt border-bottom-unique no-outline","name":_name});
	li.classList="space-around flex";
	li.appendChild(input);
	return li;
}
function addElementBlog(_id){
	var node=document.getElementById(_id);
	var li=addLiInput( "ingrediente[]");
	li.appendChild(trash());
	node.appendChild(li);
	addClass(li, "animated zoomIn");
}

function trash(){
	var btn=createElement("button",{"type":"button","onclick":"removeCampFather(this)"});
	var icon=createElement("img",{"src":"assets/img/icons/trash-alt-regular.svg","width":"20"});
	btn.appendChild(icon);
	return btn;
}

// var socialNetwork=["facebook","instagram","twitter","Pinterest"];


function addSocialLiInput(_id){

	var node=document.getElementById(_id);
	var li=addLiInput( "input-social[]");
	
	var selection=createElement("select",{"name":"social-op[]"});
	for(var s of socialNetwork){
		op=createElement("option",{"value":s.id_socialNetwork}, s.name_socialNetwork)
		selection.appendChild(op);

	}
	li.appendChild(selection);
	li.appendChild(trash());
	node.appendChild(li);
	addClass(li, "animated zoomIn");
}

function removeCampFather(children){
	
	children=children.parentNode;
	nodes=children.parentNode;
	addClass(children,"animated zoomOut");
	setTimeout(() => {
		nodes.removeChild(children);
	}, 400);
}
function togglePanel(query) {
	let element = document.querySelector(query);
	if(!element)return false;
	let classList_ = element.classList.value.split(" ");
	let hidden_ = classList_.find(res=>{
		return res =='hidden';
	});
	if(!hidden_){
		addClass(element,"animated zoomOutUp");
		setTimeout(() => {
			addClass(element, "hidden");
			removeClass(element,"animated zoomOutUp");
		}, 600);
	}else{
		addClass(element,"animated zoomInDown");
		setTimeout(() => {
			removeClass(element, "hidden");
			setTimeout(() => {
				removeClass(element,"animated zoomInDown");
			}, 1000);
		}, 200);
	}

}