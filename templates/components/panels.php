<!-- panel de mensajes -->
<div id="panelMssg" class="<?php echo isset($_SESSION['typeMessage'])?$_SESSION['typeMessage']:'hidden'; ?> abs-center ">
    <div class="panel_head flex space-btw">
        <p><?php echo isset($_SESSION['messageTittle'])?$_SESSION['messageTittle']:'';?></p>
        <a href="#!" onclick="toggle('#panelMssg','hidden')">
            <img class="icon" src="<?php echo ROUTEIMG."icons/close.svg"?>" alt="close" width="30" height="30">
        </a>
    </div>
    <div class="panel_body">
        <p><?php echo isset($_SESSION['message'])?$_SESSION['message']:'';?></p>
    </div>
</div>
<?php
    if(isset($_SESSION['typeMessage']))
        unset($_SESSION['typeMessage']);
    if(isset($_SESSION['message']))
        unset($_SESSION['message']);
?>