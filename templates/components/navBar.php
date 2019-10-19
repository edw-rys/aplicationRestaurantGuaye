<!-- <div class="container"> -->
  <!-- Navbar -->
  <nav class="navbar-tnx txt-white">
    <div class="nav_head">
      <a class="nav-iso" href="<?php echo URL?>">
          <img src="<?php echo IMAGES?>logo.png" alt="" width="100" height="30" class="d-inline-block align-top" >
      </a>
      <button class="btn-nav-toggler" onclick="toggle('#nav-first','active')">
        <i class="fas fa-bars"></i>
      </button>
    </div>
    
    <div class="items-nav" id="nav-first">
      <ul class="list-items-nav">
        <li class="item-nav flex-center">
          <a class="dir-item" href="<?php echo URL?>home/">Inicio</a>
        </li>
        <li class="item-nav flex-center">
          <a class="dir-item"  href="<?php echo URL?>home/static/about">¿Quiénes somos?</a>
        </li>
        <li class="item-nav flex-center">
          <a class="dir-item"  href="<?php echo URL?>dailymenu">Menú del día</a>
        </li>
        <li class="item-nav flex-center">
          <a class="dir-item"  href="<?php echo URL?>blog">Blog</a>
        </li>
      </ul>
      <div class="line-nav-separator"></div>
      <ul class="list-items-nav">
        <?php 
            if(isset($_SESSION['USER'])){
                $user = unserialize($_SESSION['USER']);
                $_SESSION['ID_USER']=$user->getId_user();
        ?>
            <li class="item-nav">
                <a class="head-sub-menu" href="#!" onclick="toggle('#sub-nav','active')">
                    <?php echo $user->getUsername()?>
                    <i class="fas fa-angle-down"></i>
                </a>
                <ul class="options-nav drop-down-nav" id="sub-nav">
                    <li class="option-nav">
                      <a class="op-nav" href="<?php echo URL?>event">Eventos</a>
                    </li>
                    <!-- <li class="option-nav">
                      <a class="op-nav" href="#">op1</a>
                    </li> -->
                    <div class="line-nav-separator"></div>
                    <li class="option-nav">
                      <a class="op-nav" href="<?php echo URL?>user/myprofile">Mi perfil</a>
                    </li>
                    <li class="option-nav">
                      <a class="op-nav" href="<?php echo URL?>user/settings">Ajustes</a>
                    </li>
                    <li class="option-nav">
                      <a class="op-nav" href="<?php echo URL?>user/logout">Cerrar sesión</a>
                    </li>
                </ul>
            </li>
        <?php
            }else{
                echo '<li class="item-nav"><a class="dir-item" href="#!" onclick="getFormLogin()">Login</a></li>';
                // echo '<li class="item-nav"><a class="dir-item" href="'.URL.'home/static/login">Login</a></li>';
                echo '<li class="item-nav"><a class="dir-item" href="'.URL.'home/static/signup">Registrese</a></li>';
            }
        ?>
      </ul>

    </div>
  </nav>
  <!-- Contenido -->

<!-- </div> -->
