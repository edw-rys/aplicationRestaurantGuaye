const urlUser = url+'user/';

const formLogin = document.querySelector("form[name='loginForm']");

const getFormLogin = function(param="login") {
    cleanModalFree();
    fetch(urlUser+"signin/"+param
    )
    .then(res=>res.text())
    .then(res=>{
        // console.log(res);
        if(res && res!="error"){
            activeModalFree(res);
        }
    })
    .catch(err=>console.log(err));
}
if(formLogin){
    formLogin.addEventListener('submit',function(e){
        e.preventDefault();
        // console.log(formLogin);
        login(this);    
    });
}
var token="";
const login =(form) =>{
    if(!form){
        form=document.getElementById("formLogin");
    }
    form.addEventListener("submit",e=>{e.preventDefault();});
    let loginUser=new FormData(form);
    // Bloquear botón
    let btn = form.enviar;
    animationCharge(btn);
    // Petición al servidor
    fetch(`${urlUser}login`,
        {
            method:"POST",
            body: loginUser
        }
    )
    .then(
        res=>res.json()
    )
    .then(
        res=>{
            setTimeout(() => {
                this.token=res.token;
                if(res.status=="success" && res.code=="200"){
                    fetch(`${urlUser}login/true`,
                        {
                            method:"POST",
                            body: loginUser
                        }
                    ).then(
                        res=>res.json()
                    ).then(
                        res=>{
                            if(res.status=="success" && res.code=="200"){
                                localStorage.setItem('token',this.token);
                                localStorage.setItem('identity',JSON.stringify(res.identity));
                                location.href=url;
                            }
                        }
                    )
                    .catch(err=>{
                        console.log(err);
                    });
                }else{
                    toastr.error(res.message)
                }
                animationChargeRemove(btn,"Enviar");
            },timeResponse);
        }
    )
    .catch(err=>{
        console.log(err);
        toastr.error("Ups!","Tenemos un error")
        animationChargeRemove(btn,"Login");
    });
    return false;
}


const newUser=()=>{
    const form = document.getElementById("formSignup");
    if(form){
        form.addEventListener("submit",e=>e.preventDefault());
        const data = new FormData(form);
        let btn = form.submit;
        animationCharge(btn);
        // Validar datos
        value = validarUsuarionuevo(data);
        setTimeout(() => {
            
            if(Array.isArray(value)){
                // error de datos
                value.forEach(element => {
                    toastr.error(element);
                });
            }else{
                fetch(urlUser+"/signup",
                {
                    method:"POST",
                    body: data
                })
                .then(res=>res.json())
                .then(res=>{
                    if(res){
                        if(res.status=="success"){
                            toastr.success(res.message);
                            toastr.info("Estamos iniciando sesión, por favor espere.","Información");
                            setTimeout(() => {
                                login(form);
                            }, 500);
                        }else{
                            toastr.error(res.message);
                        }
                    }else{
                        toastr.error("Ups!","Ha ocurrido un error");
                    }
                    console.log(res);
                })
                .catch(err=>{
                    console.log(err);
                    toastr.error("Ups!","Ha ocurrido un error");
                });
            }
            animationChargeRemove(btn,"Crear cuenta");
        }, timeResponse);
    }

}

const renderPost=(idUser=0)=>{
    let uri = urlUser+"renderPost/";
    if(idUser!=0){
        uri+=idUser;
    }
    fetch(uri)
    .then(res=>res.text())
    .then(res=>{
        let postWall = document.getElementById("post-blog-user");
        if(postWall){
            if(res){
                postWall.innerHTML=res;
            }else{
                postWall.innerHTML="<h3 class='txt-center'>No ha posteado</h3>";
            }
        }
    })
    .catch(err=>console.log(err));
}
const configView = ()=>{
    fetch(urlUser+"config")
    .then(res=>res.text())
    .then(res=>{
        let postWall = document.getElementById("post-blog-user");
        if(postWall){
            if(res){
                postWall.innerHTML=res;
            }
        }
    })
    .catch(err=>console.log(err));
}


