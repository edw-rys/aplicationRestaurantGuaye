<?php if(isset($blog) && !empty($blog)){ ?>
<div class="content-head_">
	<img class="poster-img" src="<?php echo URL.$blog->getRecipe()->getUrl_image()?>" alt="">
	<h3 class="title"><?php echo  $blog->getRecipe()->getName_recipe()?></h3>
</div>
<div class="content-body_">
	<div class="content-part">
		<h4 class="part-title">Ingrediente</h4>
		<ul class="content-list">
			<?php 
			foreach($blog->getRecipe()->getIngredients() as $ingredient)
				echo '<li><p>* '.$ingredient->name_ingredient.'</p></li>';		
			?>
		</ul>
	</div>
	<div class="content-part">
		<h4 class="part-title">Preparación</h4>
		<p><?php echo $blog->getRecipe()->getPreparation(); ?></p>
	</div>
	<div class="content-part">
		<div class="two-part">
			<div class="part-one">
				<p class="paragraph txt-center"><span>Usuario: </span><?php echo $blog->getUser()->getUsername(); ?></p>
				<p class="paragraph txt-center">
					<span><?php echo $blog->getUser()->getName_user(); ?></span> 
					<span><?php echo $blog->getUser()->getLast_name(); ?></span>
				</p>
			</div>
			<div class="part-one flex flex-y">
				<p>Redes sociales</p>
				<div>
				<?php foreach($blog->getUrl_social_network() as $sn){ ?>
					<a href="<?php echo $sn->link; ?>" class="separate <?php echo $sn->name_socialNetwork;?>" target="_blank">
						<img src="<?php echo IMAGES.'icons/socialNetwork/'.$sn->name_socialNetwork.'.svg';?>" alt="<?php echo $sn->name_socialNetwork;?>" width="30" height="30">						
					</a>
				<?php } ?>
				</div>
			</div>
		</div>

	</div>
</div>
<?php } ?>
