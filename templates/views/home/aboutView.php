<!-- header -->
<header>
    <?php require_once NAVIGATION; ?>
</header>
<!-- main -->
<div class="m-t-80"></div>
<main>
    <section class="nosotros flex-center bck-about">
        <div class="picture">
            <img src="<?php echo IMAGES?>pictures/about.png" alt="">
        </div>
        <div class="_content flex-center flex-y">
            <h2 class="tittle txt-center tittle-sty-bck bck-t-first">Nosotros</h2>
            <div class="border"></div>
            <p class="txt-center font-i-f">Guayé es la nueva opción de comida proveniente del mar, con el único sabor de la Perla del Pacífico. <br>Ofrecemos Desayunos y Almuerzos Ejecutivos, además de Platos a la Carta que lograrán satisfacer tus expectativas a la hora de comer!</p>
        </div>
    </section>
    <section class="time flex-center flex-y">
        <h2 class="tittle font-berkshire tittle-sty-bck bck-t-first">Horario</h2>
        <div class="container_">
            <!-- Days --> 
            <div class="box_h txt-white bck-black-time font-barriecito">
                <div class="_head"><h3 class="tittle txt-center">Días</h3></div>
                <div class="_body">
                    <div class="days flex-y">
                        <!-- <p>De lunes a Sábados</p> -->
                        <p>Lunes</p>
                        <p class="txt-center">a</p>
                        <p class="txt-right">Sábados</p>
                    </div>
                </div>
                <div class="_footer icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>  
            <!-- Hours -->
            <div class="box_h txt-white bck-black-time-2 font-barriecito">
                <div class="_head"><h3 class="tittle txt-center">Abierto desde</h3></div>
                <div class="_body">
                    <div class="hour flex-y" >
                        <p >8:00</p>
                        <p class="txt-center">hasta</p>
                        <p class="txt-right">17:00</p>
                    </div>
                </div>
                <div class="_footer icon">
                    <i class="far fa-clock"></i>
                </div>
            </div>
        </div>
    </section>
    <section class="ubicacion flex-y flex-center m-20">
        <div class="_head realive" style="position: relative;">
            <h2 class="tittle txt-center tittle-sty-bck bck-t-green">Ubicación</h2>
            <span class="icon abs"><i class="fas fa-map-marked-alt"></i></span>
        </div>
        <div class="map flex-center">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.9044134319256!2d-79.88187975016197!3d-2.189905337887941!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x902d6e7f49e2f4a7%3A0x7ea4f5b9d34749e3!2sGuay%C3%A9+Restaurant!5e0!3m2!1ses-419!2sec!4v1561342382745!5m2!1ses-419!2sec" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </section>
</main>
