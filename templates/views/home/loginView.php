<header>
    <?php require_once NAVIGATION; ?>
</header>
<div class="container-login flex-center">
    <div class="form">
        <?php 
            if(isset($_SESSION['USER'])){
                Redirect::to("");
            }
        ?>

        <h1 class="tittle txt-center">Login</h1>
        <div class="border"></div>
        <form action="" method="POST" name="loginForm">

            <!-- <span ></span> -->
            <div class="col-input">
                <label for="username" class="txt-center">Usuario:</label>
                <input class="input-txt" type="text" name="username" id="username"/>
            </div>
            <div class="col-input">
                <label for="password" class="txt-center">Contraseña:</label>
                <input class="input-txt" type="password" name="password"/>
            </div>
            
            <div class="in flex-center">
                <button class="button btn-first c-pointer" value="Ingresar" name="enviar"  style="width:50%;" >
                    Enviar
                </button>
               <br>
            </div>
        </form>
    </div>
</div>