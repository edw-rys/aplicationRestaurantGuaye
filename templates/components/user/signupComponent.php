
<!-- <div class="flex-center"> -->
    <div class="box-signup form-clasic">
        <div class="header_">
            <div class="bottom-head txt-center"><h1 class="title">Regístrate</h1></div>
        </div> 
        <form action="" method="POST" name="formRegistry" id="formSignup">
            <div class="flex-center">
                <span class="container-input border-botom">
                    <input class="clean-slide" name="name" id="name" type="text" placeholder="¿Cómo te llamas?"  onfocus="hiddenLabel(this.parentNode, 'focus')"  onblur="hiddenLabel(this.parentNode,'blur')"/>
                    <label for="name">Nombre</label>
                </span>
            </div>
            <div class="flex-center">
                <span class="container-input border-botom">
                    <input class="clean-slide" name="lastname" id="lastname" type="text" placeholder="Cuál es tu apellido?"  onfocus="hiddenLabel(this.parentNode, 'focus')"  onblur="hiddenLabel(this.parentNode,'blur')"/>
                    <label for="lastname">Apellido</label>
                </span>
            </div>
            <div class="flex-center">
                <span class="container-input border-botom">
                    <input class="clean-slide" name="username" id="username" type="text" placeholder="Escriba su nombre de usuario."  onfocus="hiddenLabel(this.parentNode, 'focus')"  onblur="hiddenLabel(this.parentNode,'blur')"/>
                    <label for="username">Usuario</label>
                </span>
            </div>
            <div class="flex-center">
                <span class="container-input border-botom">
                    <input class="clean-slide" name="numtelf" id="numtelf" type="text" placeholder="Digite su número de teléfono!"  onfocus="hiddenLabel(this.parentNode, 'focus')"  onblur="hiddenLabel(this.parentNode,'blur')"/>
                    <label for="numtelf">Teléfono</label>
                    <span class="absolute abs-right-0" style="font-size:0.7em">Opcional</span>
                </span>
            </div>
            <div class="flex-center" style="">
                <span class="container-input border-botom">
                    <input class="clean-slide" name="password" id="password" type="password" placeholder="Escriba su contraseña!"  onfocus="hiddenLabel(this.parentNode, 'focus')"  onblur="hiddenLabel(this.parentNode,'blur')"/>
                    <label for="password">Contraseña</label>
                </span>
            </div>
            <div>
                <div class="gender-container flex flex-center" style="grid-column: span 2">
                    
                    <div class="container-gender-input male relative  txt-white">
                        <label class="gender-label relative">
                            <input type="radio" name="gender" value="1" <?php if(isset($user))if(1==$user->getId_gender()) echo "checked"?>>
                            <div class="capa">
                                <img src="<?php echo IMAGES."icons/male.svg"?>" alt="">
                                <span class="flex-center">MASCULINO</span>
                            </div>
                            
                        </label>
                    </div>
                    <div class="container-gender-input female  txt-white">
                        <label class="gender-label relative">
                            <input type="radio" name="gender" value="2" <?php if(isset($user))if(2==$user->getId_gender()) echo "checked"?>>
                            <div class="capa">
                                <img src="<?php echo IMAGES."icons/female.svg"?>" alt="">
                                <span class="flex-center">FEMENINO</span>
                            </div>
                            
                        </label>
                    </div>
                </div>
            </div>
            <div class="in flex-center">
                <!-- <button   class="button btn-first c-pointer" type="submit" style="width:50%;">Registrarse</button> -->
                <button name="submit" onclick="newUser()" class="button-hover btn-third" type="submit" style="width:250px;">Crear cuenta</button>

            </div>
        </form>
        <div class="footer_"><p class="text"><span class="sign-up" onclick="getFormLogin()"> Login</span></p></div>
    </div>
<!-- </div> -->