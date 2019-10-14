const urlMenu = url+'dailymenu/';
const getFormDilyMenu =function(id) {
    let uri=id?urlMenu+"new/"+id:urlMenu+"new"
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
const saveMenu=()=>{
    const formRecipe=document.getElementById("formDailyMenu");
    var btn=formRecipe.submit;
    animationCharge(btn);
    if(formRecipe){
        formRecipe.addEventListener("submit",e=>{e.preventDefault();})
        let data = new FormData(formRecipe);
        setTimeout(() => {
            value = validarMenu(data);
            if(Array.isArray(value)){
                // error de datos
                value.forEach(element => {
                    toastr.error(element);
                });
                animationChargeRemove(btn,"Publicar");
            }else{
                fetch(urlBlog+"save",{
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
