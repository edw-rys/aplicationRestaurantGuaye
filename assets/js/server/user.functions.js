const urlUser = url+'user/';

const formLogin = document.querySelector("form[name='loginForm']");

const getFormLogin = function(param="login") {
    cleanModalFree();
    fetch(urlUser+"signin/"+param)
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
                if(res.status=="success" && res.code=="200"){
                    location.href=url;
                }else{
                    // console.log(toastr);
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


newUser=()=>{
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