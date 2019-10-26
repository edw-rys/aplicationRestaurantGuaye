const urlEvent = url+'event/';
const getFormEvent =function(id) {
    let uri=id?`${urlEvent}new/${id}`:urlEvent+"new"
    console.log(uri);
    fetch(uri)
    .then(res=>res.text())
    .then(res=>{
        // console.log(res);
        if(res && res!="error"){
            activeModal(res);
            loadSocialNetwork();
        }
    })
    .catch(err=>console.log(err));
}
const saveEvent=()=>{
    const formRecipe=document.getElementById("formEvent");
    var btn=formRecipe.submit;
    animationCharge(btn);
    if(formRecipe){
        formRecipe.addEventListener("submit",e=>{e.preventDefault();})
        let data = new FormData(formRecipe);
        setTimeout(() => {
            value = validaFormEventos(data);
            if(Array.isArray(value)){
                // error de datos
                value.forEach(element => {
                    toastr.error(element);
                });
                animationChargeRemove(btn,"Publicar");
            }else{
                let headers_ = new Headers();
                headers_.append('Content-type' , 'application/x-www-form-urlencoded');
                headers_.append('token', localStorage.getItem('token'));
                fetch(urlEvent+"save",{
                    headers:headers_,
                    method:"POST",
                    body:data
                })
                .then(res=>res.json())
                .then(
                    async (res)=>{
                        console.log(res)
                        if(res.code==200){
                            toastr.success(res.message);
                            let eventsTable = document.getElementById("body_table_event");
                            let dataEvent = await getNewEvent(res.idEvent);
                            if(dataEvent){
                                let element = getHTML(dataEvent);
                                if(!data.get("id")){
                                    // Insert new
                                    if(eventsTable.childElementCount>1){
                                        eventsTable.insertBefore(element, eventsTable.children[1]);
                                    }else{
                                        eventsTable.appendChild(element);
                                    }
                                    addClass(element,"animated zoomInUp");
                                }else{
                                    // Edit
                                    let eventReplace = document.querySelector(`[target-name="event-id-${res.idEvent}"]`);
                                    eventsTable.replaceChild(element, eventReplace);
                                }
                            }
                            removeModal();
                        }else{
                            toastr.error(res.message);
                        }
                        animationChargeRemove(btn,"Publicar");
                    }
                )
                .catch(err=>{
                    console.log(err);
                    animationChargeRemove(btn,"Publicar");
                    toastr.error("Ups!","Ha ocurrido un error");
                });
            }
        }, timeResponse);
        
    }
    return false;
}

const editEvent=(id=0 )=>{
    if(id!=0 ){
        getFormEvent(id);
    }
}
const deleteEvent=(id,col)=>{
    if(!id)return false;
    if(confirm('esta seguro?')){
        let aux = col.innerHTML;
        animationCharge(col);
        setTimeout(() => {
            fetch(urlEvent+"delete/"+id)
            .then(res=>res.json())
            .then(
                res=>{
                    if(res.status=="success"){
                        let item= col.parentNode;
                        toastr.success(res.message);
                        item.classList.add("animated");
                        item.classList.add("zoomOut");
                        setTimeout(() => {
                            item.remove();
                        },400);
                    }else{
                        toastr.error(res.message);
                    }
                    animationChargeRemove(col,"Publicar");
                    col.innerHTML = aux;
                }
            )
            .catch(
                err=>{
                    toastr.error("Ups!","Ha ocurrido un error");
                    animationChargeRemove(col,"Publicar");
                    col.innerHTML = aux;
                }
            );
        }, timeResponse);
    }else{
        
    }
}
const filterByAffair=(value="")=>{
    fetch(urlEvent+"query/"+value)
    .then(res=>res.text())
    .then(
        res=>{
            if(res!="null"){
                // console.log(res);
                let body=document.getElementById("body_table_event");
                body.innerHTML=res;
            }
        }
    )
    .catch(
        err=>{
            toastr.error("Ups!","Ha ocurrido un error");
        }
    );
}

const aceptarPeticion=(id , btn)=>{
    if(!id)return false;
    let item = btn.parentNode;
    let aux=item.innerHTML;
    loading_4(item);

    setTimeout(() => {
        fetch(urlEvent+"accept/"+id)
        .then(res=>res.json())
        .then(
            res=>{
                // console.log(res);
                if(res.status=="success"){
                    item.innerHTML="Aceptado";
                    toastr.success(res.message);
                    aux="Aceptado";
                }else{
                    toastr.error(res.message);
                }
                loading_4_close(item, aux);
            }
        )
        .catch(
            err=>{
                toastr.error("Ups!","Ha ocurrido un error");
                loading_4_close(item, aux);
            }
        )
    }, timeResponse);
}
getNewEvent= async (id)=>{
    if(!id)return false;
    let res = await fetch(urlEvent+"getItemView/"+id);
    res = await res.text();
    // Return Promise
    return res;
}

getCalendarEvents=()=>{
    const idEventCalendar='calendarEvent';
    const idorganizedCalendar='organizedEvent';
    fetch(urlEvent+"calendar")
    .then(res=>res.json())
    .then(
        res=>{
            activeModal(templatCalendar(idEventCalendar,idorganizedCalendar));
            addClass(panelModal.firstElementChild.firstElementChild,"modal-extend");
            if(res.calendar){
                let dataCalendar ={};
                res.calendar.forEach(data=>{
                    let dateEvt = data.execution_date.split("-");
                    if(!dataCalendar[dateEvt[0]]){
                        dataCalendar[dateEvt[0]]={}
                    }
                    if(!dataCalendar[dateEvt[0]][dateEvt[1]]){
                        dataCalendar[dateEvt[0]][dateEvt[1]]={}
                    }
                    if(!dataCalendar[dateEvt[0]][dateEvt[1]][dateEvt[2]]){
                        dataCalendar[dateEvt[0]][dateEvt[1]][dateEvt[2]]=[]
                    }
                    dataCalendar[dateEvt[0]][dateEvt[1]][dateEvt[2]].push({
                        startTime: data.start_time+":00",
                        endTime: data.end_time+":00",
                        text: data.event_
                    });
                });
                const calendarEvt = getCalendar(idEventCalendar,"small","Monday","#fff","#961821");
                console.log(res);
                setDataCalendar( idorganizedCalendar , calendarEvt , dataCalendar)

            }
        }
    )
    .catch(err=>console.log(err));
}