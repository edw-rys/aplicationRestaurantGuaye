<div class="row-table header blue">
    <div class="cell">Usuario</div>
    <div class="cell">Fecha de creación</div>
    <div class="cell">Asunto</div>
    <div class="cell">Fecha de ejecución</div>
    <div class="cell">Hora de entrada</div>
    <div class="cell">Hora de salida</div>
    <div class="cell">Comentarios</div>

    <?php if($_SESSION["rol"]==ADMINISTRADOR){?>	  
    <div class="cell">Estado</div>
    <?php }else{?>
    <div class="cell">Usuario</div>
    <div class="cell">Usuario</div>
    <?php }?>
</div>