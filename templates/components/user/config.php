<?php $color = ($data["user"]->getid_gender()==2)?"female":"male";?>
<div class="sections-config <?php echo $color?>" label-field='gendernameClasslabel' style="--color:var(--color-gender)">
    <div class="personalInformation">
            <h1 class="txt-center">Configuración de la cuenta</h1>
            <div class="sett">
                <div class="sub-config">
                    <a href="#!" class="field flex flex-center space-around" onclick="toggle(` [data-field='first-config']`,'hidden')">
                        <span>Nombre de usuario</span>
                        <span label-field='usernamelabel'><?php echo $data["user"]->getUsername() ?></span>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="config-edit hidden" data-field="first-config">
                        <form action="" id="formUsername">
                            <div class="inputs-config  flex-center">
                                <span class="container-input border-bottom-unique">
                                    <input class="balloon" name="username" id="username" type="text" placeholder="Escriba su nombre de usuario"  onkeypress="checkUsername(this.value)" onkeyup="checkUsername(this.value)" value="<?php echo $data["user"]->getUsername()?>"/>
                                    <label for="username">Usuario</label>
                                </span>
                            </div>
                            <div class="send flex-center">
                                <button type="submit" onclick="updateUser('formUsername')" class="button-hover <?php echo $color?>" label-field='gendernameClasslabel' style="--color-btn:var(--color-gender)">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="sub-config">
                    <a href="#!" class="field flex flex-center space-around" onclick="toggle(` [data-field='first-config-2']`,'hidden')">
                        <span>Nombres y apellidos</span>
                        <span label-field='namelastnamelabel'><?php echo $data["user"]->getName_user(). " ". $data["user"]->getLast_name()?></span>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="config-edit hidden" data-field="first-config-2">
                        <form action="" id="formNames">
                            <div class="inputs-config  flex-center separate-flex-x-y">
                                <span class="container-input border-bottom-unique separate">
                                    <input class="balloon" id="name" name="name_user" type="text" placeholder="¿Cómo te llamas?" value="<?php echo $data["user"]->getName_user()?>"/>
                                    <label for="name">Nombre</label>
                                </span>
                                <span class="container-input  border-bottom-unique separate">
                                    <input class="balloon" id="lastname" name="last_name" type="text" placeholder="Cuál es tu apellido?" value="<?php echo $data["user"]->getLast_name()?>"/>
                                    <label for="lastname">Apellido</label>
                                </span>
                            </div>
                            <div class="send flex-center">
                                <button type="submit" onclick="updateUser('formNames')" class="button-hover <?php echo $color?>" label-field='gendernameClasslabel' style="--color-btn:var(--color-gender)">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="sub-config">
                    <a href="#!" class="field flex flex-center space-around" onclick="toggle(` [data-field='first-config-3']`,'hidden')">
                        <span>Género</span>
                        <span label-field='gendertextlabel'><?php echo $data["user"]->getname_gender() ?></span>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="config-edit hidden" data-field="first-config-3">
                        <form action="" id="formGender">
                            <div class="inputs-config  flex-center gender-container">
                                <div class="container-gender-input male relative  txt-white" style="z-index:100">
                                    <label class="gender-label relative">
                                        <input onchange="updateUser('formGender')" type="radio" name="gender" value="1" <?php if(isset($data["user"]))if(1==$data["user"]->getId_gender()) echo "checked"?>>
                                        <div class="capa">
                                            <img src="<?php echo IMAGES."icons/male.svg"?>" alt="">
                                            <span class="flex-center">MASCULINO</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="container-gender-input female  txt-white" style="z-index:100">
                                    <label class="gender-label relative">
                                        <input onchange="updateUser('formGender')" type="radio" name="gender" value="2" <?php if(isset($data["user"]))if(2==$data["user"]->getId_gender()) echo "checked"?>>
                                        <div class="capa">
                                            <img src="<?php echo IMAGES."icons/female.svg"?>" alt="">
                                            <span class="flex-center">FEMENINO</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="sett">
                <div class="sub-config">
                    <a href="#!" class="field flex flex-center space-around" onclick="toggle(` [data-field='first-config-4']`,'hidden')">
                        <span>Número de teléfono</span>
                        <span label-field='phonelabel'><?php echo $data["user"]->getPhone_number() ?></span>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="config-edit hidden" data-field="first-config-4">
                        <form action="" id="formPhone">
                            <div class="inputs-config  flex-center">
                                <span class="container-input border-bottom-unique">
                                    <input name="phone_number" class="balloon" id="phone_number" type="text" placeholder="Escriba su número de teléfono" value="<?php echo $data["user"]->getPhone_number()?>"/>
                                    <label for="phone_number">Teléfono</label>
                                </span>
                            </div>
                            <div class="send flex-center">
                                <button type="submit" onclick="updateUser('formPhone')" class="button-hover <?php echo $color?>" label-field='gendernameClasslabel' style="--color-btn:var(--color-gender)">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="sub-config">
                    <a href="#!" class="field flex flex-center space-around" onclick="toggle(` [data-field='first-config-5']`,'hidden')">
                        <span>Contraseña</span>
                        <span>*******</span>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="config-edit hidden" data-field="first-config-5">
                        <form action="" id="formPassword">
                            <div class="inputs-config  flex-center flex-y" style="margin:10px">
                                <span style="font-size:0.8em">Escriba su contraseña actual</span>
                                <span class="container-input border-bottom-unique">
                                    <input name="password_current" class="balloon" id="password_current" type="password" placeholder="Escriba su contraseña" />
                                    <label for="password_current">Actual</label>
                                </span>
                            </div>
                            
                            <div class="flex-center">
                            <div class="line- flex-center" style="width:150px;height:3px;background:#A9A9A9"></div>
                            </div>
                            
                            <div class="inputs-config  flex-center" style="margin-top:10px">
                                <span class="container-input border-bottom-unique">
                                    <input name="password" class="balloon" id="password" type="password" placeholder="Escriba su contraseña" />
                                    <label for="password">Nueva</label>
                                </span>
                            </div>
                            
                            <div class="inputs-config  flex-center flex-y" style="margin-top:10px">
                                <span style="font-size:0.8em">Vuelva a escribir su nueva contraseña</span>
                                <span class="container-input border-bottom-unique">
                                    <input name="password_confirm" class="balloon" id="password_confirm" type="password" placeholder="Escriba su contraseña" />
                                    <label for="password_confirm">Nueva</label>
                                </span>
                            </div>
                            <div class="send flex-center">
                                <button type="submit" onclick="updateUser('formPassword')" class="button-hover <?php echo $color?>" label-field='gendernameClasslabel' style="--color-btn:var(--color-gender)">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="sett">
                <div class="sub-config">
                    <a href="#!" class="field flex flex-center space-around"onclick="toggle(` [data-field='first-config-7']`,'hidden')">
                        <span>Foto de perfil</span>
                        <span><?php echo $data["user"]->getUsername() ?></span>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="config-edit hidden" data-field="first-config-7">
                        <form action="" id="formUpload">
                            <div class="inputs-config  flex-center flex-y">
                                <!-- input type File  -->
                                <div class="middle flex-center">
                                    <label class="txt-white">
                                        <input type="file" name="image" class="hidden"/>
                                        <div class="box-radio active" >
                                            <span class="icon" style="--color-txt:var(--color-gender);opacity:1;transform: translateY(0px);"  label-field='gendernameClasslabel'>
                                                <i class="fas fa-camera"></i>
                                            </span>
                                            <span class="title-radio">Imagen</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="send flex-center">
                                <button type="submit" onclick="updateUser('formUpload')" onclick="" class="button-hover <?php echo $color?>" label-field='gendernameClasslabel' style="--color-btn:var(--color-gender)">Subir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- delete account -->
            <div class="sett">
                <div class="sub-config">
                    <a href="#!" class="field flex flex-center space-around" style="background:#FF3B3B" onclick="toggle(` [data-field='first-config-6']`,'hidden')">
                        <span>Deshabilitar cuenta</span>
                        <span><?php echo $data["user"]->getUsername() ?></span>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="config-edit hidden" data-field="first-config-6">
                        <form action="" id="formRemoveAccount">
                            <div class="inputs-config  flex-center flex-y">
                                <span style="font-size:0.8em">Escriba su contraseña para proceder a deshabilitar la cuenta</span>

                                <span class="container-input border-bottom-unique">
                                    <input class="balloon" name="password" id="password_remove" type="password" placeholder="Escriba su nombre de usuario"/>
                                    <label for="password_remove">Clave</label>
                                </span>
                            </div>
                            <div class="send flex-center">
                                <button type="submit" onclick="disableAccount('formRemoveAccount')" class="button-hover <?php echo $color?>" label-field='gendernameClasslabel' style="--color-btn:#FF3B3B">Deshabilitar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>