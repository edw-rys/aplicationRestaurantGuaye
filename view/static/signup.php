<header>
    <?php require_once NAVIGATION; ?>
</header>
<div class="m-20 container-login flex-center">
    <div class="form">
        
        <h1 class="tittle txt-center">REGISTRATE</h1>
        <div class="border"></div>
        
        <form action="index.php?c=user&a=signup" onsubmit="return validarUsuarionuevo()" method="POST" name="formRegistry">

            <label><span class="txt-center">Nombre:</span><input class="input-txt" type="text" name="name"/></label>

            <label><span class="txt-center">Apellido:</span><input class="input-txt" type="text" name="lastname"/></label>

            <label><span class="txt-center">Nombre de usuario:</span><input class="input-txt" type="text" name="username"/></label>
            
            <label><span class="txt-center">Contraseña:</span><input class="input-txt" type="password" name="password"/></label>

            <label><span class="txt-center">Número de teléfono:</span><input class="input-txt" type="number" name="numtelf"/></label>



            <div class="in flex-center">
                <input class="button btn-first c-pointer" type="submit" name="enviar" value="Registrarse" style="width:50%;"/><br>
            </div>
        </form>
    </div>
</div>