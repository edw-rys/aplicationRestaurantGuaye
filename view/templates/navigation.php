<div class="navigation">
	<div class="flex space-btw">
		<div class="isotipo flex-center">
			<a href="index.php">
			<img src="assets/img/logo.png" alt="">
			</a>
		</div>
		<span id="menu-bars" class="hidden center-y" onclick="toggle('#menu','active')"><i class="fa fa-bars"></i></span>
	</div>
	
	<nav id="menu" class="menu  font-p-h">
		<ul class="l-s-none list-menu">
			<li><a href="index.php?c=index&a=static&p=index">Inicio</a></li>
			<li><a href="index.php?c=index&a=static&p=about">¿Quiénes somos?</a></li>
			<li><a href="index.php?c=index&a=static&p=contact">Contacto</a></li>
			<li><a href="index.php?c=dailymenu">Menú del día</a></li>
			<li><a href="index.php?c=blog">Blog</a></li>
			<?php if(isset($_SESSION['USER'])){
					if(isset($_SESSION['rol']) && $_SESSION['rol']==102){
						echo '<li><a href="index.php?c=event">Evento</a></li>';
					}else{
						if(isset($_SESSION['rol']) && $_SESSION['rol']==101){
							echo '<li><a href="index.php?c=event&a=usacpc">Control</a></li>';
						}
					}
				}

			?>

			<li class="uss">
				<ul class="l-s-none flex">
				<?php 
					if(isset($_SESSION['USER'])){
						$user = $_SESSION['USER'];
						$_SESSION['ID_USER']=$user->getId_user();
						echo "<li><a href='#'>". $user->getUsername()."</a></li>";
						echo '<li><a href="index.php?c=user&a=logout">Cerrar sesion</a><li>';
					}else{
						echo '<li><a href="index.php?c=index&a=static&p=login">Iniciar Sesión</a></li>';
						echo '<li class="color-first"><a href="index.php?c=index&a=static&p=signup">Registrese</a></li>';
					}
			 	?>
			  	</ul>
			</li>
		</ul>
	</nav>
</div>


