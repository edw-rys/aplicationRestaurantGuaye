<div class="container-all">
	<header>
		<?php require_once NAVIGATION; ?>
	</header>
	<div class="despliegue"></div>

	<main>
		<div class="errors"></div>

		<?php if(isset($_SESSION['USER'])){ 
				if(isset($_SESSION['rol']) && $_SESSION['rol']!=MODERADOR){
					require_once "view/blog/formRecipe.php";
				}
			} 
		?>
		
		<div class="container" style="margin-top: 50px">
			<div class="flex-center">
				<h2 class="txt-center tittle tittle-sty-bck bck-t-first">Nuestro Blog</h2>
			</div>
			<div class="categorias">
				<section class="_menu recetas">
					<h3 class="tittle txt-center">Recetas</h3>
					<div class="contenido platillos">
						


						<?php 

						foreach($allBlog as $blog){

							?>
							<div class="_item">
								<div class="_head">
									<div class="view abs-left-0 abs-top-0" >
										<a href="index.php?c=blog&a=viewRecipe&id=<?php echo $blog->getId_blog()?>" class="txt-white flex-center flex-y">
											<img src="assets/img/icons/eye-solid.svg" alt="ver" width="30" height="30">
											<span>Ver post</span>
										</a>
									</div>
									<?php 

										if(isset($_SESSION['rol']) && $_SESSION['rol']==MODERADOR){
										?>
									<div class="<?php echo ($blog->getDestacado()==1)?"star":'other'?> abs-right-0 abs-top-0" target_identify="<?php echo $blog->getId_blog() ?>">
										<a href="#!" onclick="blogDestacado(<?php echo $blog->getId_blog() ?>)" class="txt-white flex-center flex-y">
											<span class="hidden"><?php  echo $blog->getDestacado()?></span>
											<img src="assets/img/icons/star-solid.svg" alt="destacado" width="30" height="30">
											<span class="<?php echo ($blog->getDestacado()==1)?"txt-black":'txt-white'?>">Destacado</span>
										</a>
									</div>
										<?php
										}else{
											if($blog->getDestacado()==1){
												?>
												<div class="star abs-right-0 abs-top-0">
													<a href="#!" class="txt-white flex-center flex-y">
														<img src="assets/img/icons/star-solid.svg" alt="destacado" width="30" height="30">
														<span class="<?php echo ($blog->getDestacado()==1)?"txt-black":'txt-white'?>">Destacado</span>
													</a>
												</div>
												<?php
											}
											
										}
									?>
								</div>
								<div class="_body font-i-f">
									
									<?php  
									echo '<img src="'.$blog->getRecipe()->getUrl_image().'">';
									?>
									<?php  
									echo '<h4 class="tittle txt-center" style="font-size:1.3em">'. $blog->getRecipe()->getName_recipe().'</h4>';
									?>
									
								</div>
								<div class="_footer font-i-f">
									<div class="user flex-center flex-y" style="margin:10px 0;">

										<p>Usuario: <?php echo $blog->getUser()->getUsername(); ?></p>
										<p> 
											<span><?php //echo $blog->getUser()->getName_user(); ?></span> 
											<span><?php //echo $blog->getUser()->getLast_name(); ?></span>
										</p>
									</div>
									<?php if(!(empty($blog->getUrl_social_network()))){ ?>
									<div class="social flex-center flex-y">
										<p class="txt-center" style="font-size:1.3em">Redes sociales</p>
										<ul class="social l-s-none flex">
											<?php 
											foreach($blog->getUrl_social_network() as $sn){
												?>
												<li class="s">
													<a href="<?php echo $sn->link; ?>" target="_blank" class="<?php echo $sn->name_socialNetwork;?>">
														<!-- <i class="<?php //echo $sn->name_class;?>"></i> -->
														<img src="<?php echo ROUTEIMG.'icons/socialNetwork/'.$sn->name_socialNetwork.'.svg';?>" alt="<?php echo $sn->name_socialNetwork;?>" width="30" height="30">
													</a>
												</li>	

												<?php 
											}
											?>
										</ul>
									</div>
										<?php }?>
									<?php 
									if(isset($_SESSION['ID_USER'])){
									?>
									<div class="options flex space-btw">
										
										<div class="setting  abs-right-0 abs-bottom-0 flex">
											<?php 
											if($blog->getUser()->getId_user()==$_SESSION['ID_USER']){
											?>
											<span class="edit txt-white">
												<a href="index.php?c=blog&a=viewRecipe&id=<?php echo $blog->getId_blog()?>&edit" class="flex-center flex-y">
													<img src="assets/img/icons/pen-square-solid.svg" alt="editar" width="30" height="30">
													<span>Editar</span>
												</a>
											</span>
											<?php 
											}?>
											<?php 
											if($blog->getUser()->getId_user()==$_SESSION['ID_USER'] || $_SESSION['rol']==MODERADOR){
											?>
											<span class="remove txt-white">
												<a href="index.php?c=blog&a=remove&id=<?php echo $blog->getId_blog()?>" class="flex-center flex-y" onclick="javascript:return confirm('esta seguro?');">
													<img src="assets/img/icons/trash-solid.svg" alt="eliminar" width="30" height="30">
													<span>Eliminar</span>											
												</a>
											</span>
											<?php }?>
										</div>
									</div>
									<?php }?>
								</div>
							</div>
						<?php } ?>
					</div>
				</section>
				<section>
					<h3 class="tittle"></h3>
				</section>
			</div>
		</div>
	</main>

	
</div>