// Options edit
const checkUsername = (username="")=>{
    let col = document.querySelector(".status-username");
    if(!username){col.innerHTML="<p style='color:#FF2929'>Escriba su nombre de usuario</p>";return false;}
    loading_7(col);
    fetch(urlUser+"config/checkusername?username="+username)
    .then(res=>res.json())
    .then(res=>{
        setTimeout(() => {
            if(res.status=="success"){
                console.log("disponible");
                col.innerHTML="<p style='color:#01DF78'>Disponible</p>";
            }else if(res.status=="error"){
                console.log(res.message);
                col.innerHTML=`<p style='color:#FF2929'>${res.message}</p>`;
            }
        }, timeResponse);
    })
    .catch(err=>console.log(err));
}
const updateUser = (idForm)=>{
    let form =document.getElementById(idForm);
    if(!form)return false;
    form.addEventListener("submit",(e)=>e.preventDefault());
    let data = new FormData(form);
    fetch(urlUser+"update",{
        method:"POST",
        body:data
    })
    .then(res=>res.json())
    .then(async (res)=>{
        console.log(res);
        if(res.status=="success"){
            toastr.success(res.message);
            let user = await getDataMyUser();
            updateDataUser(user);
        }else{
            if(res.errors){
                res.errors.forEach(val=>{
                    toastr.error(val);
                });
            }else{
                toastr.error(res.message);
            }
        }
    })
    .catch(err=>console.log(err));
}
const disableAccount = (idForm)=>{
    let form =document.getElementById(idForm);
    if(!form)return false;
    form.addEventListener("submit",(e)=>e.preventDefault());
    let data = new FormData(form);
    fetch(urlUser+"disable",{
        method:"POST",
        body:data
    })
    .then(res=>res.json())
    .then(res=>{
        console.log(res);
        if(res.status=="success"){
            toastr.success(res.message);
            toastr.info("Cerrando sesión");
            setTimeout(() => {
                window.location=urlUser+"logout";
            }, 1000);
        }else{
            toastr.error(res.message);
        }
    })
    .catch(err=>console.log(err));
}
const getDataMyUser = async()=>{
    let user=null;
    let promise = await fetch(urlUser+"getMyData");
    if(promise.ok){
        user = await promise.json();
    }
    return user;
}
const searchUser =(idForm)=>{
    let form =document.getElementById(idForm);
    if(!form)return false;
    let data = new FormData(form);

    // Página de búsqueda
    if(location.toLocaleString().indexOf(urlUser+"search")>-1){
        form.addEventListener("submit",(e)=>e.preventDefault());
        fetch(urlUser+"search/"+data.get("search"))
        .then(res=>res.text())
        .then(
            res=>{
                const dom = document.getElementById("container-seach-user")
                dom.innerHTML=res;
                // console.log(res);
            }
        )
        .catch(err=>console.log(err));
    }else{
        form.submit.addEventListener('click',e=>{
            if(!data.get("search")){
                data.set("search","random")
            }
            location.href=urlUser+"search/"+data.get("search")+"/window";
        });
    }
}

/**
 * Actualizar todos los campos que se visualizan en el DOM
 */
const updateDataUser = (user) =>{
    const username = document.querySelectorAll(`[label-field='usernamelabel']`);
    if(username){
        username.forEach( element =>{
            element.innerHTML= user.username;
        });
    }
    const name = document.querySelectorAll(`[label-field='namelabel']`);
    if(name){
        name.forEach( element =>{
            element.innerHTML= user.name_user;
        });
    }
    const phone = document.querySelectorAll(`[label-field='phonelabel']`);
    if(phone){
        name.forEach( element =>{
            element.innerHTML= user.phone_number;
        });
    }
    const lastusername = document.querySelectorAll(`[label-field='lastnamelabel']`);
    if(lastusername){
        lastusername.forEach( element =>{
            element.innerHTML= user.last_name;
        });
    }
    const namelastname = document.querySelectorAll(`[label-field='namelastnamelabel']`);
    if(namelastname){
        namelastname.forEach( element =>{
            element.innerHTML= user.name_user+ " "+user.last_name ;
        });
    }
    const gendertext = document.querySelectorAll(`[label-field='gendertextlabel']`);
    if(gendertext){
        gendertext.forEach( element =>{
            element.innerHTML= user.name_gender;
        });
    }
    const gendernameClass = document.querySelectorAll(`[label-field='gendernameClasslabel']`);
    const class_gender= (user.id_gender==1)?"male":'female';
    if(gendernameClass){
        gendernameClass.forEach( element =>{
            removeClass(element, "male female");
            addClass(element,class_gender);
        });
    }
    const urlLabelGender = document.querySelectorAll(`[label-field='genderurlImglabel']`);
    if(urlLabelGender){
        urlLabelGender.forEach( element =>{
            element.setAttribute('src',user.url_image_gender);
        });
    }
    const urlPhoto = document.querySelectorAll(`[label-field='urlPhotolabel']`);
    if(urlPhoto){
        urlPhoto.forEach( element =>{
            element.setAttribute('src',user.url_photo);
        });
    }
}