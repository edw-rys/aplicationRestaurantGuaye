const urlEvent = url+'event/';
const getFormEvent =function(id) {
    let uri=id?`${urlEvent}new/${id}`:urlEvent+"new"
    console.log(uri);
    fetch(uri)
    .then(res=>res.text())
    .then(res=>{
        // console.log(res);
        if(res && res!="error"){
            panelModal.querySelector("._body").innerHTML=res;
            panelModal.classList.remove("hidden");
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
                fetch(urlEvent+"save",{
                    method:"POST",
                    body:data
                })
                .then(res=>res.json())
                .then(
                    res=>{
                        console.log(res)
                        if(res.code==200){
                            toastr.success(res.message);
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
        }, 1000);
        
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
                        console.log(item);
                        item.classList.add("animated");
                        item.classList.add("zoomOut");
                        setTimeout(() => {
                            item.remove();
                        },500);
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
        }, 1000);
    }else{
        
    }
}
const filterByAffair=(value)=>{
    if(!value)return false;
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
    }, 1000);
}