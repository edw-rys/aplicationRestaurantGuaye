<div class="container-all">
	<header>
		<?php require_once NAVIGATION; ?>
	</header>
	<main>
		<div class="errors"></div>

		<?php 
			if(isset($_SESSION['USER'])){ 
				if(isset($_SESSION['rol']) && $_SESSION['rol']!=MODERADOR){
					?>
					<button class="float-w-l button-new-recipe" onclick="getFormRecipe()">Nueva receta</button>
					<?php
				}
			} 
		?>
		<div class=" flex-center flex-y">
			<div class="flex-center">
				<h2 class="txt-center tittle tittle-sty-bck bck-t-first">Nuestro Blog</h2>
			</div>
			<div class="">
				<section class="_menu recetas">
					<h3 class="tittle txt-center">Recetas</h3>
					<div class="allRecipes">
						<?php 
						if(isset($data["allBlog"])){
							$allBlog=$data["allBlog"];
							foreach($allBlog as $blog){
								include COMPONENTS."blog/blogItem.php";
							} 
						}
						?>
					</div>
				</section>
			</div>
		</div>
	</main>
</div>
<div class="despliegue"></div>