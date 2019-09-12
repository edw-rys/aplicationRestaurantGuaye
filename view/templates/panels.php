<!-- Error -->
<div id="error" class=" font-p-h">
    <div class="_head flex-end">
        <span class="flex-end" onclick="panelClose('#error','active','#panelErr')">
            <!-- <i class="fas fa-times"></i> -->
            <img src="assets/img/icons/close.svg" alt=""  width="30" height="30">
        </span>
    </div>
    <div id="panelErr"></div>
</div>
<?php
    if(!isset($_SESSION)){
        session_start();
    }
    if(isset( $_SESSION['messageError'])){
        ?>
        <div id="errorphp" class="active font-p-h error">
            <div class="_head flex space-btw">
                <p class="flex- txt-white">Error</p>
                <span class="flex-end" onclick="panelClose('#errorphp','active','#panelErrphp')">
                    <!-- <i class="fas fa-times"></i> -->
                    <img src="assets/img/icons/close.svg" alt="" width="30" height="30">
                </span>
            </div>
            <div id="panelErrphp">
                <p>
                    <?php
                        echo $_SESSION['messageError'];
                    ?> 
                </p>
            </div>
        </div>
        <?php
        unset( $_SESSION['messageError']);
    }
    if(isset( $_SESSION['message'])){
        echo $_SESSION['message'];
        ?>
        <div id="messagephp" class="active font-p-h message">
            <div class="_head flex space-btw">
                <p class="flex- txt-white">Aviso </p>
                <span class="flex-end" onclick="panelClose('#messagephp','active','#panelMssphp')">
                    <!-- <i class="fas fa-times"></i> -->
                    <img src="assets/img/icons/close.svg" alt="" width="30" height="30">
                </span>
            </div>
            <div id="panelMssphp">
                <p>
                    <?php
                        echo $_SESSION['message'];
                    ?> 
                </p>
            </div>
        </div>
        <?php
        unset( $_SESSION['message']);
    }
?>

<div class="internal-message  flex-end">
    <div class="" id="message-ws">
    <div class="flex-end">
        <span class="close" onclick="toggle('#message-ws','open')">
            <!-- <i class="fas fa-times"></i> -->
            <img src="assets/img/icons/close.svg" alt=""  width="30" height="30">
        </span>
    </div>
    <div class="_body">
        <div class="content txt-first flex flex-center">
            <a href="https://m.me/Guayaberestaurant"  target="_blank"><i class="messenger fab fa-facebook-messenger"></i></a>
            <a href="https://bit.ly/32fOJRC" target="_blank" class="whatsapp"><i class="fab fa-whatsapp"></i></a>
            <!-- <p>Te redireccionaremos hacia un contacto de whatsapp para resolver cualquier duda</p> -->
        </div>
        <div class="description txt-white">
            <p>¿Tienes alguna duda?, contáctanos</p>
        </div>
    </div>
    <div class="message">
        <input type="text" name="message" placeholder="Escribe aquí">
        <a href="https://bit.ly/32fOJRC" target="_blank"><i class="far fa-paper-plane"></i></a>
    </div>
    </div>
    <button class="button btn-first c-pointer" onclick="toggle('#message-ws','open')">
        <span class="text">Hola, ¿en qué te puedo ayudar?</span>
        <span class="icon" style="font-size:1.3em"><i class="far fa-question-circle"></i></span>
    </button>
</div>

