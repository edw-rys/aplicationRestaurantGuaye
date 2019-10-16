<header>
    <?php require_once NAVIGATION; ?>
</header>
<div class="m-20 container-login flex-center">
    <div class="form">
        
        <h1 class="tittle txt-center">REGISTRATE</h1>
        <div class="border"></div>
        
        <form action="" method="POST" name="formRegistry" id="formSignup">
            <div class="col-input">
                <label for="name" class="txt-center">Nombre:</label>
                <input class="input-txt" type="text" name="name" id="name"/>
            </div>
            <div class="col-input">
                <label for="lastname" class="txt-center">Apellido:</label>
                <input class="input-txt" type="text" name="lastname" id="lastname"/>
            </div>
            <div class="col-input">
                <label for="username" class="txt-center">Nombre de usuario:</label>
                <input class="input-txt" type="text" name="username" id="username"/>
            </div>
            <div class="col-input">
                <label for="numtelf" class="txt-center">Número de teléfono:</label>
                <input class="input-txt" type="text" name="numtelf" id="numtelf"/>
            </div>
            <div class="col-input">
                <label for="password" class="txt-center">Contraseña:</label>
                <input class="input-txt" type="password" name="password"/>
            </div>
            <div class="in flex-center">
                <button onclick="newUser()" name="submit" class="button btn-first c-pointer" type="submit" style="width:50%;">Registrarse</button>
            </div>
        </form>
    </div>
</div>