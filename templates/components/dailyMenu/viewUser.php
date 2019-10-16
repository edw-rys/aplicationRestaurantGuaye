<div class="_head font-barriecito flex-center" style="margin-top:120px">
    <div class="_container flex-center">
        <p class="date">Fecha: <?php echo $menudiario->getDate_create();?></p>
        <img class="picture" src="<?php echo IMAGES?>icons/calendar.png" alt="">
    </div>
</div>
<div class="_main font-i-f">
    <?php 
    if( isset($data["schedules"]) && !empty($data["schedules"]) ){
        foreach($data["schedules"] as $sc){//echo $sc->getName_schedule();?>
    <div class="section-foods">
        <div class="schedule">
            <p class="txt-center"><?php echo $sc->getName_schedule();?></p>
        </div>
        <div class="foods">
            <?php
            foreach($menudiario->getFoodControl() as $foods){
                if($foods->id_schedule==$sc->getId_schedule()){?>
            <div class="food">
                <div class="detail">
                    <p class="name grid-center"><?php echo $foods->name_food; ?></p>
                    <p class="description grid-center"><?php echo $foods->description_food; ?></p>
                </div>
                <div class="price grid-center">
                    <p>$ <?php echo $foods->price; ?></p>
                </div>
            </div>
            <?php }} ?>
        </div>
    </div>
    <?php }}?>
</div>
<div class="_foot flex-center flex-y">
    <p class="f1--">Horario de atención</p>
    <p class="f1--">Lunes a sábado de 7:30 am a 5 pm</p>
    <span><i class="fas fa-mobile-alt"></i>0996567336 / <i class="fas fa-phone"></i> (04) 2567928</span>
    <span><i class="fas fa-envelope-open-text"></i> guaye-restaurant@hotmail.com</span>
</div>