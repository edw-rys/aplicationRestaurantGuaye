const urlUser = url+'user/';

const formLogin = document.querySelector("form[name='loginForm']");
if(formLogin){
    formLogin.addEventListener('submit',function(e){
        e.preventDefault();
        // console.log(formLogin);
        login(this);    
    });
}

const login =(form) =>{
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
            },1000);
        }
    )
    .catch(err=>{
        console.log(err);
        toastr.error("Ups!","Tenemos un error")
        animationChargeRemove(btn,"Enviar");
    });
    return false;
}


