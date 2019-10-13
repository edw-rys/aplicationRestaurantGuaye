


function eliminarNodos(element){
	while(element.hasChildNodes){
		element.removeChild(element.firstChild);
	}
}


function addLiInput(_name){
	var li=document.createElement("li");
	var input=createElement("input",{"type":"text","class":"input-txt","name":_name});
	li.classList="space-around flex";
	li.appendChild(input);
	return li;
}
function addElementBlog(_id){
	var node=document.getElementById(_id);
	var li=addLiInput( "ingrediente[]");
	li.appendChild(trash());
	node.appendChild(li);
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
}

function removeCampFather(children){
	
	children=children.parentNode;
	nodes=children.parentNode;
	nodes.removeChild(children);
}
