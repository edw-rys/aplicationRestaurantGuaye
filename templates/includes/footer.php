<footer class="txt-white font-p-h">
            <div class="ft container">
                
                <div class="info ft_">
                    <div class="_head">
                        <h2 class="tittle txt-center">Información</h2>
                    </div>
                    <div class="_body">
                        <div class="part m-20">
                            <h3>Cocina</h3>
                            <ul class="">
                                <li>desayuno-almuerzo</li>
                                <li>latinoamericana</li>
                                <li>pescados y mariscos</li>
                            </ul>
                        </div>
                        <div class="part m-20">
                            <h3>Especialidades</h3>
                            <ul class="">
                                <li>Desayuno</li>
                                <li>Almuerzo</li>
                                <li>Café</li>
                                <li>Bebidas</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="ft_">
                    <div class="_head"><h2 class="tittle txt-center">Contacto</h2></div>
                    <div class="_body">
                        <ul class="l-s-none">
                            <li class="txt-center">Gerente General: Christian Chávez Toledo</li>
                            <li class="txt-center">Correo: <a href="mailto:guaye-restaurant@hotmail.com">guaye-restaurant@hotmail.com</a></li>
                            <li class="flex-center flex-y" style="margin: 10px 0;">
                                <h3 class="tittle">Nuestras redes sociales</h3>
                                <ul class="l-s-none flex social">
                                    <li class="s"><a href="https://www.facebook.com/guayerestaurant/" target="_blank" class="facebook"><i class="fab fa-facebook"></i></a></li>
                                    <li class="s"><a href="https://www.instagram.com/explore/locations/1004315499/guaye/?hl=es-la"  class="instagram" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                    
                                </ul>
                            </li><li class="flex-center">Llamar (04) 256-7928</li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

    <script src="<?php echo JS?>index.js"></script>
    <script type="text/javascript" src="<?php echo JS?>ajax.js"></script>
    <script type="text/javascript" src="<?php echo JS?>validaciones.js"></script>
    <script type="text/javascript" src="<?php echo JS?>activeForm.js"></script>
    <script type="text/javascript" src="<?php echo JS?>server/user.functions.js"></script>
    <script type="text/javascript" src="<?php echo JS?>server/blog.functions.js"></script>
    <?php if(isset($_SESSION["rol"]) && $_SESSION["rol"]=ADMINISTRADOR){?>
    <script src="<?php echo JS."server/dailymenu.functions.js"?>"></script>
    <?php }?>
    <!-- icons favicon -->
    <div class="hidden">Icons made by <a href="https://www.flaticon.es/autores/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.es/"             title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/"             title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
    <div class="hidden">Icons made by <a href="https://www.flaticon.es/autores/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.es/"             title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/"             title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
    <div class="hidden">Icons made by <a href="https://www.flaticon.es/autores/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.es/"             title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/"             title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
    <div class="hidden">Icons made by <a href="https://www.flaticon.es/autores/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.es/"             title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/"             title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
    </body>
</html>

<!-- <a href="#!" onclick="window.scrollTo(0,0);" class="btn-up btn-first"><i class="fas fa-chevron-up"></i></a> -->

