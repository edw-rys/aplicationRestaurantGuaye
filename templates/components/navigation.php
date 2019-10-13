<div class="navigation">
	<div class="flex space-btw">
		<div class="isotipo flex-center">
			<a href="<?php echo URL?>">
			<img src="<?php echo IMAGES?>logo.png" alt="">
			</a>
		</div>
		<span id="menu-bars" class="hidden center-y" onclick="toggle('#menu','active')"><i class="fa fa-bars"></i></span>
	</div>
	
	<nav id="menu" class="menu  font-p-h">
		<ul class="l-s-none list-menu">
			<li><a href="<?php echo URL?>home/">Inicio</a></li>
			<li><a href="<?php echo URL?>home/static/about">¿Quiénes somos?</a></li>
			<li><a href="<?php echo URL?>home/static/contact">Contacto</a></li>
			<li><a href="<?php echo URL?>dailymenu">Menú del día</a></li>
			<li><a href="<?php echo URL?>blog">Blog</a></li>
			<?php if(isset($_SESSION['USER'])){
					if(isset($_SESSION['rol']) && $_SESSION['rol']==102){
						echo '<li><a href="'.URL.'event">Evento</a></li>';
					}else{
						if(isset($_SESSION['rol']) && $_SESSION['rol']==101){
							echo '<li><a href="'.URL.'event">Control</a></li>';
						}
					}
				}

			?>

			<li class="uss">
				<ul class="l-s-none flex">
				<?php 
					if(isset($_SESSION['USER'])){
						$user = unserialize($_SESSION['USER']);
						$_SESSION['ID_USER']=$user->getId_user();
						echo "<li><a href='".URL."user/profile'>". $user->getUsername()."</a></li>";
						echo '<li><a href="'.URL.'user/logout">Cerrar sesion</a><li>';
					}else{
						echo '<li><a href="'.URL.'home/static/login">Iniciar Sesión</a></li>';
						echo '<li class="color-first"><a href="'.URL.'home/static/signup">Registrese</a></li>';
					}
			 	?>
			  	</ul>
			</li>
		</ul>
	</nav>
</div>


