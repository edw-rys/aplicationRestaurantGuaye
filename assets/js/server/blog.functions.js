const urlBlog = url+'blog/';
var socialNetwork =[];
const getFormRecipe =function(id) {
    let uri=id?urlBlog+"new/"+id:urlBlog+"new"
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
// const addItemSocialNetwork=()=>{
//     panelModal.querySelector();
// }
const saveBlog= ()=>{
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
                    async(res)=>{
                        // console.log(res)
                        if(res.code==200){
                            toastr.success(res.message);
                            // Agregar al muro o editar
                            let Recipes = document.querySelector(".allRecipes");
                            if(!data.get("id")){
                                // New
                                let element = await getNewItem(res.idRecipe);
                                element = getHTML(element);
                                Recipes.insertBefore(element, Recipes.firstElementChild);
                                addClass(element,"animated zoomInUp");
                            }else{
                                // Edit
                                let recipe = document.querySelector(".item-blog-number-"+res.idRecipe);
                                let element = await getNewItem(res.idRecipe);
                                element = getHTML(element);
                                Recipes.replaceChild(element, recipe);
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
        }, 500);
        
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
                        addClass(item, "animated zoomOut");
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
                activeModal(res);
            }   
        }
    )
    .catch(err=>{
        console.log(err);
        toastr.error("Ups!","Ha ocurrido un error");
    });
}


getNewItem = async (id)=>{
    if(!id)return false;
    let res = await fetch(urlBlog+"getItemView/"+id);
    res = await res.text();
    // Return Promise
    return res;
}
const updateStarPost = (id)=>{
    if(!id)return false;
    fetch(urlBlog+"destacado/"+id)
    .then(res=>res.json())
    .then(
        res=>{
            if(res.status=="success"){
                console.log('hecho');
            }else{
                toastr.error(res.message);
            }
        }
    )
    .catch(err=>console.log(err));
}