const urlBlog = url+'blog/';
var socialNetwork =[];
const getFormRecipe =function(id) {
    let uri=id?urlBlog+"new/"+id:urlBlog+"new"
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
const loadSocialNetwork=()=>{
    fetch(urlBlog+"chargeSocialNetwork")
    .then(res=>res.json())
    .then(res=>{
        if(res){
            socialNetwork=res;
        }
    })
    .catch(err=>console.log(err));
}
const addItemSocialNetwork=()=>{
    panelModal.querySelector();
}
const saveBlog=()=>{
    const formRecipe=document.getElementById("formRecipe");
    var btn=formRecipe.save;
    animationCharge(btn);
    if(formRecipe){
        formRecipe.addEventListener("submit",e=>{e.preventDefault();})
        let data = new FormData(formRecipe);
        setTimeout(() => {
            value = validaFormBlog(data);
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

const editPost=(id=0)=>{
    if(id!=0){
        getFormRecipe(id);
    }
}
const deletePost = (id=0 , btn)=>{
    if(id==0)return;
    let auxContent =btn.innerHTML; 
    btn.classList.add("flex-x");
    animationLoad(btn,"60px","60px");
    fetch(urlBlog+"delete/"+id)
    .then(res=>res.json())
    .then(
        res=>{
            setTimeout(() => {
                if(res){
                    if(res.code==200){
                        toastr.success(res.message);
                        let item =btn.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
                        item.classList.add("animated");
                        item.classList.add("zoomOut");
                        setTimeout(() => {
                            item.remove();
                        },500);
                        
                    }else{
                        toastr.error("Error!",res.message);
                    }
                    animationLoadRemove(btn,"Publicar");
                    btn.innerHTML=auxContent;
                    btn.classList.remove("flex-x");
                }
            }, 1000);
        }
    )
    .catch(err=>{
        toastr.error("Ups!","Ha ocurrido un error");
        animationLoadRemove(btn,"Publicar");
        btn.innerHTML=auxContent;
        // console.log(err);
        btn.classList.remove("flex-x");
    });
}
viewBlog =(id)=>{
    fetch(urlBlog+"viewRecipe/"+id)
    .then(res=>res.text())
    .then(
        res=>{
            if(res && res!="null"){
                panelModal.querySelector("._body").innerHTML=res;
                panelModal.classList.remove("hidden");
            }   
        }
    )
    .catch(err=>{
        console.log(err);
        toastr.error("Ups!","Ha ocurrido un error");
    });
}