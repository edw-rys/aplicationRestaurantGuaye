<header>
    <?php include_once NAVIGATION?>
</header>

<main class="flex-center main-login">
    <div class="container_login">
        <h1 class="txt-center">Inicie Sesión</h1>
        <form action="<?php echo URL?>user/login" method="POST">
            <div class="m-20"></div>
            <label class="grid grid-c-2">
                <span>Usuario: </span>
                <input class="input-txt" type="text" name="username">
            </label>
            <label class="grid grid-c-2" style="margin:10px 0">
                <span>Contraseña: </span>
                <input class="input-txt" type="password" name="password">
            </label>
            <label class="flex-center flex-y">
                <input type="submit" value="Iniciar" class="button-send ">
            </label>
        </form>
    </div>
</main>