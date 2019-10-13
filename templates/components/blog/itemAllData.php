<div class="view-recipe">
	<?php 
	if(isset($blog) && !empty($blog)){
		?>
		<div class="_item">
			<div class="_head">
				<?php  
				echo '<h4 class="tittle txt-center" style="font-size:1.3em">'. $blog->getRecipe()->getName_recipe().'</h4>';
				?>
			</div>
			<div class="m-20"></div>
			<div class="_body font-i-f">
				<?php  
				echo '<div class="flex-center"><img src="'.URL.$blog->getRecipe()->getUrl_image().'"></div>';
				?>
				<div class="prepare">
					<div class="list">
						<p class="txt-center">Ingredientes</p>
						<ul class="l-s-none">
							<?php 
							foreach($blog->getRecipe()->getIngredients() as $ingredient)
								echo '<li><p>* '.$ingredient->name_ingredient.'</p></li>';		
															// echo '<li>* <p>'+$_SESSION['receta'][3]+'</p></li>';		
							?>
						</ul>
					</div>
					<div class="preparacion flex-center flex-y">
						<p>Preparación</p>
						<p class="prep"><?php echo $blog->getRecipe()->getPreparation(); ?></p>
					</div>
				</div>
			</div>
			<div class="border"></div>

			<div class="_footer  flex-center flex-y  font-i-f">
				<div class="flex  flex-center">
					<!-- <p style="margin-right:80px">Receta publicada por</p> -->
					<div class="user user-card flex-center flex-y" style="margin:10px 0;">
						<p>Usuario: <?php echo $blog->getUser()->getUsername(); ?></p>
						<p> 
							<span><?php echo $blog->getUser()->getName_user(); ?></span> 
							<span><?php echo $blog->getUser()->getLast_name(); ?></span>
						</p>
					</div>
                </div>
                <?php if(!empty($blog->getUrl_social_network())){?>
				<div class="social flex-center flex-y">
					<p class="txt-center" style="font-size:1.3em">Redes sociales</p>
					<ul class="social l-s-none flex">
						<?php 
						foreach($blog->getUrl_social_network() as $sn){
							?>
							<li class="s">
								<a href="<?php echo $sn->link; ?>" target="_blank" class="<?php echo $sn->name_socialNetwork;?>">
									<!-- <i class="<?php //echo $sn->name_class;?>"></i> -->
									<img src="<?php echo IMAGES.'icons/socialNetwork/'.$sn->name_socialNetwork.'.svg';?>" alt="<?php echo $sn->name_socialNetwork;?>" width="30" height="30">
								</a>
							</li>	

							<?php 
						}
						?>
					</ul>
                </div>
                <?php }?>
			</div>
		</div>
	<?php } ?>
</div>