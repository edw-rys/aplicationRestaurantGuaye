var nombre=document.querySelector("input[name='nombre']");
var precio=document.querySelector("input[name='precio']");
var categoria=document.querySelector("input[name='categoria']");
var horario=document.querySelectorAll("input[name='horario']");
function queryScheduleEvent(date, in_hour, out_hour) {
    var peticion = "fecha="+date+"&inHour="+in_hour+"&outHour="+out_hour;
    xmlHttp= new XMLHttpRequest();
    xmlHttp.open("POST",'index.php?c=event&a=checkSheduleAjax');
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlHttp.send(peticion);
    xmlHttp.onreadystatechange = function(){
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var res=xmlHttp.responseText;
            if(res){
                index.addElementPanel("#panelErr", "Horario ya está reservado, seleccione otro");
            }
        }
    };
}

function aceptarPeticion(_id, id_btn){
    var id = "id_evt="+_id;
    xmlHttp= new XMLHttpRequest();
    xmlHttp.open("POST",'index.php?c=event&a=acceptEvt');
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    this.idbtnAcp =id_btn;
    xmlHttp.send(id);
    xmlHttp.onreadystatechange = function(){
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var res=xmlHttp.responseText;
            removeErr("#panelMss");
            removeErr("#panelErr");
            if(res==1){
                var p=document.createElement("p");
                p.innerHTML="Se aceptó solicitud";
                mssg=document.querySelector("#panelMss");
                mssg.appendChild(p);
                addClass("#message-panel","active");
                var parentBtn=document.querySelector(self.idbtnAcp);
                parentBtn=parentBtn.parentNode;
                parentBtn.innerHTML="Aceptado";
            }else{
                if(res==2){
                    errorMessage("#panelErr", ["Usted no tiene disponible esta opción!"]);
                    addClass("#error","active");
                }else{
                    errorMessage("#panelErr", ["Error al aceptar!"]);
                    addClass("#error","active");
                }
            }
        }
    };
}


function blogDestacado(idPost){
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = actualizarDestacadoPost;
    this.id_post = idPost;
    xmlhttp.open("GET","index.php?c=blog&a=destacado&id="+idPost);
    xmlhttp.send();
}

function actualizarDestacadoPost(){
    if(xmlhttp.readyState===4 && xmlhttp.status===200){
        var respuesta = xmlhttp.responseText;
        if(respuesta==404)return;
        var div=document.querySelector("div[target_identify='"+self.id_post+"']");
        if(!div)return;
        if(respuesta){
            let node= div.children[0].children[0].innerHTML;
            if(node==0){
                div.setAttribute("class","star  abs-right-0 abs-top-0");
                div.children[0].children[0].innerHTML = "1";
            }
            else{
                div.setAttribute("class","other  abs-right-0 abs-top-0");
                div.children[0].children[0].innerHTML = "0";
            }
        }
    }
}

function filterByAffair(affair){
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = updateTableEvent;
    xmlhttp.open("GET","index.php?c=event&a=queryData&value="+affair);
    xmlhttp.send();
}
function updateTableEvent(){
    if(xmlhttp.readyState===4 && xmlhttp.status===200){
        var respuesta = JSON.parse(xmlhttp.responseText);
        // var respuesta = xmlhttp.responseText;
        var output="";
        tBody=document.getElementById("id-table-evt");
        for(let evt of respuesta){
            output+=
            "<tr>"+
                "<td data-campo='Usuario'>"+evt.name_user+"</td>"+
                "<td data-campo='Fecha de creación'>"+evt.creation_date+"</td>"+
                "<td data-campo='Asunto'>"+evt.affair+"</td>"+
                "<td data-campo='Fecha de ejecución'>"+evt.execution_date+"</td>"+
                "<td data-campo='Hora de entrada'>"+evt.start_time+"</td>"+
                "<td data-campo='Hora de salida'>"+evt.end_time+"</td>"+
                "<td data-campo='Comentarios'>"+evt.comment+"</td>";
            if(evt.is_accepted==1)
                output+=    
                "<td data-campo='Aceptación'  colspan='1' class='txt-center'>Aceptado</td>";
            else{
                let date= new Date()
                if(date > new Date(evt.execution_date)){
                    output+=
                    "<td data-campo='Editar'><span class='txt-through txt-inactive'>Editar</span></td>"+
                    "<td data-campo='Editar'><span class='txt-through txt-inactive'>Eliminar</span></td>";
                }else{
                    output+=
                    "<td data-campo='Editar' style='--color-txt:#009F41'><a href='index.php?c=event&a=show&id="+evt.id_event+"'>Editar</a></td>"+
                    "<td data-campo='Eliminar' style='--color-txt:var(--color-first)'><a href='index.php?c=event&a=delete&id="+evt.id_event+"'  onclick='javascript:return confirm('esta seguro?');'>Eliminar</a></td>";
                }
            }
            output+="</tr>"
        }
        tBody.innerHTML=output;
        // console.log(respuesta[0])
    }
}