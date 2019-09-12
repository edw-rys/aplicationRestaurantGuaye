
        <?php
ob_start();
?>
        <header>
            <?php require_once NAVIGATION; ?>
        </header>
        <div class="container-login flex-center">
            <div class="form">
                <?php 
                    if(isset($_SESSION['USER'])){
                        header("Location:index.php");
                    }
                ?>
                
                <h1 class="tittle txt-center">Login</h1>
                <div class="border"></div>
                <form action="index.php?c=user&a=login" onsubmit="return logInNotNull()" method="POST" name="formLogin">
                
                <label><span class="txt-center">Usuario:</span><input class="input-txt" type="text" name="user"/></label>
                
                <label><span class="txt-center">Contraseña:</span><input class="input-txt" type="password" name="password"/></label>
                <div class="in flex-center">
                    <input class="button btn-first c-pointer" type="submit" name="enviar" value="Ingresar" style="width:50%;"/><br>
                </div>
            </form>
            </div>
        </div>
        <?php
        ob_end_flush();
        ?>